@extends('layouts.main')


@push('title')
<title>Enquiry</title>
@endpush

@section('main-section')

<!-- Enquiry Detail -->
<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Enquiry</h6>
    </div>
    <div class="card-body">

    <div class="row">
     
      <div class="col-lg-12">
          <div class="card mb-4">
              <div class="card-body row">
                <div class="col-6">
                    <h6 class="card-title">Name : {{ $enquiry->name }}</h6>
                    <hr>
                </div>
                <div class="col-6">
                    <h6 class="card-title">Email : {{ $enquiry->email }}</h6>
                    <hr>
                </div>
                <div class="col-6">
                    <h6 class="card-title">Phone : {{ $enquiry->phone }}</h6>
                </div>
                {{--<div class="col-6">
                    <h6 class="card-title">Subject : {{ $enquiry->title }}</h6>
                </div> --}}
              </div>
        </div>
      </div>

      <div class="col-lg-12">
      <h5 class="card-title">Enquiry</h5>
        <div class="card mb-4">
          <div class="card-body">
                <p>{{ $enquiry->description }}</p>
          </div>
        </div>
      </div>

    </div>

    </div>
</div>

@endsection
