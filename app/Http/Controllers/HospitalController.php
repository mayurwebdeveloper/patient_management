<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\City;
use App\Models\District;
use App\Models\Hospital;
use App\Models\HospitalWorkingHour;
use App\Models\State;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Hospital::select('*')->orderBy('id', 'desc')->get();
            // $data = Hospital::select('hospitals.*', 'district.district_title') 
            // ->leftJoin('district', 'hospitals.district_id', '=', 'district.districtid')
            // ->orderBy('hospitals.id', 'desc')
            // ->get();
            
            return Datatables::of($data)
                ->addColumn('checkbox', '<input type="checkbox" name="hospital_id[]" value="{{$id}}" />')
                ->addColumn('view', '<a href="{{route("view-hospital",["id"=>$id])}}" class="btn btn-primary btn-circle"><i class="fas fa-eye"></i></a>')
                ->addColumn('time', '<a href="{{route("edit-hospital-time-form",["id"=>$id])}}" class="btn btn-success btn-circle"><i class="fas fa-clock"></i></a>')
                ->addColumn('edit', '<a href="{{route("edit-hospital-form",["id"=>$id])}}" class="btn btn-info btn-circle"><i class="fas fa-edit"></i></a>')
                ->addColumn('delete', '<a href="{{route("hospital-delete",["id"=>$id])}}" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i></a>')
                ->rawColumns(['checkbox', 'view', 'time', 'edit', 'delete'])
                ->make(true);
        }
        return view('hospital.list');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sectors = Helper::getSectors();
        $types = Helper::getTypes();
        $specialities = Helper::getSpecialities();
        $states = State::all(); 
        $data = compact('specialities','sectors','types','states');
        return view('hospital.create')->with($data);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $request->validate([

            'specialities' => 'required|array|min:1',
            'specialities.*' => 'string',

            'name' => 'required|max:50',
            'type' => 'required|max:30',
            'sector' => 'required|max:30',
            'state' => 'required',
            'district' => 'required',
            'city' => 'required',
            'location' => 'required',
            'mo' => 'required',
            // 'status' => 'required',
            // 'email' => 'required',
            // 'description' => 'required',
            // 'address' => 'required',
            // 'is_pmjay' => 'required',
            // 'pmjay_description' => 'required',
        ]);

        
        
        DB::beginTransaction();

        try {

            $hospital=new Hospital();
        $hospital->type = $request['type'];
        $hospital->sector = $request['sector'];
        $hospital->specialities = implode(',', $request['specialities']);
        $hospital->name = $request['name'];
        $hospital->description = $request['description'] ?? "";
        $hospital->mo = $request['mo'];
        $hospital->email = $request['email'] ?? "";
        $hospital->address = $request['address'] ?? "";
        $hospital->location = $request['location'];
        $hospital->state_id = $request['state'];
        $hospital->district_id = $request['district'];
        $hospital->subdivision_id = $request['city'];
        $hospital->is_pmjay = $request['is_pmjay'] ?? 0;
        $hospital->speciality_type = $request['speciality_type'] ?? 1;
        $hospital->pmjay_description = $request['pmjay_description'] ?? "";
        $hospital->status = $request['status'];


        if ($request->hasFile('image')) {

            // store hospital image
            $hospitalImagePath = 'images/hospital/photos';
            if (!file_exists($hospitalImagePath)) {
                mkdir($hospitalImagePath, 0777, true);
            }

            $image = $request->file('image');
            $image_name = time() . mt_rand(1, 2000) . '.' . $image->extension();
            $Folder = public_path($hospitalImagePath);
            $image->move($Folder, $image_name);
            $hospital->image = $image_name;
        }

        if ($request->hasFile('brochure')) {

            // store hospital brochure
            $hospitalBrochurePath = 'images/hospital/brochures';
            if (!file_exists($hospitalBrochurePath)) {
                mkdir($hospitalBrochurePath, 0777, true);
            }

            $brochure = $request->file('brochure');
            $brochure_name = time() . mt_rand(1, 2000) . '.' . $brochure->extension();
            $Folder = public_path($hospitalBrochurePath);
            $brochure->move($Folder, $brochure_name);
            $hospital->brochure = $brochure_name;
        }


            if($hospital->save())
            {
                DB::commit();
                return redirect()->route('hospitals')->with('success','Record has been added');
            } else {
                throw new \Exception('Failed to save hospital record');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('hospital_error_log')->error("Add Hospital Form - : " . $e->getMessage());
            // dd($e->getMessage());
            return redirect()->route('hospitals')->with('error','something went wrong!!!');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hospital=Hospital::findOrFail($id);
        $sectors = Helper::getSectors();
        $types = Helper::getTypes();
        $specialities = Helper::getSpecialities();
        $states = State::all(); 
        $data = compact('specialities', 'sectors', 'types','states','hospital');   
        return view('hospital.show')->with($data);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hospital=Hospital::findOrFail($id);
        $sectors = Helper::getSectors();
        $types = Helper::getTypes();
        $specialities = Helper::getSpecialities();
        $states = State::all(); 
        $data = compact('specialities', 'sectors','types','states','hospital');        
        return view('hospital.edit')->with($data);
    }



        /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
            'hospital_id' => 'required',

            'specialities' => 'required|array|min:1',
            'specialities.*' => 'string',

            'name' => 'required|max:50',
            'type' => 'required|max:30',
            'sector' => 'required|max:30',
            'state' => 'required',
            'district' => 'required',
            'city' => 'required',
            'location' => 'required',


            'mo' => 'required',
            // 'status' => 'required',
            // 'email' => 'required',
            // 'description' => 'required',
            // 'address' => 'required',
            // 'is_pmjay' => 'required',
            // 'pmjay_description' => 'required',
        ]);
        
        DB::beginTransaction();

        try {

        $hospital=Hospital::findOrFail($request->hospital_id);
        $hospital->type = $request['type'];
        $hospital->sector = $request['sector'];
        $hospital->specialities = implode(',', $request['specialities']);
        $hospital->name = $request['name'];
        $hospital->description = $request['description'] ?? "";
        $hospital->mo = $request['mo'];
        $hospital->email = $request['email'] ?? "";
        $hospital->address = $request['address'] ?? "";
        $hospital->location = $request['location'];
        $hospital->state_id = $request['state'];
        $hospital->district_id = $request['district'];
        $hospital->subdivision_id = $request['city'];
        $hospital->is_pmjay = $request['is_pmjay'] ?? 0;
        $hospital->speciality_type = $request['speciality_type'] ?? 1;
        $hospital->pmjay_description = $request['pmjay_description'] ?? "";
        $hospital->status = $request['status'];


        if ($request->hasFile('image')) {

            // store hospital image
            $hospitalImagePath = 'images/hospital/photos';
            if (!file_exists($hospitalImagePath)) {
                mkdir($hospitalImagePath, 0777, true);
            }

            $image = $request->file('image');
            $image_name = time() . mt_rand(1, 2000) . '.' . $image->extension();
            $Folder = public_path($hospitalImagePath);
            $image->move($Folder, $image_name);
            $hospital->image = $image_name;
        }

        if ($request->hasFile('brochure')) {

            // store hospital brochure
            $hospitalBrochurePath = 'images/hospital/brochures';
            if (!file_exists($hospitalBrochurePath)) {
                mkdir($hospitalBrochurePath, 0777, true);
            }

            $brochure = $request->file('brochure');
            $brochure_name = time() . mt_rand(1, 2000) . '.' . $brochure->extension();
            $Folder = public_path($hospitalBrochurePath);
            $brochure->move($Folder, $brochure_name);
            $hospital->brochure = $brochure_name;
        }


            if ($hospital->save()) {
                DB::commit();
                return redirect()->route('hospitals')->with('success','Record has been updated');
            } else {
                throw new \Exception('Failed to save hospital record');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('hospitals')->with('error','something went wrong!!!');
        }

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hospital $id)
    {
        $id->workingHours()->delete();
        $id->delete();
        return redirect()->back(); 
    }




    public function deleteSelected(Request $request)
    {
        $selectedIds = $request->selectedIds;

        // Find the posts by their IDs
        $hospitals = Hospital::whereIn('id', $selectedIds)->get();

        foreach ($hospitals as $hospital) {
            $hospital->workingHours()->delete();
        }

        // Delete Hospitals
        Hospital::whereIn('id', $selectedIds)->delete();

        return response()->json(['message' => 'Selected records deleted successfully']);
    }


    public function getDistrict($state)
    {
        // Fetch District for the given state
        $districts = District::where('state_id', $state)->where('district_status', 'Active')->get();
        return response()->json($districts);
    }

    public function getSubdivision($district)
    {
        // Fetch City for the given state
        $cities = City::where('districtid', $district)->where('status', 'Active')->get();
        return response()->json($cities);
    }





    /**
     * Show the form for editing the specified resource.
     */
    public function timeEdit(string $id)
    {
        $dayNames = [
           '1' =>'Monday',
           '2' =>'Tuesday',
           '3' =>'Wednesday',
           '4' =>'Thursday',
           '5' =>'Friday',
           '6' =>'Sunday',
           '7' =>'Saturday'
        ];
        $hospital=Hospital::findOrFail($id);
        $workingDaysResult = HospitalWorkingHour::where('hospital_id', $id)->get();
        
        $workingDays = [];

        foreach($workingDaysResult as $result){
            $workingDays[$result->day] = [
                'start_time' => $result->start_time,
                'end_time' => $result->end_time,
            ];
        }

        $data = compact('hospital', 'dayNames', 'workingDays');        
        return view('hospital.time-edit')->with($data);
    }



        /**
     * Update the specified resource in storage.
     */
    public function TimeUpdate(Request $request)
    {
        $request->validate([
            'hospital_id' => 'required',
        ]);

        $results = HospitalWorkingHour::where('hospital_id', $request->hospital_id)->get();

        if($results->isNotEmpty()){
            foreach ($results as $result) {
                $result->delete();
            }
        }
        
        if($request->days){
            foreach ($request->days as $day) {
                if($request['start_time_'.$day] && $request['end_time_'.$day])
                {
                    $hours = new HospitalWorkingHour();
                    $hours->hospital_id = $request['hospital_id'];
                    $hours->day = $day;
                    $hours->start_time = $request['start_time_'.$day];
                    $hours->end_time = $request['end_time_'.$day];
                    $hours->save();
                }
            }
        }

        return redirect()->route('hospitals')->with('success','Record has been updated');
    }

}
