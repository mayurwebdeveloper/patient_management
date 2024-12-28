@extends('layouts.main')


@push('title')
<title>FollowUp Appointments</title>
@endpush

@section('main-section')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">FollowUp Appointments</h6>
        <div>
            @can('add followup')
            <a class="btn btn-info" href="{{ route('followup-form', ['appointment' => $appointmentId]) }}"><i class="fas fa-plus"></i></a>
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
                @foreach($followup as $key=>$value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->patient_name }}</td>
                        <td>{{ $value->hospital->name }}</td>
                        <td>{{ $value->speciality->title }}</td>
                        <td>{{ $value->appointment_date ? $value->appointment_date : 'No Date Available' }}</td>
                        <td>{{ ucfirst($value->status) }}</td>
                        <td>
                                                
                            <!-- Cancel Button -->
                            <form action="{{ route('appointments.update-status', ['appointment' => $value->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            </form>

                            <!-- Schedule Button -->
                            <form action="{{ route('appointments.update-status', ['appointment' => $value->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="scheduled">
                                <button type="submit" class="btn btn-primary btn-sm">Schedule</button>
                            </form>

                            <!-- Confirmed Button -->
                            <form action="{{ route('appointments.update-status', ['appointment' => $value->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                            </form>

                            <a href="{{ route('appointments.edit', $value->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            

                            
                        </td>

                      
                    </tr>
                @endforeach
            </tbody>
        </table>  
        </div>
    </div>
</div>


<!--user-form-modal end-->

<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>


@if (Session::has('success'))
<script>
    Swal.fire(
    'Users!',
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