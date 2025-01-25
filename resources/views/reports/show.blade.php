@extends('layouts.main')


@push('title')
<title>View Reports</title>
@endpush
    
@section('main-section')
<div class="container py-4">
    <h2 class="text-center mb-4">View Reports</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Display global errors or success messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}

            <form action="{{ route('upload.report.file') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $appointmentId }}">

                @forelse($getAppointmentReport as $index => $appointmentReport)
                <div class="row align-items-center mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ $appointmentReport->report->report_name }}</label>
                        <input type="hidden" name="report_ids[]" value="{{ $appointmentReport->report->id }}">
                    </div>
                    <div class="col-md-3">
                        @if($appointmentReport->report_pdf)
                        <p class="text-success mb-0">
                            <strong>Uploaded File:</strong>
                            <a href="{{ asset('images/reports/' . $appointmentReport->report_pdf) }}" 
                               target="_blank" 
                               class="text-primary text-decoration-underline">
                               Preview
                            </a>
                        </p>
                        @else
                        <p class="text-muted mb-0">No file uploaded</p>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <input type="file" name="files[{{ $index }}]" class="form-control @error("files.$index") is-invalid @enderror">
                        <!-- Error message for each file input -->
                        @error("files.$index")
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <p class="text-muted">No reports available for this appointment.</p>
                </div>
                @endforelse

                @if($getAppointmentReport->isNotEmpty())
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-upload"></i> Save
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

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