<?php
namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use PDF; // Use the PDF facade
use Illuminate\Support\Facades\Storage;


class PrescriptionController extends Controller
{
    public function index()
    {
        // Show all prescriptions (for a doctor, you can filter by doctor_id)
        $prescriptions = Prescription::with('medicines', 'doctor', 'patient')->get();
        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
         // Fetch the doctors where the role_id is 2
         $doctors = User::role('Doctor')->get(); // Use the role name, not 'role_id'


         // Fetch the patients (assuming all users are patients except doctors, or you have another way to determine patients)
         $patients = User::role('Patient')->get(); // Use role name for patients
 
         // Fetch appointments (you may filter it based on criteria)
         $appointments = Appointment::all();
 
         return view('prescriptions.create', compact('doctors', 'patients', 'appointments'));
        // Show the form to create a new prescription
        // return view('prescriptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:users,id',
            'medicines.*.name' => 'required|string',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.frequency' => 'required|string',
        ]);
    
        // Create the prescription
        $prescription = Prescription::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'notes' => $request->notes,
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
    $patients = User::role('Patient')->get(); // Fetch patients

    return view('prescriptions.edit', compact('prescription', 'doctors', 'patients'));
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
    $prescription->update([
        'doctor_id' => $request->doctor_id,
        'patient_id' => $request->patient_id,
        'notes' => $request->notes,
    ]);

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
