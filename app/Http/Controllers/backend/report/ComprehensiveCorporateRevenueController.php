<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Kot;
use App\Models\ReservationRoom;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ComprehensiveCorporateRevenueController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.comprehensive_corporate_report',compact('hotlr'));
    }

    public function comprehensiveCorporateView(){
        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            $dateFrom = date('Y-m-1');
            $dateTo   = date('Y-m-t');
        }
        $resRoom = ReservationRoom::whereBetween('created_at',[$dateFrom,$dateTo])->get();
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('client_name',function($row){
            return $row->primary_name;
        })  
        ->addColumn('contact_number',function($row){
            return $row->reservation_data->mobile;
        })
        ->addColumn('reservation_date',function($row){
            return date('d-m-Y',strtotime($row->created_at));
        })  
        ->addColumn('room_no',function($row){
            return $row->room_alloted;
        })  
        ->addColumn('tariff_type',function($row){
            return $row->tariff_detail->tariff_type;
        })  
        ->addColumn('tariff_amount',function($row){
            return $row->tariff_detail->room_tariff;
        })  
        ->addColumn('checkin_date',function($row){
            return date('d-m-Y',strtotime($row->checkin));
        })  
        ->addColumn('checkout_date',function($row){
            $today = date('Y-m-d');
            if($row->checkout >= $today || $row->status == 'Cancel' ){
                return date('d-m-Y',strtotime($row->checkout));
            }else{
                return date('d-m-Y',strtotime($today));
            }
        })  
        ->addColumn('pax',function($row){
            return intval($row->adults) + intval($row->extra_person);
        })   
        ->addColumn('duration',function($row){
            return $row->daystay;
        })  
        ->addColumn('total_amount',function($row){
            return $row->reservation_data->total_amount;
        })  
        ->addColumn('food_amount',function($row){
            $foods = Kot::where('kot_id',$row->reservation_id)->sum('grand_total');
            return $foods;
        })  
        ->addColumn('total',function($row){
            $foods = Kot::where('kot_id',$row->reservation_id)->sum('grand_total');
            return $row->reservation_data->grand_total + $foods;
        })  
        ->addColumn('advance',function($row){
            return $row->reservation_data->advance_amount;
        }) 
        ->addColumn('balance',function($row){
            $foods = Kot::where('kot_id',$row->reservation_id)->whereIn('payment_type',['Due','Complete with Due'])->sum('grand_total');
            $tot =  $row->reservation_data->grand_total - $row->reservation_data->paid_amount;
            return $tot + $foods;
        }) 
        ->addColumn('payment_status',function($row){
            $foods = Kot::where('kot_id',$row->reservation_id)->whereIn('payment_type',['Due','Complete with Due'])->sum('grand_total');
            $tot =  $row->reservation_data->grand_total - $row->reservation_data->paid_amount;
            $bal = $tot + $foods;
            if($bal > 0){
                return 'Pending';
            }else{
                return 'Done';
            }
        }) 
        ->addColumn('status',function($row){
            return $row->status;
        })  
        ->make(true);
    }
}
