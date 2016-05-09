@extends('layouts.post_layout')

@section('content')

    <h1>Edit Post</h1>
    <hr/>

    {!! Form::model($post, [
        'method' => 'PATCH',
        'route' => ['post.update', $post->id,request()->getQueryString()],
        'class' => 'form-horizontal post-form',
        'novalidate' => 'novalidate',
        'files' => true
    ]) !!}

    @include('post.form')
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection