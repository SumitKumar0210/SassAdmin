<?php

namespace App\Http\Controllers\backend\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RestaurantCategoryController extends Controller
{
    public function index(Request $request){
        $category = Category::get();
        $list = [];
        foreach($category as $cate){
            $data = [
                'id' => $cate['id'],
                'name' => $cate['name'],
                'type' => $cate->category_detail->name ?? ''
            ];
            array_push($list,$data);
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.restaurant.restaurant_item_category',compact('list','hotlr'));
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
        $check_exist = Category::where('name',$request->name)->where('type',$request->type)->exists();
        if($check_exist == false){     
            $item_insert = new Category();
            $item_insert->name = $request->name;
            $item_insert->type = $request->type;
            if ($item_insert->save()) {
                return response()->json(['success' => 'Data added successfully'], 200);
            } else {
                return response()->json(['error' => 'Something Went Wrong'], 400);
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'Category Name already exists! Enter another...']);
        }
        return $response;
    }

    public function getdetails(Request $request){

        if($request->ajax()){

            $data = Category::whereNull('deleted_at')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name ?? '';
            })
            ->addColumn('parent',function($row){
                return $row->category_detail->name ?? '';
            })
            ->addColumn('type',function($row){
                $type = 'Main';
                if($row->type > 0){
                    $type = 'Sub';
                }
                return $type.' Category';
            })
            ->addColumn('status',function($row){
                $checked = $row->status == 1 ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="restaurantCategorySwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editRestaurantCategory('.$row->id.')"></i></a></li>
                        <li class="delete ms-1" id="deleteBtn" onclick="deleteRestaurantCategory('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function switchStatus(Request $request){
        $rc_status = Category::where('id',$request->id)->pluck('status');
        $status = $rc_status[0];
        $new_status = 1;
        if($status == 1){
            $new_status = 0;
        }
        Category::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function getCategory(Request $request){
        $getData = Category::where('id',$request->id)->get(['id','name','type','status']);
        return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getData[0]],200);
    }

    public function update(Request $request){  
        Category::where('id',$request->id)->update([
            'name' => $request->name,
            'type' => $request->type
        ]);
        return response()->json(['success' => 'Data Updated Successfully'],200);
    }

    public function delete(Request $request){
        Category::where('id',$request->id)->update([
            'deleted_at' => now(),
        ]);
        return response()->json(['success' => 'Restaurant Category Deleted Successfully'],200);
    }

    public function getCategoryAll(Request $request){
        $attr = Category::where('type',$request->type)->whereNull('deleted_at')->get(['id','name']);
        return response()->json(['success' => 'All releted Category fetch Successfully','data' => $attr],200);
    }
}
