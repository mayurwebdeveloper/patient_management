<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'hospital_id' => 'required|exists:hospitals,id',
            'speciality_id' => 'required|exists:specialities,id',
            'appointment_date' => 'required|date',
        ]);

        $appointment = Appointment::create($validatedData);

        return response()->json(['message' => 'Appointment created successfully', 'appointment' => $appointment], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($validatedData);

        return response()->json(['message' => 'Appointment updated successfully', 'appointment' => $appointment], 200);
    }
}