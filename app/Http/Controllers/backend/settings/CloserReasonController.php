<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\CloserReason;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CloserReasonController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.closer_reason',compact('hotlr'));
    }
    public function view(Request $request){
        if($request->ajax()){
            $closerReasonData = CloserReason::get();
            return DataTables::of($closerReasonData)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('color',function($row){
                return  '<span class="badge" style="background-color:'.$row->color.'">'.$row->name.'</span>';
            })
            ->addColumn('status',function($row){
                $checked = $row->status == 1 ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="CloserReasonSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="closerReasonEdit('.$row->id.')"></i></a></li>
                        </ul>';
            })
            ->rawColumns(['status','action','color'])
            ->make(true);
        }
    }
    public function store(Request $request){
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'color' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }
        $check_exist = CloserReason::where('name',$request->name)->exists();
        if($check_exist == false){     
            $item_insert = new CloserReason();
            $item_insert->name = $request->name;
            $item_insert->color = $request->color;
            if ($item_insert->save()) {
                return response()->json(['success' => 'Data added successfully'], 200);
            } else {
                return response()->json(['error' => 'Something Went Wrong'], 400);
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'Closer Reason Name already exists! Enter another...']);
        }
        return $response;
    }
    public function switch(Request $request){
        $rc_status = CloserReason::where('id',$request->id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status == 1){
            $new_status = 0;
        }
        else{
            $new_status = 1;
        }
        CloserReason::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
    public function getData(Request $request){
        $getData = CloserReason::where('id',$request->id)->get();
        return response()->json(['success' => 'Data Fetched Successfully','data'=>$getData],200);
    }
    public function update(Request $request){
        $check_closer_exist = CloserReason::where('name',$request->name)->where('id','!=',$request->id)->exists();
        if($check_closer_exist == false){
            $update = CloserReason::where('id',$request->id)->update([
                'name' => $request->name,
                'color' => $request->color
            ]);
            if($update){
                return response()->json(['success' => 'Data Updated Successfully'],200);
            }else{
                return response()->json(['success' => 'Data not updated']);
            }
        }else{
            return response()->json(['alreadyfound' => 'This Closer reason already found!']);
        }
    }

}
