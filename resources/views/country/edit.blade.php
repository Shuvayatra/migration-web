@extends('layouts.master')

@section('content')

    <h1>Edit Country</h1>
    <hr/>
    {!! Form::model($country, [
        'method' => 'PATCH',
        'route' => ['country.update', $country->id],
        'class' => 'form-horizontal'
    ]) !!}
    @include('country.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection