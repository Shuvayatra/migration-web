@extends('layouts.post_layout')
@section('content')
    {!! Form::open(['route' => 'post.store',
    'class' => 'form-horizontal post-form',
    'novalidate' => 'novalidate',
    'files' => true]) !!}
    @include('post.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection