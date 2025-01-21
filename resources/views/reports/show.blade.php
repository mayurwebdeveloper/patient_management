@extends('layouts.main')


@push('title')
<title>Reports</title>
@endpush
    
@section('main-section')
<div class="container">
    <h2>Reports </h2>
    <div class="row">
        <div class="col-md-6">
            <p>IPD Date: </p>
        </div>
        <div class="col-md-6">
            <p>LPD NO: </p>
        </div>
    </div>
    
</div>
<script>
    
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