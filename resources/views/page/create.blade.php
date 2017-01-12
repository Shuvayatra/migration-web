@extends('layouts.master')

@section('content')

	<h1>Create New Page</h1>
	<hr/>

	{!! Form::open(['url' => '/pages', 'class' => 'form-horizontal']) !!}

	@include('page.form')

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-3">
			{!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}

@endsection