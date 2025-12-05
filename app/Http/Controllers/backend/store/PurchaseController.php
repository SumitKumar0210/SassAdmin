<?php

namespace App\Http\Controllers\backend\store;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\InventoryManagement;
use App\Models\PurchaseInwardLog;
use App\Models\PurchaseItemDetail;
use App\Models\PurchaseOrder;
use App\Models\RawMaterial;
use App\Models\Stock;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    public function purchaseOrder(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.store.purchase.purchase-order-list',compact('hotlr'));
    }

    public function purchaseList(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.store.purchase.purchase-list',compact('hotlr'));
    }
    
    public function purchaseItemVeiw(Request $request){
        if($request->ajax()){

            $purchaseorder = PurchaseOrder::where('status','Done')->get();
            return DataTables::of($purchaseorder)
            ->addIndexColumn()
            ->addColumn('purchase_id',function($row){
                return $row->purchase_id;
            })
            ->addColumn('item', function($row) {
                return PurchaseItemDetail::where('purchase_id', $row->purchase_id)->count();
            })
            ->addColumn('qty',function($row){
                 return PurchaseItemDetail::where('purchase_id', $row->purchase_id)->where('received_qty','>',0)->count();
            })
            ->addColumn('vendor',function($row){
                return $row->vendorData->name ?? 'NA';
            })
            ->addColumn('created_by',function($row){
                return $row->userData->name;
            })
            ->addColumn('created_at',function($row){
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('action',function($row){
                return '<div class="ms-2" onclick="printPurchase('.$row->id.')"><i class="ri-printer-line"></i></div>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    
    public function purchaseAdd(){
        $vendors = Vendor::where('status',1)->get(['id','name']);
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
        return view('backend.modules.store.purchase.purchase-add',compact('vendors','raw_materials','materials','hotlr'));
    }

    public function purchaseAddSubmit(Request $request){
        $validator = Validator::make($request->all(),[
            'vendor' => 'required',
            'itemId' => 'required|array',
            'qty' => 'required|array'
        ]);
        if($validator->fails()){
            return response()->json(['error_validation'=>$validator->error()->all(),],422);
        }

        $hotlr = HotlrConfiguration::where('id',1)->value('invoice_prefix');
        $only_chars = preg_replace('/[^a-z]/i', '', $hotlr);
        $pre_purchase_id = PurchaseOrder::latest()->value('purchase_id');
        $pre_purchase_id_num = substr($pre_purchase_id,8); // fetch latest purchase_id number
        $purchase_items = [];
        $purchase_orders = new PurchaseOrder();
        $purchase_orders->purchase_id = $only_chars.'_000'.(int)$pre_purchase_id_num + 1;
        $purchase_orders->vendor_id = $request->vendor;
        $purchase_orders->total_qty =array_sum($request->qty);
        $purchase_orders->created_by = Auth::id();
        if($purchase_orders->save()){
            foreach($request->itemId as $index => $name){
                if($request->qty[$index] > 0){
                    $purchase_items[] = [
                        'purchase_id' => $only_chars.'_000'.(int)$pre_purchase_id_num + 1,
                        'item_id' =>$request->itemId[$index],
                        'expected_qty' =>$request->qty[$index],
                        'unit' =>$request->unit[$index],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                }
            }
            $purchase_insert = PurchaseItemDetail::insert($purchase_items);
            if($purchase_insert){
                return response()->json(['success'=>'Purchase items added successfully'],200);
            }else{
                return response()->json(['error_success'=>'Purchase items not added']);
            }
        }
    }

    public function getPurchaseItem(Request $request){
        $getData = PurchaseItemDetail::where('id',$request->id)->get();
        $purchase_items = [];
        $purchase_items[]=[
            'id' => $getData[0]['id'],
            'purchase_id' => $getData[0]['purchase_id'],
            'item' => $getData[0]->itemData->name,
            'qty' => $getData[0]['expected_qty']
        ];
        return response()->json(['success'=>'Purchase item data fetched','data'=>$purchase_items],200);
    }

    public function purchaseQtyUpdate(Request $request){
        $update = PurchaseItemDetail::where('id',$request->id)->update([
            'expected_qty' => $request->qty
        ]);
        if($update){
            return response()->json(['success'=>'Purchase items updated successfully'],200);
        }else{
            return response()->json(['error_success'=>'Purchase items not updated']);
        }
    }

    public function purchaseOrderVeiw(Request $request){
        if($request->ajax()){
            $purchaseorder = PurchaseOrder::where('status','!=','Done')->get();
            return DataTables::of($purchaseorder)
            ->addIndexColumn()
            ->addColumn('purchase_id',function($row){
                return $row->purchase_id;
            })
            ->addColumn('order_item', function($row) {
                return PurchaseItemDetail::where('purchase_id', $row->purchase_id)->count();
            })
            ->addColumn('received_item',function($row){
                 return PurchaseItemDetail::where('purchase_id', $row->purchase_id)->where('received_qty','>',0)->count();
            })
            ->addColumn('vendor',function($row){
                return $row->vendorData->name ?? 'NA';
            })
            ->addColumn('created_by',function($row){
                return $row->userData->name;
            })
            ->addColumn('created_at',function($row){
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('status',function($row){
                $total_expected = PurchaseItemDetail::where('purchase_id', $row->purchase_id)->sum('expected_qty');
                $total_received = PurchaseItemDetail::where('purchase_id', $row->purchase_id)->sum('received_qty');
                if($total_received == 0){
                    return 'Pending';
                }
                else if($total_expected == $total_received ){
                    return 'Received';
                }else{
                    return 'Partial';
                }
            })
            ->addColumn('action',function($row){
                $total_expected = PurchaseItemDetail::where('purchase_id', $row->purchase_id)->sum('expected_qty');
                $total_received = PurchaseItemDetail::where('purchase_id', $row->purchase_id)->sum('received_qty');
                
                $html = '';
                $html .= '<ul class="action"> ';
                    if($total_received != $total_expected){
                        $html .='<li class="edit"> <a href="#"><i class="ri-arrow-down-line" onclick="goodsEntry('.$row->id.')"></i></a></li>';
                    }
                    $html .= '<li class="ms-2" onclick="printPurchase('.$row->id.')"><i class="ri-printer-line"></i></li>
                </ul>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function goodsEntryPage($id){
        $purchase = PurchaseOrder::where('id',$id)->get(['vendor_id','purchase_id','status']);
        $vendor = Vendor::where('id',$purchase[0]->vendor_id)->pluck('name');
        $purchaseItems = PurchaseItemDetail::where('purchase_id',$purchase[0]->purchase_id)->get();
        $item_inwards = [];
        $purchase_inward_days = PurchaseInwardLog::where('purchase_id',$purchase[0]->purchase_id)->get(['total_qty','item_id','created_at']);
        if(!empty($purchase_inward_days)){
            foreach($purchase_inward_days as $inw){
                
                $item_inwards[] = [
                    'item_id' => $inw->item_id,
                    'item' => optional($inw->itemData)->name,
                    'qty' => $inw->total_qty,
                    'date' => date('d-m-Y',strtotime($inw->created_at)),
                ];

            }
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.store.purchase.goods-entry',compact('purchase','purchaseItems','item_inwards','hotlr'));
    }

    public function receivedQuantityUpdate(Request $request){
        foreach($request->received_items as $i => $items){
            
            $stock_item_found = PurchaseItemDetail::where('id',$items['id'])->value('received_qty');
            PurchaseItemDetail::where('id',$items['id'])->update([
                'received_qty' => $stock_item_found + $items['qty'],
                'order_status' =>'Received',
            ]);

            $items_id = PurchaseItemDetail::where('id',$items['id'])->value('item_id');
            $stock_item_found = Stock::where('item_id',$items_id)->where('department_id',1)->where('expiry_date',$request->expiry_dates[$i])->exists();
            if($stock_item_found){
                
                $prev_stock_qty = Stock::where('item_id',$items_id)->where('department_id',1)->where('expiry_date',$request->expiry_dates[$i])->value('qty');
                Stock::where('item_id',$items_id)->where('expiry_date',$request->expiry_dates[$i])->where('department_id',1)->update([
                    'qty' => $prev_stock_qty + $items['qty']
                ]);
               
            }else{
                $stocks = new Stock();
                $stocks->department_id = 1;
                $stocks->item_id = $items_id;
                $stocks->qty = $items['qty'];
                $stocks->expiry_date = $request->expiry_dates[$i];
                $stocks->save();
            }
            
            if($items['qty'] > 0){
                
                $items_id = PurchaseItemDetail::where('id',$items['id'])->value('item_id');
                $logs = new PurchaseInwardLog();
                $logs->purchase_id = $request->purchase_id;
                $logs->purchase_item_id = $items['id'];
                $logs->item_id = $items_id;
                $logs->total_qty = $items['qty'];
                $logs->expiry_date = $request->expiry_dates[$i];
                $logs->created_by = Auth::id();
                $logs->save();

                $item_name = RawMaterial::where('id',$items_id)->value('name');
                $latestInventory = InventoryManagement::where('item_id', $items_id)->where('expiry_date',$request->expiry_dates[$i])
                    ->orderBy('created_at', 'desc')
                    ->first();
                $previousBalance = $latestInventory ? $latestInventory->balance : 0;
                $newBalance = $previousBalance + $items['qty'];

                $inventory_managemenet = new InventoryManagement();
                $inventory_managemenet->item_id = $items_id;
                $inventory_managemenet->item_name = $item_name;
                $inventory_managemenet->department_id = 1;
                $inventory_managemenet->expiry_date = $request->expiry_dates[$i];
                $inventory_managemenet->txn_date = today();
                $inventory_managemenet->qty_in = $items['qty'];
                $inventory_managemenet->balance = $newBalance;
                $inventory_managemenet->save();
            }
        }

        $data = PurchaseItemDetail::where('purchase_id', $request->purchase_id)
            ->selectRaw('SUM(expected_qty) as total_expected, SUM(received_qty) as total_received')
            ->first();

        $status = ($data->total_expected == $data->total_received) ? 'Done' : 'Pending';

        PurchaseOrder::where('purchase_id',$request->purchase_id)->update([
            'status' => $status
        ]);
        return response()->json(['success'=>'Received quantity updated successfully'],200);
    }

    public function printPurchase($para){
        
        $hotlr = HotlrConfiguration::get();
        $purchases = PurchaseOrder::where('id',$para)->value('purchase_id');
        $purchaseItems = [];
        $purchase_items = PurchaseItemDetail::where('purchase_id',$purchases)->get();
        foreach($purchase_items as $item){

            $purchaseItems[] = [
                'id' => $item->id,
                'purchase_id' => $item->purchase_id,
                'item_id' => $item->item_id,
                'item_name' => optional($item->itemData)->name,
                'expected_qty' => $item->expected_qty,
                'received_qty' => $item->received_qty,
                'unit' => $item->unit,
                'order_status' => $item->order_status,
            ];
        }

        return view('backend.modules.store.purchase.purchase-print',compact('hotlr','purchaseItems'));
    }
}
