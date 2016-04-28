@extends('layouts.master')

@section('content')

    <h1>Push Notification</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>ID.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Type</th>
                <th>Content Id</th>
                <th>Response</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $pushnotification->id }}</td>
                <td> {{ $pushnotification->title }} </td>
                <td> {{ $pushnotification->description }} </td>
                <td> {{ $pushnotification->type }} </td>
                <td> {{ $pushnotification->content_id }} </td>
                <td> {{ $pushnotification->response }} </td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection