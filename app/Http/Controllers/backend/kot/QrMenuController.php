<?php

namespace App\Http\Controllers\backend\kot;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Kot;
use App\Models\KotItem;
use App\Models\PaymentMethod;
use App\Models\ReservationRoom;
use App\Models\Waiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QrMenuController extends Controller
{
    public function index(Request $request){
        $date = date('Y-m-d');
        $kotList = [];
        $kots = Kot::where('menu_type','QR')->where('status',1)->where('date',$date)->with(['room:id,room_number', 'table:id,number'])->get(['id','menu_id','kot_id','type','type_number','date','order_time','total_item_qty','total','sub_total','total_gst','grand_total']);
        foreach($kots as $kot){
            
            $kotList[] = [
                'id' => $kot->id,
                'menu_id' => $kot->menu_id,
                'kot_id' => $kot->kot_id,
                'type' => $kot->type,
                'type_number' => $kot->type_number,
                'date' => date('d-m-Y',strtotime($kot->date)),
                'date_time' => date('d-m-Y h:i A',strtotime($kot->order_time)),
                'total_item_qty' => $kot->total_item_qty,
                'total' => $kot->total,
                'sub_total' => $kot->sub_total,
                'total_gst' => $kot->total_gst,
                'grand_total' => $kot->grand_total,
            ];
        }

        $payment_methods = PaymentMethod::where('status',1)->whereNull('deleted_at')->get();
        $waiters = Waiter::where('status','active')->get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.kot.qr-menu-orders',compact('kotList','payment_methods','waiters','hotlr'));
    }

    public function getKotQrDetailUpdate(Request $request){

        DB::beginTransaction();
        try{
            $kot_added_detail = Kot::where('id',$request->id)->get();

            $rndno = substr((md5(rand())),0, 15);
            $type = $kot_added_detail[0]->type;
            $number = $kot_added_detail[0]->type_number;
            $reserve_room_id_number = $kot_added_detail[0]->reserve_room_id;
            
            $kot_chk = Kot::where('type',$type)->where('type_number',$number)->where('order_status','Pending')->pluck('kot_id');
            if(sizeof($kot_chk) > 0){
                $rndno =  $kot_chk[0];
            }

            if($type == 'Room'){
                $kot_room = ReservationRoom::where('room_alloted',$number)->where('guest_status','checkin')->get(['reservation_id','id']);
                if(sizeof($kot_room) > 0){
                    $rndno =  $kot_room[0]->reservation_id;
                    $reserve_room_id_number = $kot_room[0]->id;
                }
            }

            $ajdust = $request->adjustment;
            if($request->adjustment == ''){
                $ajdust = 0;
            }

            $kot_item = KotItem::where('kot_id',$request->id)->delete();
            $count_item_qty = 0;

            foreach($request->cartItem as $level){

                foreach($level['items'] as $item){
                    // dd($item);
                    $item_insert_detail = new KotItem();
                    $item_insert_detail->kot_id = $request->id;
                    $item_insert_detail->item_id = $item['id'];
                    $item_insert_detail->item_name = $item['item_name'];
                    $item_insert_detail->qty = $item['qty'];
                    $item_insert_detail->price = $item['price'];
                    $item_insert_detail->total = $item['total'];
                    $item_insert_detail->gst = $item['gst'];
                    $item_insert_detail->gst_amount = $item['gst_amount'];
                    $item_insert_detail->grand_amount = $item['grand_amount'];
                    $item_insert_detail->save();

                    $count_item_qty += $item['qty'];
                }
            }
            
            $updateKot = Kot::where('id',$request->id)->update([
                'menu_type' => NULL,
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
                'total_item_qty' => $count_item_qty,
                'waiter_id' => $request->waiter_id,
                'narration' => $request->narration,
                'bill_by' => Auth::user()->id
            ]);
            
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }

        // dd($request->all());
    }
}
