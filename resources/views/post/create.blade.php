@extends('layouts.post_layout')
<?php
$create_route = ['post.store']+getQueryParams(request()->fullUrl());
?>
@section('content')
    {!! Form::open(['route' => $create_route,'class' => 'form-horizontal post-form',
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