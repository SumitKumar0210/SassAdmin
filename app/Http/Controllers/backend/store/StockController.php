<?php

namespace App\Http\Controllers\backend\store;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\HotlrConfiguration;
use App\Models\InventoryManagement;
use App\Models\RawMaterial;
use App\Models\Stock;
use App\Models\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    public function stockOrder(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.store.stock.stock-order-list',compact('hotlr'));
    }

    public function stockOrderVeiw(Request $request){
          if($request->ajax()){
            $purchaseorder = Stock::get();
            return DataTables::of($purchaseorder)
            ->addIndexColumn()
            ->addColumn('str_no',function($row){
                return $row->stock_id;
            })
            ->addColumn('order_item', function($row) {
                return $row->qty;
            })
            ->addColumn('department', function($row) {
                return $row->department_id;
            })
            ->addColumn('created_by',function($row){
                return $row->userData->name;
            })
            ->addColumn('created_at',function($row){
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('status',function($row){
                return $row->status;
            })
            ->addColumn('action',function($row){
                return ' <ul class="action"> 
                    <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="goodsEntry('.$row->id.')"></i></a></li>
                    </ul>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function stockAdd(){
        $departments = Department::where('status',1)->get();
        $raw_materials = RawMaterial::where('status',1)->get(['id','code','name','uom']);
        $materials = [];
        foreach($raw_materials as $raw){
            $materials[]=[
                'id' => $raw['id'],
                'name' => $raw['name'],
                'code' => $raw['code'],
                'uom' => $raw->measurement_detail->name ?? '',
                'uom_id' => $raw['uom']
            ];
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.store.stock.stock-add',compact('departments','materials','hotlr'));
    }

    public function stockAddSubmit(Request $request){
        $validator = Validator::make($request->all(),[
            'department' => 'required',
            'itemId' => 'required|array',
            'qty' => 'required|array'
        ]);
        if($validator->fails()){
            return response()->json(['error_validation'=>$validator->error()->all(),],422);
        }
 
        foreach($request->itemId as $index =>$name){
            $store_item[] = [
                'department' =>$request->department,
                'item_id' =>$request->itemId[$index],
                'expected_qty' =>$request->qty[$index],
                'unit' =>$request->unit[$index],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        $store_items = StoreRequest::insert($store_item);
        if($store_items){
            return response()->json(['success'=>'Purchase items added successfully'],200);
        }else{
            return response()->json(['error_success'=>'Purchase items not added']);
        }
    }

    public function stockRequest(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.store.stock.stock-request',compact('hotlr'));
    }

    public function stockCurrent(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.store.stock.stock-current',compact('hotlr'));
    }

    public function stockRequestView(Request $request){
        if ($request->ajax()) {
            $stock_request = StoreRequest::selectRaw('str_no, COUNT(item_id) as item_count, MIN(id) as min_id')
                ->groupBy('str_no')
                ->get()
                ->map(function ($group) {
                    $record = StoreRequest::with(['departmentData', 'userData'])
                        ->where('id', $group->min_id)
                        ->first();
                    $record->item_count = $group->item_count;
                    return $record;
                });
            return DataTables::of($stock_request)
                ->addIndexColumn()
                ->addColumn('str_no', function($row) {
                    return $row->str_no;
                })
                ->addColumn('order_item', function($row) {
                    return $row->item_count; // Count of item_id for this str_no
                })
                ->addColumn('department', function($row) {
                    return optional($row->departmentData)->name;
                })
                ->addColumn('created_by', function($row) {
                    return optional($row->userData)->name;
                })
                ->addColumn('created_at', function($row) {
                    return $row->created_at->format('d-m-Y');
                })
                ->addColumn('status', function($row) {
                    return $row->status == 0 ? 'Delivered':'Not Delivered';
                })
                ->addColumn('action', function($row) {
                    return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="stockRequestInPage(`' . $row->str_no . '`)"></i></a></li>
                        </ul>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function stockCurrentView(Request $request){
        if($request->ajax()){
            $distinct_materials = Stock::where('department_id',1)->where('status',1)->get();
            return DataTables::of($distinct_materials)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->rawMaterialDetail->name;
            })
            ->addColumn('code',function($row){
                return $row->rawMaterialDetail->code;
            })
            ->addColumn('expiry',function($row){
                return date('d-m-Y',strtotime($row->expiry_date));
            })
            ->addColumn('uom',function($row){
                return $row->rawMaterialDetail->measurement_detail->name;
            })
            ->addColumn('qty',function($row){
                return $row->qty;
            })
            ->rawColumns([''])
            ->make(true);
        }
    }

    public function stockRequestInPage($str_no){
        $store_request = StoreRequest::where('str_no',$str_no)->get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.store.stock.stock-request-in',compact('store_request','hotlr'));
    }

    public function stockReceivedQuantityUpdate(Request $request){
        // dd($request->all());
        DB::beginTransaction();

        try{
            foreach($request->request_id as $index => $key){
                $items = StoreRequest::where('id',$key)->get(['item_id','request_from','expiry_date']);
                $chk_stock = Stock::where('item_id',$items[0]->item_id)->where('department_id',1)->where('expiry_date',$items[0]->expiry_date)->value('qty');

                if($request->received_qty[$index] <= $chk_stock){

                    StoreRequest::where('id',$key)->update([
                        'received_qty' => $request->received_qty[$index],
                        'date_of_transfer' => now(),
                        'status' => 0       
                    ]);  

                    $item_name = RawMaterial::where('id',$items[0]->item_id)->value('name');
                    // Fetch latest balance of Stock
                    $latestInventory = InventoryManagement::where('item_id', $items[0]->item_id)->where('department_id',1)->where('expiry_date',$items[0]->expiry_date)
                        ->orderBy('created_at', 'desc')
                        ->first();
                    $previousBalance = $latestInventory ? $latestInventory->balance : 0;
                    $newBalance = $previousBalance - $request->received_qty[$index];

                    $inventory_managemenet = new InventoryManagement();
                    $inventory_managemenet->item_id = $items[0]->item_id;
                    $inventory_managemenet->item_name = $item_name;
                    $inventory_managemenet->department_id = 1;
                    $inventory_managemenet->expiry_date = $items[0]->expiry_date;
                    $inventory_managemenet->txn_date = today();
                    $inventory_managemenet->qty_out = $request->received_qty[$index];
                    $inventory_managemenet->balance = $newBalance;
                    $inventory_managemenet->save();

                    // Fetch latest balance
                    $latestInventoryOther = InventoryManagement::where('item_id', $items[0]->item_id)->where('department_id',$items[0]->request_from)->where('expiry_date',$items[0]->expiry_date)
                        ->orderBy('created_at', 'desc')
                        ->first();
                    $previousBalanceOther = $latestInventoryOther ? $latestInventoryOther->balance : 0;
                    $newBalanceOther = $previousBalanceOther + $request->received_qty[$index];

                    $inventory_managemenet_other = new InventoryManagement();
                    $inventory_managemenet_other->item_id = $items[0]->item_id;
                    $inventory_managemenet_other->item_name = $item_name;
                    $inventory_managemenet_other->department_id = $items[0]->request_from;
                    $inventory_managemenet_other->expiry_date = $items[0]->expiry_date;
                    $inventory_managemenet_other->txn_date = today();
                    $inventory_managemenet_other->qty_in = $request->received_qty[$index];
                    $inventory_managemenet_other->balance = $newBalanceOther;
                    $inventory_managemenet_other->save();

                    $update_stock = Stock::where('item_id',$items[0]->item_id)->where('department_id',1)->where('expiry_date',$items[0]->expiry_date)->update([
                        'qty' => $chk_stock - $request->received_qty[$index]
                    ]);

                    // Stock from the department
                    $stock_item_found = Stock::where('item_id',$items[0]->item_id)->where('department_id',$items[0]->request_from)->where('expiry_date',$items[0]->expiry_date)->exists();
                    if($stock_item_found){
                        
                        $chk_stock_department = Stock::where('item_id',$items[0]->item_id)->where('department_id',$items[0]->request_from)->where('expiry_date',$items[0]->expiry_date)->value('qty');
                        $update_stock_department = Stock::where('item_id',$items[0]->item_id)->where('department_id',$items[0]->request_from)->where('expiry_date',$items[0]->expiry_date)->update([
                            'qty' => $chk_stock_department + $request->received_qty[$index]
                        ]);
                    
                    }else{
                        $stocks = new Stock();
                        $stocks->expiry_date = $items[0]->expiry_date;
                        $stocks->department_id = $items[0]->request_from;
                        $stocks->item_id = $items[0]->item_id;
                        $stocks->qty = $request->received_qty[$index];
                        $stocks->save();
                    }
                    
                }else{
                    return response()->json(['error_success' => 'Stock Qty is not available'], 500);
                }      
            }
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Stock Received quantity updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }
}
