@extends('layouts.master')

@section('content')

    <h1>Post</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Title</th><th>Description</th><th>Source</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $post->id }}</td> <td> {{ $post->title }} </td><td> {{ $post->description }} </td><td> {{ $post->source }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection