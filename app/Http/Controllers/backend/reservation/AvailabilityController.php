<?php

namespace App\Http\Controllers\backend\reservation;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    //
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.reservation.availability',compact('hotlr'));
    }
}
