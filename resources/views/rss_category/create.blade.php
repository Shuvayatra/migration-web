@extends('layouts.master')

@section('content')

	<h1>Create New Category</h1>
	<hr/>

	{!! Form::open(['route' => 'rss_category.store', 'class' => 'form-horizontal']) !!}
	<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
		{!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::text('title', null, ['class' => 'form-control']) !!}
			{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-3">
			{!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}
@endsection