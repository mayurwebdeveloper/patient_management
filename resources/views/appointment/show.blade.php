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
            </div>
          </nav>

          <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                
   
            <div class="form-row">

            <div class="form-group col-md-3">
                <label for="appointment_status">Appointment Status : {{  $appointment->status }}</label>
            </div>

            <div class="form-group col-md-3">
                <label for="provisional">Provisional : {{  $appointment->provisional }}</label>
               
            </div>

            <div class="form-group col-md-3">
                <label for="doctor_id">Doctor : 
                    @foreach ($doctors as $key => $doctor)
                    {{ $appointment->doctor_id == $key ?   $doctor  : '' }}
                    @endforeach
                </label>
                
            </div>

            <div class="form-group col-md-3">
                <label for="hospital_id">Hospital : 
                    @foreach ($hospitals as $key => $hospital)
                    {{ $appointment->hospital_id == $key ?  $hospital : '' }} 
                 @endforeach

                </label>
                
            
            </div>

            <div class="form-group col-md-3">
                <label for="speciality_id">Speciality :   @foreach ($specialities as $key => $speciality)
                    {{ $appointment->speciality_id == $key ? $speciality : '' }}
                        
                @endforeach
                </label>
                
            </div>

            <div class="form-group col-md-3">
                <label for="opd_number">OPD Number : {{ $appointment->opd_number }}</label>
                
            </div>
            <div class="form-group col-md-3">
                <label for="patient_name">Patient Name : {{ $appointment->patient_name }}</label>
               
            
            </div>

            <div class="form-group col-md-3">
                <label for="age">Age : {{ $appointment->age }}</label>
              
            </div>
            <div class="form-group col-md-3">
                <label for="mobile_number">Mobile Number : {{ $appointment->mobile_number }}</label>
                
            </div>
            

            <div class="form-group col-md-3">
                <label for="opd_date">OPD date : {{ $appointment->opd_date }}</label>
               
            </div>



            

            </div>


            
            <div class="form-row">

                <h4> General Examination </h4>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="provisional">Provisional : {{ $appointment->provisional }}</label>
                    
                </div>
                
                <div class="form-group col-md-3">
                    <label for="weight">Weight (KG) : {{ $appointment->weight }}</label>
                    
                </div>

                <div class="form-group col-md-3">
                    <label for="height">Height (CM) : {{ $appointment->height }}</label>
                   
                </div>

                <div class="form-group col-md-3">
                    <label for="temperature">temperature (CM) : {{ $appointment->temperature }}</label>
                   
                </div>

                <div class="form-group col-md-3">
                    <label for="pulse">Pulse (/Min) : {{ $appointment->pulse }}</label>
                   
                </div>

                <div class="form-group col-md-3">
                    <label for="bp">BP (mm OR Hg) : {{ $appointment->bp }}</label>
                   
                </div>

                <div class="form-group col-md-3">
                    <label for="spo2">SPO2 : {{ $appointment->spo2 }}</label>

                </div>

                <div class="form-group col-md-3">
                    <label for="rr">RR : {{ $appointment->rr }}</label>
                    
                </div>

                <div class="form-group col-md-3">
                    <label for="paller">Paller : {{ $appointment->paller }}</label>
                   
                </div>

                <div class="form-group col-md-3">
                    <label for="clubbing">Clubbing : {{ $appointment->clubbing }}</label>
                   
                </div>

                <div class="form-group col-md-3">
                    <label for="cyanosis">Cyanosis : {{ $appointment->cyanosis }}</label>
                
                </div>

                <div class="form-group col-md-3">
                    <label for="oedema">Oedema : {{ $appointment->oedema }}</label>
                    
                </div>


            </div>
            <div class="form-row">

                <h4>Systemic Examination</h4>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="RS">RS : {{ $appointment->RS }}</label>
                   
                </div>
                
                <div class="form-group col-md-3">
                    <label for="CVS">CVS : {{ $appointment->CVS }} </label>
                  
                </div>
                
                <div class="form-group col-md-3">
                    <label for="CNS">CNS : {{ $appointment->CNS }}</label>
                    
                </div>
                
                <div class="form-group col-md-3">
                    <label for="PA">P/A : {{ $appointment->PA }}</label>
                   
                </div>
            </div>
            <div class="form-row">

                <h4>Obestetric History</h4>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                    <label for="LMP">LMP : {{ $appointment->LMP }}</label>
                  
                </div>
                
                <div class="form-group col-md-3">
                    <label for="G">G : {{ $appointment->G }}</label>
                   
                </div>
                
                <div class="form-group col-md-3">
                    <label for="P">P : {{ $appointment->P }}</label>
                   
                </div>
                
                <div class="form-group col-md-3">
                    <label for="L">L : {{ $appointment->L }}</label>
                    
                </div>
                
                <div class="form-group col-md-3">
                    <label for="A">A : {{ $appointment->A }}</label>
                 
                </div>
                
                <div class="form-group col-md-3">
                    <label for="age_of_last_child">Age of Last Child : {{ $appointment->age_of_last_child }}</label>
                    
                </div>
                
                <div class="form-group col-md-3">
                    <label for="type_of_last_delivery">Type of Last Delivery : {{ $appointment->type_of_last_delivery }}</label>
                    
                </div>
                
                <div class="form-group col-md-3">
                    <label for="personal_ho">Personal H/O : {{ $appointment->personal_ho }}</label>
                    
                </div>
                
                <div class="form-group col-md-3">
                    <label for="past_ho">Past H/O : {{ $appointment->past_ho }}</label>
                   
                </div>
            </div>
            <div class="form-row">

                <h4>Presenting Complaint</h4>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="chief_complaint">Chief Complaint : {{ $appointment->chief_complaint }}</label>
                  
                </div>
                
                <div class="form-group col-md-3">
                    <label for="past_history">Past History : {{ $appointment->past_history }}</label>
                   
                </div>
                
                <div class="form-group col-md-3">
                    <label for="family_history">Family History : {{ $appointment->family_history }}</label>
                   
                </div>
                
                <div class="form-group col-md-3">
                    <label for="vitals_general_examination">Vitals / General Examination : {{ $appointment->vitals_general_examination }}</label>
                   
                </div>
                
                <div class="form-group col-md-3">
                    <label for="personal_history">Personal History : {{ $appointment->personal_history }}</label>
                   
                </div>
                
                <div class="form-group col-md-3">
                    <label for="allergic_history">Allergic History : {{ $appointment->allergic_history }}</label>
                    
                </div>
                
                <div class="form-group col-md-3">
                    <label for="obstetric_history">Obstetric History : {{ $appointment->obstetric_history }}</label>
                 
                </div>
                
                <div class="form-group col-md-3">
                    <label for="treatment">Treatment : {{ $appointment->treatment }}</label>
                   
                </div>
                
                <div class="form-group col-md-3">
                    <label for="remarks">Remarks : {{ $appointment->remarks }}</label>
                  
                </div>
                

            </div>


           

            </div>
        </div>
          
    </div>
</div>



<!-- ajax for dynamic data -->
<script>

$(document).ready(function () {


let selectedState = "{{ old('state','12') }}";
let selectedDistrict = "{{ old('district') }}";
let selectedCity = "{{ old('city') }}";


// for address
if (selectedState) {
    initDistrict('#state',selectedDistrict);
}

if (selectedDistrict) {
    initCity('#district',selectedCity);
}

toggleDynamicField($('#is_pmjay').val());


//toggle hide/show on pmjay dropdown
$('#is_pmjay').change(function(){
    toggleDynamicField($(this).val());
});


});


function toggleDynamicField(selected){
    if(selected==1){
        $('#pmjay_description').show();
    }else{
        $('#pmjay_description').hide();
    }
}

function initDistrict(element,selected){

    let state = $(element).val();
    let url = "{{ route('get-district', ['id' => ':state']) }}";
    url = url.replace(':state', state);

    if (state) {
        $.ajax({
            type: 'GET',
            url: url,
            data: { state: state },
            selected: selected,
            async: false,  // Make the request synchronous
            success: function (data) {
                updateDistrictDropdown(data);
            },
            error: function (xhr, status, error) {
                console.error('Error:', status, error);
            },
            complete: function () {
                if(selected){
                    $('#district').val(selected);
                }
            }
        });
    }

}

function initCity(element,selected){

    let district = $(element).val();
    let url = "{{ route('get-subdivision', ['id' => ':district']) }}";
    url = url.replace(':district', district);

    if (district) {
        $.ajax({
            type: 'GET',
            url: url,
            data: { district: district },
            selected: selected,
            async: false,  // Make the request synchronous
            success: function (data) {
                updateCityDropdown(data);
            },
            error: function (xhr, status, error) {
                console.error('Error:', status, error);
            },
            complete: function () {
                if(selected){
                    $('#city').val(selected);
                }
            }
        });
    }

}

    // code for dynamic District list
    $('#state').change(function () {
        initDistrict(this);        
    });

    $('#district').change(function () {
        initCity(this);        
    });



    // Update State dropdown
    function updateStateDropdown(states) {
        let stateDropdown = $('#state');
        let districtDropdown = $('#district');
        let cityDropdown = $('#city');
        
        // Store the current selected state
        let selectedState = stateDropdown.val();

        // Clear existing options
        stateDropdown.empty();
        districtDropdown.empty();
        cityDropdown.empty();

        // Add a default option
        stateDropdown.append('<option value="">Select</option>');

        // Add options for each state
        $.each(states, function (index, state) {
            stateDropdown.append('<option value="' + state.state_id + '">' + state.state_title + '</option>');
        });

        // Set the selected state
        stateDropdown.val(selectedState);
    }

    // Update District dropdown
    function updateDistrictDropdown(districts) {
        let districtDropdown = $('#district');
        let cityDropdown = $('#city');
        
        // Store the current selected district
        let selectedDistrict = districtDropdown.val();

        // Clear existing options
        districtDropdown.empty();
        cityDropdown.empty();

        // Add options for each district
        $.each(districts, function (index, district) {
            districtDropdown.append('<option value="' + district.districtid + '">' + district.district_title + '</option>');
        });

        // Set the selected district
        districtDropdown.val(selectedDistrict);
    }


    // Update City dropdown
    function updateCityDropdown(cities) {
        let cityDropdown = $('#city');
        
        // Store the current selected city
        let selectedCity = cityDropdown.val();

        // Clear existing options
        cityDropdown.empty();

        // Add options for each city
        $.each(cities, function (index, city) {
            cityDropdown.append('<option value="' + city.id + '">' + city.name + '</option>');
        });

        // Set the selected city
        cityDropdown.val(selectedCity);
    }


</script>
@endsection
