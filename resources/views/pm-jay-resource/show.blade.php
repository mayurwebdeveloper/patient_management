@extends('layouts.main')


@push('title')
<title>PM JAY Resource</title>
@endpush


@section('main-section')


<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">PM JAY Resource</h6>
    </div>
    <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="title">PM JAY Resource Name.</label>
                    <input type="text" class="form-control" disabled name="title" id="title" value="{{$pmjay_resource->title}}" placeholder="PM JAY Resource Title">
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea disabled name="description" id="description-show" class="form-control" rows="4" placeholder="Description">{{$pmjay_resource->description}}</textarea>
                </div>
            </div>

            <div class="form-row">

                @isset($pmjay_resource->document)
                <div class="form-group col-md-12">
                    <label for="document_title">Document title.</label>
                    <input type="text" disabled class="form-control @error('document_title') is-invalid @enderror" name="document_title" id="document_title" value="{{old('document_title', $pmjay_resource->document_title)}}" placeholder="Document title">
                </div>
                @endisset

                @isset($pmjay_resource->document)
                <div class="form-group col-md-4">
                    <label for="document">document</label>
                        <a target="_blank" href="{!! asset('images/pmjay/documents/') !!}/{{$pmjay_resource->document}}">{{$pmjay_resource->document_title}}</a>
                    </div>   
                @endisset
                
            </div>

            <div class="form-row">

                <div class="form-group col-md-4">
                    <label for="status">Status.</label>
                    <select class="form-control" disabled name="status" id="status" value="{{old('status')}}" placeholder="Status">
                        <option value="1">Enable</option>
                        <option value="0" {{ $pmjay_resource->status == '0' ? 'selected' : '' }}>Disable</option>
                    </select>
                </div>
            </div>
    </div>
</div>

@endsection
