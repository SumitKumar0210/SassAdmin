<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\BanquetBooking;
use App\Models\Company;
use App\Models\HotlrConfiguration;
use App\Models\State;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    public function index(){
        $states = State::get(['gst_code','name']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.company',compact('states','hotlr'));
    }
    
    public function view(Request $request){
        if($request->ajax()){
            $companys = Company::get();
            return DataTables::of($companys)
            ->addIndexColumn()
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('gst',function($row){
                return $row->Gstin;
            })
            ->addColumn('state',function($row){
                return $row->state;
            })
            ->addColumn('mobile',function($row){
                return $row->mobile;
            })
            ->addColumn('email',function($row){
                return $row->email;
            })
            ->addColumn('status',function($row){
                $checked = $row->status =='active' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="companySwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="companyEdit('.$row->id.')"></i></a></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }
    
    public function add(Request $request){

        $check_company_exist = Company::where('Gstin',$request->gst)->exists();
        if($check_company_exist == false){
            $validator = Validator::make($request->all(),[
                'TradeName' => 'required',
                'gst' => 'required',
                'StateCode' => 'required',
                'AddrPncd' => 'nullable',
            ]);

            if($validator->fails()){
                return response()->json(['error_validation'=> $validator->errors()->all(),],422);
            }

            $companys = new Company();
            $companys->name = $request->TradeName;
            $companys->Gstin = $request->gst;
            $companys->address = $request->address;
            $companys->addrBnm = $request->AddrBnm;
            $companys->addrBno = $request->AddrBno;
            $companys->addrFlno = $request->AddrFlno;
            $companys->addrLoc = $request->AddrLoc;
            $companys->addrPncd = $request->AddrPncd;
            $companys->addrSt = $request->AddrSt;
            $companys->BlkStatus = $request->BlkStatus;
            $companys->DtDReg = $request->DtDReg;
            $companys->DtReg = $request->DtReg;
            $companys->LegalName = $request->LegalName;
            $companys->StateCode = $request->StateCode;
            $companys->TradeName = $request->TradeName;
            $companys->TxpType = $request->TxpType;
            $companys->gstStatus = $request->Status;
            $companys->state = $request->state;
            $companys->mobile = $request->mobile;
            $companys->email = $request->email;
            $companys->billing_address = $request->billing_address;
            $companys->billing_pincode = $request->billing_pincode;
            $companys->billing_state_code = $request->billing_state_code;
            $companys->billing_state = $request->billing_state;
            
            if ($companys->save()){
                $response = response()->json(['success'=>'Data addedd successfully'],200);
            } else{
                $response = response()->json(['error'=>'Data not addedd successfully'],400);
            }
        }else{
            $response = response()->json(['alreadyfound' => 'This Company details already found!']);
        }
        return $response;
    }
    
    public function switchStatus(Request $request){
        $rc_status = Company::where('id',$request->id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status === 'active'){
            $new_status = 'inactive';
        }
        else{
            $new_status = 'active';
        }
        Company::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
    
    public function getDetails(Request $request){
        $getData = Company::where('id',$request->id)->get();
        return response()->json(['success' => 'Data Fetched Successfully','data'=>$getData],200);
    }
    
    public function update(Request $request){
        $check_company_exist = Company::where('name',$request->name)->where('state',$request->state)->where('id','!=',$request->id)->exists();
        if($check_company_exist == false){
            $update = Company::where('id',$request->id)->update([
                'name' => $request->name,
                'address' => $request->address,
                'StateCode' => $request->state_code,
                'state' => $request->state,
                'addrPncd' => $request->pincode,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'billing_address' => $request->billing_address,
                'billing_pincode' => $request->billing_pincode,
                'billing_state_code' => $request->billing_state_code,
                'billing_state' => $request->billing_state,
            ]);
            if($update){
                return response()->json(['success' => 'Data Updated Successfully'],200);
            }else{
                return response()->json(['success' => 'Data not updated']);
            }
        }else{
            return response()->json(['alreadyfound' => 'This Company details already found!']);
        }
    }

    public function verifyGst(Request $request){
        // dd($request->all());
        if($request->type == 'Company'){
            $check_company_exist = Company::where('Gstin',$request->number)->exists();
        }else if($request->type == 'Banquet'){
            $check_company_exist = BanquetBooking::where('company_gst',$request->number)->exists();
        }else{
            $check_company_exist = Vendor::where('gst',$request->number)->exists();
        }
        if($check_company_exist == false){
            $hotlr = HotlrConfiguration::where('status',1)->get();
            $token = $hotlr[0]->einvoice_authtoken;

            if($hotlr[0]->einvoice_token_expiry != '' || ( $hotlr[0]->einvoice_token_expiry < date('Y-m-d H:i:s')) ){

                $url = $hotlr[0]->einvoice_url."einvoice/authenticate?email=".urlencode($hotlr[0]->einvoice_email);
        
                $headers = [
                    'accept' => '*/*',
                    'username' => $hotlr[0]->einvoice_username,
                    'password' => $hotlr[0]->einvoice_password,
                    'ip_address' => $hotlr[0]->einvoice_ipaddress,
                    'client_id' => $hotlr[0]->einvoice_clientid,
                    'client_secret' => $hotlr[0]->einvoice_clientsecret,
                    'gstin' => $hotlr[0]->einvoice_gst,
                ];
        
                $response = Http::withHeaders($headers)
                            ->withoutVerifying()
                            ->get($url);
        
        
                $data = $response->json(['data']);
                $token = $data['AuthToken'];
                $token_expiry = $data['TokenExpiry'];

                $secondsToSubtract = 20;
                
                $newExpiry = date('Y-m-d H:i:s', strtotime("$token_expiry -$secondsToSubtract seconds"));
                $update_einvoice = HotlrConfiguration::where('id',1)->update([
                    'einvoice_token_expiry' => $newExpiry,
                    'einvoice_authtoken' => $token
                ]);
            }

            // Verify the gst and get auth-token
            $url_gst = $hotlr[0]->einvoice_url."einvoice/type/GSTNDETAILS/version/V1_03?param1=".$request->number."&email=".urlencode($hotlr[0]->einvoice_email);

            $headers1 = [
                'accept' => '*/*',
                'username' => $hotlr[0]->einvoice_username,
                'password' => $hotlr[0]->einvoice_password,
                'ip_address' => $hotlr[0]->einvoice_ipaddress,
                'client_id' => $hotlr[0]->einvoice_clientid,
                'client_secret' => $hotlr[0]->einvoice_clientsecret,
                'gstin' => $hotlr[0]->einvoice_gst,
                'auth-token' => $token
            ];

            $response = Http::withHeaders($headers1)
                ->withoutVerifying()
                ->get($url_gst);

            return response()->json([
                'status' => $response->status(),
                'data' => $response->json(),
            ]);
        }else{
            return response()->json(['alreadyfound' => 'Gst already exists in record!']);
        }
    }

}