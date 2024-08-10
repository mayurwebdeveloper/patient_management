@extends('layouts.main')


@push('title')
<title>Slider</title>
@endpush


@section('main-section')

<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Slider</h6>
    </div>
    <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="title">Title.</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{$slider->title}}" placeholder="Title">
                </div>
                <div class="form-group col-md-3">
                    <label for="code">Code.</label>
                    <input type="text" class="form-control" name="code" id="code" value="{{$slider->code}}" placeholder="Code">
                </div>
                <div class="form-group col-md-3">
                    <label for="status">Status.</label>
                    <select class="form-control" name="status" id="status" value="{{$slider->status}}" placeholder="Status">
                        <option value="1">Enable</option>
                        <option value="0" @if($slider->status == '0') {{ "selected" }} @endif >Disable</option>
                    </select>
                </div>

            </div>


            <div class="form-row">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table class="table table-bordered table-hover" id="dynamic_field">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Slides</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach($slides as $slide)
                                    <tr id="row{{ $i }}">
                                        <td>
                                            {!! \App\Helpers\Helper::docfileType($slide->slide) !!}
                                        </td>
                                    </tr>
                                    @php
                                    $i = $i+1;
                                    @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
</div>

@endsection
