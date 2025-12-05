<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\HotlrConfiguration;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.event',compact('hotlr'));
    }

    public function view(Request $request){
        if($request->ajax()){
            $events = Event::get();
            return DataTables::of($events)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('status',function($row){
                $checked = $row->status =='1' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="eventSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="eventEdit('.$row->id.')"></i></a></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }
    public function switch(Request $request){
        $rc_status = Event::where('id',$request->id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status == 1){
            $new_status = 0;
        }
        else{
            $new_status = 1;
        }
        Event::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
    public function store(Request $request){
        $check_event_exist = Event::where('name',$request->name)->exists();
        if($check_event_exist == false){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
            ]);
            if($validator->fails()){
                return response()->json(['error_validation'=> $validator->errors()->all(),],422);
            }
            $events = new Event();
            $events->name = $request->name;
            if ($events->save()){
                $response = response()->json(['success'=>'Data added successfully'],200);
            } else{
                $response = response()->json(['error'=>'Data not added successfully'],400);
            }
        }else{
            $response = response()->json(['alreadyfound' => 'Event details already found!']);
        }
        return $response;
    }
    public function getData(Request $request){
        $getData = Event::where('id',$request->id)->get();
        return response()->json(['success'=>'Event data fetched','data'=>$getData],200);
    }
    public function update(Request $request){
        $update = Event::where('id',$request->id)->update([
            'name'=> $request->name
        ]);
        if($update){
               return response()->json(['success'=>'Event updated successfully'],200);
            } else{
                return response()->json(['error'=>'Event not updated'],400);
            }
    }
}
