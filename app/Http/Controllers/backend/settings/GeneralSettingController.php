<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeneralSettingController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get();
        $prefix = $hotlr[0]->invoice_prefix;
        $suffix_length = $hotlr[0]->suffix_length;
        return view('backend.modules.settings.general_setting',compact('prefix','suffix_length','hotlr'));
    }

    public function updateInvoice(Request $request){

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'prefix' => ['required'],
                'suffix_length' => ['required','numeric'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        $updateInvoiceSetting = HotlrConfiguration::where('id',1)->update([
            'invoice_prefix' => $request->prefix,
            'suffix_length' => $request->suffix_length
        ]);
        if ($updateInvoiceSetting) {
            return response()->json(['success' => 'Data updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something Went Wrong'], 400);
        }
    }

    public function resetInvoiceNumber(Request $request){
        $updateInvoiceSetting = HotlrConfiguration::where('id',$request->id)->update([
            'invoice_no' => 1,
        ]);
        if ($updateInvoiceSetting) {
            return response()->json(['success' => 'Invoice Number updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something Went Wrong'], 400);
        }
    }
}
