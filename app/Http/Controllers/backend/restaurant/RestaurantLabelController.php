<?php

namespace App\Http\Controllers\backend\restaurant;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RestaurantLabelController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.restaurant.restaurant_item_label',compact('hotlr'));
    }
    
    public function getdetails(Request $request){
        
        if ($request->ajax()){
            $data = Label::whereNull('deleted_at')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                return '<img src="'.asset('backend/uploads/Item/' . $row->image . '').'" height="50px" width="60px">';
            })
            ->addColumn('name', function ($row) {
                return $row->name ?? '';
            })
            ->addColumn('status',function($row){
                $checked = $row->status == 1 ? 'checked' : ''; // check if status is active then checked
                    return '<div class="flex-grow-1 icon-state switch-outline">
                        <label class="switch mb-0" onchange="restaurantItemLabelSwitch('.$row->id.')">
                        <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                        </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editRestaurantItemLabel('.$row->id.')"></i></a></li>
                        <li class="delete ms-1" id="deleteBtn" onclick="deleteRestaurantItemLabel('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['image','status','action'])
            ->make(true);
        }
    }

    public function store(Request $request){

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'image' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }
        $check_exist = Label::where('name',$request->name)->exists();
        if($check_exist == false){     
            $imagedata = $request->file('image');
            $item_label = new Label();
            $item_label->name = $request->name;
            
            if ($imagedata) {
                $imageName = time() . '.' . $imagedata->getClientOriginalExtension();
                $destinationPath = public_path('/backend/uploads/Item');
                $imagedata->move($destinationPath, $imageName);
                $item_label->image = $imageName;
            }
            
            if ($item_label->save()) {
                return response()->json(['success' => 'Data added successfully'], 200);
            } else {
                return response()->json(['error' => 'Data not added successfully'], 400);
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'Label Name already exists! Enter another...']);
        }
        return $response;
    }

    public function switchStatus(Request $request){
        $rc_status = Label::where('id',$request->id)->pluck('status');
        $status = $rc_status[0];
        $new_status = 1;
        if($status == 1){
            $new_status = 0;
        }
        Label::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function getLabel(Request $request){
        $getData = Label::where('id',$request->id)->get(['id','name','image','status']);
        return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getData[0]],200);
    }

    public function update(Request $request){  
        $imagedata = $request->file('image');
        if ($imagedata) {
            $imageName = time() . '.' . $imagedata->getClientOriginalExtension();
            $destinationPath = public_path('/backend/uploads/Item');
            $imagedata->move($destinationPath, $imageName);
            Label::where('id',$request->id)->update([
                'image' => $imageName
            ]);
        }
        Label::where('id',$request->id)->update([
            'name' => $request->name,
        ]);
        return response()->json(['success' => 'Data Updated Successfully'],200);
    }

    public function delete(Request $request){
        Label::where('id',$request->id)->update([
            'deleted_at' => now(),
        ]);
        // Label::where('id',$request->id)->delete();
        return response()->json(['success' => 'Label Deleted Successfully'],200);
    }
}
