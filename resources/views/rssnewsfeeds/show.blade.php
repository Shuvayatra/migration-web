@extends('layouts.master')

@section('content')

    <h1>Rss News Feed</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>ID.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Permalink</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $rssnewsfeed->id }}</td>
                <td> {{ $rssnewsfeed->title }} </td>
                <td> {{ $rssnewsfeed->description }} </td>
                <td> {{ $rssnewsfeed->permalink }} </td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection