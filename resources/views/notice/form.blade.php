<?php
$countries = \App\Nrna\Models\Category::find(1)->getImmediateDescendants()->lists('title', 'id')->toArray();
?>

<div class="form-group {{ $errors->has('metadata.title') ? 'has-error' : ''}}">
	{!! Form::label('title', 'Title: *', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('metadata[title]', null, ['class' => 'form-control required']) !!}
		{!! $errors->first('metadata.title', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('metadata.description') ? 'has-error' : ''}}">
	{!! Form::label('description', 'Description: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::textArea('metadata[description]', null, ['class' => 'form-control']) !!}
		{!! $errors->first('metadata.description', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('country_id') ? 'has-error' : ''}}">
	{!! Form::label('country', 'Destination: * ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('country_id', [''=>'Select']+$countries, null, ['class'=>
		'form-control required']) !!}
		{!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
	{!! Form::label('display', 'Display in app:', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::checkbox('status') !!}
		{!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	</div>
</div>

