<?php

namespace App\Http\Controllers\backend\audit;

use App\Http\Controllers\Controller;
use App\Models\AdvanceAmount;
use App\Models\AuditReport;
use App\Models\HotlrConfiguration;
use App\Models\Invoice;
use App\Models\Kot;
use App\Models\KotItem;
use App\Models\Module;
use App\Models\PaymentMethod;
use App\Models\Reservation;
use App\Models\ReservationPayment;
use App\Models\ReservationRoom;
use App\Models\RoomClosure;
use App\Models\RoomNumber;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditReportController extends Controller
{
    public function index(){
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d',strtotime('+1 days'));
        $progress = 0;
        $guest_folio_review_status = 0;
        $room_review_status = 0;
        $revenue_review_status = 0;
        $closer_review_status = 0;
        $f_b_audit_status = 0;
        $duration = 0;
        $validateDate = $tomorrow.' 10:00:00';
        if(date('H') < 10){
            $validateDate = date('Y-m-d 10:00:00');
        }
        $audit_today = AuditReport::where('end_datetime',$validateDate)->get(['guest_folio_review_status','room_review_status','revenue_review_status','closer_review_status','f_b_audit_status']);
        if(sizeof($audit_today) > 0){
            if($audit_today[0]->guest_folio_review_status > 0){
                $guest_folio_review_status = 1;
                $progress += 20;
            }
            if($audit_today[0]->room_review_status > 0){
                $room_review_status = 1;
                $progress += 20;
            }
            if($audit_today[0]->revenue_review_status > 0){
                $revenue_review_status = 1;
                $progress += 20;
            }
            if($audit_today[0]->closer_review_status > 0){
                $closer_review_status = 1;
                $progress += 20;
            }
            if($audit_today[0]->f_b_audit_status > 0){
                $f_b_audit_status = 1;
                $progress += 20;
            }
        }

        // state
        $total_rooms = RoomNumber::where('status','active')->count();
        $room_occupied = ReservationRoom::whereDate('checkin', '<=', $today)->whereDate('checkout', '>=', $today)->where('room_alloted','!=','NA')->count();
        $booking_per = 0;
        if($room_occupied != 0 && $total_rooms != 0){
            $booking_per = ($room_occupied/$total_rooms)*100;
        }
        $arrival = ReservationRoom::where('checkin', $tomorrow)->count();
        $departure = ReservationRoom::where('checkout', $today)->count();
        $invoice_total_room = Invoice::where('type','Room')->whereRaw('DATE(invoice_date) = ?', [$today])->sum('pay_amount');
        $room_payment = ReservationPayment::where('payment_date',$today)->sum('amount_paid');
        $revenue_room = $invoice_total_room + $room_payment;
        $revenue_kot = Kot::where('date',$today)->sum('total_paid');

        $hotlr = HotlrConfiguration::get(['audit_start','audit_end','logo','name']); // single value instead of pluck
        $s = strtotime($hotlr[0]->audit_start);
        $e = strtotime($hotlr[0]->audit_end);
        $diff = $e - $s;
        if ($diff < 0) $diff += 86400; // crosses midnight
        $duration = $diff;

        return view('backend.modules.nightaudit.dashboard',compact('progress','guest_folio_review_status','room_review_status','revenue_review_status','closer_review_status','f_b_audit_status','total_rooms','room_occupied','arrival','departure','revenue_room','revenue_kot','booking_per','today','duration','hotlr'));
    }

    public function updateProgress(Request $request){
        $today = date('Y-m-d');
        $parameter_name = '';
        if($request->type == 1){
            $parameter_name = 'guest_folio_review_status';
        }else if($request->type == 2){
            $parameter_name = 'room_review_status';
        }else if($request->type == 3){
            $parameter_name = 'revenue_review_status';
        }else if($request->type == 4){
            $parameter_name = 'closer_review_status';
        }else if($request->type == 5){
            $parameter_name = 'f_b_audit_status';
        }

        $tomorrow = date('Y-m-d 10:00:00',strtotime('+1 days'));

        $validateDate = $tomorrow;
        if(date('H') < 10){
            $validateDate = date('Y-m-d 10:00:00');
        }
        $check_existance = AuditReport::where('end_datetime',$validateDate)->count();
        if($check_existance > 0){
            $chk = AuditReport::where('end_datetime',$validateDate)->update([
                $parameter_name => $request->current_value
            ]);
            if($chk){
                return response()->json(['success' => 'Audit Updated'], 200);
            } else {
                return response()->json(['error_success' => 'Please try again'], 400);
            }
        }else{
            $nextDate = $tomorrow;
            if(date('H') < 10){
                $nextDate = date('Y-m-d 10:00:00');
            }
            $insert = new AuditReport();
            $insert->$parameter_name = $request->current_value;
            $insert->date = $today;
            $insert->start_datetime = date('Y-m-d H:i:s');
            $insert->end_datetime = $nextDate;
            $insert->audit_by = Auth::user()->id;
            if($insert->save()){
                return response()->json(['success' => 'Audit Updated'], 200);
            } else {
                return response()->json(['error_success' => 'Please try again'], 400);
            }
        }
    }

    public function auditTime(Request $request){
        
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d 10:00:00',strtotime('+1 days'));
        $validateDate = $tomorrow;
        if(date('H') < 10){
            $validateDate = date('Y-m-d 10:00:00');
        }
        if($request->x == 0){
            $duration_set = '00:00';
            $audit_today = AuditReport::where('end_datetime',$validateDate)->get(['start_time','last_time']);
            if(sizeof($audit_today) > 0){
                $time1 = new DateTime($audit_today[0]->start_time);
                $time2 = new DateTime($audit_today[0]->last_time);
                $interval = $time1->diff($time2);
                $duration_set = $interval->format('%h:%i');
            }
            return response()->json(['success' => 'Audit Time','duration_set' => $duration_set], 200);
        }else{
            $check_existance = AuditReport::where('end_datetime',$validateDate)->count();
            if($check_existance > 0){
                $chk = AuditReport::where('end_datetime',$validateDate)->update([
                    'last_time' => date('H:i')
                ]);
                if($chk){
                    return response()->json(['success' => 'Audit Time Updated'], 200);
                } else {
                    return response()->json(['error_success' => 'Please try again'], 400);
                }
            }else{
                $nextDate = $tomorrow;
                if(date('H') < 10){
                    $nextDate = date('Y-m-d 10:00:00');
                }
                $insert = new AuditReport();
                $insert->start_time = date('H:i');
                $insert->date = $today;
                $insert->start_datetime = date('Y-m-d H:i:s');
                $insert->end_datetime = $nextDate;
                $insert->audit_by = Auth::user()->id;
                if($insert->save()){
                    return response()->json(['success' => 'Audit Time Updated'], 200);
                } else {
                    return response()->json(['error_success' => 'Please try again'], 400);
                }
            }
        }
    }

    public function print(){
        $today     = date('Y-m-d');
        $tomorrow  = date('Y-m-d', strtotime('+1 day'));
        $progress  = 0;
        $guest_folio_review_status = $room_review_status = $revenue_review_status = $closer_review_status = $f_b_audit_status = 0;
        $duration  = '00:00';

        $validateDate = $tomorrow.' 10:00:00';
        if(date('H') < 10){
            $validateDate = date('Y-m-d 10:00:00');
        }
        // ðŸ”¹ Audit Report
        $audit_today = AuditReport::whereDate('end_datetime',$validateDate)
            ->select(['guest_folio_review_status','room_review_status','revenue_review_status','closer_review_status','f_b_audit_status','start_time','last_time'])
            ->first();

        if ($audit_today) {
            $statusMap = [
                'guest_folio_review_status',
                'room_review_status',
                'revenue_review_status',
                'closer_review_status',
                'f_b_audit_status'
            ];

            foreach ($statusMap as $field) {
                if ($audit_today->$field > 0) {
                    $$field = 1;     // dynamically set variable
                    $progress += 20;
                }
            }

            $duration = (new DateTime($audit_today->start_time))
                ->diff(new DateTime($audit_today->last_time))
                ->format('%h:%i');
        }

        // ðŸ”¹ Room state
        $total_rooms   = RoomNumber::where('status','active')->count();
        $room_occupied = ReservationRoom::whereDate('checkin','<=',$today)
                            ->whereDate('checkout','>=',$today)
                            ->where('room_alloted','!=','NA')
                            ->count();

        $booking_per   = $total_rooms > 0 ? ($room_occupied / $total_rooms) * 100 : 0;
        $arrival       = ReservationRoom::where('checkin', $tomorrow)->count();
        $departure     = ReservationRoom::where('checkout', $today)->count();

        $invoice_total_room = Invoice::where('type','Room')
            ->whereDate('invoice_date', $today)
            ->sum('pay_amount');

        $room_payment  = ReservationPayment::whereDate('payment_date',$today)->sum('amount_paid');
        $revenue_room  = $invoice_total_room + $room_payment;
        $revenue_kot   = Kot::whereDate('date',$today)->sum('total_paid');

        // ðŸ”¹ Kot stats
        $total_item_order = KotItem::whereDate('created_at',$today)->distinct('item_id')->count();

        $kotStats = Kot::where('status',1)
            ->whereDate('date',$today)
            ->selectRaw("
                SUM(CASE WHEN order_status = 'Delivered' THEN total_paid ELSE 0 END) as total_revenue,
                COUNT(*) as total_kot,
                SUM(CASE WHEN order_status = 'Cancelled' THEN 1 ELSE 0 END) as total_cancel_order,
                SUM(CASE WHEN payment_type = 'Cash' THEN total_paid ELSE 0 END) as kots_cash,
                SUM(CASE WHEN payment_type = 'Cheque' THEN total_paid ELSE 0 END) as kots_cheque,
                SUM(CASE WHEN payment_type = 'Card' THEN total_paid ELSE 0 END) as kots_card,
                SUM(CASE WHEN payment_type = 'UPI' THEN total_paid ELSE 0 END) as kots_upi,
                SUM(CASE WHEN is_complimentary = 1 THEN 1 ELSE 0 END) as is_complimentary
            ")->first();

        $total_revenue      = $kotStats->total_revenue;
        $total_kot          = $kotStats->total_kot;
        $total_cancel_order = $kotStats->total_cancel_order;
        $kots_cash          = $kotStats->kots_cash;
        $kots_cheque        = $kotStats->kots_cheque;
        $kots_card          = $kotStats->kots_card;
        $kots_upi           = $kotStats->kots_upi;
        $is_complimentary   = $kotStats->is_complimentary;

        $avg_cash = $total_revenue > 0 ? round($kots_cash / $total_revenue) : 0;
        $avg_card = $total_revenue > 0 ? round($kots_card / $total_revenue) : 0;
        $avg_upi  = $total_revenue > 0 ? round($kots_upi / $total_revenue)  : 0;

        // ðŸ”¹ Room Kot
        $kots = Kot::where('type','Room')
            ->whereDate('date',$today)
            ->get(['kot_id','type_number','grand_total','total_paid'])
            ->groupBy(['kot_id','type_number']);

        $kotIds       = $kots->keys()->toArray();
        $reservations = Reservation::whereIn('reservation_id',$kotIds)->pluck('first_name','reservation_id');

        $roomKot = [];
        foreach ($kots as $kotId => $rooms) {
            foreach ($rooms as $roomNumber => $details) {
                $total_bill = $details->sum('grand_total');
                $paid_bill  = $details->sum('total_paid');
                $due        = $total_bill - $paid_bill;

                $roomKot[] = [
                    'kot_id'      => $kotId,
                    'room'        => $roomNumber,
                    'name'        => $reservations[$kotId] ?? '',
                    'status'      => $due > 0 ? 'Un-Paid' : 'Paid',
                    'grand_total' => $total_bill,
                    'paid_amount' => $paid_bill,
                    'due'         => $due,
                    'kot_rooms'   => $roomNumber
                ];
            }
        }

        // room
        $total_rooms   = RoomNumber::where('status','active')->count();
        $arrival       = ReservationRoom::whereDate('checkin', $today)->count();
        $departure     = ReservationRoom::whereDate('checkout', $today)->count();

        $closures      = RoomClosure::with(['roomData:id,room_number','closureData:id,name,color'])
                            ->where('status','Closed')->get();
        $total_closure = $closures->count();

        $room_occupied = ReservationRoom::whereDate('checkin','<=',$today)
                            ->whereDate('checkout','>=',$today)
                            ->where('room_alloted','!=','NA')
                            ->where('status','!=','Check-out')
                            ->count();

        $booking_per       = $total_rooms > 0 ? round(($room_occupied / $total_rooms) * 100) : 0;
        $room_vacant       = RoomNumber::where('current_status','-1')->where('status','active')->count();
        $room_vacant_per   = $total_rooms > 0 ? round(($room_vacant / $total_rooms) * 100) : 0;
        $block_vacant      = RoomNumber::where('current_status','>',0)->where('status','active')->count();
        $block_vacant_per  = $total_rooms > 0 ? round(($block_vacant / $total_rooms) * 100) : 0;
        $under_cleaning    = RoomNumber::where('current_status',1)->where('status','active')->count();

        // ðŸ”¹ Closed Room List
        $closedRoomList = $closures->map(function($closed) {
            return [
                'id'      => $closed->id,
                'room'    => $closed->roomData->room_number ?? '',
                'closure' => $closed->closureData->name ?? '',
                'color'   => $closed->closureData->color ?? '',
            ];
        })->toArray();

        // ðŸ”¹ Guest Folio
        $rooms = ReservationRoom::with('roomData:id,room_number')
                    ->whereDate('checkin','<=',$today)
                    ->whereDate('checkout','>=',$today)
                    ->get(['id','reservation_id','primary_name','status','room_alloted']);

        $roomList = $rooms->map(function($room){
            $today     = date('Y-m-d');
            $advance = AdvanceAmount::where('reservation_id',$room->reservation_id)->whereDate('created_at','<=',$today)
                            ->sum('amount');
            $payments = ReservationPayment::where('reservation_id',$room->reservation_id)->whereDate('payment_date','<=',$today)
                            ->sum('amount_paid');
            $invoices = Invoice::where('reservation',$room->reservation_id)->whereDate('invoice_date','<=',$today)
                            ->sum('pay_amount');
            $total   = $advance + $payments + $invoices;

            return [
                'id'            => $room->id,
                'reservation_id'=> $room->reservation_id,
                'name'          => $room->primary_name,
                'status'        => $room->status,
                'room'          => $room->room_alloted ?? '',
                'balance'       => round($total),
            ];
        })->toArray();

        // ðŸ”¹ Revenue
        $method  = PaymentMethod::where('status',1)->get(['id','name']);
        $modules = Module::where('status',1)->get(['id','module']);

        $paymentList = [];
        foreach ($method as $pay_method) {
            foreach ($modules as $section) {
                $invoice_amount = Invoice::where('payment_mode',$pay_method->name)
                    ->where('type',$section->module)
                    ->whereDate('invoice_date',$today)
                    ->sum('pay_amount');

                $reservation_amount = ReservationPayment::where('payment_type',$pay_method->name)
                    ->where('module',$section->module)
                    ->whereDate('payment_date',$today)
                    ->sum('amount_paid');

                $kot_payment = 0;
                if ($section->module === 'Restaurant') {
                    $kot_payment = Kot::where('payment_type',$pay_method->name)
                        ->whereDate('date',$today)
                        ->sum('total_paid');
                }

                $total_amount = $invoice_amount + $reservation_amount + $kot_payment;

                if ($total_amount > 0) {
                    $paymentList[] = [
                        'id'         => $pay_method->id,
                        'name'       => $pay_method->name,
                        'amount'     => $total_amount,
                        'department' => $section->module
                    ];
                }
            }
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.nightaudit.dashboard-print',compact('progress','guest_folio_review_status','room_review_status','revenue_review_status','closer_review_status','f_b_audit_status','duration','total_rooms','room_occupied','arrival','departure','revenue_room','revenue_kot','booking_per','today','total_revenue','total_kot','total_item_order','total_cancel_order','kots_cash','kots_cheque','kots_card','kots_upi','is_complimentary','roomKot','avg_cash','avg_card','avg_upi','total_rooms','arrival','departure','total_closure','room_occupied','room_vacant','block_vacant','under_cleaning','booking_per','room_vacant_per','block_vacant_per','closedRoomList','roomList','paymentList','hotlr'));
    }
}
