@extends('layouts.master')

@section('content')

	<h1>Create New Block ({{ucfirst(request()->get('page','home'))}} Screen)
		@if(request()->has('country_id'))
			<?php
			$country = \App\Nrna\Models\Category::find(request()->get('country_id'))
			?>
			({{$country->title}})
		@endif
		@if(request()->has('screen_id'))
			<?php
			$screen = \App\Nrna\Models\Screen::find(request()->get('screen_id'))
			?>
			({{$screen->title}})
		@endif
	</h1>
	<hr/>
	<a href="{{route('blocks.index',['page'=>request()->get('page','home')])}}">Back</a>
	{!! Form::open(['route' => 'blocks.store', 'class' => 'form-horizontal block-form']) !!}
	@include('block.form')
	<div class="form-group">
		<div class="col-sm-3"></div>
		<div class="col-sm-3">
			{!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}
@endsection