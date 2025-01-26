

@extends('layouts.main')

{{--  @section('content')
    <h1>Prescriptions</h1>

    <a href="{{ route('prescriptions.create') }}" class="btn btn-primary">Add Prescription</a>

    <ul>
        @foreach($prescriptions as $prescription)
            <li>
                Doctor: {{ $prescription->doctor->name }} | 
                Patient: {{ $prescription->patient->name }} | 
                Notes: {{ $prescription->notes }}
                <ul>
                    @foreach($prescription->medicines as $medicine)
                        <li>{{ $medicine->name }} - {{ $medicine->dosage }} - {{ $medicine->frequency }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('prescriptions.show', $prescription->id) }}">View</a>
            </li>
        @endforeach
    </ul>
@endsection  --}}




@push('title')
<title>Appointments</title>
@endpush

@section('main-section')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <strong class="me-auto">Notification</strong>
        <small>Just now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        This is a toast message!
      </div>
    </div>
  </div>
  

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Prescriptions</h6>
          <a href="{{ route('prescriptions.create') }}" class="btn btn-primary">Add Prescription</a>
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="userTable" width="100%" cellspacing="0">
             <thead>
                <tr>
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Medicines</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                 @foreach($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription->id }}</td>
                        <td> {{ $prescription->doctor->name }}</td>
                        <td>{{ $prescription->patient->name }}</td>
                        <td>{{ $prescription->status }}</td>
                        <td>{{ $prescription->notes }}
                            @if($prescription->pharma_comment != "")
                               <br> <b>Pharma Comment:</b> {{ $prescription->pharma_comment }}
                            @endif
                        </td>
                        <td>
                         <ul>
                            @foreach($prescription->medicines as $medicine)
                                <li>{{ $medicine->name }} - {{ $medicine->dosage }} - {{ $medicine->frequency }}</li>
                            @endforeach
                        </ul>
                        </td>
                       <td>
                            <a href="{{ route('prescriptions.show', $prescription->id) }}">View</a> |
                            <a href="{{ route('prescription.pdf', $prescription->id) }}">Download PDF</a>
{{--  <a href="{{ asset('storage/' . $prescription->pdf_path) }}" target="_blank">Download PDF</a>  --}}

                            <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="btn btn-primary btn-sm">Edit</a> |

                            <form action="{{ route('prescriptions.destroy', $prescription->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this prescription?');">Delete</button>
                            </form>
                            @if($prescription->status != "completed")
                            <a data-id="{{ $prescription->id }}" id="pres-{{ $prescription->id }}" class="complete_prescription btn btn-primary btn-sm">Complete</a>
                            @endif
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

<script>
$(document).on('click','.complete_prescription',function(){
    alert($(this).data('id'))
    var formData = {
        prescription_id: $(this).data('id'),
        status:'completed'
    };
    const csrfToken = $('meta[name="csrf-token"]').attr("content");
    var pres = $(this).data('id');
    $.ajax({
        url: "{{ route('prescription.updatestatus') }}", // The PHP script to handle the request
        type: "POST",
        data: formData,
        headers: {
            "X-CSRF-TOKEN": csrfToken, // Add CSRF token to request headers
        },
        success: function (response) {
            // Display the response
            Swal.fire(
                'Prescription',
                'Prescription updated successfully!',
                'success'
                );
       
                $("#pres-"+pres).hide();
        },
        error: function (xhr, status, error) {
            console.error("Error: " + error);
            $("#response").html("An error occurred.");
        },
    });
})
    

</script>

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