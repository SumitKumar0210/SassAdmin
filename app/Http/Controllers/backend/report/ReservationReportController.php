<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Kot;
use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Models\RoomBedConfiguration;
use App\Models\RoomNumber;
use App\Models\RoomType;
use DateTime;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class ReservationReportController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.reservation_report',compact('hotlr'));
    }

    public function reservationReportView(Request $request){
        $type = $_GET["type"];
        $date = $_GET["date"];

        if ($type != 'All') {
            $resRoom = ReservationRoom::where($type, $date)->where('room_alloted','!=','NA')->get();
        } else {
            $resRoom = ReservationRoom::get();
        }

        if (sizeof($resRoom) > 0) {
            // collect all reservation_ids
            $reservationIds = $resRoom->pluck('reservation_id')->toArray();

            $res = Reservation::whereIn('reservation_id', $reservationIds)->get();
            return DataTables::of($res)
                ->addIndexColumn()
                ->addColumn('reservation', function ($row) {
                    return $row->reservation_id;
                })
                ->addColumn('booking_date', function ($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->addColumn('booking_time', function ($row) {
                    return date('h:i A', strtotime($row->created_at));
                })
                ->addColumn('primary_guest', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('guest_type', function ($row) {
                    return $row->guest_type;
                })
                ->addColumn('contact_number', function ($row) {
                    return $row->mobile;
                })
                ->addColumn('email_address', function ($row) {
                    return $row->email;
                })
                ->addColumn('address', function ($row) {
                    return $row->address . ', ' . $row->city . ', ' . $row->state . '-' . $row->pin;
                })
                ->addColumn('nationality', function ($row) {
                    return 'Indian';
                })
                ->addColumn('id_type', function ($row) {
                    return $row->document_type;
                })
                ->addColumn('id_number', function ($row) {
                    return $row->id_number;
                })
                ->addColumn('company_name', function ($row) {
                    return $row->company_name;
                })
                ->addColumn('check_in_date', function ($row) {
                    $reservation_detail = ReservationRoom::where('reservation_id', $row->reservation_id)->value('checkin');
                    return date('d-m-Y', strtotime($reservation_detail));
                })
                ->addColumn('check_out_date', function ($row) {
                    $reservation_detail = ReservationRoom::where('reservation_id', $row->reservation_id)->value('checkout');
                    return date('d-m-Y', strtotime($reservation_detail));
                })
                ->addColumn('no_of_nights', function ($row) {
                    $reservation_room = ReservationRoom::where('reservation_id', $row->reservation_id)->where('status', '!=', 'Cancel')->get(['checkin', 'checkout']);
                    foreach ($reservation_room as $room) {
                        $datetime1 = new DateTime($room['checkin']);
                        $datetime2 = new DateTime($room['checkout']);
                        $interval = $datetime1->diff($datetime2);
                        return $interval->days;
                    }
                })
                ->addColumn('no_of_room', function ($row) {
                    return ReservationRoom::where('reservation_id', $row->reservation_id)->where('status', '!=', 'Cancel')->count();
                })
                ->addColumn('room_type_requested', function ($row) {
                    return 0;
                })
                ->addColumn('adult', function ($row) {
                    return ReservationRoom::where('reservation_id', $row->reservation_id)->where('status', '!=', 'Cancel')->sum('adults');
                })
                ->addColumn('children', function ($row) {
                    return ReservationRoom::where('reservation_id', $row->reservation_id)->where('status', '!=', 'Cancel')->sum('childrens');
                })
                ->addColumn('extra_bed_required', function ($row) {
                    return ReservationRoom::where('reservation_id', $row->reservation_id)->where('status', '!=', 'Cancel')->sum('extra_person');
                })
                ->addColumn('smoking', function ($row) {
                    $smoking = 'No';
                    $reservation_room = ReservationRoom::where('reservation_id', $row->reservation_id)->where('status', '!=', 'Cancel')->get(['room_alloted_id']);
                    foreach ($reservation_room as $room) {
                        $room_types = RoomNumber::where('id', $room->room_alloted_id)->pluck('category_id');
                        foreach ($room_types as $type) {
                            $smok = RoomType::where('id', $type)->where('smoking_category', 'Smoking')->count();
                            if ($smok > 0) {
                                $smoking = 'Yes';
                            }
                        }
                    }
                    return $smoking;
                })
                ->addColumn('bed_type_preference', function ($row) {
                    $bed_type = '';
                    $reservation_room = ReservationRoom::where('reservation_id', $row->reservation_id)->where('status', '!=', 'Cancel')->get(['room_alloted_id']);
                    foreach ($reservation_room as $room) {
                        $room_types = RoomNumber::where('id', $room->room_alloted_id)->pluck('category_id');
                        foreach ($room_types as $type) {
                            $config = RoomBedConfiguration::where('roomtype_id', $type)->get(['bed_type']);
                            if (sizeof($config) > 0) {
                                $bed_type = $config[0]->bed_type;
                            }
                        }
                    }
                    return $bed_type;
                })
                ->addColumn('rate_plan', function ($row) {
                    $reservation_room = ReservationRoom::where('reservation_id', $row->reservation_id)->where('status', '!=', 'Cancel')->get(['amount']);
                    if (sizeof($reservation_room) > 0) {
                        return $reservation_room[0]->amount;
                    } else {
                        return 0;
                    }
                })
                ->addColumn('base_rate', function ($row) {
                    $reservation_room = ReservationRoom::where('reservation_id', $row->reservation_id)->where('status', '!=', 'Cancel')->get(['amount']);
                    if (sizeof($reservation_room) > 0) {
                        return $reservation_room[0]->amount;
                    } else {
                        return 0;
                    }
                })
                ->addColumn('discount_apply', function ($row) {
                    $reservation_room = ReservationRoom::where('reservation_id', $row->reservation_id)->where('status', '!=', 'Cancel')->get(['discount']);
                    if (sizeof($reservation_room) > 0) {
                        return $reservation_room[0]->discount;
                    } else {
                        return 0;
                    }
                })
                ->addColumn('total_room_charge', function ($row) {
                    $tot = 0;
                    $reservation_room = ReservationRoom::where('reservation_id', $row->reservation_id)->where('status', '!=', 'Cancel')->get(['amount', 'extra_person_amount']);
                    if (sizeof($reservation_room) > 0) {
                        foreach ($reservation_room as $room) {
                            $tot += $room['amount'] + $room['extra_person_amount']; // fixed +=
                        }
                    }
                    return $tot;
                })
                ->addColumn('tax_amount', function ($row) {
                    return 0;
                })
                ->addColumn('total_amount', function ($row) {
                    return 0;
                })
                ->addColumn('payment_status', function ($row) {
                    return 'Pending';
                })
                ->addColumn('reservation_status', function ($row) {
                    return $row->status;
                })
                ->addColumn('check_in_status', function ($row) {
                    return 0;
                })
                ->addColumn('check_out_status', function ($row) {
                    return 0;
                })
                ->addColumn('last_modified', function ($row) {
                    return date('d-m-Y', strtotime($row->updated_at));
                })
                ->addColumn('cancellation_date', function ($row) {
                    return 0;
                })
                ->addColumn('cancellation_reason', function ($row) {
                    return 0;
                })
                ->addColumn('no_show_flag', function ($row) {
                    return 0;
                })
                ->make(true);
        } else {
            return DataTables::of(collect([]))->make(true);
        }

    }

    public function printReservation($para){
        
        $reservationList = [];
        $parameter1 = explode('&',$para);
        $section1 = explode('=',$parameter1[0]);
        $section2 = explode('=',$parameter1[1]);
        $type = $section1[1];
        $date = $section2[1];
        
        if ($type != 'All') {
            $resRoom = ReservationRoom::where($type, $date)->where('room_alloted','!=','NA')->get();
            if (sizeof($resRoom) > 0) {

                foreach($resRoom as  $reser){
                    
                    $res = Reservation::where('reservation_id', $reser->reservation_id)->get();
                    foreach($res as  $row){
                        $room_types = RoomType::where('id',$reser->room_alloted_id)->value('room_category');
                        $no_of_pax = intval($reser->adults) + intval($reser->extra_person);
                        $reservationList[] = [
                            'reservation' => $row->reservation_id,
                            'booking_date' => date('d-m-Y', strtotime($row->created_at)),
                            'booking_time' => date('h:i A', strtotime($row->created_at)),
                            'primary_guest' => $row->first_name . ' ' . $row->last_name,
                            'guest_type' => $row->guest_type,
                            'contact_number' => $row->mobile,
                            'email_address' => $row->email,
                            'address' => $row->address . ', ' . $row->city . ', ' . $row->state . '-' . $row->pincode,
                            'check_in_date' => date('d-m-Y', strtotime($reser->checkedin_at)),
                            'check_in_time' => date('h:i A', strtotime($reser->checkedin_at)),
                            'check_out_date' => date('d-m-Y', strtotime($reser->checkedout_at)),
                            'check_out_time' => date('h:i A', strtotime($reser->checkedout_at)),
                            'room_number' => $reser->room_alloted,
                            'room_type' => $room_types,
                            'no_of_person' => $no_of_pax,
                        ];
                    }
                }
            }
        } 

        $company = HotlrConfiguration::get(['logo']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.reservation_checkin_checkout_report',compact('reservationList','company','hotlr'));
    }
}
