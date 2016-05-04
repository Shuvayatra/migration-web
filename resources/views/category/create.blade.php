@extends('layouts.master')

@section('content')
<div class="container">

    <h1>Create New Category</h1>
    <hr/>

    {!! Form::open(['url' => '/category',
    'class' => 'form-horizontal',
    'files' =>true
    ]) !!}

               @include('category.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection