<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkPlace;
use Illuminate\Http\Request;

class WorkPlaceController extends Controller
{
    public function index()
    {
        // Fetch all work_place_type
        $work_place_type = WorkPlace::pluck('title')->filter()->all();
    
        // Check if work_place_type exist
        if (empty($work_place_type)) {
            return response()->json(['status' => 0, 'message' => 'No work place type found'], 404);
        }
    
        // Return success response with work_place_type data
        return response()->json([
            'status' => 1,
            'data' => $work_place_type,
        ], 200);
    }
}
