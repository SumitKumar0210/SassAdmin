<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\State;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    public function index(){
        $states = State::get(['gst_code','name']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.vendor',compact('states','hotlr'));
    }
    
    public function view(Request $request){
        if($request->ajax()){
            $waiters = Vendor::get();
            return DataTables::of($waiters)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('mobile',function($row){
                return $row->mobile;
            })
            ->addColumn('address',function($row){
                return $row->address;
            })
            ->addColumn('gst',function($row){
                return $row->gst;
            })
            ->addColumn('status',function($row){
                $checked = $row->status == 1 ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="vendorSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="vendorEdit('.$row->id.')"></i></a></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function add(Request $request){
        $check_company_exist = Vendor::where('name',$request->name)->exists();
        if($check_company_exist == false){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
            ]);
            if($validator->fails()){
                return response()->json(['error_validation'=> $validator->errors()->all(),]);
            }

            $vendors = new Vendor();
            $vendors->name = $request->name;
            $vendors->mobile = $request->mobile;
            $vendors->gst = $request->gst;
            $vendors->address = $request->address;
            $vendors->addrBnm = $request->AddrBnm;
            $vendors->addrBno = $request->AddrBno;
            $vendors->addrFlno = $request->AddrFlno;
            $vendors->addrLoc = $request->AddrLoc;
            $vendors->addrPncd = $request->AddrPncd;
            $vendors->addrSt = $request->AddrSt;
            $vendors->BlkStatus = $request->BlkStatus;
            $vendors->DtDReg = $request->DtDReg;
            $vendors->DtReg = $request->DtReg;
            $vendors->LegalName = $request->LegalName;
            $vendors->StateCode = $request->StateCode;
            $vendors->TradeName = $request->TradeName;
            $vendors->TxpType = $request->TxpType;
            $vendors->gstStatus = $request->Status;
            $vendors->state = $request->state;
            $vendors->billing_address = $request->billing_address;
            $vendors->billing_pincode = $request->billing_pincode;
            $vendors->billing_state_code = $request->billing_state_code;
            $vendors->billing_state = $request->billing_state;
            
            if ($vendors->save()){
                $response = response()->json(['success'=>'Vendor addedd successfully'],200);
            } else{
                $response = response()->json(['error'=>'Vendor not addedd successfully'],400);
            }
        }else{
            $response = response()->json(['alreadyfound' => 'This Vendor details already found!']);
        }
        return $response;
    }

    public function switchStatus(Request $request){
        $rc_status = Vendor::where('id',$request->id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status == 1){
            $new_status = 0;
        }
        else{
            $new_status = 1;
        }
        Vendor::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function getDetails(Request $request){
        $getData = Vendor::where('id',$request->id)->get();
        return response()->json(['success' => 'Vendor Data Fetched Successfully','data'=>$getData],200);
    }

    public function update(Request $request){
        $check_vendor_exist = Vendor::where('name',$request->name)->where('mobile',$request->mobile)->where('gst',$request->get)->where('id','!=',$request->id)->exists();
        if($check_vendor_exist == false){
            $update = Vendor::where('id',$request->id)->update([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'StateCode' => $request->state_code,
                'state' => $request->state,
                'addrPncd' => $request->pincode,
                'mobile' => $request->mobile,
                'billing_address' => $request->billing_address,
                'billing_pincode' => $request->billing_pincode,
                'billing_state_code' => $request->billing_state_code,
                'billing_state' => $request->billing_state,
            ]);
            if($update){
                return response()->json(['success' => 'Vendor Updated Successfully'],200);
            }else{
                return response()->json(['error_success' => 'Vendor not updated']);
            }
        }else{
            return response()->json(['alreadyfound' => 'This Vendor details already found!']);
        }
    }
}
