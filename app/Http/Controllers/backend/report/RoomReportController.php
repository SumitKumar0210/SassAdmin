<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\BedType;
use App\Models\CloserReason;
use App\Models\FacilitieAmenitie;
use App\Models\HotlrConfiguration;
use App\Models\InvoiceRoomDetail;
use App\Models\RoomBedConfiguration;
use App\Models\RoomClosure;
use App\Models\RoomNumber;
use App\Models\RoomView;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class RoomReportController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.room_report',compact('hotlr'));
    }

    public function roomReportView(Request $request){
        $resRoom = RoomNumber::get();
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('room_number',function($row){
            return $row->room_number;
        })  
        ->addColumn('room_type',function($row){
            return $row->roomCategoryDetail->room_category ?? '';
        })   
        ->addColumn('room_status',function($row){
            return $row->status;
        })  
        ->addColumn('occupancy_status',function($row){
            $html = '';
            if($row->current_status == 0){
                $html = 'Occupied';
            }
            else if($row->current_status < 0){
                $html = 'Vacant';
            }else{
                $closer = CloserReason::where('id',$row->current_status)->value('name');
                $html = $closer;
            }
            return $html;
        })  
        ->addColumn('bed_configuration',function($row){
            $html = '';
            $config = RoomBedConfiguration::where('roomtype_id',$row->category_id)->where('status',1)->get(['bed_type','no_of_bed']);
            if(sizeof($config) > 0){
                foreach($config as $con){
                    $beds = BedType::where('id',$con->bed_type)->value('bedtype');
                    $html .='<li>'.$beds.' - '.$con->no_of_bed.'</li>';
                }
            }
            return $html;
        })  
        ->addColumn('room_capacity',function($row){
            return optional($row->roomCategoryDetail)->max_occupancy;
        })  
        ->addColumn('smoking_status',function($row){
            $type = optional($row->roomCategoryDetail)->smoking_category ;
            if($type == 'Smoking'){
                return 'Yes';
            }else{
                return 'No';
            }
        })  
        ->addColumn('room_size',function($row){
            return optional($row->roomCategoryDetail)->room_size.' SQM';
        })  
        ->addColumn('view',function($row){
            $views = optional($row->roomCategoryDetail)->room_view;
            $view_array = explode(',',$views);
            $html = '';
            
            foreach($view_array as $view_area){
                $room_view = RoomView::where('id',$view_area)->pluck('view_name');
                $html .='<li>'.$room_view[0].'</li>';
            }
            return $html;
        })  
        ->addColumn('amenities',function($row){
            $views = optional($row->roomCategoryDetail)->ami_facilities;
            $view_array = explode(',',$views);
             $html = '';
            foreach($view_array as $view_area){
                $room_view = FacilitieAmenitie::where('id',$view_area)->pluck('facilities');
                $html .='<li>'.$room_view[0].'</li>';
            }
            return $html;
        })  
        ->addColumn('last_maintenance',function($row){
            $latest_closer = RoomClosure::where('room_number',$row->id)->latest('updated_at')->orderBy('id','desc')->get(['updated_at']);
            if(sizeof($latest_closer) > 0){
                return date('d-m-Y',strtotime($latest_closer[0]->updated_at));
            }else{
                return '';
            }
        })
        ->addColumn('maintenance_type',function($row){
            $latest_closer = RoomClosure::where('room_number',$row->id)->latest('updated_at')->orderBy('id','desc')->get(['reason_closure']);
            if(sizeof($latest_closer) > 0){
                $closer_reason = CloserReason::where('id',$latest_closer[0]->reason_closure)->get(['name']);
                if(sizeof($closer_reason) > 0){
                    return $closer_reason[0]->name;
                }else{
                     return '';
                }
            }else{
                return '';
            }
        })  
        ->addColumn('revenue_generated',function($row){
            $invoice = InvoiceRoomDetail::where('room_id',$row->id)->sum('subtotal');
            return $invoice; 
        })  
        ->addColumn('revenue_generate_monthly',function($row){
            $t = InvoiceRoomDetail::where('room_id',$row->id)->whereBetween('invoice_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('subtotal');
            return $t;
        })  
        ->addColumn('avg_daily_rate',function($row){
            $revenue = 0;
            $days = 0;
            $revenue = InvoiceRoomDetail::where('room_id',$row->id)->sum('subtotal');
            $days = InvoiceRoomDetail::where('room_id',$row->id)->count();
            return $days > 0 ? round($revenue / $days, 2) : 0;
        })  
        ->addColumn('occupancy_rate',function($row){
            $daysOccupied = InvoiceRoomDetail::where('room_id',$row->id)->count();
            $totalDays = now()->daysInMonth; // current month days
            return $totalDays > 0 ? round(($daysOccupied / $totalDays) * 100, 2).'%' : '0%';
        })
        ->rawColumns(['view','amenities','bed_configuration'])
        ->make(true);
    }
}
