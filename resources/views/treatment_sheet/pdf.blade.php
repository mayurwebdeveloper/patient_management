<!DOCTYPE html>
<html>
<head>
    <title>Treatment Sheet PDF</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
            margin: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .clinic-info {
            text-align: left;
            font-size: 12px;
            margin-bottom: 20px;
        }
        .clinic-name {
            font-size: 20px;
            font-weight: bold;
        }
        .clinic-address {
            font-size: 12px;
            color: #555;
            margin-bottom: 10px;
        }
        .divider {
            border-bottom: 2px solid #000;
            margin: 20px 0;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h3 {
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .patient-info, .doctor-info {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .patient-info strong {
            display: inline-block;
            width: 150px;
        }
        .medicines-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }
        .medicines-table th,
        .medicines-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .medicines-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .medicines-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Treatment Sheet</h1>
    </div>
    <div class="clinic-info" style="display: none;">
        <p class="clinic-name">Your Clinic Name</p>
        <p class="clinic-address">123 Clinic Street, City, State, ZIP</p>
        <p>Phone: (123) 456-7890 | Email: info@clinic.com</p>
    </div>
    <div class="divider"></div>

    <div class="section">
        <h3>Patient Information</h3>
        <div class="patient-info">
            <strong>Patient Name:</strong> {{ optional($appointment->patient)->name ?? '' }}<br>
            <strong>IPD Date:</strong> {{ $appointment->ipd_date ?? '-' }}<br>
            <strong>LPD No:</strong> {{ $appointment->lpd_no ?? '-' }}
        </div>
    </div>

    <div class="section">
        <h3>Medicines and Treatment Details</h3>
        <table class="medicines-table">
            <thead>
                <tr>
                    <th>Medication Name</th>
                    <th>Dosage</th>
                    <th>Route</th>
                    <th>Time of Admission</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                @foreach($treatmentSheet as $key => $value)
                <tr>
                    <td>{{ $value->medication_name ?? '' }}</td>
                    <td>{{ $value->dosage ?? '' }}</td>
                    <td>{{ $value->route ?? '' }}</td>
                    <td>{{ $value->time_of_admission ?? '' }}</td>
                    <td>{{ $value->signature ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>&copy; 2025 Your Clinic Name. All rights reserved.</p>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
