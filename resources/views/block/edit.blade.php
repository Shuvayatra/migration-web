@extends('layouts.master')

@section('content')

	<h1>Edit Block</h1>
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