<?php
// app/Http/Controllers/FollowupController.php
namespace App\Http\Controllers;
use App\Helpers\Helper;
use App\Models\City;
use App\Models\District;
use App\Models\Hospital;
use App\Models\HospitalWorkingHour;
use App\Models\Speciality;
use App\Models\User;
use App\Models\State;
use App\Models\Followup;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FollowupController extends Controller
{
    public function index(Request $request)
    {
        
        // Get the logged-in doctor's ID
        $appointmentId = $request->appointment;
        if (Auth::user()->hasRole('admin')) {
            // Perform admin-specific logic
            $followup = Followup::where('appointment_id',$appointmentId)->with([
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
            $followup = Followup::where('appointment',$appointmentId)->with([
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
        return view('followup.index', compact('followup','appointmentId'));
    }
    public function create($appointmentId)
    {
        // Fetch the appointment details if needed
        $appointment = Appointment::findOrFail($appointmentId);
        // dd($appointment);
        // Pass appointment details to the view
        $sectors = Helper::getSectors();
        $types = Helper::getTypes();
        $specialities = Helper::getSpecialitiesIds();
        $states = State::all();
        $hospitals = Helper::getHospital(); 
        $doctors = Helper::getDoctor(); 
        return view('followup.create', compact('appointment','sectors','types','specialities','states','hospitals','doctors'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the incoming request data
        $validatedData = $request->validate([
            'appointment_id' => 'required|integer',
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'hospital_id' => 'required|integer',
            'speciality_id' => 'required|integer',
            'appointment_date' => 'required|date',
            'date' => 'required|date',
            'time_slot' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'scheduled' => 'nullable|string',
            'patient_name' => 'required|string',
            'opd_number' => 'required|string',
            'age' => 'nullable|integer',
            'age_month' => 'nullable|integer',
            'mobile_number' => 'nullable|string',
            'sex' => 'nullable|string',
            'village' => 'nullable|string',
            'taluka' => 'nullable|string',
            'opd_date' => 'nullable|date',
            'provisional' => 'nullable|string',
            'weight' => 'nullable|string',
            'height' => 'nullable|string',
            'temperature' => 'nullable|string',
            'pulse' => 'nullable|string',
            'bp' => 'nullable|string',
            'spo2' => 'nullable|string',
            'rr' => 'nullable|string',
            'RS' => 'nullable|string',
            'CVS' => 'nullable|string',
            'CNS' => 'nullable|string',
            'PA' => 'nullable|string',
            'LMP' => 'nullable|date',
            'G' => 'nullable|string',
            'P' => 'nullable|string',
            'L' => 'nullable|string',
            'A' => 'nullable|string',
            'age_of_last_child' => 'nullable|string',
            'type_of_last_delivery' => 'nullable|string',
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

        // Create a new follow-up using the validated data
        Followup::create($validatedData);

        // Redirect with a success message
        return redirect()->route('appointment.followup',$request->appointment_id)->with('success', 'Follow-up added successfully.');
    }
}
