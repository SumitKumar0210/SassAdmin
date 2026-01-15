<?php

namespace App\Http\Controllers\backend\reservation;

use App\Http\Controllers\Controller;
use App\Models\CloserReason;
use App\Models\HotlrConfiguration;
use App\Models\ReservationRoom;
use App\Models\RoomCategory;
use App\Models\RoomClosure;
use App\Models\RoomNumber;
use App\Models\RoomType;
use App\Models\RoomTypeName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class RoomController extends Controller
{

    public function roomCategory(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.room-category',compact('hotlr'));
    }

    public function add_room_category(Request $request) {
        // Check if room category exists
        $check_roomCategory_exist = RoomCategory::where('room_category', $request->room_category)->exists();
        if ($check_roomCategory_exist == false) {
             // Create new room category
                $roomcategory = new RoomCategory();
                $roomcategory->room_category = $request->room_category;
                if ($roomcategory->save()) {
                    $response = response()->json(['success' => 'Data added successfully'], 200);
                } else {
                    $response = response()->json(['error' => 'Failed to add data'], 500);
                }
        }else {
            $response = response()->json(['alreadyfound_error' => 'This Category already found! Enter another...']);
        }
        return $response;
    }

    public function getRoomCategoryData(Request $request){
        if($request->ajax()){
            $roomcat = RoomCategory::get();
            return DataTables::of($roomcat)
            ->addIndexColumn()
            ->addColumn('room_category',function($row){
                return $row->room_category;
            })
            ->addColumn('status',function($row){
                $id = $row->id;
                $checked = $row->status ==='active' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline" onchange="room_cat_status('.$id.')">
                      <label class="switch mb-0">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editRoomCat('.$row->id.')"></i></a></li>
                        <li class="delete ms-1 d-none" id="deleteBtn" onclick="delete_room_cat('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function roomTypeName(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return View('backend.modules.settings.roomtype-name',compact('hotlr'));
    }

    public function add_roomTypeName(Request $request){
        $check_roomTypeName_exist = RoomTypeName::where('room_name',$request->roomtype_name)->exists();
        if($check_roomTypeName_exist == false){
            // room_name
            if($request->ajax()){
            $validator = Validator::make($request->all(),[
                'roomtype_name' => ['required'],
            ]);
            if($validator->fails()){
                $response = response()->json(['error_validation' => $validator->errors()->all()],200);
            }
            $room_type_name = new RoomTypeName();
            $room_type_name->room_name = $request->roomtype_name;
            if($room_type_name->save()){
                $response = response()->json(['success' => 'Room Type Name Addedd Successfully'],200);
            }
            else{
                $response = response()->json(['error_success' => 'Room Type Name Not Addedd']);
            }
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'This Room Type Name already found! Enter another...']);
        }
        return $response;
    }

    public function get_roomTypeNameData(Request $request){
        if($request->ajax()){
            $roomType_name = RoomTypeName::get();
           
            return DataTables::of($roomType_name)
            ->addIndexColumn()
            ->addColumn('room_name',function($row){
                return $row->room_name;
            })
            ->addColumn('status',function($row){
                $checked = $row->status ==='active' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="roomTypeNameSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editRoomTypeName('.$row->id.')"></i></a></li>
                        <li class="delete ms-1 d-none" id="deleteBtn" onclick="delete_roomType_name('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function get_roomTypeNameDetails(Request $request){
       $id = $request->id;
       $getData = RoomTypeName::where('id',$id)->get();
       return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getData],200);
    }

    public function roomTypeName_update(Request $request){
        $id = $request->id;
        $roomTypeName = $request->roomTypeName;
        RoomTypeName::where('id',$id)->update([
            'room_name' => $roomTypeName
        ]);
       return response()->json(['success' => 'Data Updated Successfully'],200);
    }

    public function get_roomCategoryDetails(Request $request){
       $id = $request->id;
       $getroomCatData = RoomCategory::where('id',$id)->get();
       return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getroomCatData],200);
    }

    public function roomCategory_update(Request $request){
        $id = $request->id;
        $roomCategory = $request->roomCategory;
        RoomCategory::where('id',$id)->update([
            'room_category' => $roomCategory
        ]);
       return response()->json(['success' => 'Data Updated Successfully'],200);
    }

    public function roomCategory_status(Request $request){
        // dd($request);
        $id = $request->id;
        $rc_status = RoomCategory::where('id',$id)->get(['status']);
        $status = $rc_status[0]->status;
        // dd($status);
        if($status === 'active'){
            $new_status = 'inactive';
        }
        else{
            $new_status = 'active';
        }
        RoomCategory::where('id',$id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function roomtype_name_status(Request $request){
        // dd($request);
        $id = $request->id;
        $rc_status = RoomTypeName::where('id',$id)->get(['status']);
        $status = $rc_status[0]->status;
        // dd($status);
        if($status === 'active'){
            $new_status = 'inactive';
        }
        else{
            $new_status = 'active';
        }
        RoomTypeName::where('id',$id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function roomCategory_delete(Request $request){
        // Check if any RoomType exists for the given room_category_id
        $checkCategoryFound = RoomType::where('room_category_id', $request->id)->exists();
        if ($checkCategoryFound) {
            return response()->json(['error_success' => 'Room Category linked to Room Types. Cannot delete.'], 200);
        }else{
            RoomCategory::where('id',$request->id)->delete();
            return response()->json(['success' => 'Room Category Deleted Successfully'],200);
        }
    }

    public function roomTypeName_delete(Request $request){
        $checkroomtypeFound = RoomType::where('roomtype_name_id', $request->id)->exists();
        if ($checkroomtypeFound) {
            return response()->json(['error_success' => 'Room Type Name linked to Room Types. Cannot delete.'], 200);
        }else{
            RoomTypeName::where('id',$request->id)->delete();
            return response()->json(['success' => 'RoomType Name Deleted Successfully'],200);
        }
    }

    public function getRoomclosuredata(){
        $roomCloser = [];
        $roomclosureData =  RoomClosure::get();
        foreach($roomclosureData as $closer){

            $closer_reason = CloserReason::where('id',$closer['reason_closure'])->get(['name','color']);
            $end_date = $closer['end_date'];
            if($closer['end_date'] == NULL){
                $end_date = date('Y-m-d', strtotime(' +30 day'));
            }
            $roomCloser[] = [
                'id' => $closer['id'],
                'room_number' => $closer['room_number'],
                'start_date' => $closer['start_date'],
                'end_date' => $end_date,
                'closer_name' => strtoupper($closer_reason[0]->name),
                'closer_color' => $closer_reason[0]->color,
                'status' => $closer['status'],
            ];
        }
        return response()->json(['success' => 'Room Closure Data fetched Successfully','data'=>$roomCloser],200);
    }

    public function getRoomTypeData(Request $request){

        $roomType = [];
        $roomTypes = RoomType::where('room_category_id',$request->roomCat)->get(['roomtype_name_id']);
        foreach($roomTypes as $type){
            $room_types = RoomNumber::where('roomtype_id',$type->roomtype_name_id)->where('status','active')->count();
            if($room_types > 0){
                $room_types = RoomTypeName::where('id',$type->roomtype_name_id)->where('status','active')->get(['room_name']);
                $roomType[] = [
                    'id' => $type->roomtype_name_id,
                    'name' => $room_types[0]->room_name,
                ];
            }
        }
        return response()->json(['success'=>'Room Type Data fetched successfully','roomtypeData'=>$roomType],200);
    }

    public function getOccupancyData(Request $request){
        $roomNumber = [];
        $roomCate = $request->roomCat;
        $roomTypeName = $request->roomType;
        $roomNumbers = RoomNumber::where('category_id',$roomCate)->where('roomtype_id',$roomTypeName)->where('status','active')->get(['id','room_number']);
        $roomtypeDatas = RoomType::where('room_category_id',$roomCate)->where('roomtype_name_id',$roomTypeName)->get();
        foreach($roomNumbers as $number){
            $chkBlock = RoomClosure::where('room_number',$number['id'])->where('status','Closed')->count();
            if(!$chkBlock){
                $roomNumber[] = [
                    'id' => $number['id'],
                    'name' => $number['room_number']
                ];
            }
        }
        return response()->json(['success'=>'Room Type Data fetched successfully...','roomNum'=>$roomNumber,'roomtypeDatas'=>$roomtypeDatas],200);
    }

    public function roomOccupancy(){
        $company = HotlrConfiguration::get(['logo']);
        $reservation_data = ReservationRoom::where('status','Alloted')->get();
        return view('backend.modules.reservation.occupancy-chart',compact('reservation_data','company'));
    }

    public function getRoomTypeEditData(Request $request){
        $catID = $request->catID;
        $roomID = $request->roomID;
        $roomtypeData = RoomType::where('room_category_id',$catID)->get();
        $roomDatas = ReservationRoom::where('id',$roomID)->get();
        $roomNumber = RoomNumber::where('category_id',$catID)->where('current_status','open')->get();
        return response()->json(['success'=>'Room Type Data fetched successfully','roomtypeEditData'=>$roomtypeData,'roomDetails'=>$roomDatas,'roomNumber'=>$roomNumber],200);
    }

    public function getOccupancyEditData(Request $request){
        // dd($request);
        $roomTypeID = $request->roomTypeID;
        $roomID = $request->roomID;
        $roomCategoryEditID = $request->roomCategoryEdit;
        $roomDatasA = ReservationRoom::where('room_category_id',$roomCategoryEditID)->where('room_type_id',$roomTypeID)->get();
        $roomtypeDatas = RoomType::where('id',$roomTypeID)->get();
        return response()->json(['success'=>'Room Type Data fetched successfully','roomDatasA'=>$roomDatasA,'roomtypeDatas'=>$roomtypeDatas],200);
    }

    public function getRoomCategory(){
        $roomCat = RoomCategory::get();
        return response()->json(['success'=>'Room Category Data fetched','roomCategory'=>$roomCat],200);
    }

    public function roomBalanceFetch(Request $request){
        $roomID = $request->roomID;
        // Check if the roomID array is empty
        if (empty($roomID)) {
            $roomID = [0];  // Set to array with single element 0
        }
        $roomDatas = ReservationRoom::whereIn('id',$roomID)->get();
        return response()->json(['success'=>'Room details fetched','roomDetails'=>$roomDatas],200);
    }

    public function manageroomclose(Request $request){
        $update = RoomClosure::where('id',$request->closer_id)->update([
            'status' => 0,
            'end_date' => date('Y-m-d')
        ]);
        if($update){
            $getRoom = RoomClosure::where('id',$request->closer_id)->value('room_number');
            $update = RoomNumber::where('id',$getRoom)->update([
                'current_status' => '-1'
            ]);
            return response()->json(['success','Closure status changed successfully'],200);
        }
    }

    public function reservationRoomHistory(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.reservation.reservation_room_history',compact('hotlr'));
    }

    public function getAllRoomData(Request $request){
        $resRoom = DB::table('reservation_rooms')->get();
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('reservation_id',function($row){
            return $row->reservation_id;
        })  
        ->addColumn('primary_name',function($row){
            return $row->primary_name;
        })   
        ->addColumn('created_at',function($row){
            return $row->created_at;
        })  
        ->addColumn('status',function($row){
            return $row->status;
        })  
        ->addColumn('room_alloted',function($row){
            return $row->room_alloted;
        })  
        ->addColumn('checkin',function($row){
            return $row->checkin;
        })  
        ->addColumn('checkout',function($row){
            return $row->checkout;
        })  
        ->addColumn('room_category',function($row){
            return $row->room_category;
        })  
        ->addColumn('room_type',function($row){
            return $row->room_type;
        })  
        ->addColumn('adults',function($row){
            return $row->adults;
        })  
        ->addColumn('childrens',function($row){
            return $row->childrens;
        })  
        ->addColumn('infants',function($row){
            return $row->infants;
        })  
        ->addColumn('amount',function($row){
            return $row->amount;
        })  
        ->addColumn('extra_person',function($row){
            return $row->extra_person;
        })  
        ->addColumn('discount',function($row){
            return $row->discount;
        })  
        ->addColumn('paid_amount',function($row){
            return $row->paid_amount;
        })  
        ->make(true);
    }
  
}