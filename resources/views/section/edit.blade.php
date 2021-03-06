@extends('layouts.master')

@section('content')

    <h1>Edit Section</h1>
    <hr/>

    {!! Form::model($section, [
        'method' => 'PATCH',
        'route' => ['section.update', $section->id],
        'class' => 'form-horizontal'
    ]) !!}
     @include('section.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection