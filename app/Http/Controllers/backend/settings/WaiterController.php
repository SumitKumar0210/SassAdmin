<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Waiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class WaiterController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.waiter',compact('hotlr'));
    }
        public function view(Request $request){
        if($request->ajax()){
            $waiters = Waiter::get();
            return DataTables::of($waiters)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('mobile',function($row){
                return $row->mobile;
            })
            ->addColumn('status',function($row){
                $checked = $row->status =='active' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="waiterSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="waiterEdit('.$row->id.')"></i></a></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function add(Request $request){
        $check_company_exist = Waiter::where('name',$request->name)->where('mobile',$request->mobile)->exists();
            if($check_company_exist == false){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'mobile' => 'required'
            ]);
            if($validator->fails()){
                return response()->json(['error_validation'=> $validator->errors()->all(),],422);
            }
            $waiters = new Waiter();
            $waiters->name = $request->name;
            $waiters->mobile = $request->mobile;
            if ($waiters->save()){
                $response = response()->json(['success'=>'Data addedd successfully'],200);
            } else{
                $response = response()->json(['error'=>'Data not addedd successfully'],400);
            }
        }else{
            $response = response()->json(['alreadyfound' => 'This waiter details already found!']);
        }
        return $response;
    }

    public function switchStatus(Request $request){
        $rc_status = Waiter::where('id',$request->id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status === 'active'){
            $new_status = 'inactive';
        }
        else{
            $new_status = 'active';
        }
        Waiter::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
    public function getDetails(Request $request){
        $getData = Waiter::where('id',$request->id)->get();
        return response()->json(['success' => 'Data Fetched Successfully','data'=>$getData],200);
    }
    
    public function update(Request $request){
        $check_company_exist = Waiter::where('name',$request->name)->where('mobile',$request->mobile)->where('id','!=',$request->id)->exists();
        if($check_company_exist == false){
            $update = Waiter::where('id',$request->id)->update([
                'name' => $request->name,
                'mobile' => $request->mobile
            ]);
            if($update){
                return response()->json(['success' => 'Data Updated Successfully'],200);
            }else{
                return response()->json(['error_success' => 'Data not updated']);
            }
        }else{
            return response()->json(['alreadyfound' => 'This Waiter details already found!']);
        }
    }
}
