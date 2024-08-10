@extends('layouts.main')


@push('title')
<title>Profile</title>
@endpush

@section('main-section')

<!-- Profile Edit Form -->
<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
    </div>
    <div class="card-body">


    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="{!! asset('images/users/photos/') !!}/{{$user->profile ?? 'no-img.png'}}" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3">{{ $user->name }}</h5>
            <p class="text-muted mb-1">{{ $user->email }}</p>
          </div>
        </div>
      </div>



      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <form method="post" action="{{ route('edit-profile') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Full Name</p>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $user->name)}}" placeholder="Name">
                        @error('name')
                        <div class="invalid-feedback">
                        {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Email</p>
                    </div>
                    <div class="col-sm-9">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email', $user->email)}}" placeholder="Email">
                        @error('email')
                        <div class="invalid-feedback">
                        {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Profile picture</p>
                    </div>
                    <div class="col-sm-9">
                        <input type="file" class="@error('profile') is-invalid @enderror" id="profile" name="profile">
                        @error('profile')
                        <div class="invalid-feedback">
                        {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <hr>
                @can('edit profile')
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
    'Profile!',
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
