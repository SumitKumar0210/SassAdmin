<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\AdvanceAmount;
use App\Models\Customer;
use App\Models\HotlrConfiguration;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\ReservationPayment;
use App\Models\ReservationRoom;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BulkBookingSaleController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.bulk_booking_sale_report',compact('hotlr'));
    }

    public function bulkBookingSaleView(Request $request){

        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $dateTo = $dateTo.' 23:59:59';
        $resRoom = Invoice::where('booking_type','Bulk')->whereBetween('invoice_date',[$dateFrom,$dateTo])->get();
        $total_cash = 0;
        $total_card = 0;
        $total_amount = 0;
        $invoice_paids = Invoice::whereBetween('invoice_date',[$dateFrom,$dateTo])->get(['pay_amount','payment_mode']);
        foreach ($invoice_paids as $row) {
            if($row->payment_mode == 1){
                $total_cash += $row->pay_amount;
            }else if($row->payment_mode == 2){
                $total_card += $row->pay_amount;
            }else{
                $total_amount += $row->pay_amount;
            }
        }
        
        $advances = AdvanceAmount::whereBetween('created_at',[$dateFrom,$dateTo])->get(['amount','mode']);
        foreach ($advances as $row) {
            if($row->mode == 1){
                $total_cash += $row->amount;
            }else if($row->mode == 2){
                $total_card += $row->amount;
            }else{
                $total_amount += $row->amount;
            }
        }

        $paids = ReservationPayment::whereBetween('payment_date',[$dateFrom,$dateTo])->get(['amount_paid','payment_type']);
        foreach ($paids as $row) {
            if($row->payment_type == 1){
                $total_cash += $row->amount_paid;
            }else if($row->payment_type == 2){
                $total_card += $row->amount_paid;
            }else{
                $total_amount += $row->amount_paid;
            }
        }
    
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('room_type',function($row){
            $html = '<ul>';
            $reservation = ReservationRoom::where('reservation_id',$row->reservation)->get(['room_category_id']);
            if(sizeof($reservation) > 0){
                foreach($reservation as $res){
                    $html .= '<li>'.optional($res->room_type_detail)->room_category ?? " ".'</li>';
                }
            }
            $html .= '<ul>';
            return $html;
        })
        ->addColumn('room_number',function($row){
            $html = '<ul>';
            $reservation = ReservationRoom::where('reservation_id',$row->reservation)->get(['room_alloted']);
            if(sizeof($reservation) > 0){
                foreach($reservation as $res){
                    $html .= '<li>'.$res->room_alloted ?? " ".'</li>';
                }
            }
            $html .= '<ul>';
            return $html;
        })
        ->addColumn('reservation_id',function($row){
            return $row->reservation;
        })
        ->addColumn('guest_id',function($row){
            $customers = Customer::where('id',$row->guest_id)->value('guest_id');
            return $customers;
        })
        ->addColumn('guest_name',function($row){
            return $row->guest_name;
        })
        ->addColumn('company',function($row){
            $reservation = Reservation::where('reservation_id',$row->reservation)->value('company_name');
            return $reservation;
        })
        ->addColumn('gst_number',function($row){
            $reservation = Reservation::where('reservation_id',$row->reservation)->value('company_gst');
            return $reservation;
        })
        ->addColumn('bill_number',function($row){
            return $row->invoice_id;
        })
        ->addColumn('days',function($row){
            return $row->no_of_nights;
        })
        ->addColumn('room_price',function($row){
            return $row->total;
        })
        ->addColumn('discount',function($row){
            return $row->dis_per.'%';
        })
        ->addColumn('tax_amount',function($row){
           return $row->igst_amount;
        })
        ->addColumn('roundoff',function($row){
            return $row->round_off;
        })
        ->addColumn('total_amount',function($row){
           return ($row->amount_after_tax - $row->round_off);
        })
        ->addColumn('paid_amount',function($row){
            $dateFrom = $_GET["date_from"];
            $dateTo   = $_GET["date_to"];
            $payment = ReservationPayment::where('reservation_id',$row->reservation)->whereBetween('payment_date',[$dateFrom,$dateTo])->sum('amount_paid');
            $payment_received = AdvanceAmount::where('reservation_id',$row->reservation)->whereBetween('created_at',[$dateFrom,$dateTo])->sum('amount');
            return $payment + $payment_received + $row->pay_amount;
        })
        ->addColumn('bill_date',function($row){
            return date('d-m-Y',strtotime($row->invoice_date));
        })
        ->rawColumns(['room_type','room_number'])
         ->with([
            'total_amount' => $total_amount,
            'total_cash'  => $total_cash,
            'total_card'  => $total_card,
        ])
        ->make(true);
    }
}
