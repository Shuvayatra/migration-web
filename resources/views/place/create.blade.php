@extends('layouts.master')

@section('content')

    <h1>Create New Place</h1>
    <hr/>

    {!! Form::open(['route' => 'place.store', 'class' => 'form-horizontal place-form','files'=>true]) !!}

    @include('place.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection