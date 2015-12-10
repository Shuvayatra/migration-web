@extends('layouts.master')

@section('content')

    <h1>Edit Post</h1>
    <hr/>

    {!! Form::model($post, [
        'method' => 'PATCH',
        'route' => ['post.update', $post->id],
        'class' => 'form-horizontal'
    ]) !!}

    @include('post.post.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection