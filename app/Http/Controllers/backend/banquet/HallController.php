<?php

namespace App\Http\Controllers\backend\banquet;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Hall;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class HallController extends Controller
{
    public function index(){
        $features = Feature::where('status',1)->get(['id','name','icon']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.banquet.hall',compact('features','hotlr'));
    }

    public function view(Request $request){
        if($request->ajax()){
            $halls = Hall::get();
            return DataTables::of($halls)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('capacity',function($row){
                return $row->capacity;
            })
            ->addColumn('area',function($row){
                return $row->area;
            })
            ->addColumn('setup_time',function($row){
                return $row->setup_time;
            })
            ->addColumn('rate',function($row){
                return $row->rate;
            })
            ->addColumn('no_of_room',function($row){
                return $row->complimentary_rooms;
            })
            ->addColumn('feature',function($row){
                $html = '';
                $feat = explode(',',$row->features);
                foreach($feat as $fea){
                    $featu = Feature::where('id',$fea)->get(['id','name']);
                    $html .= $featu[0]['name'].',';
                }
                return rtrim($html, ",");
            })
            ->addColumn('status',function($row){
                $checked = $row->status =='1' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="hallSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                $html = '';
                if(in_array('Banquet Hall Edit', (explode(',',auth()->user()->permission)))){
                $html = '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="hallEdit('.$row->id.')"></i></a></li>
                        </ul>';
                }
                return $html;
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function store(Request $request){
        $check_feature_exist = Hall::where('name',$request->name)->exists();
        if($check_feature_exist == false){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'rate' => 'required',
                'capacity' => 'required | numeric',
                'area' => 'required',
                'no_of_rooms' => 'required | numeric',
                'features' => 'required | array',
                'setup_time' => 'required',
            ]);
            if($validator->fails()){
                return response()->json(['error_validation'=> $validator->errors()->all(),],422);
            }
            $features = new Hall();
            $features->name = $request->name;
            $features->rate = $request->rate;
            $features->capacity = $request->capacity;
            $features->features = implode(',',$request->features);
            $features->complimentary_rooms = $request->no_of_rooms;
            $features->setup_time = $request->setup_time;
            $features->area = $request->area;
            $features->created_by =  Auth::user()->id;
            if ($features->save()){
                $response = response()->json(['success'=>'Data added successfully'],200);
            } else{
                $response = response()->json(['error_success'=>'Data not added successfully'],400);
            }
        }else{
            $response = response()->json(['alreadyfound' => 'Event details already found!']);
        }
        return $response;
    }
    public function switch(Request $request){
        $hall_status = Hall::where('id',$request->id)->get(['status']);
        $status = $hall_status[0]->status;
        if($status == 1){
            $new_status = 0;
        }
        else{
            $new_status = 1;
        }
        Hall::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
    public function getData(Request $request){
        $getData = Hall::where('id',$request->id)->get();
        return response()->json(['success' => 'Data Fetched Successfully','data'=>$getData],200);
    }
    public function update(Request $request){
        $update = Hall::where('id',$request->id)->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'area' => $request->area,
            'setup_time' => $request->setup_time,
            'rate' => $request->rate,
            'complimentary_rooms' => $request->no_of_rooms,
            'features' => $request->features
        ]);
        if($update){
            return response()->json(['success' => 'Hall Updated Successfully'],200);
        }else{
            return response()->json(['error_success' => 'Hall not updated']);
        }
    }

    public function updateStatus(Request $request){
        
        $hall = Hall::where('id',$request->id)->value('status');
        $new_status = 1;
        if($hall == 1){
            $new_status = 2;
        }
        $update = Hall::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        if($update){
            return response()->json(['success' => 'Hall status successfully updated'],200);
        }else{
            return response()->json(['error_success' => 'Hall not updated']);
        }
        
    }
}
