<?php

namespace App\Http\Controllers\backend\audit;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\ReservationRoom;
use App\Models\RoomClosure;
use App\Models\RoomNumber;
use Illuminate\Http\Request;

class RoomAuditController extends Controller
{
    public function index(){
        $today = date('Y-m-d');
        $total_rooms = RoomNumber::where('status','active')->count();
        $arrival = ReservationRoom::where('checkin', $today)->count();
        $departure = ReservationRoom::where('checkout', $today)->count();
        $closures = RoomClosure::where('status','Closed')->get();
        $total_closure = count($closures);
        $room_occupied = ReservationRoom::whereDate('checkin', '<=', $today)->whereDate('checkout', '>=', $today)->where('room_alloted','!=','NA')->where('status','!=','Check-out')->count();
        $booking_per = round(($room_occupied/$total_rooms)*100);
        $room_vacant = RoomNumber::where('current_status','-1')->where('status','active')->count();
        $room_vacant_per = round(($room_vacant/$total_rooms)*100);
        $block_vacant = RoomNumber::where('current_status','>',0)->where('status','active')->count();
        $block_vacant_per = round(($block_vacant/$total_rooms)*100);
        $under_cleaning = RoomNumber::where('current_status',1)->where('status','active')->count();
        $closedRoomList = [];
        foreach($closures as $closed){
            $closedRoomList[] = [
                'id' => $closed->id,
                'room' => $closed->roomData->room_number ?? '',
                'closure' => $closed->closureData->name ?? '',
                'color' => $closed->closureData->color ?? '',
            ];
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.nightaudit.room-audit',compact('total_rooms','arrival','departure','total_closure','room_occupied','room_vacant','block_vacant','under_cleaning','booking_per','room_vacant_per','block_vacant_per','closedRoomList','hotlr'));
    }
    
    public function print(){
        $today = date('Y-m-d');
        $total_rooms = RoomNumber::where('status','active')->count();
        $arrival = ReservationRoom::where('checkin', $today)->count();
        $departure = ReservationRoom::where('checkout', $today)->count();
        $closures = RoomClosure::where('status','Closed')->get();
        $total_closure = count($closures);
        $room_occupied = ReservationRoom::whereDate('checkin', '<=', $today)->whereDate('checkout', '>=', $today)->where('room_alloted','!=','NA')->where('status','!=','Check-out')->count();
        $booking_per = round(($room_occupied/$total_rooms)*100);
        $room_vacant = RoomNumber::where('current_status','-1')->where('status','active')->count();
        $room_vacant_per = round(($room_vacant/$total_rooms)*100);
        $block_vacant = RoomNumber::where('current_status','>',0)->where('status','active')->count();
        $block_vacant_per = round(($block_vacant/$total_rooms)*100);
        $under_cleaning = RoomNumber::where('current_status',1)->where('status','active')->count();
        $closedRoomList = [];
        foreach($closures as $closed){
            $closedRoomList[] = [
                'id' => $closed->id,
                'room' => $closed->roomData->room_number ?? '',
                'closure' => $closed->closureData->name ?? '',
                'color' => $closed->closureData->color ?? '',
            ];
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.nightaudit.room-audit-print',compact('total_rooms','arrival','departure','total_closure','room_occupied','room_vacant','block_vacant','under_cleaning','booking_per','room_vacant_per','block_vacant_per','closedRoomList','hotlr'));
    }
}
