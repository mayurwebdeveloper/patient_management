@extends('layouts.main')


@push('title')
<title>Add PM JAY Resource</title>
@endpush


@section('main-section')


<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Add PM JAY Resource</h6>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('add-pm-jay-resource') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="title">PM JAY Resource Name.</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{old('title')}}" placeholder="PM JAY Resource Title">
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
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Description">{{old('description')}}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
            </div>

 
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="document_title">Document Title.</label>
                    <input type="text" class="form-control @error('document_title') is-invalid @enderror" name="document_title" id="document_title" value="{{old('document_title')}}" placeholder="Document Title">
                    @error('document_title')
                    <div class="invalid-feedback">
                    {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="document">Document</label>
                    <input type="file" class="form-control" name="document" id="document" placeholder="Document">
                </div>   
            </div>


            <div class="form-row">

                <div class="form-group col-md-4">
                    <label for="status">Status.</label>
                    <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" value="{{old('status')}}" placeholder="Status">
                        <option value="1">Enable</option>
                        <option value="0">Disable</option>
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
