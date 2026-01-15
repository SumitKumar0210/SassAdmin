<?php

namespace App\Http\Controllers\backend\reservation;

use App\Http\Controllers\Controller;
use App\Models\CloserReason;
use App\Models\HotlrConfiguration;
use App\Models\Reservation;
use App\Models\ReservationPayment;
use App\Models\ReservationRoom;
use App\Models\RoomClosure;
use App\Models\RoomGuest;
use App\Models\RoomNumber;
use App\Models\RoomType;
use App\Models\State;
use App\Models\Tariff;
use Illuminate\Http\Request;

class ReservationLayoutController extends Controller
{
    public function reservationViewLayout(Request $request){
        
        $roomnumber = RoomNumber::get();
        $date = date('Y-m-d');

        //below roomEachDetails used for row view reservation data display
        $reservationRoomDetail = [];
        $reservation_query = ReservationRoom::whereBetween('checkin',[$date,$date])->orWhereBetween('checkout',[$date,$date])->where('status','Reserved')->get(['id','checkin','checkout','room_type','room_category_id','status','dropped_row','dropped_checkin_date','reservation_id','primary_name','amount','extra_person','extra_person_amount','room_alloted']);
        
        foreach($reservation_query as $reserve){
            
            $total_cost = 0;
            $date1 = date_create($reserve->checkin);
            $date2 = date_create($reserve->checkout);
            $diff = date_diff($date1,$date2);
            $no_of_nights = $diff->days;
            $count_guest = RoomGuest::where('reservation_id',$reserve->reservation_id)->count();
            $paid_amount = ReservationPayment::where('reservation_id',$reserve->reservation_id)->sum('amount_paid');
            $total_amount =  ($no_of_nights * $reserve->amount) + ($no_of_nights * $reserve->extra_person * $reserve->extra_person_amount);
            $total_cost = $total_amount - $paid_amount;
            $reservationRoomDetail[] =[
                'id' => $reserve->id,
                'checkin' => $reserve->checkin,
                'checkout' => $reserve->checkout,
                'room_type' => $reserve->room_type,
                'room_category_id' => $reserve->room_category_id,
                'status' => $reserve->status,
                'dropped_row' => $reserve->dropped_row,
                'dropped_checkin_date' => $reserve->dropped_checkin_date,
                'reservation_id' => $reserve->reservation_id,
                'primary_name' => $reserve->primary_name,
                'reservation_detail'  => $reserve->reservation_data,
                'reservation_room_detail' => $reserve,
                'guest' => $count_guest,
                'stay' => $no_of_nights,
                'total' => $total_amount,
                'outstanding' => $total_cost,
                'roomData' => $reserve->roomData,
            ];
        }

        $roomEachDetails = [];
        $statusNameColor = [];
        $total_room = 0;
        foreach ($roomnumber as $rnum) {
            $roomnumberDetail = [];
            
            $rooms = ReservationRoom::whereNotIn('status',['Reserved','Final','Cancel'])->whereNull('checkedout_at')->get();
            if($rooms->isNotEmpty()) {
                $firstdate = $rooms[0]->checkin;
                $lastdate = $rooms[0]->checkout;
        
                // Generate dates range
                $currentDate = $firstdate;
                while ($currentDate <= $lastdate) {
                    $roomnumberDetail[] = $currentDate; // Avoids duplicate check with in_array
                    $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
                }
            }
            //array push
            $closer_name = '';
            $closer_color = '';
            $closer_id = '';
            if($rnum->current_status == 0){
                $closer_name = 'Occupied';
                $closer_color = '#ca4c3b';
                $closer_id = 0;
            }else if($rnum->current_status > 0){
                $closer_reasons = CloserReason::where('id',$rnum->current_status)->get(['name','color']);
                $closer_name = $closer_reasons[0]->name;
                $closer_color = $closer_reasons[0]->color;
                $roomnumberDetail = [];
                $closer_id = $rnum->current_status;
            }else{
                $closer_name = 'Vacant';
                $closer_color = '#3cc895';
                $closer_id = -1;
            }

            $room_count = RoomNumber::where('current_status',$closer_id)->count();
            $roomEachDetails[] = [
                'room_id' => $rnum->id,
                'room_number' => $rnum->room_number,
                'room_status' => $rnum->current_status,
                'room_dates' => $roomnumberDetail,
                'closer_name' => $closer_name,
                'closer_color' => $closer_color,
                'closer_name_vacant' => 'Vacant',
                'closer_color_vacant' => '#3cc895',
            ];
            
            if (array_search($closer_name, array_column($statusNameColor, 'name')) === FALSE) {
                $statusNameColor[] = [
                    'id' => $rnum->current_status,
                    'name' => $closer_name,
                    'color' => $closer_color,
                    'count' => $room_count,
                ];
            } 
        }

        $roomDetails = [];
        $roomtypes = RoomType::get();
        foreach($roomtypes as $type){
            
            $roomNumbers = RoomNumber::where('category_id',$type['id'])->where('status','active')->orderBy('room_number', 'asc')->get(['category_id','id','room_number','current_status']);
            if(count($roomNumbers) > 0){
                $room_reservation_detail = [];
                foreach($roomNumbers as $number){
                    if($number['current_status'] == 0){

                        $reservation_rooms = ReservationRoom::where('room_alloted_id',$number['id'])->whereNull('checkedout_at')->latest()->first();
                        if(!(empty($reservation_rooms))){
                            $reservations = Reservation::where('reservation_id',$reservation_rooms->reservation_id)->get();
                            
                            $room_reservation_detail[] = [
                                'room_id' => $number['id'],
                                'id' => $reservations[0]->id,
                                'reservation_room_id' =>  $reservation_rooms->id,
                                'reservation_id' => $reservation_rooms->reservation_id,
                                'first_name' => $reservations[0]->first_name,
                                'last_name' => $reservations[0]->last_name,
                                'mobile' => $reservations[0]->mobile,
                                'email' => $reservations[0]->email,
                                'guest_type' =>  $reservations[0]->guest_type,
                                'adults' =>  $reservation_rooms->adults,
                                'extra_person' =>  $reservation_rooms->extra_person,
                                'reservation_checkin_date' => date('d-m-Y',strtotime($reservation_rooms->checkin)),
                                'reservation_checkin_time' => date('h:i A', strtotime($reservation_rooms->checkedin_at)),
                                'stay' => $reservation_rooms->daystay,
                                'status' => $reservation_rooms->status,
                                'room_alloted' => $reservation_rooms->room_alloted,
                                'grand_total' => $reservations[0]->grand_total,
                                'due' => $reservations[0]->grand_total - $reservations[0]->paid_amount,
                                'company_name' => $reservations[0]->company_name ?? '',
                                'company_gst' => $reservations[0]->company_gst ?? '',
                                'tariff' => optional($reservation_rooms->tariff_detail)->tariff_type,
                                'tariff_cost' => $reservation_rooms->amount,
                                'category' => optional($reservation_rooms->room_type_detail)->room_category,
                            ];
                        }
                    }
                }

                $data = [
                    'id'=> $type['id'],
                    'name'=> $type['room_category'],
                    'max_adult'=> $type['max_adult'],
                    'max_child'=> $type['max_child'],
                    'max_infant'=> $type['max_infant'],
                    'rooms' => $roomNumbers,
                    'room_reservation_detail' => $room_reservation_detail
                ];
                array_push($roomDetails,$data);

            }
        }
        // dd($roomDetails);
        $tariffs = Tariff::where('status','active')->get(['id','room_category_id','tariff_type','room_tariff','extra_person_tariff']);
        $hotlr = HotlrConfiguration::where('id',1)->get(['name']);
        
        $roomCloser = RoomClosure::where('status','Closed')->whereNull('end_date')->get();
        return response()->json(['roomDetails' => $roomDetails, 'statusNameColor'=> $statusNameColor, 'roomEachDetails' => $roomEachDetails, 'reservationRoomDetail' => $reservationRoomDetail, 'tariffs' => $tariffs, 'roomCloser' => $roomCloser, 'hotlr' => $hotlr, 'total_room' => $total_room]);
    }
}
