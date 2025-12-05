<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Kot;
use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Models\RoomBedConfiguration;
use App\Models\HotlrConfiguration;
use App\Models\RoomNumber;
use App\Models\RoomType;
use DateTime;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class GuestHistoryReportController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.guest_history_report',compact('hotlr'));
    }

    public function guestHistoryReportView(Request $request){
        $resRoom = Customer::get();
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('guest_id',function($row){
            return $row->guest_id;
        })  
        ->addColumn('guest_name',function($row){
            return $row->first_name.' '.$row->last_name;
        })   
        ->addColumn('date_of_birth',function($row){
            return '';
        })  
        ->addColumn('gender',function($row){
            return $row->gender;
        })  
        ->addColumn('nationality',function($row){
            return 'Indian';
        })  
        ->addColumn('aadhar_no',function($row){
            return '';
        })  
        ->addColumn('contact_information',function($row){
            return $row->mobile;
        })  
        ->addColumn('guest_category',function($row){
            $type = Reservation::where('guest_id',$row->id)->pluck('guest_type');
            if(sizeof($type) > 0){
                return $type[0];
            }else{
               return '';
            }
        })  
        ->addColumn('no_of_stay',function($row){
            $total_reservation = Reservation::where('guest_id',$row->id)->count();
            return $total_reservation;
        })  
        ->addColumn('first_stay_date',function($row){
            $total_reservation = Reservation::where('guest_id',$row->id)->value('reservation_id');
            if(!empty($total_reservation)){
                $reservation_room = ReservationRoom::where('reservation_id',$total_reservation)->where('status','!=','Cancel')->value('checkin');
                if(!empty($reservation_room)){
                    return $reservation_room;
                }
            }else{
                return '';
            }
        })  
        ->addColumn('last_stay_date',function($row){
            $total_reservation = Reservation::where('guest_id',$row->id)->orderBy('id','desc')->value('reservation_id');
            if(!empty($total_reservation)){
                $reservation_room = ReservationRoom::where('reservation_id',$total_reservation)->where('status','!=','Cancel')->value('checkin');
                if(!empty($reservation_room)){
                    return $reservation_room;
                }
            }else{
                return '';
            }
        })  
        ->addColumn('stay_frequency',function($row){
            return 0;
        })  
        ->addColumn('total_nights_stay',function($row){
            $total_reservation = Reservation::where('guest_id',$row->id)->get(['reservation_id']);
            $total_night = 0;
            foreach($total_reservation as $reser){
                $reservation_room = ReservationRoom::where('reservation_id',$reser->reservation_id)->where('status','!=','Cancel')->get(['checkin','checkout']);
                foreach($reservation_room as $room){
                    $datetime1 = new DateTime($room['checkin']);
                    $datetime2 = new DateTime($room['checkout']);
                    $interval = $datetime1->diff($datetime2);
                    $total_night += $interval->days;
                }
            }
            if($total_night > 0){
                return $total_night.' Nights';
            }else{
                return '';
            }
        })  
        ->addColumn('avg_stay_duration',function($row){
            return 0;
        })  
        ->addColumn('cancellation',function($row){
            $total_reservation = Reservation::where('guest_id',$row->id)->get(['reservation_id']);
            $total_night = 0;
            foreach($total_reservation as $reser){
                $reservation_room = ReservationRoom::where('reservation_id',$reser->reservation_id)->where('status','Cancel')->count();
                $total_night += $reservation_room;
            }
            return $total_night;
        })  
        ->addColumn('corporate',function($row){
            $total_reservation = Reservation::where('guest_id',$row->id)->where('guest_type','Corporate')->count();
            if($total_reservation > 0){
                return 'Yes';
            }else{
                return '';
            }
        })  
        ->addColumn('no_show_history',function($row){
            return 0;
        })  
        ->addColumn('preferred_room',function($row){
            return '';
        }) 
        ->addColumn('preferred_view',function($row){
            return '';
        }) 
        ->addColumn('bed_type_preference',function($row){
            $bed_type = '';
            $total_reservations = Reservation::where('guest_id',$row->id)->get(['reservation_id']);
            foreach($total_reservations as $res){
                $reservation_room = ReservationRoom::where('reservation_id',$res->reservation_id)->where('status','!=','Cancel')->get(['room_alloted_id']);
                foreach($reservation_room as $room){
                    $room_types = RoomNumber::where('id',$room->room_alloted_id)->pluck('category_id');
                    foreach($room_types as $type){
                        $config = RoomBedConfiguration::where('roomtype_id',$type)->get(['bed_type']);
                        if(sizeof($config) > 0){
                            $bed_type = $config[0]->bed_type;
                        }
                    }
                }
            }
            return $bed_type;
        }) 
        ->addColumn('smoking_preference',function($row){
            $smoking = 'No';
            $total_reservations = Reservation::where('guest_id',$row->id)->get(['reservation_id']);
            foreach($total_reservations as $res){
                $reservation_room = ReservationRoom::where('reservation_id',$res->reservation_id)->where('status','!=','Cancel')->get(['room_alloted_id']);
                foreach($reservation_room as $room){
                    $room_types = RoomNumber::where('id',$room->room_alloted_id)->pluck('category_id');
                    foreach($room_types as $type){
                        $smok = RoomType::where('id',$type)->where('smoking_category','Smoking')->count();
                        if($smok > 0){
                            $smoking = 'Yes';
                        }
                    }
                }
            }
            return $smoking;
        })  
        ->addColumn('revenue_generated',function($row){
            $total_reservation = Reservation::where('guest_id',$row->id)->get(['reservation_id']);
            $total_revenue = 0;
            foreach($total_reservation as $reser){
                $reservation_room = Invoice::where('reservation',$reser->reservation_id)->sum('amount_after_tax');
                $kots = Kot::where('kot_id',$reser->reservation_id)->sum('grand_total');
                $total_revenue += $reservation_room + $kots;
            }
            return $total_revenue;
        })  
        ->addColumn('avg_spend_stay',function($row){
            return '';
        })  
        ->addColumn('room_revenue',function($row){
            $total_reservation = Reservation::where('guest_id',$row->id)->get(['reservation_id']);
            $total_revenue = 0;
            foreach($total_reservation as $reser){
                $reservation_room = Invoice::where('reservation',$reser->reservation_id)->sum('amount_after_tax');
                $total_revenue += $reservation_room;
            }
            return $total_revenue;
        })  
        ->addColumn('food_and_banquet_revenue',function($row){
            $total_reservation = Reservation::where('guest_id',$row->id)->get(['reservation_id']);
            $total_revenue = 0;
            foreach($total_reservation as $reser){
                $kots = Kot::where('kot_id',$reser->reservation_id)->sum('grand_total');
                $total_revenue += $kots;
            }
            return $total_revenue;
        })  
        ->addColumn('payment_method',function($row){
            return 'Card';
        })
        ->addColumn('outstanding_balance',function($row){
            $total_reservation = Reservation::where('guest_id',$row->id)->get(['reservation_id']);
            $total_revenue = 0;
            $total_paid = 0;
            foreach($total_reservation as $reser){
                $reservation_room = Invoice::where('reservation',$reser->reservation_id)->sum('amount_after_tax');
                $kots = Kot::where('kot_id',$reser->reservation_id)->sum('grand_total');

                $reservation_room_paid = Invoice::where('reservation',$reser->reservation_id)->sum('pay_amount');
                $kots_paid = Kot::where('kot_id',$reser->reservation_id)->sum('total_paid');

                $total_revenue += $reservation_room + $kots;
                $total_paid += $reservation_room_paid + $kots_paid;
            }
            return $total_revenue - $total_paid;
        })
        ->addColumn('payment_history',function($row){
            return '';
        })
        ->addColumn('discount_usage',function($row){
            return 0;
        })
        ->addColumn('corporate_affiliation',function($row){
            return 0;
        })  
        ->rawColumns(['payment_history'])
        ->make(true);
    }
}
