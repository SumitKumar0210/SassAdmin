<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function setting(){
        $hotlr = HotlrConfiguration::get();
        $prefix = $hotlr[0]->invoice_prefix;
        $suffix_length = $hotlr[0]->suffix_length;
        return view('backend.modules.settings.setting',compact('prefix','suffix_length','hotlr'));
    }

    public function store(Request $request){
        
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'gst' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        DB::beginTransaction();
        try{
            $update = HotlrConfiguration::where('id',1)->update([
                'name' => $request->name,
                'address' => $request->address,
                'state' => $request->state,
                'pincode' => $request->zipcode,
                'gst' => $request->gst,
                'mobile' => $request->contact,
                'email' => $request->email,
                'country' => $request->country,
                'website' => $request->website,
                'city' => $request->city,
            ]);

            $imagedata = $request->file('logo');
            if ($imagedata) {
                $imageName = time() . '.' . $imagedata->getClientOriginalExtension();
                $destinationPath = public_path('/backend/');
                $imagedata->move($destinationPath, $imageName);

                $update = HotlrConfiguration::where('id',1)->update([
                    'logo' => $imageName,
                ]);
            }

            $imagedataItem = $request->file('item_add');
            if ($imagedataItem) {
                $imageNameItem = time() . '.' . $imagedataItem->getClientOriginalExtension();
                $destinationPath = public_path('/backend/uploads/tone/');
                $imagedataItem->move($destinationPath, $imageNameItem);

                $update = HotlrConfiguration::where('id',1)->update([
                    'item_add' => $imageNameItem,
                ]);
            }

            $imagedataNotification = $request->file('notification');
            if ($imagedataNotification) {
                $imageNameNotification = time() . '.' . $imagedataNotification->getClientOriginalExtension();
                $destinationPath = public_path('/backend/uploads/tone/');
                $imagedataNotification->move($destinationPath, $imageNameNotification);

                $update = HotlrConfiguration::where('id',1)->update([
                    'notification' => $imageNameNotification,
                ]);
            }
            if($update){
                return response()->json(['success' => 'Data Updated Successfully'],200);
            }else{
                return response()->json(['success' => 'Data not updated']);
            }
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data added successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }

    public function storeEInvoice(Request $request){

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'einvoice_email' => ['required'],
                'einvoice_username' => ['required'],
                'einvoice_ipaddress' => ['required'],
                'einvoice_clientid' => ['required'],
                'einvoice_clientsecret' => ['required'],
                'einvoice_gst' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }
        
        $update = HotlrConfiguration::where('id',1)->update([
            'einvoice_email' => $request->einvoice_email,
            'einvoice_username' => $request->einvoice_username,
            'einvoice_password' => $request->einvoice_password,
            'einvoice_ipaddress' => $request->einvoice_ipaddress,
            'einvoice_clientid' => $request->einvoice_clientid,
            'einvoice_clientsecret' => $request->einvoice_clientsecret,
            'einvoice_gst' => $request->einvoice_gst,
        ]);
        if($update){
            return response()->json(['success' => 'Data Updated Successfully'],200);
        }else{
            return response()->json(['success' => 'Data not updated']);
        }
    }

    public function addSound(Request $request){
        
        if ($request->ajax()) {
            if($request->type == 'item_add'){
                $validator = Validator::make($request->all(), [
                    'item_add' => ['required'],
                ]);
            }else{
                $validator = Validator::make($request->all(), [
                    'notification' => ['required'],
                ]);
            }

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        DB::beginTransaction();
        try{
            
            if($request->type == 'item_add'){
                $imagedataItem = $request->file('item_add');
                if ($imagedataItem) {
                    $imageNameItem = time() . '.' . $imagedataItem->getClientOriginalExtension();
                    $destinationPath = public_path('/backend/uploads/tone/');
                    $imagedataItem->move($destinationPath, $imageNameItem);

                    $update = HotlrConfiguration::where('id',1)->update([
                        'item_add' => $imageNameItem,
                    ]);
                }
            }else{

                $imagedataNotification = $request->file('notification');
                if ($imagedataNotification) {
                    $imageNameNotification = time() . '.' . $imagedataNotification->getClientOriginalExtension();
                    $destinationPath = public_path('/backend/uploads/tone/');
                    $imagedataNotification->move($destinationPath, $imageNameNotification);
    
                    $update = HotlrConfiguration::where('id',1)->update([
                        'notification' => $imageNameNotification,
                    ]);
                }
            }

            if($update){
                return response()->json(['success' => 'Data Updated Successfully'],200);
            }else{
                return response()->json(['success' => 'Data not updated']);
            }
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data added successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }

    public function storeTimeConfiguration(Request $request){
       
        // DB::beginTransaction();
        // try{
        //     $timeConfiguration = [
        //         'timezone'=> $request->timezone,
        //         'timeslot'=> $request->timeslot,
        //         'checkout_time'=> $request->checkout_time ?? '',
        //         'checkout_buffer_time'=> $request->checkout_buffer_time ?? '',
        //         'checkin_time'=> $request->checkin_time ?? '',
        //         'checkin_early_time'=> $request->checkin_early_time ?? '',
        //     ];
        //     $json_string = json_encode($timeConfiguration);

        //     $update = HotlrConfiguration::where('id',1)->update([
        //         'time_configuration' => $json_string,
        //     ]);
        //     if($update){
        //         return response()->json(['success' => 'Data Updated Successfully'],200);
        //     }else{
        //         return response()->json(['success' => 'Data not updated']);
        //     }

        //     DB::commit(); // data saved in both the table successfullt.
        //     return response()->json(['success' => 'Data added successfully'], 200);
        // } catch (\Exception $e) {
        //     DB::rollBack(); // if date not saved in both table then both table rollback as before.
        //     return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        // }
        //  dd(json_decode($json_string,true));
    }

    public function soundUpdateResetMute(Request $request){
        
        DB::beginTransaction();
        try{
            $hotlr = HotlrConfiguration::where('id',1)->get(['add_item_status','notification_status']);
            if($request->type == "add_item"){
                if($request->action_type == "reset"){
                    $update = HotlrConfiguration::where('id',1)->update([
                        'item_add' => 'add.mp3',
                    ]);
                }else{
                    $status = 0;
                    if($hotlr[0]->add_item_status == 0){
                        $status = 0;
                    }
                    $update = HotlrConfiguration::where('id',1)->update([
                        'add_item_status' => $status,
                    ]);
                }

            }else{
                if($request->action_type == "reset"){
                    $update = HotlrConfiguration::where('id',1)->update([
                        'notification' => 'notification.mp3',
                    ]);
                }else{
                    $status = 0;
                    if($hotlr[0]->notification_status == 0){
                        $status = 0;
                    }
                    $update = HotlrConfiguration::where('id',1)->update([
                        'notification_status' => $status,
                    ]);
                }
            }

            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data added successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }
}
