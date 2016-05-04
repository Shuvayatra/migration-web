@extends('layouts.master')

@section('content')
<div class="container">

    <h1>Edit Category</h1>
    <hr/>

    {!! Form::model($category, [
        'method' => 'PATCH',
        'url' => ['/category', $category->id],
        'class' => 'form-horizontal',
        'files' =>true
    ]) !!}


    @include('category.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection