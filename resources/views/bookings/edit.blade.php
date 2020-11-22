@extends('layouts.app')

@section('content')
<div class="col">
<form action="{{ route('bookings.update', ['booking'=>$booking]) }}" method="POST">
    @csrf
    @method('PUT')
    @include('bookings.fields')

    @csrf

    <div class="form-group row">
        <div class="col-sm-3">
            <button type="submit" class="btn btn-primary">Add Reservation</button>
        </div>
        <div class="col-sm-9">
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
</div>
@endsection
