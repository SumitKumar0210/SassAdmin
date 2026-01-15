<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\AdvanceAmount;
use App\Models\HotlrConfiguration;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\ReservationPayment;
use App\Models\ReservationRoom;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoomRevenueController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.room_revenue_report',compact('hotlr'));
    }

    public function roomRevenueReportView(Request $request){

        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $dateTo = $dateTo.' 23:59:59';
        
        $resRoom = ReservationRoom::whereBetween('created_at',[$dateFrom,$dateTo])->whereNotIn('status',['Reserved','Cancel'])->get();
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
            ->addColumn('date',function($row){
                return date('d-m-Y',strtotime($row->created_at));
            })
            ->addColumn('room_no',function($row){
                return $row->room_alloted;
            })
            ->addColumn('room_type',function($row){
            return optional($row->room_type_detail)->room_category ?? '';
            })
            ->addColumn('room_charger',function($row){
                return $row->amount;
            })
            ->addColumn('discount',function($row){
                $reservation = Reservation::where('reservation_id',$row->reservation_id)->value('discount');
                return $reservation.' %';
            })
            ->addColumn('gst',function($row){
                $reservation = Invoice::where('reservation_id',$row->reservation)->value('igst_per');
                return $reservation ?? 0 .' %';
            })
            ->addColumn('roundoff',function($row){
                $reservation = Invoice::where('reservation',$row->reservation_id)->value('round_off');
                return $reservation ?? 0;
            })
            ->addColumn('paid_amount',function($row){
                if($row->status == 'Check-out'){
                    $invoice_paid = Invoice::where('reservation',$row->reservation_id)->get(['advance_amount','pay_amount']);
                    $t =  $invoice_paid[0]->advance_amount +  $invoice_paid[0]->pay_amount;
                    return $t;
                }else{
                    $advance = AdvanceAmount::where('reservation_id',$row->reservation_id)->value('amount');
                    $paid = ReservationPayment::where('reservation_id',$row->reservation_id)->value('amount_paid');
                    $tot = $advance + $paid;
                    return $tot;
                }
            })
            ->addColumn('due',function($row){
                if($row->status == 'Check-out'){
                    $invoice_paid = Invoice::where('reservation',$row->reservation_id)->get(['amount_after_tax','advance_amount','pay_amount','round_off']);
                    $t = (($invoice_paid[0]->amount_after_tax - $invoice_paid[0]->round_off) - $invoice_paid[0]->advance_amount) - $invoice_paid[0]->pay_amount;
                    return $t;
                }else{
                    $reservation = Reservation::where('reservation_id',$row->reservation_id)->value('grand_total');
                    $advance = AdvanceAmount::where('reservation_id',$row->reservation_id)->value('amount');
                    $paid = ReservationPayment::where('reservation_id',$row->reservation_id)->value('amount_paid');
                    $tot = $advance + $paid;
                    return $reservation - $tot;
                }
            })
            ->with([
                'total_amount' => $total_amount,
                'total_cash'  => $total_cash,
                'total_card'  => $total_card,
            ])
            ->make(true);
    }
}
