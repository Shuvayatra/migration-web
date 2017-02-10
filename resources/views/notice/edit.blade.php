@extends('layouts.master')

@section('content')

	<h1>Edit Notice</h1>
	<hr/>

	{!! Form::model($notice, [
		'method' => 'PATCH',
		'route' => ['notice.update', $notice->id],
		'class' => 'form-horizontal block-form',
		'files' =>true
	]) !!}
	@include('notice.form')
	<div class="form-group">
		<div class="col-sm-3"></div>
		<div class="col-sm-3">
			{!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}

@endsection