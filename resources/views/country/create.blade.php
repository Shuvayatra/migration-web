@extends('layouts.master')

@section('content')

    <h1>Create New Country</h1>
    <hr/>
    {!! Form::open(['route' => 'country.store',
                    'class' => 'form-horizontal',
                    'novalidate' => 'novalidate',
                    'files' => true ])
    !!}
    @include('country.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection