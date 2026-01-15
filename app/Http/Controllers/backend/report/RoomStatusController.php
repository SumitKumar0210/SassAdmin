<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\RoomClosure;
use App\Models\RoomNumber;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class RoomStatusController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.room_status_report',compact('hotlr'));
    }

    public function roomStatusView(Request $request){

        $resRoom = RoomNumber::get();
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('room_number',function($row){
            return $row->room_number;
        })
        ->addColumn('room_type',function($row){
            return optional($row->roomCategoryDetail)->room_category ?? '';
        })
        ->addColumn('room_status',function($row){
            $html = '';
            if($row->current_status == -1){
                $html = 'Vacant';
            }else if($row->current_status == 0){
                $html = 'Occupied';
            }else{
                $html = optional($row->closerReasonDetail)->name ?? '';
            }
            return '<span>'.$html.'</span>';
        })
        ->addColumn('action',function($row){
            $html = '';
            $permission_allow = explode(',',auth()->user()->permission);
            if(in_array('Make It Vacant', $permission_allow)){
                if($row->current_status > 0){
                    $html = '<button class="btn btn-success text-white" onClick="makeItVacant('.$row->id.')">Make It Vacant</button>';
                }
            }
            
            return $html;
        })
        ->rawColumns(['room_status','action'])
        ->make(true);
    }

    public function roomStatusUpdate(Request $request){

        DB::beginTransaction();
        try{
            $update = RoomClosure::where('room_number',$request->id)->whereNull('end_date')->update([
                'end_date' => date('Y-m-d')
            ]);
            
            if($update){
                $update_room = RoomNumber::where('id',$request->id)->update([
                    'current_status' => -1
                ]);
            }
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Room is Vacant successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }
}
