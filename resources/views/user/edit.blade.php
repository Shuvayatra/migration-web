@extends('layouts.master')

@section('content')

    <h1>Edit User</h1>
    <hr/>
    {!! Form::model($user, [
        'method' => 'PATCH',
        'route' => ['user.update', $user->id],
        'class' => 'form-horizontal'
    ]) !!}
    {!! Form::hidden('id') !!}

    @include('user.form')

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection