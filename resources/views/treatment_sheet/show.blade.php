@extends('layouts.main')


@push('title')
<title>Treatment Sheet</title>
@endpush
    
@section('main-section')
<div class="container">
    <h2>Treatment Sheet for {{ optional($appointment->patient)->name ?? ''  }}</h2>
    <div class="row">
        <div class="col-md-6">
            <p>IPD Date: {{ $appointment->ipd_date ?? '-' }}</p>
        </div>
        <div class="col-md-6">
            <p>LPD NO: {{ $appointment->lpd_no ?? '-' }}</p>
        </div>
    </div>
    <form action="{{ route('treatment-sheet.store', $appointment->id) }}" method="POST">
        @csrf
        <input type="hidden" name="deleted_ids" id="deleted-ids">
        <table class="table">
            <thead>
                <tr>
                    <th>Medication Name</th>
                    <th>Dosage</th>
                    <th>Root</th>
                    <th>Time of Admission</th>
                    <th>Signature</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="treatment-sheet-body">
                @foreach($treatmentSheets as $sheet)
                <tr data-id="{{ $sheet->id }}">
                    <td>
                        <input type="hidden" name="treatment_sheet_id[]" value="{{ $sheet->id }}">
                        <input type="text" name="medication_name[]" value="{{ $sheet->medication_name }}" class="form-control" required>
                    </td>
                    <td><input type="text" name="dosage[]" value="{{ $sheet->dosage }}" class="form-control" required></td>
                    <td><input type="text" name="root[]" value="{{ $sheet->root }}" class="form-control" required></td>
                    <td><input type="datetime-local" name="time_of_admission[]" value="{{ $sheet->time_of_admission }}" class="form-control" required></td>
                    <td><input type="text" name="signature[]" value="{{ $sheet->signature }}" class="form-control" required></td>
                    <td>
                        <button type="button" class="btn btn-danger remove-row" data-id="{{ $sheet->id }}">Remove</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" id="add-more" class="btn btn-primary">Add More</button>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('treatment-sheet.pdf',  $appointment->id) }}" class="btn btn-warning">Download PDF</a>
    </form>
</div>
<script>
    $(document).ready(function () {
        let deletedIds = [];

        // Add new row
        $('#add-more').click(function () {
            $('#treatment-sheet-body').append(`
                <tr>
                    <td>
                        <input type="hidden" name="treatment_sheet_id[]" value="">
                        <input type="text" name="medication_name[]" class="form-control" required>
                    </td>
                    <td><input type="text" name="dosage[]" class="form-control" required></td>
                    <td><input type="text" name="root[]" class="form-control" required></td>
                    <td><input type="datetime-local" name="time_of_admission[]" class="form-control" required></td>
                    <td><input type="text" name="signature[]" class="form-control" required></td>
                    <td>
                        <button type="button" class="btn btn-danger remove-row">Remove</button>
                    </td>
                </tr>
            `);
        });

        // Remove row
        $(document).on('click', '.remove-row', function () {
            const row = $(this).closest('tr');
            const id = row.data('id');
            
            if (id) {
                deletedIds.push(id);
                $('#deleted-ids').val(deletedIds.join(','));
            }
            
            row.remove();
        });
    });
</script>
@if (Session::has('success'))
<script>
    Swal.fire(
    'Appointment!',
    '{{Session::get("success")}}',
    'success'
    );
</script>
@php
Session::forget('success');
@endphp
@endif

@if (Session::has('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{Session::get("error")}}',
    });
</script>
@php
Session::forget('error');
@endphp
@endif
@endsection