@extends('layouts.master')

@section('content')

    <h1>Create New Post</h1>
    <hr/>

    {!! Form::open(['route' => 'post.store', 'class' => 'form-horizontal']) !!}
        @include('post.post.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection