<?php
$categories = \App\Nrna\Models\RssCategory::all()->lists('title', 'id')->toArray();
?>
<div class="form-group {{ $errors->has('language') ? 'has-error' : ''}}">
	{!! Form::label('category', 'Category: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('category_id', [''=>'Select Category']+$categories,null, ['class' => 'form-control']) !!}
		{!! $errors->first('Category', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
	{!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('title', null, ['class' => 'form-control']) !!}
		{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
	{!! Form::label('url', 'Url: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('url', null, ['class' => 'form-control']) !!}
		{!! $errors->first('url', '<p class="help-block">:message</p>') !!}
	</div>
</div>
