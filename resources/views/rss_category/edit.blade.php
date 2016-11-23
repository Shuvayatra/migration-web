@extends('layouts.master')

@section('content')

	<h1>Edit Category</h1>
	<hr/>

	{!! Form::model($rss_category, [
		'method' => 'PATCH',
		'route' => ['rss_category.update', $rss_category->id],
		'class' => 'form-horizontal',
		'files'=>true
	]) !!}

	@include('rss_category.form_fields')
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-3">
			{!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}

@endsection