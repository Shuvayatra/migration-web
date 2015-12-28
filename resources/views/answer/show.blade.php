@extends('layouts.master')

@section('content')

    <h1>Answer</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Title</th><th>Question Id</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $answer->id }}</td> <td> {{ $answer->title }} </td><td> {{ $answer->question_id }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection