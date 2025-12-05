<?php

namespace App\Http\Controllers\backend\reservation;

use App\Http\Controllers\Controller;
use App\Models\AdvanceAmount;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\ReservationPayment;
use App\Models\ReservationRoom;
use App\Models\HotlrConfiguration;
use App\Models\PaymentMethod;
use App\Models\ReservationRoomTariffLog;
use App\Models\RoomType;
use App\Models\TaxSlab;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function checkoutReservationPreview($random_id){
        
        $reserved_room = [];
        $roomReservation = ReservationRoom::where('random',$random_id)->get(['id','reservation_id','primary_name','status','room_alloted','checkin','checkout','room_category_id','room_category','room_type_id','tariff_id','room_type','rate_plan','adults','childrens','infants','amount','extra_person','extra_person_amount','notes','checkedin_at','checkedout_at']);
        $checkin = '';
        $total_advance_payment = 0;
        
        $total_reservation_room = ReservationRoom::where('reservation_id',$roomReservation[0]->reservation_id)->count();
        $advance = AdvanceAmount::where('reservation_id',$roomReservation[0]->reservation_id)->sum('amount');
        if(count($roomReservation) == $total_reservation_room){
            $total_advance_payment = $advance;
        }else{
            $total_advance_payment = ($advance/$total_reservation_room);
        }

        foreach($roomReservation as $room){

            $records = ReservationRoomTariffLog::where('reservation',$room->reservation_id)->where('reservation_room_id',$room->id)
                ->orderBy('date', 'asc')
                ->get(['id','date','tariff_id','tariff','room_id','room','adults','amount','extra_pax','extra_pax_amount','reservation_room_id','room_type_id']);
            $checkin = $records[0]->date;

            $reserved_room = $records->map(function ($item, $index) use ($records) {
                $next = $records->get($index + 1);
                $next_date = $next ? $next->date : '';
                $days = $this->daysCalculate($item->date,$next_date,1);
                $total = $days * (($item->amount) + ($item->extra_person * $item->extra_pax_amount));
                return [
                    'no' => ++$index,
                    'log_id'  => $item->id,
                    'checkin'  => $item->date,
                    'checkout' => $next_date,
                    'days' => $days,
                    'id' => $item->reservation_room_id,
                    'room_type' => optional($item->roomData)->room_category ?? '',
                    'room_number' => $item->room ?? '',
                    'tariff_type' => $item->tariff ?? '',
                    'room_tariff' => round($item->amount ?? 0),
                    'adults' => $item->adults ?? 0,
                    'extra_person' => $item->extra_person ?? 0,
                    'tariff_extra_person' => $item->extra_pax_amount ?? 0,
                    'total' => round($total)
                ];
            });

            $advance_payment = ReservationPayment::where('reservation_id',$room->reservation_id)->where('reservation_room_id',$room->id)->sum('amount_paid');
            $total_advance_payment += $advance_payment;
        }
        
        // dd($reserved_room);
        $reservations = Reservation::where('reservation_id',$roomReservation[0]->reservation_id)->get(['id','reservation_id','status','first_name','last_name','mobile','email','address','city','state','pincode','country','document_type','other_document_type','id_number','guest_comment','company_name','company_gst','company_address','note','created_at','advance_amount','discount','discount_amount']);
        
        $now = Carbon::now();
        $checkin_date = date('d/m/Y',strtotime($checkin));
        $checkin_time = date('H:i A',strtotime($checkin));
        $checkout_date = date('d/m/Y',strtotime($now));
        $checkout_time = date('H:i A',strtotime($now));
        $default_tax = 0;
        $default_tax_name = '';
        $taxList = [];
        
        $tax_slabs = TaxSlab::where('category_id',1)->where('default_tax',1)->where('status',1)->get(['name','rate']);
        foreach($tax_slabs as $slab){
            $default_tax += $slab['rate'];
            $default_tax_name .= $slab['name'].'+';
        }
        $taxList[] = [
            'value' => $default_tax,
            'name' => rtrim($default_tax_name, '+')
        ];
        
        $tav_value=0;
        $taxes = TaxSlab::where('status',1)->where('category_id',1)->where('default_tax',0)->get();
        foreach($taxes as $tax_slab){
            $tav_value = $tax_slab['rate'];
            $data = [
                'value' => $tav_value,
                'name' => $tax_slab['name']
            ];
            array_push($taxList,$data);
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        $payment_methods = PaymentMethod::where('status',1)->whereNull('deleted_at')->get();
        return view('backend.modules.reservation.checkout-bill',compact('reservations','reserved_room','checkin_date','checkin_time','checkout_date','checkout_time','total_advance_payment','taxList','default_tax','random_id','hotlr','payment_methods'));
    }

    public function daysCalculate($checkin_date,$checkout_date = '',$cal = ''){

        $hotlr = HotlrConfiguration::where('id',1)->value('time_configuration');
        $hotrl_json = json_decode($hotlr,true);

        $timeslot = $hotrl_json['timeslot'];
        $time = $hotrl_json['checkout_time'];

        $checkin_time_default = $hotrl_json['checkin_time'];
        $checkout_time_default = date("H:i", strtotime($time . " +".$hotrl_json['checkout_buffer_time']." hours"));

        $checkin = Carbon::parse($checkin_date);
        $now = Carbon::now();
        if($checkout_date != ''){
            $now = Carbon::parse($checkout_date);
        }

        $days = $checkin->diffInDays($now);

        if($timeslot == 1){

            $checkin_time = $checkin->format('H:i:s');
            $checkout_time = $now->format('H:i:s');
    
            $checkin_seconds = strtotime($checkin_time);
            $checkout_seconds = strtotime($checkout_time);
    
            $before_12 = strtotime($checkin_time_default.':00');
            $after_14 = strtotime($checkout_time_default.':00');
    
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
        }else{
            if ($days == 0) {
                $days = 1;
            }else{
                $days = $days;
            }
        }

        return $days;
    }

    public function previewInvoice($detail){
        parse_str($detail, $params);

        $random_id = $params['rand'] ?? null;
        $total_amount = $params['total'] ?? null;
        $dicount_percentage_value = $params['dicount_percentage'] ?? null;
        $dicount_amount_value = $params['dicount_amount'] ?? null;
        $tax_type_value = $params['tax_type'] ?? null;
        $tax_value = $params['tax_value'] ?? null;
        $total_cgst_value = $params['total_cgst'] ?? null;
        $total_sgst_value = $params['total_sgst'] ?? null;
        $total_igst_value = $params['total_igst'] ?? null;
        $round_off = $params['round_off'] ?? null;
        $advance_amount_value = $params['advance_amount'] ?? null;
        $payment_mode_value = $params['payment_mode'] ?? null;
        $cheque_number = $params['cheque_number'] ?? null;
        $reference_code = $params['reference_code'] ?? null;
        $number_of_days = $params['number_of_days'] ?? null;
        $remaining_amount = $params['remaining_amount'] ?? 0;
        $adv = $params['adv_view'] ?? 0;
        $showPerforma = $params['show'] ?? 01;

        $reserved_room = [];
        $roomReservation = ReservationRoom::where('random',$random_id)->get(['id','reservation_id','primary_name','status','room_alloted','room_alloted_id','checkin','checkout','room_category_id','room_category','room_type_id','tariff_id','room_type','rate_plan','adults','childrens','infants','amount','extra_person','extra_person_amount','notes','checkedin_at','checkedout_at']);
        $count = 0;
        $checkin = '';
        $total_advance_payment = 0;
        $room_number_type = '';
        
        foreach($roomReservation as $room){

            $records = ReservationRoomTariffLog::where('reservation',$room->reservation_id)->where('reservation_room_id',$room->id)
                ->orderBy('date', 'asc')
                ->get(['id','date','tariff_id','tariff','room_id','room','adults','amount','extra_pax','extra_pax_amount','reservation_room_id','room_type_id']);
            $checkin = $records[0]->date;

            $reserved_room = $records->map(function ($item, $index) use ($records) {
                $next = $records->get($index + 1);
                $next_date = $next ? $next->date : '';
                $days = $this->daysCalculate($item->date,$next_date);
                $total = $days * (($item->amount) + ($item->extra_person * $item->extra_pax_amount));
                return [
                    'no' => ++$index,
                    'log_id'  => $item->id,
                    'checkin'  => $item->date,
                    'checkout' => $next_date,
                    'days' => $days,
                    'id' => $item->reservation_room_id,
                    'room_type' => optional($item->roomData)->room_category ?? '',
                    'room_number' => $item->room ?? '',
                    'tariff_type' => $item->tariff ?? '',
                    'room_tariff' => round($item->amount ?? 0),
                    'adults' => $item->adults ?? 0,
                    'extra_person' => $item->extra_person ?? 0,
                    'tariff_extra_person' => $item->extra_pax_amount ?? 0,
                    'total' => round($total)
                ];
            });

            $advance_payment = ReservationPayment::where('reservation_id',$room->reservation_id)->where('reservation_room_id',$room->id)->sum('amount_paid');
            $total_advance_payment += $advance_payment;

            $room_number_type .= $room->room_alloted .'/'.$room->room_type_detail->room_category;

            if($room->status == 'Check-out'){
                $showPerforma = 1;
            }
        }

        $reservations = Reservation::where('reservation_id',$roomReservation[0]->reservation_id)->get(['id','reservation_id','status','first_name','last_name','mobile','email','address','city','state','pincode','document_type','other_document_type','id_number','guest_comment','company_name','company_gst','company_address','note','created_at']);
       
        $now = Carbon::now();
        $checkin_date = date('d/m/Y',strtotime($checkin));
        $checkin_time = date('H:i A',strtotime($checkin));
        $checkout_date = date('d/m/Y',strtotime($now));
        $checkout_time = date('H:i A',strtotime($now));
        $invoice_date = date('d/m/Y');
        $next_number = 1;
        $companies = HotlrConfiguration::get(['name','address','invoice_prefix','suffix_length','state','pincode','gst','mobile','logo']);
        $invoice_created = Invoice::where('status',1)->orderBy('id','desc')->get(['invoice_id','invoice_date']);
        if(sizeof($invoice_created) > 0){
            $invoice_date = date('d/m/Y',strtotime($invoice_created[0]->invoice_date));
            $invoice_id = $invoice_created[0]->invoice_id;
            $next_number = intval(str_replace($companies[0]->invoice_prefix, "", $invoice_id))+1;
        }
        $invoice_number = str_pad($next_number, $companies[0]->suffix_length, '0', STR_PAD_LEFT);
        $created_invoice = $companies[0]->invoice_prefix.''.$invoice_number;
        
        $payment_logs = [];
        $payment_log_advances = [];
        $advance_pays = AdvanceAmount::where('reservation_id',$roomReservation[0]->reservation_id)->get();
        foreach($advance_pays as $pay){
            $payment_log_advances[] = [
                'date' => date('d-m-Y',strtotime($pay['created_at'])),
                'amount' => $pay['amount'],
                'mode' => '',
            ];
        }

        $payments = ReservationPayment::where('reservation_id',$roomReservation[0]->reservation_id)->get();
        foreach($payments as $pay){
            $mode = PaymentMethod::where('id',$pay['payment_type'])->value('name');
            $payment_logs[] = [
                'date' => date('d-m-Y',strtotime($pay['payment_date'])),
                'amount' => $pay['amount_paid'],
                'mode' => $mode
            ];
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.invoice.reservation.view_invoice',compact('random_id','total_amount','dicount_percentage_value','dicount_amount_value','tax_type_value','tax_value','total_cgst_value','total_sgst_value','total_igst_value','round_off','advance_amount_value','payment_mode_value','cheque_number','reference_code','number_of_days','reserved_room','reservations','checkin_date','checkin_time','checkout_date','checkout_time','companies','created_invoice','invoice_date','count','room_number_type','remaining_amount','showPerforma','payment_logs','adv','payment_log_advances','hotlr'));
    }
}
