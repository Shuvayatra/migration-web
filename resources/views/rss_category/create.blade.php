@extends('layouts.master')

@section('content')

	<h1>Create New Category</h1>
	<hr/>

	{!! Form::open(['route' => 'rss_category.store', 'class' => 'form-horizontal','files'=>true]) !!}
	@include('rss_category.form_fields')
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-3">
			{!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}
@endsection