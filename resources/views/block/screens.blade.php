@extends('layouts.master')

@section('content')
	<div class="">
		<h2>Mobile screens</h2>
	</div>
	<ul>
		<li><a href="{{route('blocks.index',['page'=>'home'])}}">Home</a></li>
		<li><a href="{{route('blocks.index',['page'=>'destination'])}}">Destination</a></li>
		<li><a href="{{route('blocks.index',['page'=>'journey'])}}">Journey</a></li>
	</ul>
@endsection
