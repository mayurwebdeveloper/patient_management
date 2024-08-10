@extends('layouts.main')


@push('title')
<title>Edit Hospital Working Hours</title>
@endpush


@section('main-section')


<div class="card shadow mb-4">
    <div class="card-header py-3" id="table-card-title">
        <h6 class="m-0 font-weight-bold text-primary">Edit Hospital Working Hours</h6>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('update-hospital-time') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Open</th>
                        <th scope="col">Day</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">Close Time</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i=1; $i<8; $i++)                        
                    <tr>
                        <th scope="row"><input type="checkbox" name="days[]" value="{{ $i }}" {!! isset($workingDays[$i]) ? 'checked' : '' !!}></th>
                        <td>{{ $dayNames[$i] }}</td>
                        <td><input type="time" class="form-control" name="start_time_{{$i}}" value="{!! isset($workingDays[$i]) ? $workingDays[$i]['start_time'] : '' !!}"  placeholder="Start Time"></td>
                        <td><input type="time" class="form-control" name="end_time_{{$i}}"  value="{!! isset($workingDays[$i]) ? $workingDays[$i]['end_time'] : '' !!}" placeholder="End Time"></td>
                    </tr>
                    @endfor
                </tbody>
                </table>

            <button type="submit" class="btn btn-primary">save</button>
        </form>

    </div>
</div>

@endsection
