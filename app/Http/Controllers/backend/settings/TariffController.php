<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\RoomCategory;
use App\Models\RoomType;
use App\Models\RoomTypeName;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TariffController extends Controller
{
    public function index(){
        $room_types = RoomType::where('status',1)->get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.room-tariff',compact('room_types','hotlr'));
    }

    public function view(Request $request){
        if($request->ajax()){
            $waiters = Tariff::get();
            return DataTables::of($waiters)
            ->addIndexColumn()
            ->addColumn('category',function($row){
                return optional($row->roomType)->room_category;
            })
            ->addColumn('tariffType',function($row){
                return $row->tariff_type;
            })
            ->addColumn('roomTariff',function($row){
                return $row->room_tariff;
            })
            ->addColumn('extraPersonTariff',function($row){
                return $row->extra_person_tariff;
            })
            ->addColumn('status',function($row){
                $checked = $row->status =='active' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="tariffSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="tariffEdit('.$row->id.')"></i></a></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }
    
    public function add(Request $request){
            $validator = Validator::make($request->all(),[
                'category' => 'required',
                'tariffType' => 'required',
                'roomTariff' => 'required',
                'extarPersonTariff' => 'required',
            ]);
            if($validator->fails()){
                return response()->json(['error_validation'=> $validator->errors()->all(),],422);
            }
            $tariffs = new Tariff();
            $tariffs->room_category_id = $request->category;
            $tariffs->tariff_type = $request->tariffType;
            $tariffs->room_tariff = $request->roomTariff;
            $tariffs->extra_person_tariff = $request->extarPersonTariff;
            if ($tariffs->save()){
                $response = response()->json(['success'=>'Data addedd successfully'],200);
            } else{
                $response = response()->json(['error'=>'Data not addedd successfully'],400);
            }
        return $response;
    }
    
    public function switchStatus(Request $request){
        $rc_status = Tariff::where('id',$request->id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status === 'active'){
            $new_status = 'inactive';
        }
        else{
            $new_status = 'active';
        }
        Tariff::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function getDetails(Request $request){
        $getData = Tariff::where('id',$request->id)->get();
        return response()->json(['success' => 'Data Fetched Successfully','data'=>$getData],200);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'category' => 'required',
            'tariffType' => 'required',
            'roomTariff' => 'required',
            'extarPersonTariff' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error_validation'=> $validator->errors()->all(),],422);
        }

        $update = Tariff::where('id',$request->id)->update([
            'room_category_id' => $request->category,
            'tariff_type' => $request->tariffType,
            'room_tariff' => $request->roomTariff,
            'extra_person_tariff' => $request->extarPersonTariff
        ]);
        if($update){
            return response()->json(['success' => 'Data Updated Successfully'],200);
        }else{
            return response()->json(['error_success' => 'Data not updated']);
        }
        
    }
}
