@extends('layouts.main')


@push('title')
<title>Hospital</title>
@endpush


@section('main-section')


<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Hospital</h6>
    </div>
    <div class="card-body">    

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Hospital Name.</label>
                    <input type="text" class="form-control" disabled name="name" id="name" value="{{ $hospital->name }}" placeholder="Hospital Name">
                </div>

                <div class="form-group col-md-6">
                    <label for="speciality_type">Speciality Type.</label>
                    <select class="form-control" id="speciality_type" placeholder="Speciality Type">
                        <option value="1">Single</option>
                        <option value="2" @if($hospital->speciality_type == 2) selected @endif>Multi Speciality</option>
                    </select>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="type">Type.</label>
                    <select class="form-control" disabled name="type" id="type" placeholder="Type">
                        <option value="">Select</option>
                        @foreach ($types as $type)
                            <option value="{{ $type }}" {{ $hospital->type == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="sector">Sector.</label>
                    <select class="form-control" id="sector" disabled value="{{$hospital->sector}}" placeholder="Sector">
                        <option value="">Select</option>
                        @foreach ($sectors as $sector)
                            <option value="{{ $sector }}" {{ $hospital->sector == $sector ? 'selected' : '' }}>{{ $sector }}</option>
                        @endforeach
                    </select>
                </div>

            </div>


            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="specialities">Specialities.</label>
                    <select multiple disabled class="form-control @error('specialities') is-invalid @enderror" name="specialities[]" id="specialities" placeholder="Specialities">
                        @foreach ($specialities as $speciality)
                            <option value="{{ $speciality }}" {{ in_array($speciality, explode(',', $hospital->specialities)) ? 'selected' : '' }}>{{ $speciality }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="mo">Phone no.</label>
                    <input type="text" class="form-control" disabled name="mo" id="mo" value="{{ $hospital->mo }}" placeholder="Phone no">
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" disabled name="email" id="email" value="{{$hospital->email }}" placeholder="Email">
                </div>

            </div>


            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea name="description" id="description-show" class="form-control" disabled rows="4" placeholder="Description">{{$hospital->description}}</textarea>
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="state">State.</label>
                    <select class="form-control" disabled name="state" id="state" placeholder="state">
                        <option value="">Select</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->state_id }}" {{ $hospital->state_id == $state->state_id ? 'selected' : '' }}>{{ $state->state_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="district">District.</label>
                    <select class="form-control" disabled name="district" id="district" placeholder="district">
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="city">Sub division.</label>
                    <select class="form-control" disabled name="city" id="city" placeholder="Sub division">
                    </select>
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="address">Address</label>
                    <textarea name="address" id="" class="form-control" disabled rows="4" placeholder="Address">{{$hospital->address}}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="location">Location Link.</label>
                    <input type="text" class="form-control"  id="location" value="{{$hospital->location}}" placeholder="Location Link">
                </div>
            </div>



            <div class="form-row">
                @isset($hospital->image)
                <div class="form-group col-md-4">
                    <label for="image">Image</label>
                    <img src="{!! asset('images/hospital/photos/') !!}/{{$hospital->image ?? 'no-img.png'}}" alt="hospital-photo" width="100px">
                </div>
                @endisset
                
                @isset($hospital->brochure)
                <div class="form-group col-md-4">
                    <label for="brochure">Brochure</label>
                        <a target="_blank" href="{!! asset('images/hospital/brochures/') !!}/{{$hospital->brochure}}">{{$hospital->brochure}}</a>
                    </div>   
                @endisset

                <div class="form-group col-md-4">
                    <label for="status">Status.</label>
                    <select class="form-control" disabled name="status" id="status" placeholder="Status">
                        <option value="1">Enable</option>
                        <option value="0" {{ $hospital->status == '0' ? 'selected' : '' }}>Disable</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="is_pmjay">PMJAY-MA.</label>
                    <select class="form-control" disabled name="is_pmjay" id="is_pmjay" placeholder="PMJAY-MA">
                        <option value="0">No</option>
                        <option value="1" @if($hospital->is_pmjay == 1) selected @endif>Yes</option>
                    </select>
                </div>
            </div>


            <div class="form-row" id="pmjay_description">
                <div class="form-group col-md-12">
                    <label for="pmjay_description">PmJay Description</label>
                    <textarea name="pmjay_description" id="pmjay_description_box" class="form-control" disabled rows="4" disabled readonly >{{$hospital->pmjay_description}}</textarea>
                </div>
            </div>

    </div>
</div>

<!-- ajax for dynamic data -->
<script>

$(document).ready(function () {

let selectedState = "{{ $hospital->state_id }}";
let selectedDistrict = "{{ $hospital->district_id }}";
let selectedCity = "{{ $hospital->subdivision_id }}";



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
