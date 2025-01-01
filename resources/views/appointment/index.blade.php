@extends('layouts.main')


@push('title')
<title>Appointments</title>
@endpush

@section('main-section')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Appointments</h6>
        <div>
            @can('add appointment')
            <a class="btn btn-info" href="{{ route('add-appointment-form') }}"><i class="fas fa-plus"></i></a>
            @endcan
            @can('delete appointment')
            <button id="delete-selected" class="btn btn-danger"><i class="fas fa-trash"></i></button>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="userTable" width="100%" cellspacing="0">
             <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Hospital</th>
                    <th>Speciality</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->patient_name }}</td>
                        <td>{{ $appointment->hospital->name }}</td>
                        <td>{{ $appointment->speciality->title }}</td>
                        <td>{{ $appointment->appointment_date ? $appointment->appointment_date->format('d-m-Y H:i') : 'No Date Available' }}</td>
                        <td>{{ ucfirst($appointment->status) }}</td>
                        <td>
                                                
                            <!-- Cancel Button -->
                            <form action="{{ route('appointments.update-status', ['appointment' => $appointment->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            </form>

                            <!-- Schedule Button -->
                            <form action="{{ route('appointments.update-status', ['appointment' => $appointment->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="scheduled">
                                <button type="submit" class="btn btn-primary btn-sm">Schedule</button>
                            </form>

                            <!-- Confirmed Button -->
                            <form action="{{ route('appointments.update-status', ['appointment' => $appointment->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                            </form>

                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ route('appointment.followup', ['appointment' => $appointment->id]) }}" class="btn btn-sm btn-primary">Followup</a>
                            <button 
                            type="button" 
                            class="btn btn-sm btn-warning" 
                            data-toggle="modal" 
                            data-target="#investigationModal" 
                            data-appointment-id="{{ $appointment->id }}">
                            Investigation
                        </button>
                            
                        </td>

                      
                    </tr>
                @endforeach
            </tbody>
        </table>  
        </div>
    </div>
</div>


<div class="modal fade" id="investigationModal" tabindex="-1" aria-labelledby="investigationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="investigationModalLabel">Select Investigations</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="investigationForm" method="POST" action="{{ route('appointments.save-reports') }}">
                    @csrf
                    <input type="hidden" name="appointment_id" id="appointment_id">
                    <div class="form-group">
                        <label for="reports">Reports</label>
                        <div id="reportList">
                            
                        </div>
                    </div>
                    <div class="errorMessage text-danger d-none">Please select at least one report before saving</div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--user-form-modal end-->

<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function () {
    $('#investigationModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget); 
        const appointmentId = button.data('appointment-id'); 
        const reportList = $('#reportList');
        const appointmentInput = $('#appointment_id');
        appointmentInput.val(appointmentId);
        $.ajax({
            url: `appointments/${appointmentId}/reports`,
            method: 'GET',
            success: function (data) {
                reportList.empty(); 

                data.reports.forEach(function (report) {
                    const isChecked = data.selected.includes(report.id) ? 'checked' : '';
                    const reportHtml = `
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="report_ids[]" 
                                value="${report.id}" 
                                id="report-${report.id}" 
                                ${isChecked}>
                            <label class="form-check-label" for="report-${report.id}">
                                ${report.report_name}
                            </label>
                        </div>
                    `;
                    reportList.append(reportHtml);
                });
            }
        });
    });


    $('#investigationForm').on('submit', function (e) {
        e.preventDefault(); 

        const checkedReports = $('#reportList input[type="checkbox"]:checked').map(function() {
            return $(this).val();
        }).get();

        if (checkedReports.length === 0) {
            $('.errorMessage').removeClass('d-none');
        } else {
            $('.errorMessage').addClass('d-none'); 

            $.ajax({
                url: $('#investigationForm').attr('action'), 
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(), 
                    appointment_id: $('#appointment_id').val(), 
                    report_ids: checkedReports, 
                },
                success: function (response) {
                    if (response.success) {
                        $('#investigationModal').modal('hide'); 
                        Swal.fire('Report added successfully');
                    } else {
                        alert('Error while saving reports');
                    }
                },
                error: function () {
                    alert('An error occurred while processing your request.');
                }
            });
        }
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