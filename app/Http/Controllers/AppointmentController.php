<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\City;
use App\Models\District;
use App\Models\Hospital;
use App\Models\HospitalWorkingHour;
use App\Models\Speciality;
use App\Models\User;
use App\Models\State;
use App\Models\Report;
use App\Models\AppointmentReport;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use Carbon\Carbon as CarbonDate;




class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        // Get the logged-in doctor's ID
        
        if (Auth::user()->hasRole('admin')) {
            // Perform admin-specific logic
            $appointments = Appointment::with([
                'patient' => function ($query) {
                    $query->select('id', 'name');
                },
                'doctor' => function ($query) {
                    $query->select('id', 'name');
                },
                'hospital' => function ($query) {
                    $query->select('id', 'name');
                }
            ])->orderBy('opd_date', 'asc')->get();
        }else{
            $doctorId = Auth::user()->id;
            $appointments = Appointment::with([
                'patient' => function ($query) {
                    $query->select('id', 'name');
                },
                'doctor' => function ($query) {
                    $query->select('id', 'name');
                },
                'hospital' => function ($query) {
                    $query->select('id', 'name');
                },
                'speciality' => function ($query) {
                    $query->select('id', 'title');
                }
            ])->where('doctor_id', $doctorId)->orderBy('opd_date', 'asc')->get();
        }

       
        // Fetch appointments for the logged-in doctor
     

        // Return the view with the appointments data
        return view('appointment.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sectors = Helper::getSectors();
        $types = Helper::getTypes();
        $specialities = Helper::getSpecialitiesIds();
        $states = State::all();
        $hospitals = Helper::getHospital(); 
        $doctors = Helper::getDoctor(); 
        
        $data = compact('specialities','sectors','types','states','hospitals','doctors');
        return view('appointment.create')->with($data);
        //
    }

    /**
     * Store a new appointment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'doctor_id' => 'required|integer',
            'hospital_id' => 'required|integer',
            'speciality_id' => 'required|integer',
            'opd_number' => 'nullable|string|max:255',
            'patient_name' => 'nullable|string|max:255',
            'age' => 'nullable|string|max:10',
            'age_month' => 'nullable|string|max:10',
            'mobile_number' => 'nullable|string|max:15',
            'sex' => 'nullable|string|max:15',
            'village' => 'nullable|string|max:50',
            'taluka' => 'nullable|string|max:50',
            'opd_date' => 'nullable|date',
        ]);

        // echo $request->opd_number;
        // exit;

        $validatedData['appointment_date'] = CarbonDate::createFromFormat('Y-m-d', $request->opd_date)->format('Y-m-d');

        $validatedData['opd_date'] =  CarbonDate::createFromFormat('Y-m-d', $request->opd_date)->format('Y-m-d');
        // $validatedData['opd_date'] = $request->opd_number;
        // Create a new appointment record
        $appointment = Appointment::create($validatedData);

        // Return a JSON response
        return redirect()->back();


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing an appointment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $appointment = Appointment::findOrFail($id);

        // Fetch related data for dropdowns and fields
        $sectors = Helper::getSectors();
        $types = Helper::getTypes();
        $specialities = Helper::getSpecialitiesIds();
        $states = State::all();
        $hospitals = Helper::getHospital();
        $doctors = Helper::getDoctor();
        
        $appointment = Appointment::with(['doctor', 'hospital'])->findOrFail($id);

        $doctors = Helper::getDoctor(); // Fetch all doctors
        $hospitals = Helper::getHospital(); // Fetch all hospitals
        // echo "<pre>";
        // print_r($specialities);
        // echo "</pre>";
    

        $data = compact('appointment', 'specialities', 'sectors', 'types', 'states', 'hospitals', 'doctors');

        return view('appointment.edit')->with($data);
    }

    /**
     * Update the specified appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'doctor_id' => 'required|integer',
            'hospital_id' => 'required|integer',
            'speciality_id' => 'required|integer',
            'opd_number' => 'nullable|string|max:255',
            'patient_name' => 'nullable|string|max:255',
            'age' => 'nullable|string|max:10',
            'age_month' => 'nullable|string|max:10',
            'mobile_number' => 'nullable|string|max:15',
            'sex' => 'nullable|string|max:15',
            'village' => 'nullable|string|max:50',
            'taluka' => 'nullable|string|max:50',
            'opd_date' => 'nullable|date',
        ]);

        $validatedData['appointment_date'] = CarbonDate::createFromFormat('Y-m-d', $request->opd_date)->format('Y-m-d');

        // Find and update the appointment
        $appointment = Appointment::findOrFail($id);
        $appointment->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    /**
     * Update the specified appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moupdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'provisional' => 'nullable',
            'weight' => 'nullable',
            'height' => 'nullable',
            'temperature' => 'nullable',
            'bp' => 'nullable',
            'pulse' => 'nullable',
            'spo2' => 'nullable',
            'rr' => 'nullable',
            'paller' => 'nullable',
            'clubbing' => 'nullable',
            'cyanosis' => 'nullable',
            'oedema' => 'nullable',
            'RS' => 'nullable',
            'CVS' => 'nullable',
            'CNS' => 'nullable',
            'PA' => 'nullable',
            'LMP' => 'nullable|date',
            'G' => 'nullable',
            'P' => 'nullable',
            'L' => 'nullable',
            'A' => 'nullable',
            'age_of_last_child' => 'nullable',
            'type_of_last_delivery' => 'nullable',
            'personal_ho' => 'nullable',
            'past_ho' => 'nullable',
            'chief_complaint' => 'nullable',
            'past_history' => 'nullable',
            'family_history' => 'nullable',
            'vitals_general_examination' => 'nullable',
            'personal_history' => 'nullable',
            'allergic_history' => 'nullable',
            'obstetric_history' => 'nullable',
            'treatment' => 'nullable',
            'remarks' => 'nullable',
        ]);
    
        // Find and update the appointment
        $appointment = Appointment::findOrFail($id);
        $appointment->update($validatedData);
    
    
        // Redirect back with a success message
        return redirect()->route('doctor.appointments')->with('success', 'Appointment updated successfully.');
    }


    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if ($appointment) {
            $appointment->status = $request->input('status');
            $appointment->save();

            return redirect()->back()->with('success', 'Appointment status updated successfully.');
        }

        return redirect()->back()->with('error', 'Appointment not found.');
    }

    public function getReports($appointmentId)
    {
        $reports = Report::all();
        $selectedReports = AppointmentReport::where('appointment_id', $appointmentId)
                            ->pluck('report_id')
                            ->toArray();
        return response()->json([
            'reports' => $reports,
            'selected' => $selectedReports,
        ]);
    }

    public function saveReports(Request $request)
    {

        $appointmentId = $request->appointment_id;
        $reportIds = $request->input('report_ids', []);
        $date = date('Y-m-d');

        AppointmentReport::where('appointment_id', $appointmentId)->delete();

        foreach ($reportIds as $reportId) {
            AppointmentReport::create([
                'appointment_id' => $appointmentId,
                'report_id' => $reportId,
                'date' => $date,
                'status' => 'pending',
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Investigations updated successfully.']);
    }

}
