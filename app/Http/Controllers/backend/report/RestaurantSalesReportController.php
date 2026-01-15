<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\HotlrConfiguration;
use App\Models\Kot;
use App\Models\KotInvoice;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RestaurantSalesReportController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.restaurant_sales_report',compact('hotlr'));
    }

    public function restaurantSaleReportView(Request $request){

        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $resRoom = Kot::whereNotNull('bill_number')->whereBetween('bill_date',[$dateFrom,$dateTo])->get();
        $total_cash = 0;
        $total_card = 0;
        $total_amount = 0;
        foreach ($resRoom as $row) {
            if($row->payment_type == 1 || $row->payment_type == 'Cash' ){
                $total_cash += $row->total_paid;
            }else if($row->payment_mode == 2 || $row->payment_type == 'Card'){
                $total_card += $row->total_paid;
            }else{
                $total_amount += $row->total_paid;
            }
        }
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('guest_name',function($row){
            return $row->contact_person_name ?? '';
        })
       ->addColumn('room_number',function($row){
            if($row->type == "Room"){
                return $row->type_number;
            }else{
                return '';
            }
        })
        ->addColumn('table_no',function($row){
            if($row->type == "Table"){
                return $row->type_number;
            }else{
                return '';
            }
        })
        ->addColumn('bill_no',function($row){
            return $row->bill_number;
        })
        ->addColumn('discount',function($row){
            return $row->discount_value ?? 0 .'%';
        })
        ->addColumn('cgst',function($row){
            return '2.5%';
        })
        ->addColumn('sgst',function($row){
            return '2.5%';
        })
        ->addColumn('roundoff',function($row){
            return $row->adjustment;
        })
        ->addColumn('paid_amount',function($row){
            return $row->total_paid;
        })
        ->addColumn('company',function($row){
            $html = '';
            if($row->contact_person_mobile != ''){
                $company = Company::where('mobile',$row->contact_person_mobile)->value('name');
                $html = $company;
            }
            return $html;
        })
        ->addColumn('gst_number',function($row){
            $html = '';
            if($row->contact_person_mobile != ''){
                $company = Company::where('mobile',$row->contact_person_mobile)->value('Gstin');
                $html = $company;
            }
            return $html;
        })
        ->addColumn('bill_date',function($row){
            return date('d-m-Y',strtotime($row->bill_date));
        })
        ->with([
            'total_amount' => $total_amount,
            'total_cash'  => $total_cash,
            'total_card'  => $total_card,
        ])
        ->make(true);
    }
}
