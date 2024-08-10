@extends('layouts.main')


@push('title')
<title>Settings</title>
@endpush

@section('main-section')

<!-- Settings Edit Form -->
<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Settings</h6>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('edit-settings') }}" enctype="multipart/form-data">
            @csrf
            <h6 class="mb-3 font-weight-bold text-primary">General Settings</h6>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="app_name">App Name.</label>
                    <input type="text" class="form-control @error('app_name') is-invalid @enderror" id="app_name" name="app_name" value="{{old('app_name', $setting['app_name'])}}" placeholder="App name">
                    @error('app_name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="app_email">App Email</label>
                    <input type="email" class="form-control @error('app_email') is-invalid @enderror" name="app_email" id="app_email" value="{{old('app_email', $setting['app_email'])}}" placeholder="App Email">
                    @error('app_email')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="app_logo">App Logo.</label>
                    <input type="file" class="@error('app_logo') is-invalid @enderror" name="app_logo" id="app_logo" placeholder="App Logo">
                    <img src="{!! asset('img/') !!}/{{ $setting['app_logo'] ?? 'logo.png' }}" style="border:1px solid black;" alt="app-logo" width="100px">
                    @error('app_logo')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <hr>
            <h6 class="mb-3 font-weight-bold text-primary">Email Settings</h6>    
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="mail_engine">Mail Engine.</label>
                    <select class="form-control @error('mail_engine') is-invalid @enderror" name="mail_engine" id="mail_engine" value="{{old('mail_engine', $setting['mail_engine'])}}" placeholder="Mail Engine">
                        <option value="sendmail">Mail</option>
                        <option value="smtp" @if($setting['mail_engine'] == 'smtp') {{ "selected" }} @endif >SMTP</option>
                    </select>
                    @error('mail_engine')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="smtp_hostname">Hostname.</label>
                    <input type="text" class="form-control @error('smtp_hostname') is-invalid @enderror" name="smtp_hostname" id="smtp_hostname" value="{{old('smtp_hostname', $setting['smtp_hostname'])}}" placeholder="Hostname">
                    @error('smtp_hostname')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="smtp_username">Username.</label>
                    <input type="text" class="form-control @error('smtp_username') is-invalid @enderror" name="smtp_username" id="smtp_username" value="{{old('smtp_username', $setting['smtp_username'])}}" placeholder="Username">
                    @error('smtp_username')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>


                <div class="form-group col-md-4">
                    <label for="smtp_password">Password.</label>
                    <input type="password" class="form-control @error('smtp_password') is-invalid @enderror" name="smtp_password" id="smtp_password" value="{{old('smtp_password', $setting['smtp_password'])}}" placeholder="Password">
                    @error('smtp_password')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="smtp_port">Port.</label>
                    <input type="text" class="form-control @error('smtp_port') is-invalid @enderror" name="smtp_port" id="smtp_port" value="{{old('smtp_port', $setting['smtp_port'])}}" placeholder="Port">
                    @error('smtp_port')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label for="smtp_timeout">Timeout.</label>
                    <input type="text" class="form-control @error('smtp_timeout') is-invalid @enderror" name="smtp_timeout" id="smtp_timeout" value="{{old('smtp_timeout', $setting['smtp_timeout'])}}" placeholder="Timeout">
                    @error('smtp_timeout')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-2">
                    <label for="smtp_encryption">Encryption.</label>
                    <select class="form-control @error('smtp_encryption') is-invalid @enderror" name="smtp_encryption" id="smtp_encryption" value="{{old('smtp_encryption', $setting['smtp_encryption'])}}" placeholder="Encryption">
                        <option value="tls">tls</option>
                        <option value="ssl" @if($setting['smtp_encryption'] == 'ssl') {{ "selected" }} @endif >ssl</option>
                    </select>
                    @error('smtp_encryption')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

            </div>
            @can('edit settings')
            <button type="submit" class="btn btn-primary">save</button>
            @endcan
        </form>

    </div>
</div>


@if (Session::has('success'))
<script>
    Swal.fire(
        'Settings!',
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