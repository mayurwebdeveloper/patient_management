<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\TreatmentSheet;
use PDF; // Use the PDF facade
class TreatmentSheetController extends Controller
{
    public function show($appointmentId)
    {
        $appointment = Appointment::with([
                'patient' => function ($query) {
                    $query->select('id', 'name');
                }])->findOrFail($appointmentId);
        // dd($appointment);
        $treatmentSheets = TreatmentSheet::where('appointment_id', $appointmentId)->get();

        return view('treatment_sheet.show', compact('appointment', 'treatmentSheets'));
    }

    public function store(Request $request, $appointmentId)
    {
        $request->validate([
            'medication_name.*' => 'required|string',
            'dosage.*' => 'required|string',
            'root.*' => 'required|string',
            'time_of_admission.*' => 'required|date',
            'signature.*' => 'required|string',
        ]);

        // Handle updates and new entries
        foreach ($request->medication_name as $key => $value) {
            if (isset($request->treatment_sheet_id[$key])) {
                // Update existing rows
                $treatmentSheet = TreatmentSheet::find($request->treatment_sheet_id[$key]);
                if ($treatmentSheet) {
                    $treatmentSheet->update([
                        'medication_name' => $value,
                        'dosage' => $request->dosage[$key],
                        'root' => $request->root[$key],
                        'time_of_admission' => $request->time_of_admission[$key],
                        'signature' => $request->signature[$key],
                    ]);
                }
            } else {
                // Create new rows
                TreatmentSheet::create([
                    'appointment_id' => $appointmentId,
                    'medication_name' => $value,
                    'dosage' => $request->dosage[$key],
                    'root' => $request->root[$key],
                    'time_of_admission' => $request->time_of_admission[$key],
                    'signature' => $request->signature[$key],
                ]);
            }
        }

        // Handle deleted rows
        if ($request->deleted_ids) {
            TreatmentSheet::whereIn('id', explode(',', $request->deleted_ids))->delete();
        }

        return redirect()->back()->with('success', 'Treatment sheet updated successfully.');
    }

    public function generatePDF($id)
    {
        $appointment = Appointment::with([
        'patient' => function ($query) {
            $query->select('id', 'name');
        }])->findOrFail($id);
        $treatmentSheet = TreatmentSheet::with(['appointment'])->where('appointment_id',$id)->get();
        $pdf = PDF::loadView('treatment_sheet.pdf', compact('treatmentSheet','appointment'));
        return $pdf->download('treatmentsheet_'.$id.'.pdf');
    }

}
