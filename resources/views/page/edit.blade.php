@extends('layouts.master')

@section('content')

	<h1>Edit Page {{ $page->id }}</h1>

	{!! Form::model($page, [
		'method' => 'PATCH',
		'url' => ['/pages', $page->id],
		'class' => 'form-horizontal'
	]) !!}

	@include('page.form')
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-3">
			{!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}

@endsection