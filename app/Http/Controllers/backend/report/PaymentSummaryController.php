<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\AdvanceAmount;
use App\Models\HotlrConfiguration;
use App\Models\Kot;
use App\Models\PaymentMethod;
use App\Models\ReservationPayment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentSummaryController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.payment_summary_report',compact('hotlr'));
    }

    public function paymentSummaryView(Request $request){

        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $payments = [];
        $payment_modes = PaymentMethod::where('status',1)->get();
        foreach($payment_modes as $mode){
            $count_payment = 0;
            $total_payment = 0;
            
            $count_payment += AdvanceAmount::where('mode',$mode->id)->whereBetween('created_at',[$dateFrom,$dateTo])->count();
            $total_payment += AdvanceAmount::where('mode',$mode->id)->whereBetween('created_at',[$dateFrom,$dateTo])->sum('amount');
            
            $count_payment += ReservationPayment::where('payment_type',$mode->id)->whereBetween('created_at',[$dateFrom,$dateTo])->count();
            $total_payment += ReservationPayment::where('payment_type',$mode->id)->whereBetween('created_at',[$dateFrom,$dateTo])->sum('amount_paid');
            
            $count_payment += Kot::where('payment_type',$mode->name)->whereBetween('created_at',[$dateFrom,$dateTo])->count();
            $total_payment += Kot::where('payment_type',$mode->name)->whereBetween('created_at',[$dateFrom,$dateTo])->sum('total_paid');

            if($count_payment > 0){
                $payments[] = [
                    'date' => $dateFrom,
                    'payment_mode' => $mode->name ?? '',
                    'bill_count' => $count_payment ?? 0,
                    'total_amount' => $total_payment ?? 0,
                ];
            }
        }
        return DataTables::of($payments)
        ->addIndexColumn()
        ->addColumn('date',function($row){
            return date('d-m-Y',strtotime($row['date']));
        })
        ->addColumn('payment_mode',function($row){
            return $row['payment_mode'];
        })
        ->addColumn('bill_count',function($row){
            return $row['bill_count'];
        })
        ->addColumn('total_amount',function($row){
           return $row['total_amount'];
        })
        ->make(true);
    }
}
