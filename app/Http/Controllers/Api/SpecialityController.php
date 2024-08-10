<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    public function index()
    {
        // Fetch all specialities
        $specialities = Speciality::pluck('title')->filter()->all();
    
        // Check if specialities exist
        if (empty($specialities)) {
            return response()->json(['status' => 0, 'message' => 'No specialities found'], 404);
        }
    
        // Return success response with specialities data
        return response()->json([
            'status' => 1,
            'data' => $specialities,
        ], 200);
    }
    
}
