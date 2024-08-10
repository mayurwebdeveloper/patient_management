@extends('layouts.main')


@push('title')
<title>Front Setting</title>
@endpush

@section('main-section')

<!-- Front Setting Edit Form -->
<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Front Setting</h6>
    </div>
    <div class="card-body">

      <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-body">
            <form method="post" action="{{ route('edit-front-setting') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                  <div class="form-group col-md-4">
                      <label for="locations">Locations.</label>
                      <input type="text" class="form-control @error('locations') is-invalid @enderror" name="locations" id="locations" value="{{old('locations', $count->locations ?? 0 )}}" placeholder="Locations">
                      @error('locations')
                      <div class="invalid-feedback">
                      {{$message}}
                      </div>
                      @enderror
                  </div>

                  <div class="form-group col-md-4">
                      <label for="doctors">Doctors.</label>
                      <input type="text" class="form-control @error('doctors') is-invalid @enderror" name="doctors" id="doctors" value="{{old('doctors', $count->doctors ?? 0 )}}" placeholder="Doctors">
                      @error('doctors')
                      <div class="invalid-feedback">
                      {{$message}}
                      </div>
                      @enderror
                  </div>

                  <div class="form-group col-md-4">
                      <label for="beneficiary">Beneficiary.</label>
                      <input type="text" class="form-control @error('beneficiary') is-invalid @enderror" name="beneficiary" id="beneficiary" value="{{old('beneficiary', $count->beneficiary ?? 0 )}}" placeholder="Beneficiary">
                      @error('beneficiary')
                      <div class="invalid-feedback">
                      {{$message}}
                      </div>
                      @enderror
                  </div>
              </div>

                <hr>
                @can('edit front-setting')
                <button type="submit" class="btn btn-primary">save</button>
                @endcan
            </form>
          </div>
        </div>
      </div>
    </div>

    </div>
</div>


@if (Session::has('success'))
<script>
    Swal.fire(
    'Front Setting!',
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
