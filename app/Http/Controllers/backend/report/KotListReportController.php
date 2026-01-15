<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Kot;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KotListReportController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.kot_list_report',compact('hotlr'));
    }

    public function kotListReportView(Request $request){

        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $resRoom = Kot::whereBetween('order_time',[$dateFrom,$dateTo])->get();
        $total_cash = 0;
        $total_card = 0;
        $total_amount = 0;
        foreach ($resRoom as $row) {
            if($row->payment_type == 1 || $row->payment_type == 'Cash' ){
                $total_cash += $row->total_paid;
            }else if($row->payment_type == 2 || $row->payment_type == 'Card'){
                $total_card += $row->total_paid;
            }else{
                $total_amount += $row->total_paid;
            }
        }
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('kot_no',function($row){
            return 'KOT'.date('Ymd').$row->id;
        })
       ->addColumn('table_no',function($row){
            if($row->type == 'Table'){
                return $row->type_number;
            }else{
                return '';
            }
        })
        ->addColumn('room_number',function($row){
            if($row->type == 'Room'){
                return $row->type_number;
            }else{
                return '';
            }
        })
        ->addColumn('kot_type',function($row){
            if($row->is_complimentary == 1){
                return 'Complimentary';
            }else{
                return 'Paid';
            }
        })
        ->addColumn('guest_name',function($row){
            return $row->contact_person_name;
        })
        ->addColumn('assisted_by',function($row){
            return optional($row->waiterDetail)->name;
        })
        ->addColumn('created_by',function($row){
            return optional($row->user_detail)->name;
        })
        ->addColumn('status',function($row){
            return $row->order_status;
        })
        ->addColumn('cancelled_by',function($row){
            return optional($row->user_detail_cancel)->name;
        })
        ->addColumn('reason',function($row){
            return $row->cancel_reason;
        })
        ->addColumn('kot_value',function($row){
            return $row->grand_total;
        })
        ->addColumn('date_time',function($row){
            return date('d-m-Y h:i A',strtotime($row->order_time));
        })
        ->with([
            'total_amount' => $total_amount,
            'total_cash'  => $total_cash,
            'total_card'  => $total_card,
        ])
        ->make(true);
    }
}
