<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\BedType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BedtypeController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $bedTypeData = BedType::get();
           //dd($bedTypeData);
            return DataTables::of($bedTypeData)
            ->addIndexColumn()
            // ->addColumn('id',function($row){
            //     return $row->id;
            // })
            ->addColumn('bedtype',function($row){
                return $row->bedtype;
            })
            ->addColumn('status',function($row){
                $checked = $row->status ==='active' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="bedtypeSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editbedType('.$row->id.')"></i></a></li>
                        <li class="delete ms-1 d-none" id="deleteBtn" onclick="delete_bedType('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }
    public function store(Request $request){   
        
        $check_bedType_exist = BedType::where('bedtype',$request->bedtype)->exists();
        if($check_bedType_exist == false){
            $bedtypedata = $request->bedtype;
            $bedType = new BedType();
            $bedType->bedtype = $bedtypedata;
            
            if ($bedType->save()){
                $response = response()->json(['success'=>'Data addedd successfully'],200);
            } else{
                $response = response()->json(['error'=>'Data not addedd successfully'],400);
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'This Bed Type already found! Enter another...']);
        }
        return $response;
    }
    public function bedTypeSwitch(Request $request){
        $id = $request->id;
        $rc_status = BedType::where('id',$id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status === 'active'){
            $new_status = 'inactive';
        }
        else{
            $new_status = 'active';
        }
        BedType::where('id',$id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
    public function get_bedtypeDetails(Request $request){
        $id = $request->id;
        $getData = BedType::where('id',$id)->get();
        return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getData],200);
     }
     public function bedType_update(Request $request)
     {  
       // dd($request->all());
         $id = $request->id;
         $bed_type = $request->bed_type;
         BedType::where('id',$id)->update([
             'bedtype' => $bed_type
         ]);
        return response()->json(['success' => 'Data Updated Successfully'],200);
     }
     public function bedType_delete(Request $request)
     {
         $id = $request->id;
         BedType::where('id',$id)->delete();
         return response()->json(['success' => 'RoomType Name Deleted Successfully'],200);
     }
    }
