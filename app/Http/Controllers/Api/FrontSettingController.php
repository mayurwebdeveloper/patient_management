<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FrontSetting;
use Illuminate\Http\Request;

class FrontSettingController extends Controller
{
    public function index()
    {
        $count = FrontSetting::latest()->first();

        // Check if count exist
        if (!$count) {
            return response()->json(['status' => 0, 'message' => 'No count found'], 404);
        }
    
        $data = [
          "locations" => $count->locations ?? 0,
          "doctors" => $count->doctors ?? 0,
          "beneficiary" => $count->beneficiary ?? 0,
        ];

        // Return success response with resources data
        return response()->json([
            'status' => 1,
            'data' => $data,
        ], 200);
    }
}
