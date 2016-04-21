@extends('layouts.master')

@section('content')
    <?php
    $section = \App\Nrna\Models\Section::find($section_id);
    ?>
    <h1>Section : {{$section->title}}</h1>
    <h3>Create New Category attribute</h3>
    <hr/>

    {!! Form::open(['route' => ['section.category.store', $section_id], 'class' => 'form-horizontal',
    'files'=>true
    ]) !!}

    @include('categoryattribute.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}


@endsection