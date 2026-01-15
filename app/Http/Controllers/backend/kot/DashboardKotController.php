<?php

namespace App\Http\Controllers\backend\kot;

use App\Http\Controllers\Controller;
use App\Models\CloserReason;
use App\Models\HotlrConfiguration;
use App\Models\RoomNumber;
use App\Models\RoomType;
use App\Models\Table;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardKotController extends Controller
{
    public function index(Request $request){

        $hotlr = HotlrConfiguration::get(['logo','name','restaurant_area','item_add','notification','add_item_status']);

        $area = explode(',',$hotlr[0]->restaurant_area);
        $tableArea = [];
        $roomList = [];
        foreach($area as $table_area){
            $tables = Table::where('status',1)->where('area',$table_area)->get();
            if(sizeof($tables) > 0){
                $data = [
                    'area' => $table_area,
                    'table' => $tables
                ];
                array_push($tableArea,$data);
            }
        }
        
        $tables = Table::where('status',1)->get();
        $room_types = RoomType::get();
        foreach($room_types as $type){
            $rooms = [];
            $room_numbers = RoomNumber::where('category_id',$type->id)->where('status','active')->where('current_status','0')->get();
            foreach($room_numbers as $number){
                $rooms[] = [
                    'id' => $number->id,
                    'room_number' => $number->room_number,
                    'current_status' => $number->current_status,
                    'color' => '#feb858'
                ];
            }
            if(count($rooms) > 0){
                $data = [
                    'id'=> $type->id,
                    'name'=> $type->room_category,
                    'rooms'=> $rooms
                ];
                array_push($roomList,$data);
            }
        }

        return view('backend.modules.kot.dashboard',compact('area','tableArea','roomList','hotlr','tables'));
    }

    public function occupancyStatus(Request $request){
        
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id' => ['required'],
                'type' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        DB::beginTransaction(); 

        try{
            $type = 0;
            if($request->type == 'Reserved'){
                $type = 1;
            }

            $update = Table::where('id',$request->id)->update([
                'occupancy_status' => $type
            ]);

            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Invoice created successfully'], 200);
        }catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }
}
