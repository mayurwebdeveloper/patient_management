<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Notification;
use App\Models\PmJay;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {     
        // error_reporting(E_ALL);
        // ini_set('display_errors',1);
        $hospital_count = Hospital::all()->count();
        $pmjay_count = PmJay::all()->count();
        $enquiry_count = Notification::all()->count();
        $data = compact('hospital_count','pmjay_count','enquiry_count');
        return view('dashboard')->with($data);
    }
}
