@extends('layouts.main')


@push('title')
<title>Edit Hospital</title>
@endpush


@section('main-section')


<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Edit Hospital</h6>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('update-hospital') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Hospital Name.</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name', $hospital->name )}}" placeholder="Hospital Name">
                    @error('name')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="speciality_type">Speciality Type.</label>
                    <select class="form-control @error('speciality_type') is-invalid @enderror" name="speciality_type" id="speciality_type" placeholder="Speciality Type">
                        <option value="1" @if(old('speciality_type') == 1) selected @endif>Single</option>
                        <option value="2" @if(old('speciality_type', $hospital->speciality_type) == 2) selected @endif>Multi Speciality</option>
                    </select>
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="type">Type.</label>
                    <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" value="{{old('type', $hospital->type )}}" placeholder="Type">
                        <option value="">Select</option>
                        @foreach ($types as $type)
                            <option value="{{ $type }}" {{ old('type', $hospital->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="sector">Sector.</label>
                    <select class="form-control @error('sector') is-invalid @enderror" name="sector" id="sector" value="{{old('sector', $hospital->sector)}}" placeholder="Sector">
                        <option value="">Select</option>
                        @foreach ($sectors as $sector)
                            <option value="{{ $sector }}" {{ old('sector', $hospital->sector) == $sector ? 'selected' : '' }}>{{ $sector }}</option>
                        @endforeach
                    </select>
                    @error('sector')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

            </div>


            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="specialities">Specialities.</label>
                    <select multiple required class="form-control @error('specialities') is-invalid @enderror" name="specialities[]" id="specialities" placeholder="Specialities">
                        @foreach ($specialities as $speciality)
                            <option value="{{ $speciality }}" {{ in_array($speciality, old('specialities', explode(',', $hospital->specialities))) ? 'selected' : '' }}>{{ $speciality }}</option>
                        @endforeach
                    </select>
                    @error('specialities')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>



            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="mo">Phone no.</label>
                    <input type="text" class="form-control @error('mo') is-invalid @enderror" name="mo" id="mo" value="{{old('mo', $hospital->mo )}}" placeholder="Phone no">
                    @error('mo')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{old('email', $hospital->email )}}" placeholder="Email">
                    @error('email')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

            </div>


            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Description">{{old('description', $hospital->description)}}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="state">State.</label>
                    <select class="form-control @error('state') is-invalid @enderror" name="state" id="state" placeholder="state">
                        <option value="">Select</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->state_id }}" {{ old('state',$hospital->state_id) == $state->state_id ? 'selected' : '' }}>{{ $state->state_title }}</option>
                        @endforeach
                    </select>
                    @error('state')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="district">District.</label>
                    <select class="form-control @error('district') is-invalid @enderror" name="district" id="district" placeholder="district">
                    </select>
                    @error('district')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="city">Sub division.</label>
                    <select class="form-control @error('city') is-invalid @enderror" name="city" id="city" placeholder="Sub division">
                    </select>
                    @error('city')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="address">Address</label>
                    <textarea name="address" id="" class="form-control @error('address') is-invalid @enderror" rows="4" placeholder="Address">{{old('address', $hospital->address)}}</textarea>
                    @error('address')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="location">Location Link.</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" id="location" value="{{old('location', $hospital->location)}}" placeholder="Location Link">
                    @error('location')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
            </div>



            <div class="form-row">

                <div class="form-group col-md-4">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" name="image" id="image" placeholder="Image">
                    @isset($hospital->image)
                    <img src="{!! asset('images/hospital/photos/') !!}/{{$hospital->image ?? 'no-img.png'}}" alt="hospital-photo" width="100px">
                    @endisset
                </div>

                <div class="form-group col-md-4">
                    <label for="brochure">Brochure</label>
                    <input type="file" class="form-control" name="brochure" id="brochure" placeholder="Brochure">
                    @isset($hospital->brochure)
                        <a target="_blank" href="{!! asset('images/hospital/brochures/') !!}/{{$hospital->brochure}}">{{$hospital->brochure}}</a>
                    @endisset
                </div>    

                <div class="form-group col-md-4">
                    <label for="status">Status.</label>
                    <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" value="{{old('status')}}" placeholder="Status">
                        <option value="1">Enable</option>
                        <option value="0" {{ old('status', $hospital->status) == '0' ? 'selected' : '' }}>Disable</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

            </div>


            <div class="form-row">

                <div class="form-group col-md-4">
                    <label for="is_pmjay">PMJAY-MA.</label>
                    <select class="form-control @error('is_pmjay') is-invalid @enderror" name="is_pmjay" id="is_pmjay" placeholder="PMJAY-MA">
                        <option value="0">No</option>
                        <option value="1" @if(old('is_pmjay', $hospital->is_pmjay) == 1) selected @endif>Yes</option>
                    </select>
                </div>

            </div>

            <div class="form-row" id="pmjay_description">
                <div class="form-group col-md-12">
                    <label for="pmjay_description">PmJay Description</label>
                    <textarea name="pmjay_description" id="pmjay_description_box" class="form-control @error('pmjay_description') is-invalid @enderror" rows="4" >{{old('pmjay_description', $hospital->pmjay_description)}}</textarea>
                    @error('pmjay_description')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">save</button>
        </form>

    </div>
</div>

<!-- ajax for dynamic data -->
<script>

$(document).ready(function () {

let selectedState = "{{ old('state', $hospital->state_id) }}";
let selectedDistrict = "{{ old('district', $hospital->district_id) }}";
let selectedCity = "{{ old('city', $hospital->subdivision_id) }}";



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
