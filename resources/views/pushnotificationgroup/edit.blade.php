@extends('layouts.master')

@section('content')

    <h1>Edit Push Notification Group</h1>
    <hr/>

    {!! Form::model($pushnotificationgroup, [
        'method' => 'PATCH',
        'route' => ['pushnotificationgroup.update', $pushnotificationgroup->id],
        'class' => 'form-horizontal'
    ]) !!}

    @include('pushnotificationgroup.form')


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection