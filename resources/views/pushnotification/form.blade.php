<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
	{!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('title', null, ['class' => 'form-control']) !!}
		{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
	{!! Form::label('description', 'Description: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::textArea('description', null, ['class' => 'form-control']) !!}
		{!! $errors->first('description', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
	{!! Form::label('type', 'Show Notification in : ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('send_notification_to',['test'=>'Test App','global'=>"Live App"],null, ['class'
		=>'form-control',
		'id'=>'post_type']) !!}
		{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div style="display: none" class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
	{!! Form::label('type', 'Type: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('type',[''=>'Select', 'post'=>'Post'],null, ['class' =>'form-control','id'=>'post_type']) !!}
		{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div style="display: none" class="form-group {{ $errors->has('content_id') ? 'has-error' : ''}}">
	{!! Form::label('content_id', 'Content Id: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('content_id',['0'=>'Select']+$contentOptions,null, ['class' =>'form-control','id'=>'post_type']) !!}
		{!! $errors->first('content_id', '<p class="help-block">:message</p>') !!}
	</div>
</div>