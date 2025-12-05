<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\BanquetBooking;
use App\Models\HotlrConfiguration;
use DateTime;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OutstandingPaymentsReportController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.outstanding_payments_report',compact('hotlr'));
    }

    public function outstandingPaymentsView(){
        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $resRoom = BanquetBooking::whereBetween('created_at',[$dateFrom,$dateTo])->get();
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('client_name',function($row){
            return $row->client_name;
        })   
        ->addColumn('booking_id',function($row){
            return date('Ymd',strtotime($row->created_at)).''.$row->id;
        })  
        ->addColumn('invoice_number',function($row){
            return 0;
        })
        ->addColumn('invoice_date',function($row){
            return 0;
        })  
        ->addColumn('due_date',function($row){
            return 0;
        })  
        ->addColumn('original_amount',function($row){
            return $row->grand_total;
        })  
        ->addColumn('paid_amount',function($row){
            return $row->paid_amount;
        })  
        ->addColumn('outstanding_amount',function($row){
            return $row->grand_total - $row->paid_amount;
        })
        ->addColumn('day_overdue',function($row){
            $date1 = new DateTime($row->created_at);
            $date2 = new DateTime();
            $interval = $date1->diff($date2);
            return $interval->days;
        })
        ->addColumn('collection',function($row){
            return 0;
        })
        ->addColumn('last_follow',function($row){
            return 0;
        })
        ->addColumn('next_follow',function($row){
            return 0;
        })
        ->addColumn('action',function($row){
            return '';
        })
        ->make(true);
    }
}
