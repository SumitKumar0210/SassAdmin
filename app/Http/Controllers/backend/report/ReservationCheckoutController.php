<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\ReservationRoom;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReservationCheckoutController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.reservation_checkout_report',compact('hotlr'));
    }

    public function reservationCheckoutReportView(Request $request){
        $room = $_GET["room"];
        $guest = $_GET["guest"];

        if($room == '' && $guest == ''){
            return DataTables::of(collect([]))->make(true);
        }else{
             if ($room != '') {
                $resRoom = ReservationRoom::where('room_alloted', $room)->get();
            }else if ($guest != '') {
                $resRoom = ReservationRoom::where('primary_name', $guest)->get();
            }
        }

        return DataTables::of($resRoom)
            ->addIndexColumn()
            ->addColumn('reservation', function ($row) {
                return $row->reservation_id;
            })
            ->addColumn('guest_name', function ($row) {
                return $row->primary_name;
            })
            ->addColumn('room_type', function ($row) {
                return optional($row->room_type_detail)->room_category ?? '';
            })
            ->addColumn('room_number', function ($row) {
                return $row->room_alloted;
            })
            ->addColumn('checkin_date', function ($row) {
                return date('d-m-Y h:i A', strtotime($row->checkedin_at));
            })
            ->addColumn('action',function($row){
                $html ='<div class="dropdown icon-dropdown">
                        <button class="btn dropdown-toggle" id="userdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-2-fill"></i></button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown">
                            <a class="dropdown-item" href="javascript:;" onclick="edit_reservation('.$row->id.',`'.$row->reservation_id.'`)"><i class="ri-logout-box-r-line text-danger"></i> Checkout</a>
                        </div>
                    </div>';
                return $html;
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }
}
