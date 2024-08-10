<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HospitalController extends Controller
{

  public function isDistrict($city = 0)
  {
    return District::where('district_title', 'like', "%$city%")->count();
  }

  public function cityId($city = 0, $type = 0)
  {
    if ($type == 1) {
      $data = District::where('district_title', 'like', "%$city%")->first()->districtid ?? 0;
    }

    if ($type == 2) {
      $data = City::where('name', 'like', "%$city%")->first()->id ?? 0;
    }

    return $data;
  }


  public function index(Request $request)
  {
    $query = Hospital::where('status', 1);

    // Apply filters if they are provided in the request
    // if ($request->has('city')) {

    //   $isDistrict = $this->isDistrict($request->input('city'));

    //   if ($isDistrict) {
    //     $query->where('district_id', $this->cityId($request->input('city'), 1));
    //   } else {
    //     $query->where('subdivision_id', $this->cityId($request->input('city'), 2));
    //   }
    // }

    // Log::channel('hospital_error_log')->error("Request Data: " . json_encode($request->all()));

    // speciality filter
    if ($request->has('speciality')) {
      $speciality = $request->input('speciality');
      $query->where('specialities', 'like', "%$speciality%");
    }

    // place type filter
    if ($request->has('type')) {
      $query->where('type', $request->input('type'));
    }


    // sector filter (govenment/ private)
    if ($request->has('sector')) {
      $query->where('sector', $request->input('sector'));
    }


    // speciality type filter
    if ($request->has('speciality_type')) {
      $query->where('speciality_type', $request->input('speciality_type'));
    }
  
    // is pmjay supported or not filter
    if ($request->has('is_pmjay')) {
      $query->where('is_pmjay', $request->input('is_pmjay'));
    }

    // hospital name search filter 
    if ($request->has('search')) {
      $query->where('name', 'like', '%' . $request->input('search') . '%');
    }

    // Get the page parameter from the JSON payload
    $page = $request->input('page', 1);

    // Paginate the results with 10 records per page
    $hospitals = $query->paginate(10, ['*'], 'page', $page);

    if ($hospitals->isEmpty()) {
      return response()->json(['status' => 0, 'message' => 'Hospitals not found'], 404);
    }

    $availability = $request->input('availability');

    $data = $hospitals->map(function ($hospital) use ($availability) {
      $image = $hospital->image ? asset("images/hospital/photos/" . $hospital->image) : "";

      $workingHours = true;
      if($availability){
        $workingHours = $hospital->workingHours()->where('day', date('N', strtotime($availability)))
          ->whereTime('start_time', '<=', date('H:i:s', strtotime($availability)))
          ->whereTime('end_time', '>=', date('H:i:s', strtotime($availability)))
          ->exists();
      }

      return [
        'id' => $hospital->id,
        'name' => $hospital->name ?? "",
        'image' => $image,
        'address' => $hospital->address ?? "",
        'location' => $hospital->location ?? "",
        'speciality_type' => $hospital->speciality_type,
        'specialities' => explode(',', $hospital->specialities),
        'is_available' => $workingHours,
      ];
    });

    return response()->json([
      'status' => 1,
      'data' => $data,
      'pagination' => [
        'current_page' => $hospitals->currentPage(),
        'per_page' => $hospitals->perPage(),
        'total' => $hospitals->total(),
      ],
    ], 200);
  }


  public function show($id = null)
  {

    if ($id) {
      $hospital = Hospital::where('id', $id)->first();
    } else {
      return response()->json(['status' => 0, 'message' => 'Id is required'], 404);
    }

    if (!$hospital) {
      return response()->json(['status' => 0, 'message' => 'Hospital not found'], 404);
    }


    // other data
    $image = "";
    if ($hospital->image) {
      $image = asset("images/hospital/photos/" . $hospital->image);
    }

    $brochure = "";
    if ($hospital->brochure) {
      $brochure = asset("images/hospital/brochures/" . $hospital->brochure);
    }


    $data = [
      "id" => $hospital->id,
      "type" => $hospital->type ?? "",
      "sector" => $hospital->sector ?? "",
      "speciality_type" => $hospital->speciality_type ?? 1,
      "specialities" => explode(',', $hospital->specialities),
      "name" => $hospital->name ?? "",
      "description" => $hospital->description ?? "",
      "mo" => $hospital->mo ?? "",
      "email" => $hospital->email ?? "",
      "address" => $hospital->address ?? "",
      "location" => $hospital->location ?? "",
      "is_pmjay" => $hospital->is_pmjay,
      "pmjay_description" => $hospital->pmjay_description ?? "",
      "image" => $image,
      "brochure" => $brochure,
    ];


    return response()->json([
      'status' => 1,
      'data' => $data,
    ], 200);
  }


}
