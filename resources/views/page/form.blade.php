<div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
	{!! Form::label('slug', trans('pages.slug'), ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('slug', null, ['class' => 'form-control']) !!}
		{!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
	{!! Form::label('content', trans('pages.content'), ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::textarea('content', null, ['class' => 'form-control tinymce']) !!}
		{!! $errors->first('content', '<p class="help-block">:message</p>') !!}
	</div>
</div>

