<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PmJay;
use Illuminate\Http\Request;

class PmJayController extends Controller
{


    public function index()
    {
        $resources = PmJay::all();
        
        // Check if resources exist
        if ($resources->isEmpty()) {
            return response()->json(['status' => 0, 'message' => 'No Resource found'], 404);
        }

        $data = [];

        foreach ($resources as $resource) {

            $document = "";
            if ($resource->document) {
              $document = asset("images/pmjay/documents/" . $resource->document);
            }

            $data[] = [
                "id" => $resource->id,
                "title" => $resource->title ?? "",
                "description" => $resource->description ?? "",
                "document_title" => $resource->document_title ?? "",
                "document" => $document ?? ""
              ];
        }

        // Return success response with resources data
        return response()->json([
            'status' => 1,
            'data' => $data,
        ], 200);
    }



    public function show($id = null)
    {

        if($id){
            $resource = PmJay::find($id);
    
            // Check if resource with the given ID exists
            if (!$resource) {
                return response()->json(['status' => 0, 'message' => 'Resource not found'], 404);
            }
        }else{
            $resource = PmJay::latest()->first();
    
            // Check if resources exist
            if (!$resource) {
                return response()->json(['status' => 0, 'message' => 'No resources found'], 404);
            }
        }


        $document = "";
        if ($resource->document) {
          $document = asset("images/pmjay/documents/" . $resource->document);
        }
    
    
        $data = [
          "id" => $resource->id,
          "title" => $resource->title ?? "",
          "description" => $resource->description ?? "",
          "document_title" => $resource->document_title ?? "",
          "document" => $document ?? ""
        ];
    

        // Return success response with resources data
        return response()->json([
            'status' => 1,
            'data' => $data,
        ], 200);
    }

}
