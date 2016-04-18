@extends('layouts.master')

@section('content')

    <h1>Edit Journey</h1>
    <hr/>

    {!! Form::model($journey, [
        'method' => 'PATCH',
        'route' => ['journey.update', $journey->id],
        'class' => 'form-horizontal',
        'files' =>true
    ]) !!}

               @include('journey.form')


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection