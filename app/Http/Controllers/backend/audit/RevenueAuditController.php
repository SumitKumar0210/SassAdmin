<?php

namespace App\Http\Controllers\backend\audit;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Invoice;
use App\Models\Kot;
use App\Models\Module;
use App\Models\PaymentMethod;
use App\Models\ReservationPayment;
use Illuminate\Http\Request;

class RevenueAuditController extends Controller
{
    public function index(){
        $today = date('Y-m-d');
        $method = PaymentMethod::where('status',1)->get(['id','name']);
        $paymentList = [];
        foreach($method as $pay_method){
            $modules = Module::where('status',1)->get(['id','module']);
            foreach($modules as $section){
                $invoice = Invoice::where('payment_mode',$pay_method->name)->where('type',$section->module)->whereRaw('DATE(invoice_date) = ?', [$today])->sum('pay_amount');
                $reservation_payment = ReservationPayment::where('payment_type',$pay_method->name)->where('module',$section->module)->where('payment_date', $today)->sum('amount_paid');
                $kot_payment = 0;
                if($section->module == 'Restaurant'){
                    $kots = Kot::where('payment_type',$pay_method->name)->where('date',$today)->sum('total_paid');
                    $kot_payment = $kots;
                }
                $total_amount = $invoice + $reservation_payment + $kot_payment;
                if($total_amount > 0){
                    $paymentList[] = [
                        'id' => $pay_method->id,
                        'name' => $pay_method->name,
                        'amount' => $total_amount,
                        'department' => $section->module
                    ];
                }
            }
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.nightaudit.revenue-audit',compact('paymentList','hotlr'));
    }

    public function print(){
        $today = date('Y-m-d');
        $method = PaymentMethod::where('status',1)->get(['id','name']);
        $paymentList = [];
        foreach($method as $pay_method){
            $modules = Module::where('status',1)->get(['id','module']);
            foreach($modules as $section){
                $invoice = Invoice::where('payment_mode',$pay_method->name)->where('type',$section->module)->whereRaw('DATE(invoice_date) = ?', [$today])->sum('pay_amount');
                $reservation_payment = ReservationPayment::where('payment_type',$pay_method->name)->where('module',$section->module)->where('payment_date', $today)->sum('amount_paid');
                $kot_payment = 0;
                if($section->module == 'Restaurant'){
                    $kots = Kot::where('payment_type',$pay_method->name)->where('date',$today)->sum('total_paid');
                    $kot_payment = $kots;
                }
                $total_amount = $invoice + $reservation_payment + $kot_payment;
                if($total_amount > 0){
                    $paymentList[] = [
                        'id' => $pay_method->id,
                        'name' => $pay_method->name,
                        'amount' => $total_amount,
                        'department' => $section->module
                    ];
                }
            }
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.nightaudit.revenue-audit-print',compact('paymentList','hotlr'));
    }
}
