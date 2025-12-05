<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index(){
        $userdata = User::get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.admin.permission',compact('userdata','hotlr'));
    }
    public function update_users(Request $request){
        $request->validate([
            'id' => 'required|exists:users,id',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required'
        ]);
        $permissionArray = $request->permission;
        $permission = implode(",", $permissionArray);
        $updated = User::where('id', $request->id)->update([
            'name' => $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'permission' => $permission,
        ]);
        if ($updated) {
            return response()->json(['success' => 'User updated successfully'], 200);
        } else {
            return response()->json(['error_success' => 'User not updated'], 500);
        }
    }
    public function addNewUser(Request $request){
        $validator = Validator::make($request->all(),[
        'name' => ['required'],
        'email' => ['required'],
        'mobile' => ['required'],
        'password' => ['required'],
        'permission' => ['required','array']
        ]);
        if($validator->fails()){
            return response()->json(['error_validation' => $validator->errors()->all()], 200);
        }
        $password = $request->password;
        $hash_pass = Hash::make($password);
        $pemission_string = implode(",",$request->permission);
        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->mobile = $request->mobile;
        $users->password = $hash_pass;
        $users->plain_password = $password;
        $users->permission = $pemission_string;
        if($users->save()){
            return response()->json(['success'=>'Used added successfully'],200);
        }else{
            return response()->json(['error_success'=>'Used not added']);
        }
    }
    public function deleteUser(Request $request){
        $user = User::find($request->id);
        if ($user) {
            $user->delete();
            return response()->json(["success" => "User deleted successfully"], 200);
        } else {
            return response()->json(["error_success" => "User not found"], 404);
        }
    }
}