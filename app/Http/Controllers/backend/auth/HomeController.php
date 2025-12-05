<?php

namespace App\Http\Controllers\backend\auth;

use App\Http\Controllers\Controller;
use App\Models\AdvanceAmount;
use App\Models\BanquetBooking;
use App\Models\HotlrConfiguration;
use App\Models\Kot;
use App\Models\PaymentReceived;
use App\Models\ReservationPayment;
use App\Models\ReservationRoom;
use App\Models\Reservation;
use App\Models\RoomNumber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function dashboard(){ 

        $roomnum = RoomNumber::where('status','active')->count();
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        
        $new_booking_percentage = 0;
        $new_booking = Reservation::whereDate('created_at',$today)->count();
      
        $new_booking_yes = Reservation::whereDate('created_at',$yesterday)->count();
        if($new_booking > 0 && $new_booking_yes > 0){
            $new_booking_percentage = ($new_booking/$new_booking_yes)*100;
        }

        $check_ins_per = 0;
        $check_outs_per = 0;

        if($roomnum > 0){

            $check_ins = ReservationRoom::whereDate('checkedin_at',$today)->count();
            $check_ins_per = ($check_ins/$roomnum)*100;
    
            $check_outs = ReservationRoom::whereDate('checkedout_at',$today)->count();
            $check_outs_per = ($check_outs/$roomnum)*100;
        }

        $revenue = 0;
        $reservation_payment = ReservationPayment::whereDate('created_at',$today)->sum('amount_paid');
        $advance_reservation = AdvanceAmount::whereDate('created_at',$today)->sum('amount');
        $banquet_booking = BanquetBooking::whereDate('created_at',$today)->where('status',1)->sum('advance_paid');
        $kot_total = Kot::whereDate('created_at',$today)->where('payment_type','Paid')->sum('total_paid');
        $payment_recerved = PaymentReceived::whereDate('created_at',$today)->sum('amount');

        $revenue = $reservation_payment + $advance_reservation + $banquet_booking + $kot_total + $payment_recerved;
        $occupied = 0;
        $available = 0;
        $not_ready = 0;
        $rooms = RoomNumber::where('status','active')->get(['current_status']);
        foreach($rooms as $r){
            if($r['current_status'] == 0){
                $occupied++;
            }else if($r['current_status'] > 0){
               $not_ready++;
            }else{
                $available++;
            }
        }
        
        $reservedRoom = [];
        $reservations = ReservationRoom::whereDate('checkedin_at',$today)->get();
        foreach($reservations as $room){
            $status = 'Checkin';
            if($room->checkedout_at != null){
                $status = 'Check out';
            }
            $days = 'Night';
            if($room->daystay > 1){
                $days = 'Nights';
            }
            $reservedRoom[] = [
                'reservation_id' => $room->reservation_id,
                'guest_name' => $room->primary_name,
                'room_type' => optional($room->room_type_detail)->room_category,
                'room' =>  $room->room_alloted,
                'duration' => $room->daystay,
                'days' => $days,
                'checkin' => date('M d, Y', strtotime($room->checkedin_at)),
                'checkout' => date('M d, Y', strtotime($room->checkedout_at)),
                'status' => $status
            ];
        }
        
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.dashboard',compact('new_booking','new_booking_yes','new_booking_percentage','check_ins','check_ins_per','check_outs','check_outs_per','roomnum','revenue','occupied','not_ready','available','reservedRoom','hotlr'));
    }

    public function dashboardChart(){
        $roomnum = RoomNumber::where('status','active')->count();
        $occupied = 0;
        $available = 0;
        $not_ready = 0;
        $rooms = RoomNumber::where('status','active')->get(['current_status']);
        foreach($rooms as $r){
            if($r['current_status'] == 0){
                $occupied++;
            }else if($r['current_status'] > 0){
               $not_ready++;
            }else{
                $available++;
            }
        }

        $today = date('Y-m-d');
        $new_booking = Reservation::whereDate('created_at',$today)->count();

        // monthly revenue
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $year = date('Y');

            // First day of month
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $startDate = "$year-$month-01";
            $endDate   = date("Y-m-t", strtotime($startDate));

            $reservation_payment = ReservationPayment::whereBetween('created_at',[$startDate,$endDate])->sum('amount_paid');
            $advance_reservation = AdvanceAmount::whereBetween('created_at',[$startDate,$endDate])->sum('amount');
            $banquet_booking = BanquetBooking::whereBetween('created_at',[$startDate,$endDate])->where('status',1)->sum('advance_paid');
            $kot_total = Kot::whereBetween('created_at',[$startDate,$endDate])->where('payment_type','Paid')->sum('total_paid');
            $payment_recerved = PaymentReceived::whereBetween('created_at',[$startDate,$endDate])->sum('amount');

            $revenue = $reservation_payment + $advance_reservation + $banquet_booking + $kot_total + $payment_recerved;

            $monthlyRevenue[] = $revenue;
        }

        $lastBooking = [];
        $lastCancel = [];
        $lastDay = [];
        for ($i = 9; $i >= 1; $i--) {
            $date = date('Y-m-d', strtotime('-'.$i.' day'));

            $reservation_cancel = ReservationRoom::where('checkin',$date)->where('status','Cancel')->count();
            $reservation_book = ReservationRoom::where('checkin',$date)->count();
            
            $lastBooking[] = $reservation_book;
            $lastCancel[] = $reservation_cancel;
            $lastDay[] = date('d M',strtotime($date));
        }

        return response()->json(['roomnum' => $roomnum,'occupied' => $occupied,'available' => $available, 'not_ready' => $not_ready, 'reserved' => $new_booking,'monthlyRevenue' => $monthlyRevenue, 'lastBooking' => $lastBooking, 'lastCancel' => $lastCancel, 'lastDay' => $lastDay]);

    }

    public function clearCache(){
       Artisan::call('config:clear');
       Artisan::call('cache:clear');
       Artisan::call('route:clear');
       Artisan::call('view:clear');
       return response()->json(['success' => 'Cache cleared successfully']);
    }
  
}
