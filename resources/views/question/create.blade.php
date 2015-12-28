@extends('layouts.master')

@section('content')

    <h1>Create New Question</h1>
    <hr/>

    {!! Form::open(['route' => 'question.store', 'class' => 'form-horizontal question-form']) !!}
    @include('question.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection