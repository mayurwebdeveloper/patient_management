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
                'appointment' => function ($query) {
                    $query->select('id', 'patient_id', 'doctor_id', 'hospital_id','speciality_id')
                        ->with([
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
                        ]);
                }
            ])->orderBy('opd_date', 'asc')->get();
        }else{
            $doctorId = Auth::user()->id;
            $followup = Followup::where('appointment',$appointmentId)->with([
                'appointment' => function ($query) {
                    $query->select('id', 'patient_id', 'doctor_id', 'hospital_id','speciality_id')
                        ->with([
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
                        ]);
                }
            ])->where('doctor_id', $doctorId)->orderBy('opd_date', 'asc')->get();
        }

        return view('followup.index', compact('followup','appointmentId'));
    }
    public function create($appointmentId)
    {
        // Fetch the appointment details if needed
        $appointment = Appointment::with([
            'patient' => function ($query) {
                $query->select('id', 'name');
            },
            'doctor' => function ($query) {
                $query->select('id', 'name');
            },
            'hospital' => function ($query) {
                $query->select('id', 'name');
            },
            'speciality' =>function ($query){
                $query->select('id', 'title');
            }
        ])->findOrFail($appointmentId);
        
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
            
            'opd_number' => 'required|string',
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
        
        $appointment = Followup::with([
            'appointment' => function ($query) {
                $query->select('id', 'patient_id', 'doctor_id', 'hospital_id','speciality_id')
                    ->with([
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
                    ]);
            }
        ])->findOrFail($id);

        $doctors = Helper::getDoctor(); // Fetch all doctors
        $hospitals = Helper::getHospital(); // Fetch all hospitals
        // echo "<pre>";
        // print_r($specialities);
        // echo "</pre>";
    

        $data = compact('appointment', 'specialities', 'sectors', 'types', 'states', 'hospitals', 'doctors');

        return view('followup.edit')->with($data);
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
        $validatedData = $request->validate([
            'opd_number' => 'required|string',
            'opd_date' => 'nullable|date',
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
        $appointment = Followup::findOrFail($id);
        $appointment->update($validatedData);
    
    
        // Redirect back with a success message
        return redirect()->route('appointment.followup',$appointment->appointment_id)->with('success', 'Followup updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $followup = Followup::findOrFail($id);
        $followup->delete();
        return redirect()->back()->with('success', 'Followup deleted successfully.'); 
    }
}
