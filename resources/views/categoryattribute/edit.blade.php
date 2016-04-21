@extends('layouts.master')

@section('content')
    <?php
    $section = \App\Nrna\Models\Section::find($section_id);
    ?>
    <h1>Section : {{$section->title}}</h1>
    <h3>Edit Category attribute</h3>
    <hr/>

    {!! Form::model($categoryattribute, [
        'method' => 'PATCH',
        'route' => ['section.category.update',$section_id, $categoryattribute->id],
        'class' => 'form-horizontal',
        'files' =>true
    ]) !!}

     @include('categoryattribute.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection