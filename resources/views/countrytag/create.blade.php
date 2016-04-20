@extends('layouts.master')

@section('content')

    <h1>Create New Country tag</h1>
    <hr/>

    {!! Form::open(['route' => 'countrytag.store', 'class' => 'form-horizontal']) !!}

               @include('countrytag.form')

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection