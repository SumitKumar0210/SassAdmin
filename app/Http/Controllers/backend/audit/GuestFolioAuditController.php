<?php

namespace App\Http\Controllers\backend\audit;

use App\Http\Controllers\Controller;
use App\Models\AdvanceAmount;
use App\Models\HotlrConfiguration;
use App\Models\Invoice;
use App\Models\PaymentMethod;
use App\Models\ReservationPayment;
use App\Models\ReservationRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GuestFolioAuditController extends Controller
{
    public function index(){
        $today = date('Y-m-d');
        $roomList = [];
        $rooms = ReservationRoom::whereDate('checkin', '<=', $today)->whereDate('checkout', '>=', $today)->where('status','!=','Cancel')->get(['id','reservation_id','primary_name','status','room_alloted']);
        foreach($rooms as $room){
            $number_of_res = ReservationRoom::where('reservation_id',$room->reservation_id)->where('room_alloted','!=','NA')->count();
            $payment_advance = AdvanceAmount::where('reservation_id',$room->reservation_id)->sum('amount');
            $payment = ReservationPayment::where('reservation_id',$room->reservation_id)->where('reservation_room_id',$room->id)->sum('amount_paid');
            $invoice = Invoice::where('reservation',$room->reservation_id)->where('reserved_room_id',$room->id)->sum('pay_amount');
            $total = $payment + $invoice + ($payment_advance/$number_of_res);
            $roomList[] = [
                'id' => $room->id,
                'reservation_id' => $room->reservation_id,
                'name' => $room->primary_name,
                'status' => $room->status,
                'room' => $room->room_alloted ?? '',
                'balance' => round($total)
            ];
        }

        $payments = PaymentMethod::where('status',1)->get(['id','name']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.nightaudit.guest-folio',compact('roomList','payments','hotlr'));
    }

    public function print(){
        $today = date('Y-m-d');
        $roomList = [];
        $rooms = ReservationRoom::whereDate('checkin', '<=', $today)->whereDate('checkout', '>=', $today)->get(['id','reservation_id','primary_name','status','room_alloted']);
        foreach($rooms as $room){
            $payment = ReservationPayment::where('reservation_id',$room->reservation_id)->where('reservation_room_id',$room->id)->sum('amount_paid');
            $invoice = Invoice::where('reservation',$room->reservation_id)->where('reserved_room_id',$room->id)->sum('pay_amount');
            $total = $payment + $invoice;
            $roomList[] = [
                'id' => $room->id,
                'reservation_id' => $room->reservation_id,
                'name' => $room->primary_name,
                'status' => $room->status,
                'room' => $room->room_alloted ?? '',
                'balance' => round($total)
            ];
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.nightaudit.guest-folio-print',compact('roomList','hotlr'));
    }

    public function recordReservationPayment(Request $request){
    //    dd($request->all());
       if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'amount' => 'required',
                'reservationid' => 'required',
                'mode' => 'required',
            ]);
    
            if($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
            $reservationpayment = new ReservationPayment();
            $reservationpayment->reservation_id = $request->reservationid;
            $reservationpayment->reservation_room_id = $request->id;
            $reservationpayment->amount_paid = $request->amount;
            $reservationpayment->payment_date = date('Y-m-d');
            $reservationpayment->payment_type = $request->mode;
            $reservationpayment->reference_number = $request->txn;
            $reservationpayment->recorded_by = Auth::user()->id;
            if($reservationpayment->save()){
                return response()->json(['success'=>'Payment Received Successfully'], 200);
            } else {
                return response()->json(['error_success'=>'Something Went wrong'], 500);
            }
        }
    }
}
