@extends('layouts.master')

@section('content')

    <h1>Edit Place</h1>
    <hr/>

    {!! Form::model($place, [
        'method' => 'PATCH',
        'route' => ['place.update', $place->id],
        'class' => 'form-horizontal place-form',
        'files'=> true
    ]) !!}
    @include('place.form')
    <div class="form-group">
        <div class="row col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection