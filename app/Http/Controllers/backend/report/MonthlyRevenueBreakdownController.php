<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\BanquetBooking;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MonthlyRevenueBreakdownController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.monthly_revenue_breakdown',compact('hotlr'));
    }

    public function monthlyRevenueView(){
        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $resRoom = BanquetBooking::get();
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('month',function($row){
            return $row->name;
        })   
        ->addColumn('year',function($row){
            return 0;
        })  
        ->addColumn('total_revenue',function($row){
            return 0;
        })
        ->addColumn('hall_revenue',function($row){
            return 0;
        })  
        ->addColumn('f_b_revenue',function($row){
            return 0;
        })  
        ->addColumn('additional_revenue',function($row){
            return 0;
        })  
        ->addColumn('advance_collection',function($row){
            return 0;
        })  
        ->addColumn('total_collection',function($row){
            return 0;
        })
        ->addColumn('outstanding_amount',function($row){
            return 0;
        })
        ->addColumn('growth',function($row){
            return 0;
        })
        ->make(true);
    }
}
