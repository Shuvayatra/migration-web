@extends('layouts.master')

@section('content')

    <h1>Edit Tag</h1>
    <hr/>

    {!! Form::model($tag, [
        'method' => 'PATCH',
        'route' => ['tag.update', $tag->id],
        'class' => 'form-horizontal'
    ]) !!}

    @include('tag.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection