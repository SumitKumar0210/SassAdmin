<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.payment_method',compact('hotlr'));
    }

    public function store(Request $request){

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }
        $check_exist = PaymentMethod::where('name',$request->name)->exists();
        if($check_exist == false){     
            $item_insert = new PaymentMethod();
            $item_insert->name = $request->name;
            if ($item_insert->save()) {
                return response()->json(['success' => 'Data added successfully'], 200);
            } else {
                return response()->json(['error' => 'Something Went Wrong'], 400);
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'Payment Method Name already exists! Enter another...']);
        }
        return $response;
    }

    public function getdetails(Request $request){

        if($request->ajax()){

            $data = PaymentMethod::whereNull('deleted_at')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name ?? '';
            })
            ->addColumn('status',function($row){
                $checked = $row->status == 1 ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="paymentMethodSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editPaymentMethod('.$row->id.')"></i></a></li>
                        <li class="delete ms-1 d-none" id="deleteBtn" onclick="deletePaymentMethod('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }
    
    public function switchStatus(Request $request){
        $rc_status = PaymentMethod::where('id',$request->id)->pluck('status');
        $status = $rc_status[0];
        $new_status = 1;
        if($status == 1){
            $new_status = 0;
        }
        PaymentMethod::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function getPaymentMethod(Request $request){
        $getData = PaymentMethod::where('id',$request->id)->get(['id','name','status']);
        return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getData[0]],200);
    }

    public function update(Request $request){  
        PaymentMethod::where('id',$request->id)->update([
            'name' => $request->name,
        ]);
        return response()->json(['success' => 'Data Updated Successfully'],200);
    }

    public function delete(Request $request){
        PaymentMethod::where('id',$request->id)->update([
            'deleted_at' => now(),
        ]);
        return response()->json(['success' => 'Payment Method Deleted Successfully'],200);
    }
}
