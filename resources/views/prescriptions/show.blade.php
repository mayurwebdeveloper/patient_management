
@extends('layouts.main')



@push('title')
<title>Add Prescription</title>
@endpush


@section('main-section')

    <h1>Prescription Details</h1>

    <!-- Assuming you're passing a prescription variable to this view -->
    <div class="card">
        <div class="card-header">
            Prescription for {{ $prescription->patient->name }}
        </div>
        <div class="card-body">
            <p><strong>Doctor:</strong> {{ $prescription->doctor->name }}</p>
            <p><strong>Date:</strong> {{ $prescription->created_at->format('d M Y') }}</p>

            <h4>Medicines</h4>
            <ul>
                @foreach ($prescription->medicines as $medicine)
                    <li>
                        <strong>Name:</strong> {{ $medicine->name }}<br>
                        <strong>Dosage:</strong> {{ $medicine->dosage }}<br>
                        <strong>Frequency:</strong> {{ $medicine->frequency }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
