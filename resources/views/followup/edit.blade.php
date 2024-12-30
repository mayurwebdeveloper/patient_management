@extends('layouts.main')


@push('title')
<title>Edit Followup</title>
@endpush


@section('main-section')


<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Edit Followup</h6>
    </div>
    <div class="card-body">


        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-coreui-toggle="tab" data-coreui-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
            </div>
          </nav>

          <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                
        <form method="post" action="{{ route('followup.update', $appointment->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                        
                
                
                <div class="form-group col-md-3">
                    <label for="opd_number">Patient Name :</label>
                    <input type="text" class="form-control" value="{{ $appointment->patient->name }}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label for="opd_number">Doctor Name :</label>
                    <input type="text" class="form-control" value="{{ $appointment->doctor->name }}" disabled>
                </div>


                <div class="form-group col-md-3">
                    <label for="opd_number">Hospital Name :</label>
                    <input type="text" class="form-control" value="{{ $appointment->hospital->name }}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label for="opd_number">Speciality Name :</label>
                    <input type="text" class="form-control" value="{{ $appointment->speciality->title }}" disabled>
                </div>


                <!-- OPD Number -->
                <div class="form-group col-md-3">
                    <label for="opd_number">OPD Number</label>
                    <input type="text" name="opd_number" id="opd_number" class="form-control @error('opd_number') is-invalid @enderror" value="{{ $appointment->opd_number }}">
                    @error('opd_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            
                <!-- Age -->
                
            
                <!-- OPD Date -->
                <div class="form-group col-md-3">
                    <label for="opd_date">OPD Date</label>
                    <input type="date" name="opd_date" id="opd_date" class="form-control @error('opd_date') is-invalid @enderror" value="{{ $appointment->opd_date }}">
                    @error('opd_date')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-row">

                <h4> General Examination </h4>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="provisional">Provisional</label>
                    <input type="text" name="provisional" id="provisional" class="form-control" value="{{ $appointment->provisional }}">
                    @error('provisional')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="weight">Weight (KG)</label>
                    <input type="text" name="weight" id="weight" class="form-control" value="{{ $appointment->weight }}">
                    @error('weight')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="height">Height (CM)</label>
                    <input type="text" name="height" id="height" class="form-control" value="{{ $appointment->height }}">
                    @error('height')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="temperature">temperature (CM)</label>
                    <input type="text" name="temperature" id="temperature" class="form-control" value="{{ $appointment->temperature }}">
                    @error('temprature')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="pulse">Pulse (/Min)</label>
                    <input type="text" name="pulse" id="pulse" class="form-control" value="{{ $appointment->pulse }}">
                    @error('pulse')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="bp">BP (mm OR Hg)</label>
                    <input type="text" name="bp" id="bp" class="form-control" value="{{ $appointment->bp }}">
                    @error('bp')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="spo2">SPO2</label>
                    <input type="text" name="spo2" id="spo2" class="form-control" value="{{ $appointment->spo2 }}">
                    @error('spo2')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="rr">RR</label>
                    <input type="text" name="rr" id="rr" class="form-control" value="{{ $appointment->rr }}">
                    @error('rr')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="paller">Paller</label>
                    <input type="text" name="paller" id="paller" class="form-control" value="{{ $appointment->paller }}">
                    @error('paller')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="clubbing">Clubbing</label>
                    <input type="text" name="clubbing" id="clubbing" class="form-control" value="{{ $appointment->clubbing }}">
                    @error('clubbing')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="cyanosis">Cyanosis</label>
                    <input type="text" name="cyanosis" id="cyanosis" class="form-control" value="{{ $appointment->cyanosis }}">
                    @error('cyanosis')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="oedema">Oedema</label>
                    <input type="text" name="oedema" id="oedema" class="form-control" value="{{ $appointment->oedema }}">
                    @error('oedema')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>


            </div>
            <div class="form-row">

                <h4>Systemic Examination</h4>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="RS">RS</label>
                    <input type="text" name="RS" id="RS" class="form-control" value="{{ $appointment->RS }}">
                    @error('RS')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="CVS">CVS</label>
                    <input type="text" name="CVS" id="CVS" class="form-control" value="{{ $appointment->CVS }}">
                    @error('CVS')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="CNS">CNS</label>
                    <input type="text" name="CNS" id="CNS" class="form-control" value="{{ $appointment->CNS }}">
                    @error('CNS')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="PA">P/A</label>
                    <input type="text" name="PA" id="PA" class="form-control" value="{{ $appointment->PA }}">
                    @error('PA')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-row">

                <h4>Obestetric History</h4>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                    <label for="LMP">LMP</label>
                    <input type="date" name="LMP" id="LMP" class="form-control" value="{{ $appointment->LMP }}">
                    @error('LMP')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="G">G</label>
                    <input type="text" name="G" id="G" class="form-control" value="{{ $appointment->G }}">
                    @error('G')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="P">P</label>
                    <input type="text" name="P" id="P" class="form-control" value="{{ $appointment->P }}">
                    @error('P')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="L">L</label>
                    <input type="text" name="L" id="L" class="form-control" value="{{ $appointment->L }}">
                    @error('L')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="A">A</label>
                    <input type="text" name="A" id="A" class="form-control" value="{{ $appointment->A }}">
                    @error('A')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="age_of_last_child">Age of Last Child</label>
                    <input type="text" name="age_of_last_child" id="age_of_last_child" class="form-control" value="{{ $appointment->age_of_last_child }}">
                    @error('age_of_last_child')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="type_of_last_delivery">Type of Last Delivery</label>
                    <input type="text" name="type_of_last_delivery" id="type_of_last_delivery" class="form-control" value="{{ $appointment->type_of_last_delivery }}">
                    @error('type_of_last_delivery')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="personal_ho">Personal H/O</label>
                    <textarea name="personal_ho" id="personal_ho" class="form-control">{{ $appointment->personal_ho }}</textarea>
                    @error('personal_ho')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="past_ho">Past H/O</label>
                    <textarea name="past_ho" id="past_ho" class="form-control">{{ $appointment->past_ho }}</textarea>
                    @error('past_ho')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-row">

                <h4>Presenting Complaint</h4>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="chief_complaint">Chief Complaint</label>
                    <textarea name="chief_complaint" id="chief_complaint" class="form-control">{{ $appointment->chief_complaint }}</textarea>
                    @error('chief_complaint')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="past_history">Past History</label>
                    <textarea name="past_history" id="past_history" class="form-control">{{ $appointment->past_history }}</textarea>
                    @error('past_history')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="family_history">Family History</label>
                    <textarea name="family_history" id="family_history" class="form-control">{{ $appointment->family_history }}</textarea>
                    @error('family_history')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="vitals_general_examination">Vitals / General Examination</label>
                    <textarea name="vitals_general_examination" id="vitals_general_examination" class="form-control">{{ $appointment->vitals_general_examination }}</textarea>
                    @error('vitals_general_examination')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="personal_history">Personal History</label>
                    <textarea name="personal_history" id="personal_history" class="form-control">{{ $appointment->personal_history }}</textarea>
                    @error('personal_history')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="allergic_history">Allergic History</label>
                    <textarea name="allergic_history" id="allergic_history" class="form-control">{{ $appointment->allergic_history }}</textarea>
                    @error('allergic_history')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="obstetric_history">Obstetric History</label>
                    <textarea name="obstetric_history" id="obstetric_history" class="form-control">{{ $appointment->obstetric_history }}</textarea>
                    @error('obstetric_history')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="treatment">Treatment</label>
                    <textarea name="treatment" id="treatment" class="form-control">{{ $appointment->treatment }}</textarea>
                    @error('treatment')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="remarks">Remarks</label>
                    <textarea name="remarks" id="remarks" class="form-control">{{ $appointment->remarks }}</textarea>
                    @error('remarks')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                

            </div>


            <button type="submit" class="btn btn-primary">Update</button>
        </form>

            </div>
        </div>
          
    </div>
</div>




@endsection
