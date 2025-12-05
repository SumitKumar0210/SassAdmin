<?php

namespace App\Http\Controllers\backend\banquet;

use App\Http\Controllers\Controller;
use App\Models\BanquetBooking;
use App\Models\BanquetMenuItem;
use App\Models\Event;
use App\Models\Feature;
use App\Models\Hall;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;

class BanquetDashboardController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.banquet.dashboard',compact('hotlr'));
    }

    public function getDashboardData(){
        $hallDetail = [];
        $halls = Hall::where('status','!=',0)->get();
        foreach($halls as $hall){
            $html = '';
            $feat = explode(',',$hall['features']);
            foreach($feat as $fea){
                $featu = Feature::where('id',$fea)->get(['id','name']);
                $html .= $featu[0]['name'].',';
            }
            $booking_status = 'Available';
            $booking_date = '';
            $booking_status_color = 'success';
            if($hall['status'] == '2'){
                $booking_status = 'Maintainance';
                $booking_status_color = 'danger';
            }else if($hall['booked_date'] == date('Y-m-d')){
                $booking_status = 'Occupied';
                $booking_status_color = 'warning';
                $booking_date = date('d/m/Y',strtotime($hall['booked_date']));
            }
            $menuList = [];
            if($booking_status == 'Occupied'){
                $menu = BanquetMenuItem::get(['menu_category_name','serve_time'])->groupBy('serve_time');
                foreach ($menu as $serveTime => $rows) {
                    $menuList[] = [
                        'time' => $serveTime,
                        'category' => $rows[0]->menu_category_name
                    ];
                }
            }
            $hallDetail[] = [
                'id'=> $hall['id'],
                'name' => $hall['name'],
                'capacity' => $hall['capacity'],
                'area' => $hall['area'],
                'setup_time' => $hall['setup_time'],
                'rate' => $hall['rate'],
                'complimentary_rooms' => $hall['complimentary_rooms'],
                'features' => rtrim($html, ","),
                'booked_date' => $booking_date,
                'booking_status' => $booking_status,
                'booking_status_color' => $booking_status_color,
                'booking_id' => $hall['booking_id'],
                'menuList' => $menuList
            ];
        }

        $banquets = BanquetBooking::where('event_date',date('Y-m-d'))->get(['event_name']);

        $quarterly_detail = [];
        $quarters = [[date('Y-01-01'),date('Y-03-31')],[date('Y-04-01'),date('Y-06-30')],[date('Y-07-01'),date('Y-09-31')],[date('Y-10-01'),date('Y-12-31')]];
        foreach($quarters as $quarter){
            $booking_count = BanquetBooking::where('status',1)->whereBetween('event_date',[$quarter[0],$quarter[1]])->count();
            $booking = BanquetBooking::where('status',1)->whereBetween('event_date',[$quarter[0],$quarter[1]])->sum('grand_total');
            $quarterly_detail[] = [
                'start_date' => date('M',strtotime($quarter[0])),
                'end_date' => date('M',strtotime($quarter[1])),
                'total' => $booking_count,
                'amount' => $booking,
                'avg' => 0,
                'a' => $quarter[0].'-'.$quarter[1]
            ];
        }

        $eventList = [];
        $events = Event::where('status',1)->get();
        foreach($events as $event){
            $booking_count = BanquetBooking::where('event_id',$event->id)->count();
            if($booking_count > 0){
                $booking = BanquetBooking::where('event_id',$event->id)->sum('grand_total');
                $eventList[] = [
                    'id' => $event->id,
                    'name' => $event->name,
                    'count' => $booking_count,
                    'booking' => $booking,
                ];
            }
        }
        usort($eventList, function($a, $b) {
            return $b['booking'] <=> $a['booking']; // descending
        });
        return response()->json(['success' => 'Data Fetched Successfully','hallDetail'=>$hallDetail,'quarterly_detail'=>$quarterly_detail,'eventList' => $eventList,'banquets' => $banquets],200);
    }

    public function calenderDateInfo(){
        $dates = [];
        $banquets = BanquetBooking::where('status',1)->get(['event_date','event_name']);
        foreach($banquets as $banq){
            $dates[] = [
                'title' => $banq->event_name,
                'start' => $banq->event_date,
            ];
        }
        return response()->json(['success' => 'Data Fetched Successfully','dates'=>$dates,'today'=> date('Y-m-01')],200);
    }
}
