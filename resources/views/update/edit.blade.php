@extends('layouts.master')

@section('content')

    <h1>Edit Update</h1>
    <hr/>

    {!! Form::model($update, [
        'method' => 'PATCH',
        'route' => ['update.update', $update->id],
        'class' => 'form-horizontal'
    ]) !!}
    @include('update.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection