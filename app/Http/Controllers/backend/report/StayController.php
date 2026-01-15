<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\ReservationRoom;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StayController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.stay_report',compact('hotlr'));
    }

    public function stayReportView(Request $request){

        // $dateFrom = $_GET["date_from"];
        // $dateTo   = $_GET["date_to"];
        // if($dateFrom == '' || $dateTo == ''){
        //     return DataTables::of(collect([]))->make(true);
        // }
        $resRoom = ReservationRoom::where('status','!=','Cancel')->get();
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('guest_name',function($row){
            return $row->primary_name;
        })
        ->addColumn('room_no',function($row){
            return $row->room_alloted;
        })
        ->addColumn('room_type',function($row){
            return optional($row->room_type_detail)->room_category ?? '';
        })
        ->addColumn('checkin_date',function($row){
            if($row->checkedin_at != ''){
                return date('d-m-Y h:i A', strtotime($row->checkedin_at));
            }else{
                return '';
            }
        })
        ->addColumn('checkout_date',function($row){
            if($row->checkedout_at != ''){
                return date('d-m-Y h:i A', strtotime($row->checkedout_at));
            }else{
                return '';
            }
        })
        ->addColumn('status',function($row){
            return $row->status;
        })
        ->make(true);
    }

}
