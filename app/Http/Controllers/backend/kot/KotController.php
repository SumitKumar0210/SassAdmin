<?php

namespace App\Http\Controllers\backend\kot;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Kot;
use App\Models\KotItem;
use App\Models\PaymentMethod;
use App\Models\PaymentReceived;
use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Models\RoomCategory;
use App\Models\RoomNumber;
use App\Models\RoomType;
use App\Models\Table;
use App\Models\Waiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class KotController extends Controller
{

    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name','restaurant_area','item_add','notification']);
        $area = explode(',',$hotlr[0]->restaurant_area);
        $tableArea = [];
        $roomList = [];
        foreach($area as $table_area){
            $tables = Table::where('status',1)->where('area',$table_area)->get();
            if(sizeof($tables) > 0){
                $data = [
                    'area' => $table_area,
                    'table' => $tables
                ];
                array_push($tableArea,$data);
            }
        }
        
        $room_types = RoomType::get();
        foreach($room_types as $type){
            $rooms = [];
            $room_numbers = RoomNumber::where('category_id',$type->id)->where('status','active')->where('current_status','0')->get();
            foreach($room_numbers as $number){
                $rooms[] = [
                    'id' => $number->id,
                    'room_number' => $number->room_number,
                    'current_status' => $number->current_status,
                ];
            }
            if(count($rooms) > 0){
                $data = [
                    'id'=> $type->id,
                    'name'=> $type->room_category,
                    'rooms'=> $rooms
                ];
                array_push($roomList,$data);
            }
        }

        $payment_methods = PaymentMethod::where('status',1)->whereNull('deleted_at')->get();
        $lastKot = 0;
        $kot = Kot::latest('id')->first();
        if($kot == NULL){
            $lastKot = 1;
        }else{
            $lastKot = $kot['id'] + 1;
        }
        $bill_by = Auth::user()->name .' ('.Auth::user()->designation.')';
        $waiters = Waiter::where('status','active')->get();
        return view('backend.modules.kot.generate-kot',compact('area','tableArea','roomList','payment_methods','lastKot','bill_by','waiters','hotlr'));
    }

    public function store(Request $request){
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'kot_time' => ['required'],
                'total_cost' => ['required'],
                'cartItem' => ['required'],
                'basicKot' => ['required'],
                'waiter' => ['required']
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        $rndno = substr((md5(rand())),0, 15);
        $type = '';
        $number = '';
        $reserve_room_id_number ='';
        if(isset($request->basicKot)){
            $type = $request->basicKot[0]['type'];
            $number = $request->basicKot[0]['number'];
        }
       
        $kot_chk = Kot::where('type',$type)->where('type_number',$number)->where('order_status','Pending')->pluck('kot_id');
        if(sizeof($kot_chk) > 0){
            $rndno =  $kot_chk[0];
        }

        if($type == 'Room'){
            $kot_room = ReservationRoom::where('room_alloted',$number)->whereNotNull('checkedin_at')->whereNull('checkedout_at')->get(['reservation_id','id']);
            if(sizeof($kot_room) > 0){
                $rndno =  $kot_room[0]->reservation_id;
                $reserve_room_id_number = $kot_room[0]->id;
            }
        }

        $item_insert = new Kot();
        $ajdust = $request->adjustment;
        if($request->adjustment == ''){
            $ajdust = 0;
        }
        $item_insert->type = $type;
        $item_insert->type_number = $number;
        $item_insert->kot_id = $rndno;
        $item_insert->reserve_room_id = $reserve_room_id_number;
        $item_insert->date = date('Y-m-d');
        $item_insert->order_time = date('Y-m-d H:m:s');
        $item_insert->note = $request->orderNote;
        $item_insert->is_complimentary = $request->complimentary;
        $item_insert->waiter_id = $request->waiter;
        $item_insert->apply_coupon = $request->apply_coupon;
        $item_insert->coupon_code = $request->coupon_code;
        $item_insert->coupon_amount = $request->coupon_value;
        $item_insert->total = $request->total_cost;
        $item_insert->discount_type = $request->discount_type;
        $item_insert->discount_value = $request->discount_value;
        $item_insert->sub_total = $request->subtotal;
        $item_insert->total_gst = $request->gst_amount;
        $item_insert->adjustment = $ajdust;
        $item_insert->grand_total = $request->grand_total;
        $item_insert->total_paid = $request->total_paid;
        $item_insert->payment_type = $request->paymentType;
        $item_insert->card_number = $request->payment_card;
        $item_insert->upi_type = $request->other_type;
        $item_insert->reference_number = $request->other_ref;
        $item_insert->narration = $request->narration;
        $item_insert->bill_by = Auth::user()->id;
        if($request->total_paid > 0){
           $item_insert->order_status ='Delivered';
        }
        if(isset($request->person)){
            $item_insert->contact_person_name = $request->person[0]['name'];
            $item_insert->contact_person_mobile = $request->person[0]['phone'];
            // $item_insert->contact_person_email = $request->person[0]->name;
        }
        if ($item_insert->save()) {

            foreach($request->cartItem as $item){
                $item_insert_detail = new KotItem();
                $item_insert_detail->kot_id = $item_insert->id;
                $item_insert_detail->item_id = $item['id'];
                $item_insert_detail->item_name = $item['name'];
                $item_insert_detail->qty = $item['qty'];
                $item_insert_detail->price = $item['price'];
                $item_insert_detail->total = $item['total_price'];
                $item_insert_detail->gst = $item['gst'];
                $item_insert_detail->gst_amount = $item['gst_amount'];
                $item_insert_detail->grand_amount = $item['mrp'];
                $item_insert_detail->save();
            }

            return response()->json(['success' => 'Data added successfully','rnd' => $item_insert->id], 200);
        } else {
            return response()->json(['error' => 'Something Went Wrong'], 400);
        }
        return $response;
    }

    public function checkCoupon(Request $request){
        
    }

    public function recordPayment(Request $request){
        $kots = Kot::where('id',$request->kot_id)->pluck('grand_total');
        $update = Kot::where('id',$request->kot_id)->update([
            'total_paid' => $kots[0],
            'payment_type' => 'Cash',
            'order_status' => 'Delivered'
        ]);
        if($update){
            return response()->json(['success' => 'Payment updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something Went Wrong'], 400);
        }
    }

    public function getRoomDetail(){
        $roomList = [];
        $reservationRoom = ReservationRoom::where('status','Alloted')->where('room_alloted','!=','NA')->get(['room_alloted_id']);
        foreach($reservationRoom as $room){
            $roomList[] = [
                'id' => $room->room_alloted_id,
                'number' =>$room->roomData->room_number
            ];
        }
        return response()->json(['success' => 'Room Fetch successfully','roomList' => $roomList], 200);
    }

    public function convertTableRoom(Request $request){
        $reservationRoom = ReservationRoom::where('status','Alloted')->where('room_alloted',$request->room)->pluck('reservation_id');
        $update = Kot::where('id',$request->id)->update([
            'reserve_room_id' => $request->room,
            'kot_id' => $reservationRoom[0],
            'type' => 'Room',
            'type_number' => $request->number
        ]);
        if($update){
            return response()->json(['success' => 'Table Kot Converted To Room Kot successfully'], 200);
        } else {
            return response()->json(['error' => 'Something Went Wrong'], 400);
        }
    }

    public function collectPayment(Request $request){
       
        $addKotPayment = new PaymentReceived();
        $addKotPayment->type = 'Restaurant';
        $addKotPayment->type_id = $request->id;
        $addKotPayment->payment_mode = $request->pmode;
        $addKotPayment->txn_number = $request->txn ?? null;
        $addKotPayment->amount = $request->amount ?? 0;
        $addKotPayment->received_by = Auth::user()->id;
        if($addKotPayment->save()){
            $kot_payment = Kot::where('id',$request->id)->get(['payment_type','total_paid','grand_total']);
            if(sizeOf($kot_payment) > 0){
                $paid_amount = $kot_payment[0]->total_paid + $request->amount;
                // $status = $kot_payment[0]->payment_type;
                // if($paid_amount == $kot_payment[0]->grand_total){
                //     $status = 'Paid';
                // }
                $update_kot_payment = Kot::where('id',$request->id)->update([
                    'total_paid' => $paid_amount
                ]);
            }
            return response()->json(['success'=>'Payment added successfully'],200);
        }else{
            return response()->json(['error_success'=>'Payment not added']);
        }
    }

    public function callNishaSecond(){
        //this is for git
    }
}
