@extends('layouts.master')

@section('content')

    <h1>Create New Block</h1>
    <hr/>
    {!! Form::open(['route' => 'blocks.store', 'class' => 'form-horizontal block-form']) !!}
    @include('block.form')
    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection