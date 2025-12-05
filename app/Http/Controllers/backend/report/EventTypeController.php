<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventTypeController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.event_type_analysis',compact('hotlr'));
    }

    public function eventTypeView(){
        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $resRoom = Event::get();
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('event_type',function($row){
            return $row->name;
        })   
        ->addColumn('total_booking',function($row){
            return 0;
        })  
        ->addColumn('percentage_share',function($row){
            return 0;
        })
        ->addColumn('total_revenue',function($row){
            return 0;
        })  
        ->addColumn('avg_guest',function($row){
            return 0;
        })  
        ->addColumn('avg_duration',function($row){
            return 0;
        })  
        ->addColumn('avg_booking',function($row){
            return 0;
        })
        ->make(true);
    }
}
