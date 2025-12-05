<?php

namespace App\Http\Controllers\backend\restaurant;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Measurement;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RestaurantRawMaterialController extends Controller
{
    public function index(Request $request){
        $measurements = Measurement::get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.restaurant.restaurant_raw_material',compact('measurements','hotlr'));
    }

    public function store(Request $request){

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'itemcode' => ['required'],
                'name' => ['required'],
                'uom' => ['required'],
                'min_qty' => ['required'],
                'max_qty' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }
        $check_exist = RawMaterial::where('code',$request->itemcode)->where('name',$request->name)->exists();
        if($check_exist == false){     
            $item_insert = new RawMaterial();
            $item_insert->code = $request->itemcode;
            $item_insert->name = $request->name;
            $item_insert->uom = $request->uom;
            $item_insert->min_qty = $request->min_qty;
            $item_insert->max_qty = $request->max_qty;
            if ($item_insert->save()) {
                return response()->json(['success' => 'Data added successfully'], 200);
            } else {
                return response()->json(['error' => 'Something Went Wrong'], 400);
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'Item already exists! Enter another...']);
        }
        return $response;
    }

    public function getdetails(Request $request){

        if($request->ajax()){

            $data = RawMaterial::whereNull('deleted_at')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('code',function($row){
                return $row->code ?? '';
            })
            ->addColumn('name',function($row){
                return $row->name ?? '';
            })
            ->addColumn('uom',function($row){
                $unit = Measurement::where('id',$row->uom)->pluck('short_name');
                return $unit[0] ?? '';
            })
            ->addColumn('min_qty',function($row){
                return $row->min_qty ?? '';
            })
            ->addColumn('max_qty',function($row){
                return $row->max_qty ?? '';
            })
            ->addColumn('status',function($row){
                $checked = $row->status == 1 ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="RawMaterialSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editRawMaterial('.$row->id.')"></i></a></li>
                        <li class="delete ms-1" id="deleteBtn" onclick="deleteRawMaterial('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function switchStatus(Request $request){
        $rc_status = RawMaterial::where('id',$request->id)->pluck('status');
        $status = $rc_status[0];
        $new_status = 1;
        if($status == 1){
            $new_status = 0;
        }
        RawMaterial::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function getRawMaterial(Request $request){
        $getData = RawMaterial::where('id',$request->id)->get(['id','code','name','uom','min_qty','max_qty','status']);
        return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getData[0]],200);
    }

    public function update(Request $request){  
        RawMaterial::where('id',$request->id)->update([
            'code' => $request->code,
            'name' => $request->name,
            'uom' => $request->uom,
            'min_qty' => $request->min_qty,
            'max_qty' => $request->max_qty
        ]);
        return response()->json(['success' => 'Data Updated Successfully'],200);
    }

    public function delete(Request $request){
        RawMaterial::where('id',$request->id)->update([
            'deleted_at' => now(),
        ]);
        return response()->json(['success' => 'Item Attribute Deleted Successfully'],200);
    }
}
