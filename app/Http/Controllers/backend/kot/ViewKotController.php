<?php

namespace App\Http\Controllers\backend\kot;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\InventoryManagement;
use App\Models\ItemRequireMaterial;
use App\Models\Kot;
use App\Models\KotItem;
use App\Models\Measurement;
use App\Models\PaymentMethod;
use App\Models\RawMaterial;
use App\Models\RoomNumber;
use App\Models\RoomType;
use App\Models\Stock;
use App\Models\Table;
use App\Models\Waiter;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ViewKotController extends Controller
{
    public function index(Request $request){
        $payments = PaymentMethod::where('status',1)->whereNull('deleted_at')->get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kot.kot',compact('payments','hotlr'));
    }

    public function allDetail(){
        $companies = HotlrConfiguration::where('id',1)->pluck('restaurant_area');
        $area = explode(',',$companies[0]);
        $tableArea = [];
        $roomList = [];
        foreach($area as $table_area){
            $t = [];
            $tables = Table::where('status',1)->where('area',$table_area)->get();
            if(sizeof($tables) > 0){
                foreach($tables as $tab){
                    $chk_kot = Kot::where('type','Table')->where('type_number',$tab->number)->where('order_status','Pending')->count();
                    if($chk_kot == 0){
                        $data = [
                            'id' => $tab->id,
                            'capacity' => $tab->capacity,
                            'number' => $tab->number,
                        ];
                        array_push($t,$data);
                    }
                }
            }
            if(count($t) > 0){
                $data = [
                    'area' => $table_area,
                    'table' => $t
                ];
                array_push($tableArea,$data);
            }
        }
        // $room_category = RoomCategory::where('status','active')->whereNull('deleted_at')->get();
        // foreach($room_category as $cat){
            
        // }

        $room_types = RoomType::get();
        foreach($room_types as $type){
            $a = [];
            $room_number = RoomNumber::where('status','active')->where('category_id',$type->id)->whereNull('deleted_at')->get(['room_number','id']);
            if(sizeof($room_number) > 0){
                foreach($room_number as $room){
                    $chk_kot = Kot::where('type','Room')->where('type_number',$room->room_number)->where('order_status','Pending')->count();
                    if($chk_kot == 0){
                        $data = [
                            'id' => $room->id,
                            'room_number' => $room->room_number,
                            'chk_kot' =>$chk_kot
                        ];
                        array_push($a,$data);
                    }
                }
            }
            if(count($a) > 0){
                $data = [
                    'category_id' => $type->id,
                    'name' => $type->room_category,
                    'rooms' => $a
                ];
                array_push($roomList,$data);
            }
        }

        $payment_methods = PaymentMethod::where('status',1)->whereNull('deleted_at')->get();

        $kotDetail = [];
        $kots = Kot::whereIn('order_status',['Pending','Prepared'])->whereNull('menu_type')->get();
        foreach($kots as $kot){
            $date = new DateTime('now', new DateTimeZone('Asia/Kolkata')); 
            $a =  $date->format('Y-m-d H:i:s');
            $date2 = new DateTime($a); // current date and time
            $date1 = new DateTime($kot->order_time); // given date
            $diffInSeconds = $date2->getTimestamp() - $date1->getTimestamp();
            $diffInMinutes = floor($diffInSeconds / 60);
            $data = [
                'id' => $kot->id,
                'kot_id' => $kot->kot_id,
                'type' => $kot->type,
                'number' => str_pad($kot->type_number, 2, '0', STR_PAD_LEFT),
                'grand_total' => round($kot->grand_total),
                'diff' =>  $diffInMinutes,
            ];
            array_push($kotDetail,$data);
        }
       
        $kotDetailComplete = [];
        $kots = Kot::where('order_status','Delivered')->whereNull('menu_type')->orderBy('updated_at', 'desc')->get();
        foreach($kots as $kot){
            $date = new DateTime('now', new DateTimeZone('Asia/Kolkata')); 
            $a =  $date->format('Y-m-d H:i:s');
            $date2 = new DateTime($a); // current date and time
            $date1 = new DateTime($kot->order_time); // given date
            $diff = $date2->diff($date1);
            $data = [
                'id' => $kot->id,
                'kot_id' => $kot->kot_id,
                'type' => $kot->type,
                'number' => str_pad($kot->type_number, 2, '0', STR_PAD_LEFT),
                'grand_total' => round($kot->grand_total),
                'diff' =>  $diff->format('%I'),
            ];
            array_push($kotDetailComplete,$data);
        }
        return response()->json(['success' => 'Data Fetched Successfully','area'=>$area,'tableArea'=>$tableArea,'roomList'=>$roomList,'payment_methods'=>$payment_methods,'kotDetail' => $kotDetail,'kotDetailComplete' => $kotDetailComplete],200);
    }

    public function getKotDetail(Request $request){
        $kotDetails = [];
        $kots = Kot::where('id',$request->id)->get(['type','type_number','date']);
        $kot_ids = Kot::where('kot_id',$request->kot_id)->whereNull('menu_type')->where('payment_type','Due')->get();
        foreach($kot_ids as $kot){
            $kot_items = KotItem::where('kot_id',$kot['id'])->get();
            $data = [
                'id' => $kot['id'],
                'type' => $kot['type'],
                'number' => $kot['type_number'],
                'note' => $kot['note'],
                'order_time' => $kot['order_time'],
                'time' => date('H:m', strtotime($kot['order_time'])),
                'date' => $kot['date'],
                'note' => $kot['note'],
                'is_complimentary' => $kot['is_complimentary'],
                'waiter_id' => $kot['waiter_id'],
                'waiter_name' => optional($kot->waiterDetail)->name ?? '',
                'apply_coupon' => $kot['apply_coupon'],
                'coupon_code' => $kot['coupon_code'],
                'coupon_amount' => $kot['coupon_amount'],
                'total' => $kot['total'],
                'discount_type' => $kot['discount_type'],
                'discount_value' => $kot['discount_value'],
                'sub_total' => $kot['sub_total'],
                'total_gst' => $kot['total_gst'],
                'adjustment' => $kot['adjustment'],
                'grand_total' => $kot['grand_total'],
                'total_paid' => $kot['total_paid'],
                'payment_type' => $kot['payment_type'],
                'card_number' => $kot['card_number'],
                'upi_type' => $kot['upi_type'],
                'reference_number' => $kot['reference_number'],
                'contact_person_name' => $kot['contact_person_name'],
                'contact_person_mobile' => $kot['contact_person_mobile'],
                'order_status' => $kot['order_status'],
                'items' => $kot_items,
                'narration' => $kot['narration'],
            ];
            array_push($kotDetails,$data);
        }
        return response()->json(['success' => 'Data Fetched Successfully','kotDetail' => $kotDetails,'kots' => $kots],200);
    }
    
    public function getQrKotDetail(Request $request){
        $kotDetails = [];
        $kots = Kot::where('id',$request->id)->get();
        // $kot_ids = Kot::where('kot_id',$request->kot_id)->where('payment_type','Due')->get();
        foreach($kots as $kot){
            $kot_items = KotItem::where('kot_id',$kot['id'])->get();

            $waiter_prev = Kot::where('kot_id',$kot['kot_id'])->value('waiter_id');
            $data = [
                'id' => $kot['id'],
                'type' => $kot['type'],
                'number' => $kot['type_number'],
                'note' => $kot['note'],
                'order_time' => $kot['order_time'],
                'time' => date('H:m', strtotime($kot['order_time'])),
                'date' => $kot['date'],
                'note' => $kot['note'],
                'is_complimentary' => $kot['is_complimentary'],
                'waiter_id' => $kot['waiter_id'],
                'waiter_name' => optional($kot->waiterDetail)->name ?? '',
                'apply_coupon' => $kot['apply_coupon'],
                'coupon_code' => $kot['coupon_code'],
                'coupon_amount' => $kot['coupon_amount'],
                'total' => $kot['total'],
                'discount_type' => $kot['discount_type'],
                'discount_value' => $kot['discount_value'],
                'sub_total' => $kot['sub_total'],
                'total_gst' => $kot['total_gst'],
                'adjustment' => $kot['adjustment'],
                'grand_total' => $kot['grand_total'],
                'total_paid' => $kot['total_paid'],
                'payment_type' => $kot['payment_type'],
                'card_number' => $kot['card_number'],
                'upi_type' => $kot['upi_type'],
                'reference_number' => $kot['reference_number'],
                'contact_person_name' => $kot['contact_person_name'],
                'contact_person_mobile' => $kot['contact_person_mobile'],
                'order_status' => $kot['order_status'],
                'items' => $kot_items,
                'waiter_prev' => $waiter_prev
                
            ];
            array_push($kotDetails,$data);
        }
        return response()->json(['success' => 'Data Fetched Successfully','kotDetail' => $kotDetails,'kots' => $kots],200);
    }

    public function update(Request $request){
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'total_cost' => ['required'],
                'cartItem' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        $total_item_list = 0;
        $total_item = 0;
        $total_kot = 0;
        $kots = [];
        foreach($request->cartItem as $kot){
            array_push($kots,$kot['id']);
            foreach($kot['items'] as $item){
                $updateItemKot = KotItem::where('id',$item['id'])->update([
                    'qty' => $item['qty'],
                    'total' => $item['total'],
                    'gst_amount' => $item['gst_amount'],
                    'grand_amount' => $item['grand_amount'],
                ]);
                if($updateItemKot){
                    $total_item++;
                }
                $total_item_list++;
            }
        }
        
        $ajdust = $request->adjustment;
        if($request->adjustment == ''){
            $ajdust = 0;
        }
        $status ='Pending';
        if($request->total_paid > 0){
            $status ='Delivered';
        }
        
        if($request->paymentType == 'Complete with Due'){
            $status ='Delivered';
        }

        foreach($kots as $kot){
            $updateKot = Kot::where('id',$kot)->update([
                'is_complimentary' => $request->complimentary,
                'apply_coupon' => $request->apply_coupon,
                'coupon_code' => $request->coupon_code,
                'coupon_amount' => $request->coupon_value,
                'total' => $request->total_cost,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'sub_total' => $request->subtotal,
                'total_gst' => $request->gst_amount,
                'adjustment' => $ajdust,
                'grand_total' => $request->grand_total,
                'total_paid' => $request->total_paid,
                'payment_type' => $request->paymentType,
                'card_number' => $request->payment_card,
                'upi_type' => $request->other_type,
                'reference_number' => $request->other_ref,
                'order_status' => $status,
                'narration' => $request->narration
            ]);
            if($updateKot){

                $kot_item_details = KotItem::where('kot_id',$kot)->get();
                foreach($kot_item_details as $kotIt){
                    $items = ItemRequireMaterial::where('item_id',$kotIt['item_id'])->get(['material_id','qty','uom']);
                    if(sizeof($items) > 0){
                        $current_qty = $items[0]->qty;
                        $measurement = Measurement::where('child_symbol',$items[0]->uom)->value('conversion');
                        if($measurement > 0){
                            $current_qty = ($items[0]->qty / $measurement);
                        }

                        $item_name = RawMaterial::where('id',$items[0]->material_id)->value('name');
                        // Fetch latest balance of Stock
                        $latestInventory = InventoryManagement::where('item_id', $items[0]->material_id)->where('department_id',2)
                            ->orderBy('created_at', 'desc')
                            ->first();
                        $previousBalance = $latestInventory ? $latestInventory->balance : 0;
                        $newBalance = $previousBalance - $current_qty;

                        $inventory_managemenet = new InventoryManagement();
                        $inventory_managemenet->item_id = $items[0]->material_id;
                        $inventory_managemenet->item_name = $item_name;
                        $inventory_managemenet->department_id = 2;
                        $inventory_managemenet->txn_date = today();
                        $inventory_managemenet->qty_out = $current_qty;
                        $inventory_managemenet->balance = $newBalance;
                        $inventory_managemenet->save();

                        $chk_stock = Stock::where('item_id',$items[0]->material_id)->where('department_id',1)->value('qty');
                        $update_stock = Stock::where('item_id',$items[0]->material_id)->where('department_id',2)->update([
                            'qty' => $chk_stock - $current_qty
                        ]);
                    }
                }

                $total_kot++;
            }
        }
        
        if($total_kot == count($kots) && $total_item == $total_item_list) {
            return response()->json(['success' => 'Data updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something Went Wrong'], 400);
        }
    }

    public function printKotInvoice($id){
        $kotDetails = [];
        $kotItems = [];
        $kotIds = [];
        $kots = Kot::where('kot_id',$id)->get();
        foreach($kots as $kot){
            array_push($kotIds,$kot['id']);
        }

        $distictItem = [];
        $dist_kot = KotItem::whereIn('kot_id',$kotIds)->select('item_id')->distinct()->get();
        foreach($dist_kot as $dist_item){
            $items = KotItem::whereIn('kot_id',$kotIds)->where('item_id',$dist_item['item_id'])->get();
            $total_qty = 0;
            foreach($items as $item){
                $total_qty += $item['qty'];
            }
            
            $gst_amount = ($items[0]['gst']/100) * ($total_qty * $items[0]['price']);
            $mrp = $gst_amount + ($total_qty * $items[0]['price']);
            $data =[
                'item_id' => $items[0]['item_id'],
                'item_name' => $items[0]['item_name'],
                'qty' => $total_qty,
                'price' => $items[0]['price'],
                'total_price' => $total_qty * $items[0]['price'],
                'gst' => $items[0]['gst'],
                'gst_amount' => $gst_amount,
                'grand_total' => $mrp
            ];
            array_push($distictItem,$data);
        }
        
        $hotel = HotlrConfiguration::get(['name','address','pincode','gst','state','email','mobile']);
        $status = $kots[0]['payment_type'];
        if($kots[0]['is_complimentary'] == 1){
            $status = 'Complimentary';
        }
        $basic_detail = [
            'token' => date('Ym').$kots[0]['id'],
            'type' => $kots[0]['type'],
            'type_number' =>  $kots[0]['type_number'],
            'date' =>  $kots[0]['date'],
            'order_time' =>  $kots[0]['order_time'],
            'note' =>  $kots[0]['note'],
            'is_complimentary' =>  $kots[0]['is_complimentary'],
            'apply_coupon' =>  $kots[0]['apply_coupon'],
            'coupon_code' =>  $kots[0]['coupon_code'],
            'coupon_amount' =>  $kots[0]['coupon_amount'],
            'total' =>  $kots[0]['total'],
            'discount_type' =>  $kots[0]['discount_type'],
            'discount_value' =>  $kots[0]['discount_value'],
            'sub_total' =>  $kots[0]['sub_total'],
            'total_gst' =>  $kots[0]['total_gst'],
            'adjustment' =>  $kots[0]['adjustment'],
            'grand_total' =>  $kots[0]['grand_total'],
            'total_paid' =>  $kots[0]['total_paid'],
            'payment_type' =>  $status,
            'card_number' =>  $kots[0]['card_number'],
            'upi_type' =>  $kots[0]['upi_type'],
            'reference_number' =>  $kots[0]['reference_number'],
            'contact_person_name' =>  $kots[0]['contact_person_name'],
            'status' =>  $kots[0]['order_status'],
            'bill_by' =>  optional($kots[0]->user_detail)->name,
        ];
        // dd($basic_detail);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kot.print-kot',compact('distictItem','basic_detail','hotel','hotlr'));
    }

    public function cancelKot(Request $request){
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'kot_id' => ['required'],
                'reason' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }
        $updateKot = Kot::where('id',$request->kot_id)->update([
            'cancel_at' => now(),
            'order_status' => 'Cancelled',
            'cancel_reason' => $request->reason,
        ]);

        if($updateKot) {
            return response()->json(['success' => 'KOT Cancel successfully'], 200);
        } else {
            return response()->json(['error' => 'Something Went Wrong'], 400);
        }
    }

    public function getKotPrint($para){

        $kotDetails = [];
        $kotItems = [];
        $kotIds = [];
        $parameter = explode('=',$para);
        $id = $parameter[1];
        $kots = Kot::where('id',$id)->get();
        foreach($kots as $kot){
            array_push($kotIds,$kot['id']);
        }

        $distictItem = [];
        $dist_kot = KotItem::whereIn('kot_id',$kotIds)->select('item_id')->distinct()->get();
        foreach($dist_kot as $dist_item){
            $items = KotItem::whereIn('kot_id',$kotIds)->where('item_id',$dist_item['item_id'])->get();
            $total_qty = 0;
            foreach($items as $item){
                $total_qty += $item['qty'];
            }
            
            $gst_amount = ($items[0]['gst']/100) * ($total_qty * $items[0]['price']);
            $mrp = $gst_amount + ($total_qty * $items[0]['price']);
            $data =[
                'item_id' => $items[0]['item_id'],
                'item_name' => $items[0]['item_name'],
                'qty' => $total_qty,
                'price' => $items[0]['price'],
                'total_price' => $total_qty * $items[0]['price'],
                'gst' => $items[0]['gst'],
                'gst_amount' => $gst_amount,
                'grand_total' => $mrp
            ];
            array_push($distictItem,$data);
        }
        
        $hotel = HotlrConfiguration::get(['name','address','pincode','gst','state','email','mobile']);
        $waiters = Waiter::where('id',$kots[0]['waiter_id'])->value('name');
        $basic_detail = [
            'token' => date('Ym',strtotime($kots[0]['created_at'])).$id,
            'type' => $kots[0]['type'],
            'type_number' =>  $kots[0]['type_number'],
            'date' =>  $kots[0]['date'],
            'order_time' =>  $kots[0]['order_time'],
            'note' =>  $kots[0]['note'],
            'waiter' => $waiters,
            'is_complimentary' =>  $kots[0]['is_complimentary'],
            'apply_coupon' =>  $kots[0]['apply_coupon'],
            'coupon_code' =>  $kots[0]['coupon_code'],
            'coupon_amount' =>  $kots[0]['coupon_amount'],
            'total' =>  $kots[0]['total'],
            'discount_type' =>  $kots[0]['discount_type'],
            'discount_value' =>  $kots[0]['discount_value'],
            'sub_total' =>  $kots[0]['sub_total'],
            'total_gst' =>  $kots[0]['total_gst'],
            'adjustment' =>  $kots[0]['adjustment'],
            'grand_total' =>  $kots[0]['grand_total'],
            'total_paid' =>  $kots[0]['total_paid'],
            'payment_type' =>  $kots[0]['payment_type'],
            'card_number' =>  $kots[0]['card_number'],
            'upi_type' =>  $kots[0]['upi_type'],
            'reference_number' =>  $kots[0]['reference_number'],
            'contact_person_name' =>  $kots[0]['contact_person_name'],
            'status' =>  $kots[0]['order_status'],
            'bill_by' =>  optional($kots[0]->user_detail)->name,
        ];
        // dd($basic_detail);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kot.kot-print',compact('distictItem','basic_detail','hotel','hotlr'));
    }

}
