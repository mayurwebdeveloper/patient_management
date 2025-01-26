
@extends('layouts.main')



@push('title')
<title>Add Prescription</title>
@endpush


@section('main-section')
    <h1>Edit Prescription</h1>

    <form action="{{ route('prescriptions.update', $prescription->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Appointment Dropdown -->
        <div class="form-group">
            <label for="appointment_id">Select Appointment</label>
            <select name="appointment_id" id="appointment_id" class="form-control" required>
                <option value="">-- Select Appointment --</option>
                @foreach($appointments as $appointment)
                    <option value="{{ $appointment->id }}"  {{ $appointment->id == $prescription->appointment_id ? 'selected' : '' }}  >
                        Appointment with {{ $prescription->appointment_id }} {{ @$appointment->patient->name == "" ? $appointment->patient_name : @$appointment->patient->name }} on {{ $appointment->opd_date }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Doctor Dropdown -->
        <div class="form-group">
            <label for="doctor_id">Doctor</label>
            <select name="doctor_id" class="form-control" required>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $doctor->id == $prescription->doctor_id ? 'selected' : '' }}>
                        {{ $doctor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Patient Dropdown -->
        <div class="form-group">
            <label for="patient_id">Patient</label>
            <select name="patient_id" class="form-control" required>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $patient->id == $prescription->patient_id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>

        @if(Auth::user()->hasRole('Doctor'))
        <div class="form-group">
            <div class="checkbox">
                <label>
                  <input type="checkbox" name="status" value="transferred" data-toggle="toggle" checked>
                  Transfer to Pharmasist
                </label>
              </div>
              <select name="pharmacist_id" id="pharmacist_id" class="form-control">
                <option value="">-- Select Pharmasist --</option>
                    @foreach($pharmacist as $pharm)
                        <option value="{{ $pharm->id }}"  {{ $pharm->id == $prescription->pharmacist_id ? 'selected' : '' }} >{{ $pharm->name }}</option>
                    @endforeach
                </select>
        </div>
        @endif

        @if(Auth::user()->hasRole('Pharmacist'))
        <div class="form-group">
            <div class="checkbox">
                <label>
                  <input type="checkbox" name="status" {{ $prescription->status == "returned" ? 'checked' : '' }}  value="returned"   data-toggle="toggle">
                  Return to MO
                </label>
              </div>
        </div>
        @endif

        @if(Auth::user()->hasRole('Pharmacist'))
        <!-- Notes -->
        <div class="form-group">
            <label for="pharma_comment">Notes To MO</label>
            <textarea name="pharma_comment" class="form-control">{{ $prescription->pharma_comment }}</textarea>
        </div>
        @endif


        <!-- Notes -->
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" class="form-control">{{ $prescription->notes }}</textarea>
        </div>

        <!-- Medicines -->
        <h4>Medicines</h4>

        <div class="row mb-3">
            <div class="col-md-4"><strong>Medicine Name</strong></div>
            <div class="col-md-3"><strong>Dosage</strong></div>
            <div class="col-md-3"><strong>Frequency</strong></div>
            <div class="col-md-2"></div>
        </div>

        <div id="medicines">
            @foreach($prescription->medicines as $index => $medicine)
                <div class="medicine-group row mb-3">
                    <div class="col-md-4">
                        <input type="text" name="medicines[{{ $index }}][name]" class="form-control" value="{{ $medicine->name }}" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="medicines[{{ $index }}][dosage]" class="form-control" value="{{ $medicine->dosage }}" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="medicines[{{ $index }}][frequency]" class="form-control" value="{{ $medicine->frequency }}" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-medicine">Remove</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mb-3">
            <button type="button" id="add-medicine" class="btn btn-secondary">Add Another Medicine</button>
        </div>

        <button type="submit" class="btn btn-primary">Update Prescription</button>
    </form>

    <script>
        document.getElementById('add-medicine').addEventListener('click', function() {
            let medicineCount = document.querySelectorAll('.medicine-group').length;
            let medicinesDiv = document.getElementById('medicines');

            let newMedicineDiv = document.createElement('div');
            newMedicineDiv.classList.add('medicine-group', 'row', 'mb-3');

            newMedicineDiv.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="medicines[${medicineCount}][name]" class="form-control" placeholder="Enter medicine name" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="medicines[${medicineCount}][dosage]" class="form-control" placeholder="Enter dosage" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="medicines[${medicineCount}][frequency]" class="form-control" placeholder="e.g., 2 times a day" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-medicine">Remove</button>
                </div>
            `;
            medicinesDiv.appendChild(newMedicineDiv);

            updateRemoveButtons();
        });

        function updateRemoveButtons() {
            let removeButtons = document.querySelectorAll('.remove-medicine');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    button.closest('.medicine-group').remove();
                });
            });
        }

        updateRemoveButtons();
    </script>
@endsection
