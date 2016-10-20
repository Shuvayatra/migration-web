@extends('layouts.master')

@section('content')
    <div class="">
        Manage App content
    </div>
    <ul>
        <li><a href="{{route('blocks.create')}}">Add Block</a></li>
        <li><a href="{{route('blocks.create')}}">Home Page</a></li>
        <li><a href="{{route('blocks.create')}}">Journey Page</a></li>
        <li><a href="{{route('blocks.create')}}">Destination Page</a></li>
    </ul>
@endsection
