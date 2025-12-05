<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.department',compact('hotlr'));
    }
        public function view(Request $request){
        if($request->ajax()){
            $departments = Department::get();
            return DataTables::of($departments)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('status',function($row){
                 $disabled = ($row->id == 1) ? 'd-none' : '';
                $checked = $row->status == 1 ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0 '.$disabled.'" onchange="departmentSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                $disabled = ($row->id == 1) ? 'd-none' : '';
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt '.$disabled.'" onclick="departmentEdit('.$row->id.')"></i></a></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }
    public function add(Request $request){
        $check_company_exist = Department::where('name',$request->name)->exists();
            if($check_company_exist == false){
            $validator = Validator::make($request->all(),[
                'name' => 'required'
            ]);
            if($validator->fails()){
                return response()->json(['error_validation'=> $validator->errors()->all(),],422);
            }
            $departments = new Department();
            $departments->name = $request->name;
            if ($departments->save()){
                $response = response()->json(['success'=>'Department addedd successfully'],200);
            } else{
                $response = response()->json(['error'=>'Department not addedd successfully'],400);
            }
        }else{
            $response = response()->json(['alreadyfound' => 'This department already found!']);
        }
        return $response;
    }
      public function switchStatus(Request $request){
        $rc_status = Department::where('id',$request->id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status == 1){
            $new_status = 0;
        }
        else{
            $new_status = 1;
        }
        Department::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
    public function getDetails(Request $request){
        $getData = Department::where('id',$request->id)->get();
        return response()->json(['success' => 'Data Fetched Successfully','data'=>$getData],200);
    }
    public function update(Request $request){
        $check_company_exist = Department::where('name',$request->name)->where('id','!=',$request->id)->exists();
        if($check_company_exist == false){
            $update = Department::where('id',$request->id)->update([
                'name' => $request->name
            ]);
            if($update){
                return response()->json(['success' => 'Department Updated Successfully'],200);
            }else{
                return response()->json(['error_success' => 'Department not updated']);
            }
        }else{
            return response()->json(['alreadyfound' => 'This department already found!']);
        }
    }
}
