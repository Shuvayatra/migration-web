@extends('layouts.master')

@section('content')

    <h1>Edit Question</h1>
    <hr/>

    {!! Form::model($question, [
        'method' => 'PATCH',
        'route' => ['question.update', $question->id],
        'class' => 'form-horizontal'
    ]) !!}
     @include('question.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection