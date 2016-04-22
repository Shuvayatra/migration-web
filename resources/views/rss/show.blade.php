@extends('layouts.master')

@section('content')

    <h1>Rss</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Title</th><th>Url</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $rss->id }}</td> <td> {{ $rss->title }} </td><td> {{ $rss->url }} </td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection