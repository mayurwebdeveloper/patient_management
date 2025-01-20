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
            ])->orderBy('id', 'desc')->get();
        }else{

            if (Auth::user()->hasRole('Staff Nurse')) {
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
        $patients = Helper::getPatients();
        $data = compact('specialities','sectors','types','states','hospitals','doctors','patients');
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
        // echo "<pre>";
        // print_r($_POST);
        // exit;
        // Validate the incoming request data
        $validatedData = $request->validate([

            'patient_id' => 'required',
            'doctor_id' => 'required',
            'speciality_id' => 'required',
            'hospital_id' => 'required',
            'opd_number' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'age_month' => 'nullable|integer|min:0',
            'village' => 'nullable|string|max:255',
            'taluka' => 'nullable|string|max:255',
            'sex' => 'nullable|string|in:male,female,other',
            'mobile_number' => 'nullable|digits:10',
            'opd_date' => 'nullable|date',
            'ipd_date' => 'nullable|date',
            'lpd_no' => 'nullable|string|max:255',
            'provisional' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'temprature' => 'nullable|numeric|min:0',
            'pulse' => 'nullable|numeric|min:0',
            'bp' => 'nullable|string|max:255',
            'spo2' => 'nullable|numeric|min:0',
            'rr' => 'nullable|numeric|min:0',
            'RS' => 'nullable|string|max:255',
            'CVS' => 'nullable|string|max:255',
            'CNS' => 'nullable|string|max:255',
            'PA' => 'nullable|string|max:255',
            'LMP' => 'nullable|date',
            'G' => 'nullable|string|max:255',
            'P' => 'nullable|string|max:255',
            'L' => 'nullable|string|max:255',
            'A' => 'nullable|string|max:255',
            'age_of_last_child' => 'nullable|string|max:255',
            'type_of_last_delivery' => 'nullable|string|max:255',
            'personal_ho' => 'nullable|string',
            'past_ho' => 'nullable|string',
            'chief_complaint' => 'nullable|string',
            'past_history' => 'nullable|string',
            'family_history' => 'nullable|string',
            'vitals_general_examination' => 'nullable|string',
            'personal_history' => 'nullable|string',
            'allergic_history' => 'nullable|string',
            'obstetric_history' => 'nullable|string',
            'treatment' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        // Save data to the appointments table
        
        // echo $request->opd_number;
        // exit;

        $validatedData['appointment_date'] = $request->opd_date;

        $validatedData['opd_date'] =  CarbonDate::createFromFormat('Y-m-d', $request->opd_date)->format('Y-m-d');
        // $validatedData['opd_date'] = $request->opd_number;
        // Create a new appointment record
        $appointment = new Appointment();
        $appointment->fill($validatedData);
        $appointment->save();


        // Return a JSON response
        return redirect()->route('doctor.appointments')->with('success', 'Appointment created successfully.');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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

        return view('appointment.show')->with($data);
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
        $patients = Helper::getPatients();

        $data = compact('appointment', 'specialities', 'sectors', 'types', 'states', 'hospitals', 'doctors','patients');

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
            'patient_id ' => 'required',
            'hospital_id' => 'required|integer',
            'speciality_id' => 'required|integer',
            'opd_number' => 'nullable|string|max:255',
            'age' => 'nullable|string|max:10',
            'age_month' => 'nullable|string|max:10',
            'mobile_number' => 'nullable|string|max:15',
            'sex' => 'nullable|string|max:15',
            'village' => 'nullable|string|max:50',
            'taluka' => 'nullable|string|max:50',
            'opd_date' => 'required|date',
            'ipd_date' => 'nullable|date',
            'lpd_no' => 'nullable|string'
        ]);

        $validatedData['appointment_date'] = CarbonDate::createFromFormat('Y-m-d', $request->opd_date)->format('Y-m-d');

        // Find and update the appointment
        $appointment = Appointment::findOrFail($id);
        $appointment->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('doctor.appointments')->with('success', 'Appointment updated successfully.');
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
            'patient_id ' => 'required',
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
            'opd_date' => 'required|date',
            'ipd_date' => 'nullable|date',
            'lpd_no' => 'nullable'
        ]);
        // dd($validatedData);
    
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

    public function updateAdmitStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->is_ipd = $request->input('is_ipd');
        $appointment->save();

        return response()->json(['success' => true, 'message' => 'Admitted status updated successfully']);
    }

    public function savePatientInfo(Request $request)
    {
        
        $validated = $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'speciality_id' => 'required',
            'hospital_id' => 'required',
            'opd_number' => 'required',
            'age' => 'nullable|integer|min:0',
            'age_month' => 'nullable|integer|min:0',
            'village' => 'nullable|string|max:255',
            'taluka' => 'nullable|string|max:255',
            'sex' => 'nullable|string|in:male,female,other',
            'mobile_number' => 'nullable|digits:10',
            'opd_date' => 'required|date',
            'ipd_date' => 'nullable|date',
            'lpd_no' => 'nullable|string|max:255',
        ]);
        $validated['appointment_date'] = $request->opd_date;

        $validated['opd_date'] =  CarbonDate::createFromFormat('Y-m-d', $request->opd_date)->format('Y-m-d');
        $appointment = Appointment::create($validated);

        return response()->json([
            'success' => true,
            'appointment_id' => $appointment->id,
        ]);
    }

    public function saveGeneralExam(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'provisional' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'temprature' => 'nullable|numeric|min:0',
            'pulse' => 'nullable|numeric|min:0',
            'bp' => 'nullable|string|max:255',
            'spo2' => 'nullable|numeric|min:0',
            'rr' => 'nullable|numeric|min:0',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointment->update($validated);

        return response()->json(['success' => true]);
    }

    public function saveSystemicExam(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'rr' => 'nullable|numeric|min:0',
            'RS' => 'nullable|string|max:255',
            'CVS' => 'nullable|string|max:255',
            'CNS' => 'nullable|string|max:255',
            'PA' => 'nullable|string|max:255',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointment->update($validated);
        return response()->json(['success' => true]);
    }

    public function saveHistoryExam(Request $request)
    {
        
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'LMP' => 'nullable|date',
            'G' => 'nullable|string|max:255',
            'P' => 'nullable|string|max:255',
            'L' => 'nullable|string|max:255',
            'A' => 'nullable|string|max:255',
            'age_of_last_child' => 'nullable|string|max:255',
            'type_of_last_delivery' => 'nullable|string|max:255',
            'personal_ho' => 'nullable|string',
            'past_ho' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointment->update($validated);

        return response()->json(['success' => true]);
    }

    public function saveComplaintExam(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'chief_complaint' => 'nullable|string',
            'past_history' => 'nullable|string',
            'family_history' => 'nullable|string',
            'vitals_general_examination' => 'nullable|string',
            'personal_history' => 'nullable|string',
            'allergic_history' => 'nullable|string',
            'obstetric_history' => 'nullable|string',
            'treatment' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointment->update($validated);

        return response()->json(['success' => true]);
    }

    public function updatePatientInfo(Request $request, $id)
    {
        $validated = $request->validate([
            'opd_number' => 'required',
            'age' => 'nullable|integer|min:0',
            'age_month' => 'nullable|integer|min:0',
            'village' => 'nullable|string|max:255',
            'taluka' => 'nullable|string|max:255',
            'sex' => 'nullable|string|in:male,female,other',
            'mobile_number' => 'nullable|digits:10',
            'opd_date' => 'required|date',
            'ipd_date' => 'nullable|date',
            'lpd_no' => 'nullable|string|max:255',
            'status' => 'nullable'
        ]);
        $appointment = Appointment::findOrFail($id);
        if($request->opd_date != $appointment->opd_date){
            $validated['appointment_date'] = $request->opd_date;
            $validated['opd_date'] =  CarbonDate::createFromFormat('Y-m-d', $request->opd_date)->format('Y-m-d');
        }
        $appointment->update($validated);

        return response()->json([
            'success' => true,
            'appointment_id' => $appointment->id,
        ]);
    }

    public function updateGeneralExam(Request $request, $id)
    {
        $validated = $request->validate([
            'provisional' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'temprature' => 'nullable|numeric|min:0',
            'pulse' => 'nullable|numeric|min:0',
            'bp' => 'nullable|string|max:255',
            'spo2' => 'nullable|numeric|min:0',
            'rr' => 'nullable|numeric|min:0',
            'paller' => 'nullable',
            'clubbing' => 'nullable',
            'cyanosis' => 'nullable',
            'oedema' => 'nullable',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($validated);

        return response()->json(['success' => true]);
    }

    public function updateSystemicExam(Request $request, $id)
    {
        $validated = $request->validate([
            'rr' => 'nullable|numeric|min:0',
            'RS' => 'nullable|string|max:255',
            'CVS' => 'nullable|string|max:255',
            'CNS' => 'nullable|string|max:255',
            'PA' => 'nullable|string|max:255',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($validated);
        return response()->json(['success' => true]);
    }

    public function updateHistoryExam(Request $request, $id)
    {
        
        $validated = $request->validate([
            'LMP' => 'nullable|date',
            'G' => 'nullable|string|max:255',
            'P' => 'nullable|string|max:255',
            'L' => 'nullable|string|max:255',
            'A' => 'nullable|string|max:255',
            'age_of_last_child' => 'nullable|string|max:255',
            'type_of_last_delivery' => 'nullable|string|max:255',
            'personal_ho' => 'nullable|string',
            'past_ho' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($validated);

        return response()->json(['success' => true]);
    }

    public function updateComplaintExam(Request $request, $id)
    {
        $validated = $request->validate([
            'chief_complaint' => 'nullable|string',
            'past_history' => 'nullable|string',
            'family_history' => 'nullable|string',
            'vitals_general_examination' => 'nullable|string',
            'personal_history' => 'nullable|string',
            'allergic_history' => 'nullable|string',
            'obstetric_history' => 'nullable|string',
            'treatment' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($validated);

        return response()->json(['success' => true]);
    }

}
