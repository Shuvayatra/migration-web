@extends('layouts.master')

@section('content')

    <h1>Create New Section</h1>
    <hr/>

    {!! Form::open(['route' => 'section.store', 'class' => 'form-horizontal']) !!}

              @include('section.form')

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection