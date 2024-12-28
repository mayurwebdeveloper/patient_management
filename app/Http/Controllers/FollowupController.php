<?php
// app/Http/Controllers/FollowupController.php
namespace App\Http\Controllers;

use App\Models\Followup;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    public function create($appointmentId)
{
    // Fetch the appointment details if needed
    $appointment = Appointment::findOrFail($appointmentId);

    // Pass appointment details to the view
    return view('followup.create', compact('appointment'));
}


    public function store(Request $request)
    {
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
            'paller' => 'nullable|string',
            'clubbing' => 'nullable|string',
            'cyanosis' => 'nullable|string',
            'oedema' => 'nullable|string',
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
        return redirect()->route('followup-form')->with('success', 'Follow-up added successfully.');
    }
}
