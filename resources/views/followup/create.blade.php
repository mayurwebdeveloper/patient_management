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


        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-coreui-toggle="tab" data-coreui-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
              <button class="nav-link" id="nav-profile-tab" data-coreui-toggle="tab" data-coreui-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
              <button class="nav-link" id="nav-contact-tab" data-coreui-toggle="tab" data-coreui-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
            </div>
          </nav>

          <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                
        <form method="post" action="{{ route('add-followup') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <!-- Appointment ID -->
                <div class="form-group col-md-3">
                    <label for="appointment_id">Appointment ID</label>
                    <input type="text" name="appointment_id" id="appointment_id" class="form-control" value="{{ old('appointment_id') }}">
                    @error('appointment_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Patient ID -->
                <div class="form-group col-md-3">
                    <label for="patient_id">Patient ID</label>
                    <input type="text" name="patient_id" id="patient_id" class="form-control" value="{{ old('patient_id') }}">
                    @error('patient_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Doctor ID -->
                <div class="form-group col-md-3">
                    <label for="doctor_id">Doctor ID</label>
                    <input type="text" name="doctor_id" id="doctor_id" class="form-control" value="{{ old('doctor_id') }}">
                    @error('doctor_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Hospital ID -->
                <div class="form-group col-md-3">
                    <label for="hospital_id">Hospital ID</label>
                    <input type="text" name="hospital_id" id="hospital_id" class="form-control" value="{{ old('hospital_id') }}">
                    @error('hospital_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Speciality ID -->
                <div class="form-group col-md-3">
                    <label for="speciality_id">Speciality ID</label>
                    <input type="text" name="speciality_id" id="speciality_id" class="form-control" value="{{ old('speciality_id') }}">
                    @error('speciality_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Appointment Date -->
                <div class="form-group col-md-3">
                    <label for="appointment_date">Appointment Date</label>
                    <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ old('appointment_date') }}">
                    @error('appointment_date')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Date -->
                <div class="form-group col-md-3">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}">
                    @error('date')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Time Slot -->
                <div class="form-group col-md-3">
                    <label for="time_slot">Time Slot</label>
                    <input type="text" name="time_slot" id="time_slot" class="form-control" value="{{ old('time_slot') }}">
                    @error('time_slot')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Title -->
                <div class="form-group col-md-3">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Description -->
                <div class="form-group col-md-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Status -->
                <div class="form-group col-md-3">
                    <label for="status">Status</label>
                    <input type="text" name="status" id="status" class="form-control" value="{{ old('status') }}">
                    @error('status')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Scheduled -->
                <div class="form-group col-md-3">
                    <label for="scheduled">Scheduled</label>
                    <input type="text" name="scheduled" id="scheduled" class="form-control" value="{{ old('scheduled') }}">
                    @error('scheduled')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Patient Name -->
                <div class="form-group col-md-3">
                    <label for="patient_name">Patient Name</label>
                    <input type="text" name="patient_name" id="patient_name" class="form-control" value="{{ old('patient_name') }}">
                    @error('patient_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- OPD Number -->
                <div class="form-group col-md-3">
                    <label for="opd_number">OPD Number</label>
                    <input type="text" name="opd_number" id="opd_number" class="form-control" value="{{ old('opd_number') }}">
                    @error('opd_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Age -->
                <div class="form-group col-md-3">
                    <label for="age">Age</label>
                    <input type="text" name="age" id="age" class="form-control" value="{{ old('age') }}">
                    @error('age')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Age Month -->
                <div class="form-group col-md-3">
                    <label for="age_month">Age in Months</label>
                    <input type="text" name="age_month" id="age_month" class="form-control" value="{{ old('age_month') }}">
                    @error('age_month')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Mobile Number -->
                <div class="form-group col-md-3">
                    <label for="mobile_number">Mobile Number</label>
                    <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{ old('mobile_number') }}">
                    @error('mobile_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Sex -->
                <div class="form-group col-md-3">
                    <label for="sex">Sex</label>
                    <input type="text" name="sex" id="sex" class="form-control" value="{{ old('sex') }}">
                    @error('sex')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Village -->
                <div class="form-group col-md-3">
                    <label for="village">Village</label>
                    <input type="text" name="village" id="village" class="form-control" value="{{ old('village') }}">
                    @error('village')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Taluka -->
                <div class="form-group col-md-3">
                    <label for="taluka">Taluka</label>
                    <input type="text" name="taluka" id="taluka" class="form-control" value="{{ old('taluka') }}">
                    @error('taluka')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- OPD Date -->
                <div class="form-group col-md-3">
                    <label for="opd_date">OPD Date</label>
                    <input type="date" name="opd_date" id="opd_date" class="form-control" value="{{ old('opd_date') }}">
                    @error('opd_date')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Provisional -->
                <div class="form-group col-md-3">
                    <label for="provisional">Provisional</label>
                    <input type="text" name="provisional" id="provisional" class="form-control" value="{{ old('provisional') }}">
                    @error('provisional')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Weight -->
                <div class="form-group col-md-3">
                    <label for="weight">Weight (KG)</label>
                    <input type="text" name="weight" id="weight" class="form-control" value="{{ old('weight') }}">
                    @error('weight')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Height -->
                <div class="form-group col-md-3">
                    <label for="height">Height (CM)</label>
                    <input type="text" name="height" id="height" class="form-control" value="{{ old('height') }}">
                    @error('height')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Temperature -->
                <div class="form-group col-md-3">
                    <label for="temperature">Temperature</label>
                    <input type="text" name="temperature" id="temperature" class="form-control" value="{{ old('temperature') }}">
                    @error('temperature')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Pulse -->
                <div class="form-group col-md-3">
                    <label for="pulse">Pulse</label>
                    <input type="text" name="pulse" id="pulse" class="form-control" value="{{ old('pulse') }}">
                    @error('pulse')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- BP -->
                <div class="form-group col-md-3">
                    <label for="bp">Blood Pressure</label>
                    <input type="text" name="bp" id="bp" class="form-control" value="{{ old('bp') }}">
                    @error('bp')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- SPO2 -->
                <div class="form-group col-md-3">
                    <label for="spo2">SPO2</label>
                    <input type="text" name="spo2" id="spo2" class="form-control" value="{{ old('spo2') }}">
                    @error('spo2')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- RR -->
                <div class="form-group col-md-3">
                    <label for="rr">RR</label>
                    <input type="text" name="rr" id="rr" class="form-control" value="{{ old('rr') }}">
                    @error('rr')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Paller -->
                <div class="form-group col-md-3">
                    <label for="paller">Paller</label>
                    <input type="text" name="paller" id="paller" class="form-control" value="{{ old('paller') }}">
                    @error('paller')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Clubbing -->
                <div class="form-group col-md-3">
                    <label for="clubbing">Clubbing</label>
                    <input type="text" name="clubbing" id="clubbing" class="form-control" value="{{ old('clubbing') }}">
                    @error('clubbing')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Cyanosis -->
                <div class="form-group col-md-3">
                    <label for="cyanosis">Cyanosis</label>
                    <input type="text" name="cyanosis" id="cyanosis" class="form-control" value="{{ old('cyanosis') }}">
                    @error('cyanosis')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Oedema -->
                <div class="form-group col-md-3">
                    <label for="oedema">Oedema</label>
                    <input type="text" name="oedema" id="oedema" class="form-control" value="{{ old('oedema') }}">
                    @error('oedema')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- RS -->
                <div class="form-group col-md-3">
                    <label for="RS">RS</label>
                    <textarea name="RS" id="RS" class="form-control">{{ old('RS') }}</textarea>
                    @error('RS')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- CVS -->
                <div class="form-group col-md-3">
                    <label for="CVS">CVS</label>
                    <textarea name="CVS" id="CVS" class="form-control">{{ old('CVS') }}</textarea>
                    @error('CVS')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- CNS -->
                <div class="form-group col-md-3">
                    <label for="CNS">CNS</label>
                    <textarea name="CNS" id="CNS" class="form-control">{{ old('CNS') }}</textarea>
                    @error('CNS')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- PA -->
                <div class="form-group col-md-3">
                    <label for="PA">PA</label>
                    <textarea name="PA" id="PA" class="form-control">{{ old('PA') }}</textarea>
                    @error('PA')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- LMP -->
                <div class="form-group col-md-3">
                    <label for="LMP">LMP</label>
                    <input type="date" name="LMP" id="LMP" class="form-control" value="{{ old('LMP') }}">
                    @error('LMP')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- G -->
                <div class="form-group col-md-3">
                    <label for="G">G</label>
                    <input type="text" name="G" id="G" class="form-control" value="{{ old('G') }}">
                    @error('G')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- P -->
                <div class="form-group col-md-3">
                    <label for="P">P</label>
                    <input type="text" name="P" id="P" class="form-control" value="{{ old('P') }}">
                    @error('P')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- L -->
                <div class="form-group col-md-3">
                    <label for="L">L</label>
                    <input type="text" name="L" id="L" class="form-control" value="{{ old('L') }}">
                    @error('L')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- A -->
                <div class="form-group col-md-3">
                    <label for="A">A</label>
                    <input type="text" name="A" id="A" class="form-control" value="{{ old('A') }}">
                    @error('A')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Age of Last Child -->
                <div class="form-group col-md-3">
                    <label for="age_of_last_child">Age of Last Child</label>
                    <input type="text" name="age_of_last_child" id="age_of_last_child" class="form-control" value="{{ old('age_of_last_child') }}">
                    @error('age_of_last_child')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Type of Last Delivery -->
                <div class="form-group col-md-3">
                    <label for="type_of_last_delivery">Type of Last Delivery</label>
                    <input type="text" name="type_of_last_delivery" id="type_of_last_delivery" class="form-control" value="{{ old('type_of_last_delivery') }}">
                    @error('type_of_last_delivery')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Personal H/O -->
                <div class="form-group col-md-3">
                    <label for="personal_ho">Personal H/O</label>
                    <textarea name="personal_ho" id="personal_ho" class="form-control">{{ old('personal_ho') }}</textarea>
                    @error('personal_ho')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Past H/O -->
                <div class="form-group col-md-3">
                    <label for="past_ho">Past H/O</label>
                    <textarea name="past_ho" id="past_ho" class="form-control">{{ old('past_ho') }}</textarea>
                    @error('past_ho')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Chief Complaint -->
                <div class="form-group col-md-3">
                    <label for="chief_complaint">Chief Complaint</label>
                    <textarea name="chief_complaint" id="chief_complaint" class="form-control">{{ old('chief_complaint') }}</textarea>
                    @error('chief_complaint')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Past History -->
                <div class="form-group col-md-3">
                    <label for="past_history">Past History</label>
                    <textarea name="past_history" id="past_history" class="form-control">{{ old('past_history') }}</textarea>
                    @error('past_history')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Family History -->
                <div class="form-group col-md-3">
                    <label for="family_history">Family History</label>
                    <textarea name="family_history" id="family_history" class="form-control">{{ old('family_history') }}</textarea>
                    @error('family_history')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Vitals/General Examination -->
                <div class="form-group col-md-3">
                    <label for="vitals_general_examination">Vitals/General Examination</label>
                    <textarea name="vitals_general_examination" id="vitals_general_examination" class="form-control">{{ old('vitals_general_examination') }}</textarea>
                    @error('vitals_general_examination')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Personal History -->
                <div class="form-group col-md-3">
                    <label for="personal_history">Personal History</label>
                    <textarea name="personal_history" id="personal_history" class="form-control">{{ old('personal_history') }}</textarea>
                    @error('personal_history')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Allergic History -->
                <div class="form-group col-md-3">
                    <label for="allergic_history">Allergic History</label>
                    <textarea name="allergic_history" id="allergic_history" class="form-control">{{ old('allergic_history') }}</textarea>
                    @error('allergic_history')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Treatment Given -->
                <div class="form-group col-md-3">
                    <label for="treatment_given">Treatment Given</label>
                    <textarea name="treatment_given" id="treatment_given" class="form-control">{{ old('treatment_given') }}</textarea>
                    @error('treatment_given')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Remarks -->
                <div class="form-group col-md-3">
                    <label for="remarks">Remarks</label>
                    <textarea name="remarks" id="remarks" class="form-control">{{ old('remarks') }}</textarea>
                    @error('remarks')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Next Appointment -->
                <div class="form-group col-md-3">
                    <label for="next_appointment">Next Appointment</label>
                    <input type="date" name="next_appointment" id="next_appointment" class="form-control" value="{{ old('next_appointment') }}">
                    @error('next_appointment')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Signature -->
                <div class="form-group col-md-3">
                    <label for="signature">Signature</label>
                    <input type="text" name="signature" id="signature" class="form-control" value="{{ old('signature') }}">
                    @error('signature')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            

            </div>

            <button type="submit" class="btn btn-primary">save</button>
        </form>

            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
          </div>
          
    </div>
</div>


