<?php

namespace App\Http\Controllers;

use App\Models\FrontSetting;
use Illuminate\Http\Request;

class FrontSettingController extends Controller
{
    public function index(){
        $count = FrontSetting::latest()->first();
        return view('front-setting.edit',['count' => $count]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'locations' => 'required|max:10',
            'doctors' => 'required|max:10',
            'beneficiary' => 'required|max:10',
        ]);
    
        $frontSetting = FrontSetting::latest()->first(); // Fetch the latest record
    
        if (!$frontSetting) {
            $frontSetting = new FrontSetting(); 
        }
        
        $frontSetting->locations = $request->input('locations');
        $frontSetting->doctors = $request->input('doctors');
        $frontSetting->beneficiary = $request->input('beneficiary');
    
        if ($frontSetting->save()) {
            return redirect()->route('front-setting')->with('success', 'Front setting has been updated');
        } else {
            return redirect()->route('front-setting')->with('error', 'Something went wrong while updating');
        }
    }

}
