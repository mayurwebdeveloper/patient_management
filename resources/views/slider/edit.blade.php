@extends('layouts.main')


@push('title')
<title>Edit Slider</title>
@endpush


@section('main-section')

<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Edit Slider</h6>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('update-slider') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="slider_id" value="{{ $slider->id }}">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="title">Title.</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{old('title', $slider->title)}}" placeholder="Title">
                    @error('title')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>


                <div class="form-group col-md-3">
                    <label for="code">Code.</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{old('code', $slider->code)}}" placeholder="Code">
                    @error('code')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="status">Status.</label>
                    <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" value="{{old('status')}}" placeholder="Status">
                        <option value="1">Enable</option>
                        <option value="0" @if($slider->status == '0') {{ "selected" }} @endif >Disable</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

            </div>


            <button type="button" name="add" id="add" class="btn btn-primary mb-4"><i class="fa fa-plus" aria-hidden="true"></i> Add Slide</button>

            <div class="form-row">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table class="table table-bordered table-hover" id="dynamic_field">
                                    <!-- dynamicly add slides field -->
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach($slides as $slide)
                                    <tr id="row{{ $i }}">
                                        <td>
                                            <input type="hidden" name="slide_id[]" value="{{ $slide->id }}" required />
                                            <input type="hidden" name="old_slides[]" value="{{ $slide->slide }}" required />
                                            {!! \App\Helpers\Helper::docfileType($slide->slide) !!}
                                        </td>
                                        <td><button type="button" name="remove" id="{{ $i }}" class="btn btn-danger btn_remove"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                                    </tr>
                                    @php
                                    $i = $i+1;
                                    @endphp
                                    @endforeach
                                    <!-- dynamicly add slides field end-->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">save</button>
        </form>

    </div>
</div>

<script>

$(document).ready(function(){
    
    var i = "{{ $slideCount }}";

    $("#add").click(function() {
        i++;
        $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="file" name="slides[]" required class="form-control"/></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function() {
        let button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });
});

</script>

@endsection
