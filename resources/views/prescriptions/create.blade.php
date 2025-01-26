
@extends('layouts.main')



@push('title')
<title>Add Prescription</title>
@endpush


@section('main-section')


<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Add Prescription</h6>
    </div>
    <div class="card-body">
       <form action="{{ route('prescriptions.store') }}" method="POST">
        @csrf
        <div class="col-md-6">
          <!-- Appointment Dropdown -->
        <div class="form-group">
            <label for="appointment_id">Select Appointment</label>
            <select name="appointment_id" id="appointment_id" class="form-control" required>
                <option value="">-- Select Appointment --</option>
                @foreach($appointments as $appointment)
                    <option value="{{ $appointment->id }}"  {{ $appointment->id == $appointment_id ? 'selected' : '' }}  >
                        Appointment with {{ $appointment_id }} {{ @$appointment->patient->name == "" ? $appointment->patient_name : @$appointment->patient->name }} on {{ $appointment->opd_date }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Doctor Dropdown -->
        <div class="form-group">
            <label for="doctor_id">Select Doctor</label>
            <select name="doctor_id" id="doctor_id" class="form-control" required>
                <option value="">-- Select Doctor --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }} >{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Patient Dropdown -->
        <div class="form-group">
            <label for="patient_id">Select Patient</label>
            <select name="patient_id" id="patient_id" class="form-control" required>
                <option value="">-- Select Patient --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }} >{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
        <div class="checkbox">
            <label>
              <input type="checkbox" name="status" data-toggle="toggle" checked>
              Transfer to Pharmasist
            </label>
          </div>
          <select name="pharmacist_id" id="pharmacist_id" class="form-control">
            <option value="">-- Select Pharmasist --</option>
                @foreach($pharmacist as $pharm)
                    <option value="{{ $pharm->id }}" >{{ $pharm->name }}</option>
                @endforeach
            </select>
          
        </div>
    </div>
        <!-- Notes for Prescription -->
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control"></textarea>
        </div>

        <h4>Medicines</h4>

        <!-- Headers for the medicine fields -->
        <div class="row mb-3">
            <div class="col-md-4"><strong>Medicine Name</strong></div>
            <div class="col-md-3"><strong>Dosage</strong></div>
            <div class="col-md-3"><strong>Frequency</strong></div>
            <div class="col-md-2"></div> <!-- Empty column for remove button -->
        </div>

        <div id="medicines">
            <div class="medicine-group row mb-3">
                <div class="col-md-4">
                    <input type="text" name="medicines[0][name]" class="form-control" placeholder="Enter medicine name" required>
                </div>

                <div class="col-md-3">
                    <input type="text" name="medicines[0][dosage]" class="form-control" placeholder="Enter dosage" required>
                </div>

                <div class="col-md-3">
                    <input type="text" name="medicines[0][frequency]" class="form-control" placeholder="e.g., 2 times a day" required>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-medicine" style="display:none;">Remove</button>
                </div>
            </div>
        </div>
    


        <button type="button" id="add-medicine" class="btn btn-secondary">Add Another Medicine</button>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


    </div>
</div>

    
    
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

            // Show the remove button for each medicine group
            updateRemoveButtons();
        });

        function updateRemoveButtons() {
            let removeButtons = document.querySelectorAll('.remove-medicine');
            removeButtons.forEach((button, index) => {
                button.style.display = 'block'; // Always display the remove button
                button.addEventListener('click', function() {
                    button.closest('.medicine-group').remove();
                });
            });
        }

        // Initially hide the remove button if there's only one medicine
        updateRemoveButtons();
    </script>
@endsection