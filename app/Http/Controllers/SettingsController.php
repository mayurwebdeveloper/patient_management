<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public $keys = [];

    public function __construct() {

        $this->keys = [
            'app_name',
            'app_email',
            'mail_engine',
            'smtp_hostname',
            'smtp_username',
            'smtp_password',
            'smtp_port',
            'smtp_encryption',
            'smtp_timeout',
        ];
    }

    public function index(){

        $setting = [];

        foreach ($this->keys as $key) {
            $result = Setting::where('key', $key)->first();
            $setting[$key] = $result->value ?? "";
        }
        //get app logo
        $setting['app_logo'] = Setting::where('key', 'app_logo')->first()->value ?? 'logo.png';
        return view('settings.edit',['setting' => $setting]);
    }


    public function update(Request $request){

        foreach ($this->keys as $key) {
            if($request->has($key) && $request->input($key)){
                // Check if the setting already exists
                $setting = Setting::where('key', $key)->first();
                if ($setting) {
                    // Update the existing setting
                    $setting->update(['value' => $request->input($key)]);
                } else {
                    // Create a new setting
                    Setting::create(['key' => $key, 'value' => $request->input($key)]);
                }
            }
        }

        //store logo
        $appLogoPath = 'img';
        if (!file_exists($appLogoPath)) {
            mkdir($appLogoPath, 0777, true);
        }

        if ($request->hasFile('app_logo')) {
            $photo = $request->file('app_logo');
            $photo_image_name = time() . mt_rand(1, 2000) . '.' . $photo->extension();
            $Folder = public_path($appLogoPath);
            $photo->move($Folder, $photo_image_name);

            $app_logo = Setting::where('key', 'app_logo')->first();
            if ($app_logo) {
                // Update the existing app_logo
                $app_logo->update(['value' => $photo_image_name]);
            } else {
                // Create a new setting
                Setting::create(['key' => 'app_logo', 'value' => $photo_image_name]);
            }
        }

        return redirect()->route('settings')->with('success','Settings has been updated');

    }
}
