@extends('layouts.master')

@section('content')
	<h1>Edit Screen</h1>
	<hr/>
	{!! Form::model($screen, [
        'method' => 'PATCH',
        'route' => ['screen.update', $screen->id],
        'class' => 'form-horizontal',
        'files' =>true
    ]) !!}
	@include('screen.form')
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-3">
			{!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
	{!! Form::close() !!}
@endsection
