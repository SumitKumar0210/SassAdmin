<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Models\HotlrConfiguration;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ReservationCancelController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.reservation_cancel_report',compact('hotlr'));
    }

    public function reservationCancelView(Request $request){
        
        $dateFrom = $_GET["dateFrom"];
        $dateTo   = $_GET["dateTo"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $dateTo = $dateTo.' 23:59:59';
        $resRoom = ReservationRoom::whereBetween('created_at',[$dateFrom,$dateTo])->where('status','Cancel')->get();

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
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown">
                                <a class="dropdown-item" href="javascript:;" onclick="updateReservationStatus('.$row->id.',`'.$row->reservation_id.'`)"><i class="ri-login-box-line text-success"></i> Update Reservation Date</a>
                            </div>
                        </div>';
                    return $html;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        } else {
            return DataTables::of(collect([]))->make(true);
        }
    }

    public function reservationUpdateTime(Request $request){
        
        DB::beginTransaction();
        try{
            $reservations = ReservationRoom::where('id',$request->reservation_room_id)->update([
                'status' => 'Reserved',
                'Checkin' => $request->reservation_checkin_date,
                'checkout' => $request->reservation_checkout_date
            ]);

            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Reservation Status updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }
}
