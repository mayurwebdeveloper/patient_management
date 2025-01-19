@extends('layouts.main')

@push('title')
<title>Add Appointment</title>
@endpush

@section('main-section')
<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Add Appointment</h6>
    </div>
    <div class="card-body">

        <!-- Navigation Tabs -->
        <nav>
            <div class="nav nav-tabs appointmentTab" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-patient-tab" data-toggle="tab" data-target="#nav-patient" type="button" role="tab" aria-controls="nav-patient" aria-selected="true">Patient Info</button>
                <button class="nav-link disabled" id="nav-general-tab" data-toggle="tab" data-target="#nav-general" type="button" role="tab" aria-controls="nav-general" aria-selected="false">General Examination</button>
                <button class="nav-link disabled" id="nav-systemic-tab" data-toggle="tab" data-target="#nav-systemic" type="button" role="tab" aria-controls="nav-systemic" aria-selected="false">Systemic Examination</button>
                <button class="nav-link disabled" id="nav-history-tab" data-toggle="tab" data-target="#nav-history" type="button" role="tab" aria-controls="nav-history" aria-selected="false">Obstetric History</button>
                <button class="nav-link disabled" id="nav-complaint-tab" data-toggle="tab" data-target="#nav-complaint" type="button" role="tab" aria-controls="nav-complaint" aria-selected="false">Presenting Complaint</button>
            </div>
        </nav>

        <!-- Tab Content -->
        <div class="tab-content" id="nav-tabContent">
            <!-- Patient Info Tab -->
            
                <div class="tab-pane fade show active" id="nav-patient" role="tabpanel" aria-labelledby="nav-patient-tab">
                    <form method="post" id="form-patient-info" name="form-patient-info" action="{{ route('add-appointment') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="patient_id">Patient</label>
                            

                                <select  class="form-control @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id" placeholder="patient_id">
                                    <option value="">Select</option>
                                    @foreach ($patients as $k => $patient)
                                        <option value="{{ $k }}" {{ old('patient_id') == $k ? 'selected' : '' }}>{{ $patient }}</option>
                                    @endforeach
                                </select>
                               
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sector">Doctor</label>
                                <select class="form-control @error('doctor_id') is-invalid @enderror" name="doctor_id" id="doctor_id" placeholder="Doctor">
                                    <option value="">Select</option>
                                    @foreach ($doctors as $key=> $doctor)
                                        <option value="{{ $key }}" {{ old('doctor_id') == $doctor ? 'selected' : '' }}>{{ $doctor }}</option>
                                    @endforeach
                                </select>
                               
                            </div>
                            <div class="form-group col-md-6">
                                <label for="speciality_id">Specialities.</label>
                                <select  required class="form-control @error('speciality_id') is-invalid @enderror" name="speciality_id" id="speciality_id" placeholder="speciality_id">
                                    <option value="">Select</option>
                                    @foreach ($specialities as $key => $speciality)
                                        <option value="{{ $key }}" {{ in_array($key, old('specialities', [])) ? 'selected' : '' }}>{{ $speciality }}</option>
                                    @endforeach
                                </select>
                               
                            </div>

                            <div class="form-group col-md-6">
                                <label for="hospital_id">Hospital</label>
                                <select  required class="form-control @error('hospital_id') is-invalid @enderror" name="hospital_id" id="hospital_id" placeholder="hospital_id">
                                    <option value="">Select</option>
                                    @foreach ($hospitals as $key => $hospital_id)
                                        <option value="{{ $key }}" {{ in_array($key, old('hospitals', [])) ? 'selected' : '' }}>{{ $hospital_id }}</option>
                                    @endforeach
                                </select>
                               
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="opd_number">OPD Number.</label>
                                <input type="text" class="form-control @error('opd_number') is-invalid @enderror" name="opd_number" id="opd_number" value="{{old('opd_number')}}" placeholder="OPD Number">
                                @error('opd_number')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="age">Age.</label>
                                <input type="text" class="form-control @error('age') is-invalid @enderror" name="age" id="age" value="{{old('age')}}" placeholder="Age">
                                @error('age')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="age_month">Age Month.</label>
                                <input type="text" class="form-control @error('age_month') is-invalid @enderror" name="age_month" id="age_month" value="{{old('age_month')}}" placeholder="Age Month">
                                @error('age_month')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="village">Village</label>
                                <input type="text" class="form-control @error('village') is-invalid @enderror" name="village" id="village" value="{{old('village')}}" placeholder="Village">
                                @error('village')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="taluka">Taluka</label>
                                <input type="text" class="form-control @error('taluka') is-invalid @enderror" name="taluka" id="taluka" value="{{old('taluka')}}" placeholder="Taluka">
                                @error('taluka')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sex">Sex</label>
                                <input type="text" class="form-control @error('sex') is-invalid @enderror" name="sex" id="sex" value="{{old('sex')}}" placeholder="Sex">
                                @error('sex')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="mobile_number">Mobile</label>
                                <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" id="mobile_number" value="{{old('mobile_number')}}" placeholder="Mobile">
                                @error('mobile_number')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="opd_date">OPD date</label>
                                <input type="date" class="form-control @error('opd_date') is-invalid @enderror" name="opd_date" id="opd_date" value="{{old('opd_date')}}" placeholder="OPD Date">
                                @error('opd_date')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>


                            <div class="form-group col-md-3">
                                <label for="ipd_date">IPD Date</label>
                                <input type="date" class="form-control @error('ipd_date') is-invalid @enderror" name="ipd_date" id="ipd_date" value="{{old('ipd_date')}}" placeholder="IPD Date">
                                @error('ipd_date')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="lpd_no">LPD number</label>
                                <input type="text" class="form-control @error('lpd_no') is-invalid @enderror" name="lpd_no" id="lpd_no" value="{{old('lpd_no')}}" placeholder="LPD No">
                                @error('lpd_no')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            

                        </div>
                        <button type="button" id="save-patient-info" class="btn btn-primary">Save</button>
                    </form>           
                </div>

                <!-- General Examination Tab -->
                <div class="tab-pane fade" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
                    <form id="form-general-exam" method="post" action="{{ route('add-appointment') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="appointment_id" id="appointment_id" class="appointment_id">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="provisional">Provisional</label>
                                <input type="text" name="provisional" id="provisional" class="form-control" value="{{ old('provisional') }}">
                                @error('provisional')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="weight">Weight (KG)</label>
                                <input type="text" name="weight" id="weight" class="form-control" value="{{ old('weight') }}">
                                @error('weight')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="height">Height (CM)</label>
                                <input type="text" name="height" id="height" class="form-control" value="{{ old('height') }}">
                                @error('height')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="temprature">Temprature (CM)</label>
                                <input type="text" name="temprature" id="temprature" class="form-control" value="{{ old('temprature') }}">
                                @error('temprature')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="pulse">Pulse (/Min)</label>
                                <input type="text" name="pulse" id="pulse" class="form-control" value="{{ old('pulse') }}">
                                @error('pulse')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="bp">BP (mm OR Hg)</label>
                                <input type="text" name="bp" id="bp" class="form-control" value="{{ old('bp') }}">
                                @error('bp')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="spo2">SPO2</label>
                                <input type="text" name="spo2" id="spo2" class="form-control" value="{{ old('spo2') }}">
                                @error('spo2')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="rr">RR</label>
                                <input type="text" name="rr" id="rr" class="form-control" value="{{ old('rr') }}">
                                @error('rr')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="paller">Paller</label>
                                <input type="text" name="paller" id="paller" class="form-control" value="{{ old('paller') }}">
                                @error('paller')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="clubbing">Clubbing</label>
                                <input type="text" name="clubbing" id="clubbing" class="form-control" value="{{ old('clubbing') }}">
                                @error('clubbing')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="cyanosis">Cyanosis</label>
                                <input type="text" name="cyanosis" id="cyanosis" class="form-control" value="{{ old('cyanosis') }}">
                                @error('cyanosis')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="oedema">Oedema</label>
                                <input type="text" name="oedema" id="oedema" class="form-control" value="{{ old('oedema') }}">
                                @error('oedema')
                                <div class="invalid-feedback">
                                {{$message}}
                                </div>
                                @enderror
                            </div>


                        </div>
                        <button type="button" id="save-general-exam" class="btn btn-primary">Save</button>
                    </form>   
                </div>

                <!-- Systemic Examination Tab -->
                <div class="tab-pane fade" id="nav-systemic" role="tabpanel" aria-labelledby="nav-systemic-tab">
                    <form id="form-systemic-exam" method="post" action="{{ route('add-appointment') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="appointment_id" id="appointment_id" class="appointment_id">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="RS">RS</label>
                                <input type="text" name="RS" id="RS" class="form-control" value="{{ old('RS') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="cvs">CVS</label>
                                <input type="text" name="CVS" id="CVS" class="form-control" value="{{ old('CVS') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="CNS">CNS</label>
                                <input type="text" name="CNS" id="CNS" class="form-control" value="{{ old('CNS') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="PA">PA</label>
                                <input type="text" name="PA" id="PA" class="form-control" value="{{ old('PA') }}">
                            </div>
                        </div>
                        <button type="button" id="save-systemic-exam" class="btn btn-primary">Save</button>
                    </form>
                </div>

                <!-- Obstetric History Tab -->
                <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
                    <form id="form-history-exam" method="post" action="{{ route('add-appointment') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="appointment_id" id="appointment_id" class="appointment_id">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="LMP">LMP</label>
                                <input type="date" name="LMP" id="LMP" class="form-control" value="{{ old('LMP') }}">
                                @error('LMP')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="G">G</label>
                                <input type="text" name="G" id="G" class="form-control" value="{{ old('G') }}">
                                @error('G')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="P">P</label>
                                <input type="text" name="P" id="P" class="form-control" value="{{ old('P') }}">
                                @error('P')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="L">L</label>
                                <input type="text" name="L" id="L" class="form-control" value="{{ old('L') }}">
                                @error('L')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="A">A</label>
                                <input type="text" name="A" id="A" class="form-control" value="{{ old('A') }}">
                                @error('A')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="age_of_last_child">Age of Last Child</label>
                                <input type="text" name="age_of_last_child" id="age_of_last_child" class="form-control" value="{{ old('age_of_last_child') }}">
                                @error('age_of_last_child')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="type_of_last_delivery">Type of Last Delivery</label>
                                <input type="text" name="type_of_last_delivery" id="type_of_last_delivery" class="form-control" value="{{ old('type_of_last_delivery') }}">
                                @error('type_of_last_delivery')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="personal_ho">Personal H/O</label>
                                <textarea name="personal_ho" id="personal_ho" class="form-control">{{ old('personal_ho') }}</textarea>
                                @error('personal_ho')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="past_ho">Past H/O</label>
                                <textarea name="past_ho" id="past_ho" class="form-control">{{ old('past_ho') }}</textarea>
                                @error('past_ho')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <button type="button" id="save-history-exam" class="btn btn-primary">Save</button>
                    </form>
                </div>

                <div class="tab-pane fade" id="nav-complaint" role="tabpanel" aria-labelledby="nav-complaint-tab">
                    <form id="form-complaint-exam" method="post" action="{{ route('add-appointment') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="appointment_id" id="appointment_id" class="appointment_id">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="chief_complaint">Chief Complaint</label>
                                <textarea name="chief_complaint" id="chief_complaint" class="form-control">{{ old('chief_complaint') }}</textarea>
                                @error('chief_complaint')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="past_history">Past History</label>
                                <textarea name="past_history" id="past_history" class="form-control">{{ old('past_history') }}</textarea>
                                @error('past_history')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="family_history">Family History</label>
                                <textarea name="family_history" id="family_history" class="form-control">{{ old('family_history') }}</textarea>
                                @error('family_history')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="vitals_general_examination">Vitals / General Examination</label>
                                <textarea name="vitals_general_examination" id="vitals_general_examination" class="form-control">{{ old('vitals_general_examination') }}</textarea>
                                @error('vitals_general_examination')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="personal_history">Personal History</label>
                                <textarea name="personal_history" id="personal_history" class="form-control">{{ old('personal_history') }}</textarea>
                                @error('personal_history')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="allergic_history">Allergic History</label>
                                <textarea name="allergic_history" id="allergic_history" class="form-control">{{ old('allergic_history') }}</textarea>
                                @error('allergic_history')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="obstetric_history">Obstetric History</label>
                                <textarea name="obstetric_history" id="obstetric_history" class="form-control">{{ old('obstetric_history') }}</textarea>
                                @error('obstetric_history')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="treatment">Treatment</label>
                                <textarea name="treatment" id="treatment" class="form-control">{{ old('treatment') }}</textarea>
                                @error('treatment')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-3">
                                <label for="remarks">Remarks</label>
                                <textarea name="remarks" id="remarks" class="form-control">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            
            
                        </div>
                        <button type="button" id="save-complaint-exam" class="btn btn-primary">Save</button>
                    </form>
                </div>

                
            </div>
            {{-- <div class="mt-3">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form> --}}
    </div>
</div>
<script src="{{ asset('/js/appointment.js') }}"></script>
@endsection
