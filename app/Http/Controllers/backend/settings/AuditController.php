<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['audit_start','audit_end','duration','logo','name']);
        return view('backend.modules.settings.audit',compact('hotlr'));
    }

    public function update(Request $request){
        $config = HotlrConfiguration::where('id',1)->update([
            'audit_start' => $request->start,
            'audit_end' => $request->end,
            'duration' => $request->duration
        ]);
        if($config){
            return $response = response()->json(['success'=>'Data updated successfully'],200);
        } else{
            return $response = response()->json(['error'=>'Data not updated successfully'],400);
        }
    }

}
