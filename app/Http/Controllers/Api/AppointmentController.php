<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Hospital;
use App\Models\Speciality;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\Prescription;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {

        $user = $request->user();

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            // 'hospital_id' => 'required|integer',
            // // 'department_id' => 'required|integer',
            // 'doctor_id' => 'required|integer',
            // 'date' => 'required|date',
            // 'time_slot' => 'required|string',
            // // 'title' => 'required|string|max:255',
            // // 'description' => 'nullable|string',
            // // 'token' => 'required|string',

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
            'opd_date' => 'nullable|date'


        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        // $appointment->user_id = $user->id; // Add the authenticated user's ID

        // // Store the appointment data
        // $appointment = new Appointment();
        // $appointment->patient_id = $user->id;
        // $appointment->hospital_id = $request->hospital_id;
        // $appointment->speciality_id = $request->department_id; // Assuming department_id maps to speciality_id
        // $appointment->doctor_id = $request->doctor_id;
        // $appointment->date = $request->date;
        // $appointment->time_slot = $request->time_slot;
        // $appointment->title = $request->title;
        // $appointment->description = $request->description;
        // $appointment->status = 'scheduled'; // or any default status you prefer
        // $appointment->save();

        $validatedData['appointment_date'] = CarbonDate::createFromFormat('Y-m-d', $request->opd_date)->format('Y-m-d');

        $validatedData['opd_date'] =  CarbonDate::createFromFormat('Y-m-d', $request->opd_date)->format('Y-m-d');
        // $validatedData['opd_date'] = $request->opd_number;
        // Create a new appointment record
        $appointment = Appointment::create($validatedData);

        return response()->json([
            'status' => true,
            'data' => $appointment,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled|scheduled',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($validatedData);

        return response()->json(['message' => 'Appointment updated successfully', 'appointment' => $appointment], 200);
    }

    public function list(Request $request){
        $user = $request->user();

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
        ])
        ->where('patient_id', $user->id)
        // ->orWhere('doctor_id', $user->id)
        ->get(['id', 'patient_id', 'doctor_id', 'hospital_id', 'date', 'time_slot', 'title', 'description', 'status']);
        
        // Accessing patient name, doctor name, and hospital name

        
        foreach ($appointments as &$appointment) {
            $appointment->patientName = $appointment->patient->name ?? 'N/A';
            $appointment->doctorName = $appointment->doctor->name ?? 'N/A';
            $appointment->hospitalName = $appointment->hospital->name ?? 'N/A';
            // You can now use these variables as needed
        }


        return response()->json([
            'status' => true,
            'data' => $appointments,
        ], 201);

    }


    public function hospitallist(){
        $hospitals = Hospital::where('status', 1)->get(['id','name']);
        return response()->json([
            'status' => true,
            'data' => $hospitals,
        ], 201);
    }

    public function speciality(){
        $specialities = Speciality::get(['id','title']);
    
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

    public function doctorslist(){
        $role = Role::findById(2); // or findByName('role_name')
        $doctors = User::role($role->name)->get();
        
        // Check if specialities exist
        if (empty($doctors)) {
            return response()->json(['status' => 0, 'message' => 'No doctor found'], 404);
        }
    
        // Return success response with specialities data
        return response()->json([
            'status' => 1,
            'data' => $doctors,
        ], 200);
        
    }

    public function appointmentWisePrescriptions(Request $request)
    {
        // $user = Auth::user();

        $user = $request->user();
        
        // If the user is a doctor, retrieve prescriptions where the user is the doctor
        if ($user->hasRole('Doctor')) {
            $prescriptions = Prescription::whereHas('appointment', function ($query) use ($user) {
                $query->where('doctor_id', $user->id);
            })->with(['medicines', 'patient', 'doctor', 'appointment'])->get();
        }

        // If the user is a patient, retrieve prescriptions where the user is the patient
        elseif ($user->hasRole('Patient')) {
            $prescriptions = Prescription::whereHas('appointment', function ($query) use ($user) {
                $query->where('patient_id', $user->id);
            })->with(['medicines', 'doctor', 'appointment'])->get();
        }

        // If the user has no related role or is not associated with an appointment
        else {
            return response()->json([
                'status'=>0,
                'message' => 'Unauthorized or no prescriptions found for this user.',
            ], 403);
        }

         // Include the URL of the PDF file in the response
        $prescriptions->transform(function($prescription) {
            $prescription->pdf_url = $prescription->pdf_path ? url('public/prescriptions/'.$prescription->pdf_path) : null;
            return $prescription;
        });
        

        return response()->json([
            'status'=>1,
            'message'=>'Prescriptions list!',
            'prescription_list' => $prescriptions,
        ], 200);
    }

    
}