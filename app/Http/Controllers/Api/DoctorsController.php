<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use DataTables;
use Spatie\Permission\Models\Role;
use App\Models\Speciality;

class DoctorsController extends Controller
{

 


  public function index(Request $request)
  {
    $roleId = 2;
    $role = Role::findOrFail($roleId);

    $query = User::role($role->name)->orderBy('id', 'desc');

    // $query = Hospital::where('status', 1);

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
  

    // Get the page parameter from the JSON payload
    $page = $request->input('page', 1);

    // Paginate the results with 10 records per page
    $doctors = $query->paginate(10, ['*'], 'page', $page);

    if ($doctors->isEmpty()) {
      return response()->json(['status' => 0, 'message' => 'Doctors not found'], 404);
    }

    // $availability = $request->input('availability');

    // $data = $hospitals->map(function ($hospital) use ($availability) {

    //   $image = $hospital->image ? asset("images/hospital/photos/" . $hospital->image) : "";

      

    //   return [
    //     'id' => $hospital->id,
    //     'name' => $hospital->name ?? "",
    //     'image' => $image,
    //     'address' => $hospital->address ?? "",
    //     'location' => $hospital->location ?? "",
    //     'speciality_type' => $hospital->speciality_type,
    //     'specialities' => explode(',', $hospital->specialities),
    //     'is_available' => $workingHours,
    //   ];
    
    // });

    

    return response()->json([
      'status' => 1,
      'data' => $doctors,
      'pagination' => [
        'current_page' => $doctors->currentPage(),
        'per_page' => $doctors->perPage(),
        'total' => $doctors->total(),
      ],
    ], 200);
  }



}
