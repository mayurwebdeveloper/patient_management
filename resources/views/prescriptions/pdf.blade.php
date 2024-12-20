<!DOCTYPE html>
<html>
<head>
    <title>Prescription PDF</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .clinic-info { text-align: left; font-size: 12px; }
        .clinic-name { font-size: 20px; font-weight: bold; }
        .clinic-address { font-size: 12px; color: #555; margin-bottom: 10px; }
        .divider { border-bottom: 2px solid #000; margin: 20px 0; }
        .section { margin-bottom: 20px; }
        .section h3 { margin-bottom: 10px; font-size: 16px; }
        .patient-info, .doctor-info { font-size: 14px; }
        .medicines-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .medicines-table th, .medicines-table td { border: 1px solid #ddd; padding: 8px; }
        .medicines-table th { background-color: #f4f4f4; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 30px; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>

    <!-- Header with Clinic Information -->
    <div class="header">
        <div class="clinic-info">
            <div class="clinic-name">{{ $prescription->appointment->hospital->name }}</div>
            <div class="clinic-address">
                {{ $prescription->appointment->hospital->address }}<br>
                Phone: {{ $prescription->appointment->hospital->mo }} | Email: {{ $prescription->appointment->hospital->email }}
            </div>
        </div>
    </div>

    <!-- Divider Line -->
    <div class="divider"></div>

    <!-- Prescription Details -->
    <div class="section">
        <h3>Prescription Details</h3>
        <div class="patient-info">
            <strong>Patient:</strong> {{ $prescription->patient->name }}<br>
            <strong>Date:</strong> {{ $prescription->created_at->format('d M, Y') }}
        </div>
        <div class="doctor-info" style="margin-top: 10px;">
            <strong>Doctor:</strong> Dr. {{ $prescription->doctor->name }}
        </div>
    </div>

    <!-- Medicines Section -->
    <div class="section">
        <h3>Medicines</h3>
        <table class="medicines-table">
            <thead>
                <tr>
                    <th>Medicine Name</th>
                    <th>Dosage</th>
                    <th>Frequency</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescription->medicines as $medicine)
                    <tr>
                        <td>{{ $medicine->name }}</td>
                        <td>{{ $medicine->dosage }}</td>
                        <td>{{ $medicine->frequency }}</td>
                        <td>{{ $medicine->duration ?? 'N/A' }}</td> <!-- Optional duration -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Notes Section -->
    <div class="section">
        <h3>Doctor's Notes</h3>
        <p>{{ $prescription->notes ?? 'No specific notes provided.' }}</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        This prescription is generated electronically. Please consult the doctor before making any changes to the prescribed dosage.
    </div>

</body>
</html>
