@extends('layouts.master')

@section('content')

	<h1>Edit Category</h1>
	<hr/>

	{!! Form::model($rss_category, [
		'method' => 'PATCH',
		'route' => ['rss_category.update', $rss_category->id],
		'class' => 'form-horizontal'
	]) !!}

	<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
		{!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::text('title', null, ['class' => 'form-control']) !!}
			{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-3">
			{!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}

@endsection