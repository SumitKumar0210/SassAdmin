<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\ModulePermission;
use App\Models\User;
use App\Models\Usertype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ImageCompressor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.user',compact('hotlr'));
    }

    public function create(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $usertypes = Usertype::where('status',1)->get();
       
        return view('backend.modules.settings.user-create',compact('hotlr','usertypes'));
    }

    public function view(Request $request){
        if($request->ajax()){
            $features = User::get();
            return DataTables::of($features)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('email',function($row){
                return $row->email;
            })
            ->addColumn('mobile',function($row){
                return $row->mobile;
            })
            ->addColumn('usertype',function($row){
                return $row->usertype_detail->name;
            })
            ->addColumn('status',function($row){
                $checked = $row->status =='1' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="userSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                if(Auth::user()->id != $row->id){
                    return '<ul class="action"> 
                        <li class="edit"> <a href="'.route('user-edit.edit',$row->id).'"><i class="icon-pencil-alt"></i></a></li>
                        </ul>';
                }else{
                    return '';
                }
                
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function store(Request $request){
    
        $check_company_exist = User::where('mobile',$request->user_mobile)->where('email',$request->user_email)->exists();
        if($check_company_exist == false){
            $validator = Validator::make($request->all(),[
                'user_name' => 'required',
                'user_email' => 'required',
                'user_mobile' => 'required',
            ]);
            if($validator->fails()){
                return response()->json(['error_validation'=> $validator->errors()->all(),]);
            }

            $password = $request->user_password;
            $hash_pass = Hash::make($password);
            $filename = '';

            $permission_list = [];
            foreach($request->permissions as $per){
                $permission_name = ModulePermission::where('id',$per)->value('module_option');
                array_push($permission_list,$permission_name);
            }
            $item_insert = new User();
            $item_insert->name = $request->user_name;
            $item_insert->email = $request->user_email;
            $item_insert->password = $hash_pass;
            $item_insert->mobile = $request->user_mobile;
            $item_insert->address = $request->user_address;
            $item_insert->city = $request->user_city;
            $item_insert->state = $request->user_state;
            $item_insert->pincode = $request->user_pincode;
            $item_insert->country = $request->user_country;
            $item_insert->usertype_id = $request->user_usertype;
            $item_insert->id_proof_type = $request->user_documenttype;
            $item_insert->id_proof_other = $request->user_otherdetail;
            $item_insert->id_number = $request->user_idnumber;
            if ($request->hasFile('user_profile')) {

                $image = $request->file('user_profile');
                $folder = public_path('backend/uploads/profile/');
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $filename = time() . '.jpg';
                $destination = $folder . $filename;

                ImageCompressor::resizeAndCompress(
                    $image->getPathname(),
                    $destination,
                    1024,   // max width
                    150     // target size (KB)
                );

                $item_insert->profile = $filename;
            }
            $item_insert->permission = implode(',',$permission_list);

            if ($item_insert->save()) {
                return response()->json(['success' => 'Data added successfully'], 200);
            } else {
                return response()->json(['error' => 'Something Went Wrong'], 400);
            }
        }
    }

    public function edit($id){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $usertypes = Usertype::where('status',1)->get();
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
        
        $user = User::where('id',$id)->get();
        return view('backend.modules.settings.user-edit',compact('hotlr','moduleLists','usertypes','user'));
    }

    public function update(Request $request){
        $check_company_exist = User::where('name',$request->name)->where('mobile',$request->mobile)->where('id','!=',$request->user_id)->exists();
        if($check_company_exist == false){

            $permission_list = [];
            foreach($request->permissions as $per){
                $permission_name = ModulePermission::where('id',$per)->value('module_option');
                array_push($permission_list,$permission_name);
            }

            $update = User::where('id',$request->user_id)->update([
                'name' => $request->user_name,
                'mobile' => $request->user_mobile,
                'address' => $request->user_address,
                'city' => $request->user_city,
                'state' => $request->user_state,
                'pincode' => $request->user_pincode,
                'country' => $request->user_country,
                'usertype_id' => $request->user_usertype,
                'id_proof_type' => $request->user_documenttype,
                'id_proof_other' => $request->user_otherdetail,
                'id_number' => $request->user_idnumber,
                'permission' => implode(',',$permission_list),
            ]);

            if($update){

                if ($request->hasFile('user_profile')) {

                    $image = $request->file('user_profile');
                    $folder = public_path('backend/uploads/profile/');
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                    }

                    $filename = time() . '.jpg';
                    $destination = $folder . $filename;

                    ImageCompressor::resizeAndCompress(
                        $image->getPathname(),
                        $destination,
                        1024,   // max width
                        150     // target size (KB)
                    );

                    $update = User::where('id',$request->user_id)->update([
                        'profile' => $filename
                    ]);
                }

                return response()->json(['success' => 'Data Updated Successfully'],200);
            }else{
                return response()->json(['error_success' => 'Data not updated']);
            }
        }else{
            return response()->json(['alreadyfound' => 'This User details already found!']);
        }
    }

    public function switch(Request $request){
        $rc_status = User::where('id',$request->id)->value('status');
        $status = $rc_status;
        if($status == 1){
            $new_status = 0;
        }else{
            $new_status = 1;
        }
        User::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
}
