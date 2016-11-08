@extends('layouts.master')

@section('content')

	<h1>Edit Radio</h1>
	<hr/>

	{!! Form::model($rss, [
		'method' => 'PATCH',
		'route' => ['rss.update', $rss->id],
		'class' => 'form-horizontal'
	]) !!}
	@include('rss.form')

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-3">
			{!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}

@endsection