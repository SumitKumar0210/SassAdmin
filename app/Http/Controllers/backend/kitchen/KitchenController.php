<?php

namespace App\Http\Controllers\backend\kitchen;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\InventoryManagement;
use App\Models\Kot;
use App\Models\KotItem;
use App\Models\RawMaterial;
use App\Models\Stock;
use App\Models\StoreRequest;
use App\Models\StoreReturnRequest;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class KitchenController extends Controller
{   
    public function dashboard(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kitchen.dashboard',compact('hotlr'));
    }

    public function getRoomKotData(Request $request){
        if($request->ajax()){
            $roomKot = Kot::where('type','Room')->get();
            return DataTables::of($roomKot)
            ->addIndexColumn()
            ->addColumn('room_no',function($row){
                return $row->type_number;
            })
            ->addColumn('name',function($row){
                return $row->contact_person_name ?? 'NA';
            })
            ->addColumn('status',function($row){
                return $row->order_status;
            })
            ->addColumn('amount',function($row){
                return $row->grand_total ?? 0;
            })
            ->addColumn('pending',function($row){
                return ($row->grand_total - $row->total_paid) ?? 0;
            })
            ->addColumn('action',function($row){
                 return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="#"></i></a></li>
                        </ul>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getTableKotData(Request $request){
        if($request->ajax()){
            $table_kot = Kot::where('type','Table')->get();
            return DataTables::of($table_kot)
            ->addIndexColumn()
            ->addColumn('table_no',function($row){
                return $row->type_number;
            })
            ->addColumn('name',function($row){
                return $row->contact_person_name ?? 'NA';
            })
            ->addColumn('status',function($row){
                return $row->order_status;
            })
            ->addColumn('amount',function($row){
                return $row->grand_total ?? 0;
            })
            ->addColumn('pending',function($row){
                return ($row->grand_total - $row->total_paid) ?? 0;
            })
            ->addColumn('action',function($row){
                 return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="#"></i></a></li>
                        </ul>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function KotMonitor(){
        $kots = Kot::where('status',1)->whereNull('menu_type')->get();
        $kot_items = KotItem::where('status',1)->get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kitchen.kot-monitor',compact('kots','kot_items','hotlr'));
    }

    public function KotMonitorData(Request $request){
        $kots = Kot::where('status',1)->whereNull('menu_type')->orderBy('id','desc')->get();
        $kot_items = KotItem::where('status',1)->get();
        return response()->json(['success'=>'Kot data fetched','kots'=>$kots,'kot_items'=>$kot_items],200);
    }

    public function markKotDelivered(Request $request){
        $update = Kot::where('id',$request->id)->update([
            'order_status' => 'Prepared'
        ]);
        if($update){
            return response()->json(['success'=>'Kot Prepared succesfully'],200);
        }else{
            return response()->json(['error_success'=>'Kot not Prepared']);
        }
    }

    public function inStock(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kitchen.in-stock',compact('hotlr'));
    }

    public function inStockView(Request $request){

        if($request->ajax()){
            $distinct_materials = Stock::where('department_id',2)->get();
            return DataTables::of($distinct_materials)
            ->addIndexColumn()
            ->addColumn('item_code',function($row){
                return $row->rawMaterialDetail->code;
            })
            ->addColumn('item_name',function($row){
                return $row->rawMaterialDetail->name;
            })
            ->addColumn('uom',function($row){
                return $row->rawMaterialDetail->measurement_detail->name;
            })
            ->addColumn('qty',function($row){
                return $row->qty;
            })
            ->make(true);
        }
    }

    public function consumtionReport(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kitchen.consumption-report',compact('hotlr'));
    }

    public function consumptionReportView(Request $request){
        
        if ($request->ajax()) {

            $in_stock_data = InventoryManagement::where('department_id', 2)
                ->whereIn('id', function ($query) {
                    $query->selectRaw('MAX(id)')
                        ->from('inventory_management')
                        ->groupBy('item_id', 'expiry_date');   // IMPORTANT
                })
                ->orderBy('expiry_date', 'asc')  // optional
                ->get();
        
            return DataTables::of($in_stock_data)
                ->addIndexColumn()
                ->addColumn('item_name', function($row){
                    return $row->item_name;
                })
                ->addColumn('department', function($row){
                    return optional($row->departmentData)->name ?? '';
                })
                ->addColumn('expiry', function($row){
                    return $row->expiry_date ? date('d-m-Y', strtotime($row->expiry_date)) : '';
                })
                ->addColumn('txn_date', function($row){
                    return $row->txn_date ? date('d-m-Y', strtotime($row->txn_date)) : '';
                })
                ->addColumn('qty_in', function($row){
                    return $row->qty_in;
                })
                ->addColumn('qty_out', function($row){
                    return $row->qty_out;
                })
                ->addColumn('balance', function($row){
                    return $row->balance;
                })
                ->make(true);
        }
    }

    public function transferRequest(){
        $materials = [];
        $stocks = Stock::where('status',1)->get();
        foreach($stocks as $latests){
            $materials[] = [
                'id' => $latests['item_id'],
                'name' => optional($latests->rawMaterialDetail)->name,
                'code' => optional($latests->rawMaterialDetail)->code,
                'expiry' => date('d/m/Y', strtotime($latests['expiry_date'])),
                'uom' => optional($latests->rawMaterialDetail->measurement_detail)->name ?? '',
                'uom_id' => optional($latests->rawMaterialDetail)->uom
            ];
        }

        // ---- SORT BY EXPIRY DATE (ASC) ----
        usort($materials, function($a, $b) {
            $dateA = DateTime::createFromFormat('d/m/Y', $a['expiry']);
            $dateB = DateTime::createFromFormat('d/m/Y', $b['expiry']);
            return $dateA <=> $dateB;
        });
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kitchen.transfer-request',compact('materials','hotlr'));
    }

    public function transferRequestSubmit(Request $request){
        
        $validator = Validator::make($request->all(),[
            'itemId' => 'required|array',
            'qty' => 'required|array'
        ]);
        
        if($validator->fails()){
            return response()->json(['error_validation'=>$validator->error()->all(),],422);
        }

        $pre_str_no = StoreRequest::orderBy('id', 'desc')->value('str_no');
        $pre_str_number = substr($pre_str_no,7); // fetch latest purchase_id number
        foreach($request->itemId as $index => $key){
            $store_data[] = [
                'str_no' => 'STR_000'.(int)$pre_str_number + 1,
                'item_id' => $request->itemId[$index],
                'expected_qty' => $request->qty[$index],
                'expiry_date' => date("Y-m-d", strtotime(str_replace('/', '-', $request->expiry[$index]))),
                'unit' => $request->unit[$index],
                'created_by' => Auth::id(),
                'request_from' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        $store_data = StoreRequest::insert($store_data);
        if($store_data){
            return response()->json(['success'=>'Transfer request submitted succesfully'],200);
        }else{
            return response()->json(['error_success'=>'Transfer request not submitted']);
        }
    }

    public function pendingRequest(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kitchen.pending-request',compact('hotlr'));
    }

    public function pendingRequestVeiw(Request $request){
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
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="stockReturnPage(`' . $row->id . '`)"></i></a></li>
                        </ul>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function returnRequest($id){
        $str_no = StoreRequest::where('id',$id)->value('str_no');
        $store_items_id = StoreRequest::where('str_no',$str_no)->get(['item_id']);
        $raw_materials = RawMaterial::whereIn('id',$store_items_id)->where('status',1)->get(['id','code','name','uom']);
        $materials = [];
        foreach($raw_materials as $raw){
            $mx_qty = StoreRequest::where('str_no',$str_no)->where('item_id',$raw['id'])->value('received_qty');
            $materials[]=[
                'id' => $raw['id'],
                'name' => $raw['name'],
                'code' => $raw['code'],
                'uom' => $raw->measurement_detail->name ?? '',
                'uom_id' => $raw['uom'],
                'max_qty' => (int)$mx_qty
            ];
        }
        // dd($materials);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kitchen.return-request',compact('materials','str_no','hotlr'));
    }

    public function returnRequestSubmit(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'itemId' => 'required|array',
            'qty' => 'required|array',
            'reason' => 'required|array',
            'str_no' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['error_validation'=>$validator->error()->all(),],422);
        }

        foreach($request->itemId as $index =>$key){
            $items = StoreRequest::where('str_no',$request->str_no)->where('item_id',$request->itemId[$index])->get(['id','request_from','expiry_date']);

            $store_data[] = [
                'str_no' => $request->str_no,
                'store_return_id' => $items[0]->id, 
                'item_id' => $request->itemId[$index],
                'qty' => $request->qty[$index],
                'unit' => $request->unit[$index],
                'reason' => $request->reason[$index],
                'created_by' => Auth::id(),
                'request_from' => $items[0]->request_from,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ];
            // insert in for stock in out management
            $item_name = RawMaterial::where('id',$request->itemId[$index])->value('name');
            // Fetch latest balance
            $latestInventoryReturn = InventoryManagement::where('item_id', $request->itemId[$index])->where('expiry_date',$items[0]->expiry_date)
                ->orderBy('created_at', 'desc')
                ->first();
            $previousBalanceReturn = $latestInventoryReturn ? $latestInventoryReturn->balance : 0;
            $newBalance = $previousBalanceReturn - $request->qty[$index];

            $inventory_managemenet = new InventoryManagement();
            $inventory_managemenet->item_id = $request->itemId[$index];
            $inventory_managemenet->item_name = $item_name;
            $inventory_managemenet->department_id = $items[0]->request_from;
            $inventory_managemenet->expiry_date = $items[0]->expiry_date;
            $inventory_managemenet->txn_date = today();
            $inventory_managemenet->qty_out = $request->qty[$index];
            $inventory_managemenet->balance = $newBalance;
            $inventory_managemenet->save();   
            
            $latestInventory = InventoryManagement::where('item_id', $request->itemId[$index])->where('expiry_date',$items[0]->expiry_date)
                ->orderBy('created_at', 'desc')
                ->first();
            $previousBalance = $latestInventory ? $latestInventory->balance : 0;
            $newBalance = $previousBalance + $request->qty[$index];

            $inventory_managemenet = new InventoryManagement();
            $inventory_managemenet->item_id = $request->itemId[$index];
            $inventory_managemenet->item_name = $item_name;
            $inventory_managemenet->department_id = 1;
            $inventory_managemenet->expiry_date = $items[0]->expiry_date;
            $inventory_managemenet->txn_date = today();
            $inventory_managemenet->qty_in = $request->qty[$index];
            $inventory_managemenet->balance = $newBalance;
            $inventory_managemenet->save();   
            
            // stock calculation
            $chk_stock_department = Stock::where('item_id',$request->itemId[$index])->where('department_id',$items[0]->request_from)->where('expiry_date',$items[0]->expiry_date)->value('qty');
            $update_stock_department = Stock::where('item_id',$request->itemId[$index])->where('department_id',$items[0]->request_from)->where('expiry_date',$items[0]->expiry_date)->update([
                'qty' => $chk_stock_department - $request->qty[$index]
            ]);

            $chk_stock = Stock::where('item_id',$request->itemId[$index])->where('department_id',1)->where('expiry_date',$items[0]->expiry_date)->value('qty');
            $update_stock = Stock::where('item_id',$request->itemId[$index])->where('department_id',1)->where('expiry_date',$items[0]->expiry_date)->update([
                'qty' => $chk_stock + $request->received_qty[$index]
            ]);
        }

        $store_data = StoreReturnRequest::insert($store_data);
        if($store_data){
            return response()->json(['success'=>'Return request submitted succesfully'],200);
        }else{
            return response()->json(['error_success'=>'Return request not submitted']);
        }
    }

    public function returnRequestList(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kitchen.return-request-list',compact('hotlr'));
    }
    
    public function returnRequestVeiw(Request $request){
        if ($request->ajax()) {
            $stock_request = StoreReturnRequest::get();
                return DataTables::of($stock_request)
                ->addIndexColumn()
                ->addColumn('created_at', function($row) {
                    return $row->created_at->format('d-m-Y');
                })
                ->addColumn('str_no', function($row) {
                    return $row->str_no;
                })
                ->addColumn('item', function($row) {
                    return $row->itemData->name; // Count of item_id for this str_no
                })
                ->addColumn('qty', function($row) {
                    return $row->qty;
                })
                ->addColumn('unit', function($row) {
                    return $row->measurement_detail->name;
                })
                ->addColumn('reason', function($row) {
                    return $row->reason;
                })
                ->rawColumns([''])
                ->make(true);
        }
    }
}
