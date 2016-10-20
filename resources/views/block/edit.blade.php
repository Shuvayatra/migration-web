@extends('layouts.master')

@section('content')

    <h1>Edit Place</h1>
    <hr/>

    {!! Form::model($block, [
        'method' => 'PATCH',
        'route' => ['block.update', $block->id],
        'class' => 'form-horizontal block-form',
        'files'=> true
    ]) !!}
    @include('block.form')
    <div class="form-group">
        <div class="col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection