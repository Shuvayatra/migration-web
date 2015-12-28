@extends('layouts.master')
<?php
$questionService = app('App\Nrna\Services\QuestionService');
$questions = $questionService->getList();
?>
@section('content')

    <h1>Edit Answer</h1>
    <hr/>

    {!! Form::model($answer, [
        'method' => 'PATCH',
        'route' => ['answer.update', $answer->id],
        'class' => 'form-horizontal'
    ]) !!}

                <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                {!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
    <div class="form-group {{ $errors->has('question_id') ? 'has-error' : ''}}">
        {!! Form::label('question_id', 'Question: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::select('question_id',[''=>''] + $questions->toArray(),null, ['class'=>'form-control']) !!}
            {!! $errors->first('question', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@endsection