<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\BanquetBooking;
use App\Models\HotlrConfiguration;
use DateTime;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ComprehensiveBookingReportController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.comprehensive_booking_report',compact('hotlr'));
    }

    public function comprehensiveBookingView(){
        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $resRoom = BanquetBooking::whereBetween('created_at',[$dateFrom,$dateTo])->get();
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('booking_date',function($row){
            return date('d-m-Y',strtotime($row->created_at));;
        })   
        ->addColumn('client_name',function($row){
            return $row->client_name;
        })  
        ->addColumn('contact_number',function($row){
            return $row->contact_no;
        })
        ->addColumn('hall',function($row){
            return $row->hall_name;
        })  
        ->addColumn('event_type',function($row){
            return $row->event_name;
        })  
        ->addColumn('event_date',function($row){
            return date('d-m-Y',strtotime($row->event_date));
        })  
        ->addColumn('start',function($row){
            return $row->start_time;
        })  
        ->addColumn('end',function($row){
            return $row->start_end;
        })  
        ->addColumn('guest_count',function($row){
            return $row->expected_guest_count;
        })  
        ->addColumn('duration',function($row){
            $time1 = new DateTime($row->start_time);
            $time2 = new DateTime($row->end_time);

            $interval = $time1->diff($time2);
            return $interval->format("%H Hrs, %i Mins");
        })  
        ->addColumn('base_amount',function($row){
            return $row->total_hall_charge;
        })  
        ->addColumn('food_amount',function($row){
            return $row->total_food_charge;
        })  
        ->addColumn('additional',function($row){
            $total = $row->total_accesories_charge + $row->extra_room_charge;
            return $total;
        })  
        ->addColumn('total',function($row){
            return $row->grand_total;
        })  
        ->addColumn('advance',function($row){
            return $row->advance_paid;
        }) 
        ->addColumn('balance',function($row){
            return $row->due;
        }) 
        ->addColumn('payment_status',function($row){
            if($row->due > 0 || $row->advance_paid > 0){
                return 'Partial';
            }else if($row->due > 0 || $row->advance_paid == 0){
                return 'Due';
            }else{
                return 'Complete';
            }
        }) 
        ->addColumn('booking_status',function($row){
            $html = 'Pending';
            if($row->status == 1){
                $html = 'Confirm';
            }else if($row->status == 2){
                $html = 'Cancelled';
            }
            return $html;
        })  
        ->addColumn('sales',function($row){
            return '';
        })  
        ->addColumn('note',function($row){
            return $row->note;
        })  
        ->make(true);
    }
}
