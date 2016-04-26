@extends('layouts.master')

@section('content')

    <h1>Create New User</h1>
    <hr/>

    {!! Form::open(['route' => 'user.store', 'class' => 'form-horizontal']) !!}

    @include('user.form')


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection