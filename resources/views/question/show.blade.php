@extends('layouts.master')

@section('content')

    <h1>Question</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Title</th><th>Description</th><th>Source</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $question->id }}</td> <td> {{ $question->title }} </td><td> {{ $question->description }} </td><td> {{ $question->source }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection