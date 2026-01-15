<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Models\RoomNumber;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

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
            $resRoom = ReservationRoom::where('status','!=','Cancel')->get();
        }

        if (sizeof($resRoom) > 0) {
            return DataTables::of($resRoom)
                ->addIndexColumn()
                ->addColumn('reservation', function ($row) {
                    return $row->reservation_id;
                })
                ->addColumn('booking_date', function ($row) {
                    return date('d-m-Y h:i A', strtotime($row->created_at));
                })
                ->addColumn('primary_guest', function ($row) {
                    return $row->primary_name;
                })
                ->addColumn('contact_number', function ($row) {
                    $res = Reservation::where('reservation_id', $row->reservation_id)->value('mobile');
                    return $res;
                })
                ->addColumn('check_in_date', function ($row) {
                    if($row->checkedin_at != ''){
                        return date('d-m-Y h:i A', strtotime($row->checkedin_at));
                    }else{
                        return '';
                    }
                })
                ->addColumn('check_out_date', function ($row) {
                    if($row->checkedout_at != ''){
                        return date('d-m-Y h:i A', strtotime($row->checkedout_at));
                    }else{
                        return '';
                    }
                })
                ->addColumn('action',function($row){
                    $html ='<div class="dropdown icon-dropdown">
                            <button class="btn dropdown-toggle" id="userdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-2-fill"></i></button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown">';
                                if($row->status == 'Reserved'){
                                  $html .='<a class="dropdown-item" href="javascript:;" onclick="edit_reservation('.$row->id.',`'.$row->reservation_id.'`)"><i class="ri-login-box-line text-success"></i> Checkin</a>';  
                                }else if($row->status == 'Alloted'){
                                    $html .='<a class="dropdown-item" href="javascript:;" onclick="cancelCheckout(`'.$row->reservation_id.'`)"><i class="ri-close-fill text-danger"></i> Cancel Checkout</a>
                                    <a class="dropdown-item" href="javascript:;" onclick="edit_reservation('.$row->id.',`'.$row->reservation_id.'`)"><i class="ri-logout-box-r-line text-danger"></i> Checkout</a>
                                    <a class="dropdown-item" href="javascript:;" onclick="getReservationData('.$row->id.')"><i class="ri-logout-box-r-line text-danger"></i> Update Checkin & Checkout Time</a>';  
                                }else if($row->status == 'Check-out') {
                                    $html .='<a class="dropdown-item" href="javascript:;" onclick="cancelCheckout(`'.$row->reservation_id.'`)"><i class="ri-close-fill text-danger"></i> Cancel Checkout</a>
                                    <a class="dropdown-item" href="javascript:;" onclick="getReservationData('.$row->id.')"><i class="ri-logout-box-r-line text-danger"></i> Update Checkin & Checkout Time</a>';
                                }
                            $html .='</div>
                        </div>';
                    return $html;
                })
                ->rawColumns(['status','action'])
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

    public function reservationCancelCheckout(Request $request){
        
        DB::beginTransaction();
        try{
            $reservations = ReservationRoom::where('reservation_id',$request->id)->update([
                'status' => 'Alloted',
                'random' => NULL,
                'checkedout_at' => NULL
            ]);

            $reservation_rooms = ReservationRoom::where('reservation_id',$request->id)->get(['room_alloted_id']);
            foreach($reservation_rooms as $room){
                $room_number = RoomNumber::where('id',$room->room_alloted_id)->update([
                    'current_status' => 0
                ]);
            }

            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data added successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }

    public function reservationGetDetail(Request $request){

        DB::beginTransaction();
        try{
            $reservations = ReservationRoom::where('id',$request->id)->get(['checkin','checkedin_at','checkout','checkedout_at','status']);
            $checkin_date = '';
            $checkin_time = '';
            $checkout_date = '';
            $checkout_time = '';
            if($reservations[0]->status == 'Alloted'){
                $checkin_date = date('Y-m-d',strtotime($reservations[0]->checkedin_at));
                $checkin_time = date('H:i:s',strtotime($reservations[0]->checkedin_at));
                $checkout_date = date('Y-m-d',strtotime($reservations[0]->checkout));;
                $checkout_time = date('H:i:s',strtotime($reservations[0]->checkout));
            }else if($reservations[0]->status == 'Check-out'){
                $checkin_date = date('Y-m-d',strtotime($reservations[0]->checkedin_at));
                $checkin_time = date('H:i:s',strtotime($reservations[0]->checkedin_at));
                $checkout_date = date('Y-m-d',strtotime($reservations[0]->checkedout_at));;
                $checkout_time = date('H:i:s',strtotime($reservations[0]->checkedout_at));
            }else{
                $checkin_date = date('Y-m-d',strtotime($reservations[0]->checkin));
                $checkin_time = date('H:i:s',strtotime($reservations[0]->checkin));
                $checkout_date = date('Y-m-d',strtotime($reservations[0]->checkout));;
                $checkout_time = date('H:i:s',strtotime($reservations[0]->checkout));
            }
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data added successfully','checkin_date' => $checkin_date, 'checkin_time' => $checkin_time, 'checkout_date' => $checkout_date, 'checkout_time' => $checkout_time], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }

    public function reservationUpdateCheckinCheckout(Request $request){
       
        DB::beginTransaction();
        try{
            $checkin = $request->reservation_checkin_date.' '.$request->reservation_checkin_time;
            $checkout = $request->reservation_checkout_date.' '.$request->reservation_checkout_time;

            $status = ReservationRoom::where('id',$request->id)->value('status');
            if($status == 'Alloted'){
                $update_reservation = ReservationRoom::where('id',$request->reservation_room_id)->updated([
                    'checkedin_at' => $checkin,
                    'checkout' => $checkout
                ]);
            }else if($status == 'Check-out'){
                $update_reservation = ReservationRoom::where('id',$request->reservation_room_id)->updated([
                    'checkedin_at' => $checkin,
                    'checkedout_at' => $checkout
                ]);
            }
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }

    }
}
