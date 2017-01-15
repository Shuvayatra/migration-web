@extends('layouts.master')
@section('content')
	<h1>Manage {{$screen->title}}</h1>
	<?php
	$categories = \App\Nrna\Models\Category::where('section', 'categories')->first()->getImmediateDescendants()->lists
	('title', 'id')
										   ->toArray();
	$countries = \App\Nrna\Models\Category::where('section', 'country')->first()->getImmediateDescendants()->lists('title', 'id')
										  ->toArray();
	$is_edit = false;
	$route = ['screen.feed.store',$screen->id];
	if($screen->categories->count()>0){
		$is_edit = true;
		$route = ['screen.feed.update',$screen->id,1];
	}
	?>
	{!! Form::open(['route' => $route,'class' => 'form-horizontal post-form',
	'novalidate' => 'novalidate',
	'files' => true]) !!}
	@if($is_edit)
	<input name="_method" type="hidden" value="PUT">
	@endif

	<div class="form-group {{ $errors->has('category') ? 'has-error' : ''}}">
		{!! Form::label('tag', 'Category:* ', ['class' => 'control-label']) !!}
		{!! Form::select('category[category][]', $categories, ($is_edit)?$screen->categories->lists('id')->toArray()
		:null,
		['class' =>
		'form-control','multiple'=>'']) !!}
		{!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
	</div>
	<div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
		{!! Form::label('tag', 'Country: ', ['class' => 'control-label']) !!}
		{!! Form::select('category[country][]', $countries, ($is_edit)?$screen->categories->lists('id')->toArray()
		:null,
		['class' =>
		'form-control','multiple'=>true]) !!}
		{!! $errors->first('country', '<p class="help-block">:message</p>') !!}
	</div>
	<div class="form-group">
		<div class="row col-sm-3">
			{!! Form::submit(($is_edit)?"Update":'Create', ['class' => 'btn btn-primary form-control']) !!}
		</div>
		<div class="row col-sm-3">
			<a href="{!! route('screen.index') !!}" class="btn btn-default  form-control">Cancel</a>
		</div>
	</div>
	{!! Form::close() !!}
@endsection

