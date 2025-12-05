<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.profile',compact('hotlr'));
    }
}
