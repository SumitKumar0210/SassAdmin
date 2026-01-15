<?php

namespace App\Http\Controllers\backend\reservation;
use App\Models\HotlrConfiguration;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AdvanceAmount;
use App\Models\Kot;
use App\Models\PaymentMethod;
use App\Models\Reservation;
use App\Models\ReservationPayment;
use App\Models\ReservationRoom;
use App\Models\ReservationRoomTariffLog;
use App\Models\RoomGuest;
use App\Models\State;
use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationActionController extends Controller
{
    public function index(){
        $states = State::get(['gst_code','name']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $payments = PaymentMethod::where('status',1)->get(['id','name']);
        return view('backend.modules.reservation.create-reservation',compact('hotlr','payments','states'));
    }
    
    public function editReservation($detail){

        $states = State::get(['gst_code','name']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $payments = PaymentMethod::where('status',1)->get(['id','name']);

        parse_str($detail, $params);

        $resid = $params['reservation_room_id'] ?? 0;
        $reservation_id = $params['reservation'] ?? 0;
       
        $checkin_date = '';
        $checkin_at = '';
        $checkout_date = '';
        $checkin = '';
        $checkout = '';
        $payment_log = [];
        //$resrvationroomdetails = ReservationRoom::where('id',$resid)->get();
        $reservationroomAll = ReservationRoom::where('reservation_id',$reservation_id)->where('status','!=','Cancel')->get();
        $resrvationdetails = Reservation::where('reservation_id',$reservation_id)->get();
        $guest_count = RoomGuest::where('reservation_id',$reservation_id)->where('room_id',$resid)->count();
        $resrvationpaymentdetails = ReservationPayment::where('reservation_room_id',$resid)->where('status',1)->where('reservation_id',$reservation_id)->get();
        foreach($resrvationpaymentdetails as $detail){
            $payment_log[] = [
                'id' => $detail['id'],
                'reservation_id' => $detail['reservation_id'],
                'amount' => $detail['amount_paid'],
                'date' => date('d-m-Y',strtotime($detail['payment_date'])),
                'mode' => optional($detail->payment_mode_type)->name ?? '',
                'recorded_by' => $detail->payment_recorded_by->name ?? '',
                'type' => 'Payment'
            ];
        }
        $reservationAdvances = AdvanceAmount::where('reservation_id',$reservation_id)->where('type','Reservation')->get();
        foreach($reservationAdvances as $adv){
            $payment_log[] = [
                'id' => $adv['id'],
                'reservation_id' => $adv['reservation_id'],
                'amount' => $adv['amount'],
                'date' => date('d-m-Y',strtotime($adv['created_at'])),
                'mode' => optional($adv->payment_mode_by)->name ?? '',
                'recorded_by' => $adv->payment_recorded_by->name ?? '',
                'type' => 'Advance'
            ];
        }

        $guestRoom = [];
        $disRoom = RoomGuest::where('reservation_id',$reservation_id)->distinct()->get(['room_id']);
        foreach($disRoom as $room){
            $resRoomGuest = RoomGuest::where('reservation_id',$reservation_id)->where('status','pending')->where('room_id',$room['room_id'])->get();
            $roomID = $room['room_id'];
            $roomData = ReservationRoom::where('id',$roomID)->get(['room_alloted','room_type']);
            $data = [
                'guests' => $resRoomGuest,
                'room' => $room['room_id'],
                'guest_id' => rand(),
                'room_num' => $roomData[0]->room_alloted ?? '',
                'room_type' => $roomData[0]->room_type ?? '',
            ];
            array_push($guestRoom,$data);
        }
        
        $reservationTariffHistory = [];
        foreach($reservationroomAll as $reservation){
            if($reservation['id'] == $resid){
                $checkin_date = date('d-M-Y',strtotime($reservation['checkin']));
                $checkout_date = date('d-M-Y',strtotime($reservation['checkout']));
                $checkin_at = $reservation['checkedin_at'];
            }

            $reservationroomtariffs = ReservationRoomTariffLog::where('reservation',$reservation_id)->where('reservation_room_id',$reservation['id'])->get();
            foreach($reservationroomtariffs as $log){
                $current_status = 'Active';
                if($log->end_date == null){
                    $date = Carbon::now();
                    $days = $this->daysCalculate($log->date,$date,1);
                }else{
                    $current_status = 'In-Active';
                    $days = $this->daysCalculate($log->date,$log->end_date,1);
                }

                $total_amount = $days * (($log->amount) + ($log->extra_pax * $log->extra_pax_amount));
                $reservationTariffHistory[] = [
                    'id' => $log->id,
                    'reservation_room_id' => $log->reservation_room_id,
                    'room_type_id' => $log->room_type_id,
                    'room' => $log->room,
                    'room_id' => $log->room_id,
                    'tariff' => $log->tariff,
                    'tariff_id' => $log->tariff_id,
                    'adults' => $log->adults,
                    'childrens' => $log->childrens,
                    'infants' => $log->infants,
                    'amount' => $log->amount,
                    'extra_pax' => $log->extra_pax,
                    'extra_pax_amount' => $log->extra_pax_amount,
                    'date' => $log->date,
                    'end_date' => $log->end_date,
                    'day_stay' => $days,
                    'cost_extra_room' => $days * ($log->extra_pax * $log->extra_pax_amount),
                    'cost_room' => $days * $log->amount,
                    'grand_total' => $total_amount,
                    'current_status' => $current_status
                ];
            }
        }

        if($checkout_date <= date('Y-m-d')){
            $checkout_date = date('Y-m-d'); 
        }

        $checkin = date('Y-m-d',strtotime($checkin_date));
        $checkout = date('Y-m-d',strtotime($checkout_date));
        // Kot detail
        $kotList = [];
        $kot_detail = Kot::where('kot_id',$reservation_id)->where('reserve_room_id',$resid)->get(['id','sub_total','total_gst','grand_total','order_time','payment_type']);
        foreach($kot_detail as $detail){
            $kotList[] = [
                'id' => $detail->id,
                'sub_total' => $detail->sub_total,
                'total_gst' => $detail->total_gst,
                'grand_total' => $detail->grand_total,
                'order_time' => date('d-m-Y h:i A',strtotime($detail->order_time)),
                'payment_type' => $detail->payment_type,
                'kot_id' => $reservation_id,
            ];
        }

        $logs = [];
        $activity_logs = ActivityLog::where('reservation_id',$reservation_id)->where('room_id',$resid)->get();
        foreach($activity_logs as $activity){
            $logs[] = [
                'id' => $activity->id,
                'activity' => $activity->activity,
                'activity_by' => $activity->activity_by,
                'date' => date('d-m-Y',strtotime($activity->created_at)),
            ];
        }

        $last_company_id = $resrvationdetails[0]->company_id;
        $gst_last = $resrvationdetails[0]->company_gst;
        $last_company = $resrvationdetails[0]->company_name;
        $last_company_addr = $resrvationdetails[0]->company_address;
        // dd($guestRoom);
        return view('backend.modules.reservation.edit-reservation',compact('hotlr','resrvationdetails','payment_log','reservationroomAll','reservationroomtariffs','reservationTariffHistory','disRoom','guest_count','guestRoom','checkin_date','checkout_date','kotList','logs','checkin','checkout','checkin_at','states','payments','resrvationpaymentdetails','activity_logs','resid','reservation_id','gst_last','last_company','last_company_id','last_company_addr'));
    }

    public function daysCalculate($checkin_date,$checkout,$cal = ''){
        
        $checkin = Carbon::parse($checkin_date);
        $checkout = Carbon::parse($checkout);
        if($cal == ''){
            $now = Carbon::now();
            $checkout_time = $now->format('H:i:s');
            if($checkout > $now){
                $now = $checkout;
                $checkout_time = $now->format('12:00:00');
            }
        }else{
            $now = $checkout;
            $checkout_time = $now->format('H:i:s');
        }
        
        $days = $checkin->diffInDays($now);
        $checkin_time = $checkin->format('H:i:s');
        

        $checkin_seconds = strtotime($checkin_time);
        $checkout_seconds = strtotime($checkout_time);

        $before_12 = strtotime('12:00:00');
        $after_14 = strtotime('14:00:00');

        if ($days == 0) {
            if ($checkin_seconds < $before_12 && $checkout_seconds > $after_14) {
                $days += 2;
            } else {
                $days += 1;
            }
        } else {
            if ($checkin_seconds < $before_12 && $checkout_seconds > $after_14) {
                $days += 2;
            } elseif (
                ($checkin_seconds < $before_12 && $checkout_seconds < $after_14) ||
                ($checkin_seconds > $before_12 && $checkout_seconds > $after_14)
            ) {
                $days += 1;
            }
        }

        return $days;
    }

    public function printPaymentReceipt($detail){
        parse_str($detail, $params);

        $type = $params['type'] ?? '';
        $id = $params['payment'] ?? 0;
        $hotlr = HotlrConfiguration::get();
        $paymentDetail = [];

        if ($type === 'Advance') {
            $payment = AdvanceAmount::with('payment_mode_by')->find($id);
            $amount  = $payment?->amount;
            $prefix  = 'ADV';
            $mode    = $payment?->payment_mode_by?->name ?? '';
        } else {
            $payment = ReservationPayment::with('payment_mode_type')->find($id);
            $amount  = $payment?->amount_paid;
            $prefix  = 'PAY';
            $mode    = $payment?->payment_mode_type?->name ?? '';
        }

        if ($payment) {
            $reservation = ReservationRoom::where('reservation_id', $payment->reservation_id)
                ->first(['primary_name', 'room_alloted']);

            $paymentDetail = [
                'id'          => $prefix . $payment->id,
                'amount'      => $amount,
                'mode'        => $mode,
                'in_word'     => convertToIndianCurrency($amount),
                'reservation' => $payment->reservation_id,
                'name'        => $reservation?->primary_name ?? '',
                'room'        => $reservation?->room_alloted ?? '',
                'date'        => $payment->created_at->format('d-m-Y h:i A'),
            ];
        }

        return view('backend.modules.reservation.print-payment-receipt',compact('hotlr','paymentDetail'));
    }

    public function printPaymentReceiptAll($detail){
        $payments = array_filter(
            array_map('intval', explode(',', request()->query('payment', '')))
        );

        $advances = array_filter(
            array_map('intval', explode(',', request()->query('advance', '')))
        );

        $hotlr = HotlrConfiguration::get();
        $paymentList = [];
        
        $reservation_id='';

        if(sizeof($payments)){
            foreach($payments as $pay){
                $payment = ReservationPayment::find($pay);
                $paymentList[] = [
                    'amount' => $payment?->amount_paid,
                    'mode' => $payment?->payment_mode_type->name,
                    'date' => date('d-m-Y h:i A', strtotime($payment?->created_at))
                ];
                $reservation_id = $payment?->reservation_id;
            }
        }
        if(sizeof($advances)){
            foreach($payments as $pay){
                $payment = AdvanceAmount::find($pay);
                $paymentList[] = [
                    'amount' => $payment?->amount,
                    'mode' => $payment?->payment_mode_by->name,
                    'date' => date('d-m-Y h:i A', strtotime($payment?->created_at))
                ];
                $reservation_id = $payment?->reservation_id;
            }
        }
        
        $reservation = ReservationRoom::where('reservation_id', $reservation_id)->first(['primary_name', 'room_alloted']);

        return view('backend.modules.reservation.print-payment-receipt-all',compact('hotlr','paymentList','reservation'));
    }

    public function reservationExitGuest(Request $request){
        //dd($request->all());
        DB::beginTransaction();
        
        try {
            // $update_guest = RoomGuest::where('id',$request->id)->update([
            //     'status' => 'Check-out',
            //     'checkedout_at' => Carbon::now()
            // ]);

            $room_id = RoomGuest::where('id',$request->id)->value('room_id');
            $reservation_category = ReservationRoom::where('id',$room_id)->get(['room_category_id','tariff_id','amount']);
            $tariffs = Tariff::where('room_category_id',$reservation_category[0]->room_category_id)->get();

            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Guest Exit successfully','tariff_id' => $reservation_category[0]->tariff_id ,'amount' => $reservation_category[0]->amount, 'tariffs' => $tariffs, 'room_id' => $room_id], 200);

        } catch (\Exception $e) {
         
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Guest cannot Exit, try again later ', 'message' => $e->getMessage()], 500);
        }
    }

    public function reservationTariffUpdate(Request $request){
        //dd($request->all());
        DB::beginTransaction();
        
        try {
            $room_id = RoomGuest::where('id',$request->change_tariff_reservation_room_id)->value('room_id');
            $reservation_room_detail =  ReservationRoom::where('id',$room_id)->get();
            $reservation_detail = Reservation::where('reservation_id',$reservation_room_detail[0]->reservation_id)->value('id');
            $tariff = Tariff::where('id',$request->change_tariff_list)->value('tariff_type');

            $update_last = ReservationRoomTariffLog::where('reservation',$reservation_room_detail[0]->reservation_id)->where('reservation_room_id',$request->change_tariff_reservation_room_id)->whereNull('end_date')->update([
                'end_date' => date('Y-m-d H:i:s')
            ]);

            $update_guest = RoomGuest::where('id',$request->change_tariff_reservation_room_id)->update([
                'status' => 'Check-out',
                'checkedout_at' => date('Y-m-d H:i:s')
            ]);
            $reservation_room_tariff = new ReservationRoomTariffLog();
            $reservation_room_tariff->date = date('Y-m-d H:i:s');
            $reservation_room_tariff->reservation_id = $reservation_detail;
            $reservation_room_tariff->reservation = $reservation_room_detail[0]->reservation_id;
            $reservation_room_tariff->reservation_room_id = $request->change_tariff_reservation_room_id;
            $reservation_room_tariff->room_type_id =  $reservation_room_detail[0]->room_category_id;
            $reservation_room_tariff->tariff_id = $request->change_tariff_list;
            $reservation_room_tariff->tariff = $tariff;
            $reservation_room_tariff->room_id = $reservation_room_detail[0]->room_alloted_id;
            $reservation_room_tariff->room = $reservation_room_detail[0]->room_alloted;
            $reservation_room_tariff->adults = $reservation_room_detail[0]->adults;
            $reservation_room_tariff->childrens = $reservation_room_detail[0]->childrens;
            $reservation_room_tariff->infants = $reservation_room_detail[0]->infants;
            $reservation_room_tariff->amount = $request->change_tariff_amount;
            $reservation_room_tariff->extra_pax = $reservation_room_detail[0]->extra_person;
            $reservation_room_tariff->extra_pax_amount = $request->change_tariff_amount;
            $reservation_room_tariff->save();
        
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Tariff updated successfully'], 200);
        } catch (\Exception $e) {
         
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Guest cannot Exit, try again later ', 'message' => $e->getMessage()], 500);
        }
    }
}
