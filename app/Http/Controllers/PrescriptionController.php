<?php
namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use PDF; // Use the PDF facade
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function index()
    {
        // Show all prescriptions (for a doctor, you can filter by doctor_id
        if (Auth::user()->hasRole('Pharmacist')) {
            $pharmacist_id = Auth::user()->id;
            $prescriptions = Prescription::with('medicines', 'doctor', 'patient')->where(['pharmacist_id'=>$pharmacist_id])->get();

        }else{
            $prescriptions = Prescription::with('medicines', 'doctor', 'patient')->get();
        }
        return view('prescriptions.index', compact('prescriptions'));
    }

    public function returnmo()
    {
        // Show all prescriptions (for a doctor, you can filter by doctor_id
        if (Auth::user()->hasRole('Doctor')) {
            $doctor_id = Auth::user()->id;
            $prescriptions = Prescription::with('medicines', 'doctor', 'patient')->where(['doctor_id'=>$doctor_id,'status'=>'returned'])->get();
        }else{
            $prescriptions = Prescription::with('medicines', 'doctor', 'patient')->get();
        }
        return view('prescriptions.index', compact('prescriptions'));
    }

    public function updatestatus(Request $request){
        $prescription = Prescription::findOrFail($request->prescription_id);
        $status = isset($request->status) ? $request->status : 'transferred';
        if(isset($request->status)){
            $arr['status'] = $status;
        }
        $prescription->update($arr);

        return response()->json($prescription, 200); 
    
    }

    

    public function create(Request $request)
    {
         // Fetch the doctors where the role_id is 2
         $doctors = User::role('Doctor')->get(); // Use the role name, not 'role_id'

         $appointment_id = $request->appointment;

         // Fetch the patients (assuming all users are patients except doctors, or you have another way to determine patients)
         $patients = User::role('Patients')->get(); // Use role name for patients
 
         // Fetch appointments (you may filter it based on criteria)
         $appointments = Appointment::all();

        if($appointment_id != ""){
          $appointment = Appointment::where(['id'=>$appointment_id])->get();
        }else{
            $appointment = [];
        }

        $pharmacist = User::role('Pharmacist')->get(); // Use role name for patients
         
 
         return view('prescriptions.create', compact('doctors', 'patients', 'appointments','appointment_id','appointment','pharmacist'));
        // Show the form to create a new prescription
        // return view('prescriptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:users,id',
            // 'pharmacist_id'=> 'required',
            'medicines.*.name' => 'required|string',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.frequency' => 'required|string',
        ]);

        
    
        // Create the prescription
        $prescription = Prescription::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'pharmacist_id' => $request->pharmacist_id,
            'notes' => $request->notes,
            'status'=>'transferred'
        ]);
    
        // Add medicines
        foreach ($request->medicines as $medicineData) {
            $prescription->medicines()->create($medicineData);
        }


        
                // Generate PDF
        // $pdf = PDF::loadView('prescriptions.pdf', compact('prescription'));

        // // Define the relative path to save the PDF
        // $pdfFileName = 'prescription_' . $prescription->id . '.pdf';
        // $pdfPath = 'prescriptions/' . $pdfFileName;

        // // Store the generated PDF in the public/prescriptions/ directory
        // Storage::put('public/' . $pdfPath, $pdf->output());

        // // Save only the relative path in the database
        // $prescription->update(['pdf_path' => $pdfFileName]);

    
        
        return redirect()->route('prescriptions.index')->with('success', 'Prescription created successfully.');
    }
    

    public function show($id)
    {
        $prescription = Prescription::with(['doctor', 'patient', 'medicines'])->findOrFail($id);

        return view('prescriptions.show', compact('prescription'));
    }


    public function edit($id)
{
    $prescription = Prescription::with('medicines')->findOrFail($id);
    $doctors = User::role('Doctor')->get(); // Fetch doctors
    $patients = User::role('Patients')->get(); // Fetch patie+3nts
    $pharmacist = User::role('Pharmacist')->get(); // Use role name for patients
    $appointment = Appointment::where(['id'=>$prescription->appointment_id])->get();
    $appointments = Appointment::all();
    return view('prescriptions.edit', compact('prescription', 'doctors', 'patients','pharmacist','appointment','appointments'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'doctor_id' => 'required',
        'patient_id' => 'required',
        'notes' => 'nullable|string',
        'medicines' => 'required|array',
        'medicines.*.name' => 'required|string',
        'medicines.*.dosage' => 'required|string',
        'medicines.*.frequency' => 'required|string',
    ]);

    $prescription = Prescription::findOrFail($id);

    $status = isset($request->status) ? $request->status : 'transferred';



    $arr = [
        'doctor_id' => $request->doctor_id,
        'patient_id' => $request->patient_id,
        'notes' => $request->notes,
    ];

    if(isset($request->status)){
        $arr['status'] = $status;
    }
    if(isset($request->pharma_comment) && $request->pharma_comment != ""){
        $arr['pharma_comment'] = $request->pharma_comment;
    }

    

    $prescription->update($arr);

    // Update the medicines
    $prescription->medicines()->delete();
    foreach ($request->medicines as $medicine) {
        $prescription->medicines()->create($medicine);
    }


        // Generate PDF
    //     $pdf = PDF::loadView('prescriptions.pdf', compact('prescription'));

    //     // Define the relative path to save the PDF
    //     $pdfFileName = 'prescription_' . $prescription->id . '.pdf';
    //     $pdfPath = 'prescriptions/' . $pdfFileName;
    
    //     // Store the generated PDF in the public/prescriptions/ directory
    //     Storage::put('public/' . $pdfPath, $pdf->output());
    // // echo $pdfPath;

    //     // Save only the relative path in the database
    //     $updatess = $prescription->update(['pdf_path' => $pdfFileName]);
// var_dump($updatess);
// exit;
        

    return redirect()->route('prescriptions.index')->with('success', 'Prescription updated successfully.');
}

public function generatePDF($id)
{
    // Retrieve the prescription data
    $prescription = Prescription::with(['medicines', 'doctor', 'patient', 'appointment.hospital'])->findOrFail($id);

    // Load the view and pass the prescription data
    $pdf = PDF::loadView('prescriptions.pdf', compact('prescription'));

    // Return the generated PDF (to view/download)
    return $pdf->download('prescription_'.$prescription->id.'.pdf');
}



    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect()->route('prescriptions.index')->with('success', 'Prescription deleted successfully.');
    }
}
