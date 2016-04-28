@extends('layouts.master')

@section('content')

    <h1>Resend Push Notification</h1>
    <hr/>

    {!! Form::model($pushnotification, [
        'method' => 'PATCH',
        'route' => ['pushnotification.update', $pushnotification->id],
        'class' => 'form-horizontal'
    ]) !!}

    @include('pushnotification.form')


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Resend', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection