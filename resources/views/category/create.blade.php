@extends('layouts.master')
<?php
$title = "Create Main Section";
if(request()->has("section_id")){
    $cat = \App\Nrna\Models\Category::find(request()->get('section_id'));
    $title = $cat->title;
}

?>
@section('content')
    <div class="container">
        <h1>
            {{$title}}
        </h1>
        <hr/>
        {!! Form::open(['route' => 'category.store',
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