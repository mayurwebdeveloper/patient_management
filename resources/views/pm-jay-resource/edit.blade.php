@extends('layouts.main')


@push('title')
<title>Edit PM JAY Resource</title>
@endpush


@section('main-section')


<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Edit PM JAY Resource</h6>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('update-pm-jay-resource') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="pmjay_id" value="{{ $pmjay_resource->id }}">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="title">PM JAY Resource Name.</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{old('title', $pmjay_resource->title)}}" placeholder="PM JAY Resource Title">
                    @error('title')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

            </div>


            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Description">{{old('description', $pmjay_resource->description)}}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
            </div>


            <div class="form-row">

                <div class="form-group col-md-12">
                    <label for="document_title">Document title.</label>
                    <input type="text" class="form-control @error('document_title') is-invalid @enderror" name="document_title" id="document_title" value="{{old('document_title', $pmjay_resource->document_title)}}" placeholder="Document title">
                    @error('document_title')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="document">Document</label>
                    <input type="file" class="form-control" name="document" id="document" placeholder="Document">
                    @isset($pmjay_resource->document)
                        <a target="_blank" href="{!! asset('images/pmjay/documents/') !!}/{{$pmjay_resource->document}}">{{$pmjay_resource->document_title}}</a>
                    @endisset
                </div>    
            </div>



            <div class="form-row">

                <div class="form-group col-md-4">
                    <label for="status">Status.</label>
                    <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" value="{{old('status')}}" placeholder="Status">
                        <option value="1">Enable</option>
                        <option value="0" {{ old('status', $pmjay_resource->status) == '0' ? 'selected' : '' }}>Disable</option>
                    </select>
                    @error('status')
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

@endsection
