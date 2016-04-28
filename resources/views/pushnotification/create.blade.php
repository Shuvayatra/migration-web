@extends('layouts.master')

@section('content')

    <h1>Send Push Notification</h1>
    <hr/>

    {!! Form::open(['route' => 'pushnotification.store', 'class' => 'form-horizontal']) !!}

    @include('pushnotification.form')

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Send', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection