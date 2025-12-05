<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
class FeatureController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.feature',compact('hotlr'));
    }

    public function view(Request $request){
        if($request->ajax()){
            $features = Feature::get();
            return DataTables::of($features)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('status',function($row){
                $checked = $row->status =='1' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="featureSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="featureEdit('.$row->id.')"></i></a></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }
    
    public function store(Request $request){
        $check_feature_exist = Feature::where('name',$request->name)->exists();
        if($check_feature_exist == false){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
            ]);
            if($validator->fails()){
                return response()->json(['error_validation'=> $validator->errors()->all(),],422);
            }
            $features = new Feature();
            $features->name = $request->name;
            if ($features->save()){
                $response = response()->json(['success'=>'Data added successfully'],200);
            } else{
                $response = response()->json(['error'=>'Data not added successfully'],400);
            }
        }else{
            $response = response()->json(['alreadyfound' => 'Event details already found!']);
        }
        return $response;
    }
     public function switch(Request $request){
        $rc_status = Feature::where('id',$request->id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status == 1){
            $new_status = 0;
        }
        else{
            $new_status = 1;
        }
        Feature::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
     public function getData(Request $request){
        $getData = Feature::where('id',$request->id)->get();
        return response()->json(['success'=>'Feature data fetched','data'=>$getData],200);
    }
    public function update(Request $request){
        $update = Feature::where('id',$request->id)->update([
            'name'=> $request->name
        ]);
        if($update){
               return response()->json(['success'=>'Feature updated successfully'],200);
            } else{
                return response()->json(['error'=>'Feature not updated'],400);
            }
    }
}
