@extends('layouts.master')

@section('content')

	<h1>Edit Block ({{ucfirst(request()->get('page','home'))}} Screen) @if(request()->has('country_id'))
			<?php
			$country = \App\Nrna\Models\Category::find(request()->get('country_id'))
			?>
			({{$country->title}})
		@endif</h1>
	<hr/>
	<hr/>

	{!! Form::model($block, [
		'method' => 'PATCH',
		'route' => ['blocks.update', $block->id],
		'class' => 'form-horizontal block-form',
	]) !!}
	@include('block.form')
	<div class="form-group">
		<div class="col-sm-3"></div>
		<div class="col-sm-3">
			{!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}

@endsection