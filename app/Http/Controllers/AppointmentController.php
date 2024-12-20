<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\City;
use App\Models\District;
use App\Models\Hospital;
use App\Models\HospitalWorkingHour;
use App\Models\State;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;





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
            ])->get();
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
            ])->where('doctor_id', $doctorId)->get();
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
        $specialities = Helper::getSpecialities();
        $states = State::all(); 
        $data = compact('specialities','sectors','types','states');
        return view('appointment.create')->with($data);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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

}
