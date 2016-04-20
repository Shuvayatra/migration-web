@extends('layouts.master')

@section('content')

    <h1>Edit Countrytag</h1>
    <hr/>

    {!! Form::model($countrytag, [
        'method' => 'PATCH',
        'route' => ['countrytag.update', $countrytag->id],
        'class' => 'form-horizontal'
    ]) !!}

                @include('countrytag.form')

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}


@endsection