<?php

namespace App\Http\Controllers\backend\restaurant;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\ItemAttribute;
use App\Models\ItemVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RestaurantItemAttributeController extends Controller
{
    public function index(Request $request){
        $attribute = ItemAttribute::where('type',0)->get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.restaurant.restaurant_item_attribute', compact('attribute','hotlr'));
    }

    public function store(Request $request){

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'type' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }
        $check_exist = ItemAttribute::where('name',$request->name)->where('type',$request->type)->exists();
        if($check_exist == false){     
            $item_insert = new ItemAttribute();
            $item_insert->name = $request->name;
            $item_insert->type = $request->type;
            if ($item_insert->save()) {
                return response()->json(['success' => 'Data added successfully'], 200);
            } else {
                return response()->json(['error' => 'Something Went Wrong'], 400);
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'Attribute Name already exists! Enter another...']);
        }
        return $response;
    }

    public function getdetails(Request $request){

        if($request->ajax()){

            $data = ItemAttribute::whereNull('deleted_at')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name ?? '';
            })
            ->addColumn('attribute',function($row){
                $type = '';
                if($row->type > 0){
                    $attr = ItemAttribute::where('id',$row->type)->value('name');
                    $type = $attr;
                }
                return $type;
            })
            ->addColumn('type',function($row){
                $type = 'Main';
                if($row->type > 0){
                    $type = 'Sub';
                }
                return $type.' Attribute';
            })
            ->addColumn('status',function($row){
                $checked = $row->status == 1 ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="restaurantItemAttributeSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editRestaurantItemAttribute('.$row->id.')"></i></a></li>
                        <li class="delete ms-1" id="deleteBtn" onclick="deleteRestaurantItemAttribute('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function switchStatus(Request $request){
        $rc_status = ItemAttribute::where('id',$request->id)->pluck('status');
        $status = $rc_status[0];
        $new_status = 1;
        if($status == 1){
            $new_status = 0;
        }
        ItemAttribute::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function getAttribute(Request $request){
        $getData = ItemAttribute::where('id',$request->id)->get(['id','name','type','status']);
        return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getData[0]],200);
    }

    public function update(Request $request){  
        ItemAttribute::where('id',$request->id)->update([
            'name' => $request->name,
            'type' => $request->type
        ]);
        return response()->json(['success' => 'Data Updated Successfully'],200);
    }

    public function delete(Request $request){
        ItemAttribute::where('id',$request->id)->update([
            'deleted_at' => now(),
        ]);
        return response()->json(['success' => 'Item Attribute Deleted Successfully'],200);
    }
   
    public function getAttributeAll(Request $request){
        $attr = ItemAttribute::where('type',$request->type)->whereNull('deleted_at')->get(['id','name']);
        return response()->json(['success' => 'All releted Attribute fetch  Successfully','data' => $attr],200);
    }

    public function itemVariantGetAll(Request $request){
        $variants = ItemVariation::where('item_id',$request->id)->whereNull('deleted_at')->get(['id','name','price']);
        return response()->json(['success' => 'All releted variant fetch Successfully','data' => $variants],200);
    }
}
