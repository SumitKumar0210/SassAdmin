<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use App\Models\ModulePermission;
use App\Models\Usertype;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UsertypeController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.usertype',compact('hotlr'));
    }

    public function view(Request $request){
        if($request->ajax()){
            $features = Usertype::get();
            return DataTables::of($features)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('status',function($row){
                $checked = $row->status =='1' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="usertypeSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="'.route('usertype-edit.edit',$row->id).'"><i class="icon-pencil-alt"></i></a></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function create(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $modules = ModulePermission::distinct()->select('module_id')->where('status',1)->get();
        $moduleLists = [];
        foreach($modules as $modul){

            $modules = ModulePermission::where('module_id',$modul->module_id)->where('status',1)->get(['id','module_id','module','module_option']);
            $moduleLists[] = [
                'module_id' => $modul->module_id,
                'module' => $modules[0]->module,
                'items' => $modules
            ];
        }
        
        return view('backend.modules.settings.usertype-create',compact('hotlr','moduleLists'));
    }

    public function store(Request $request){
        // dd($request->all());
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'permissions' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        $check_exist = Usertype::where('name',$request->name)->exists();
        if($check_exist == false){     
            $item_insert = new Usertype();
            $item_insert->name = $request->name;
            $item_insert->permissions = implode(',',$request->permissions);
            if ($item_insert->save()) {
                return response()->json(['success' => 'Data added successfully'], 200);
            } else {
                return response()->json(['error' => 'Something Went Wrong'], 400);
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'Usertype already exists! Enter another...']);
        }
        return $response;
    }

    public function switch(Request $request){
        $rc_status = Usertype::where('id',$request->id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status == 1){
            $new_status = 0;
        }
        else{
            $new_status = 1;
        }
        Usertype::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function getPermissionUser(Request $request){
       
        $get_permission = Usertype::where('id',$request->id)->value('permissions');
        $modules = ModulePermission::distinct()->select('module_id')->where('status',1)->get();
        $moduleLists = [];
        foreach($modules as $modul){

            $modules = ModulePermission::where('module_id',$modul->module_id)->where('status',1)->get(['id','module_id','module','module_option']);
            $moduleLists[] = [
                'module_id' => $modul->module_id,
                'module' => $modules[0]->module,
                'items' => $modules
            ];
        }

        return response()->json(['success' => 'Data Fetched Successfully','permissions'=> $get_permission, 'moduleLists' => $moduleLists],200);
    }

    public function edit($id){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $modules = ModulePermission::distinct()->select('module_id')->where('status',1)->get();
        $moduleLists = [];
        foreach($modules as $modul){

            $modules = ModulePermission::where('module_id',$modul->module_id)->where('status',1)->get(['id','module_id','module','module_option']);
            $moduleLists[] = [
                'module_id' => $modul->module_id,
                'module' => $modules[0]->module,
                'items' => $modules
            ];
        }
        
        $usertypes = Usertype::where('id',$id)->get();
        return view('backend.modules.settings.usertype-edit',compact('hotlr','moduleLists','usertypes'));
    }

    public function update(Request $request){
        
        $check_company_exist = Usertype::where('name',$request->name)->where('id','!=',$request->id)->exists();
        if($check_company_exist == false){
            $update = Usertype::where('id',$request->id)->update([
                'name' => $request->name,
                'permissions' => implode(',',$request->permissions)
            ]);
            if($update){
                return response()->json(['success' => 'Data Updated Successfully'],200);
            }else{
                return response()->json(['error_success' => 'Data not updated']);
            }
        }else{
            return response()->json(['alreadyfound' => 'This Usertype details already found!']);
        }
    }
}
