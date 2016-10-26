@extends('layouts.master')

@section('content')

	<h1>Create New Notice</h1>
	<hr/>
	{!! Form::open(['route' => 'notice.store', 'class' => 'form-horizontal notice-form']) !!}
	@include('notice.form')
	<div class="form-group">
		<div class="col-sm-3"></div>
		<div class="col-sm-3">
			{!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}
@endsection