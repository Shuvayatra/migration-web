<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
	{!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('title', null, ['class' => 'form-control']) !!}
		{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
	{!! Form::label('image', 'Image: ', ['class' => 'col-sm-3  control-label']) !!}
	<div class="col-sm-6">
		{!! Form::file('image', ['class'=>'form-control'])!!}
		{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
		@if(isset($rss_category))
			<a href="#" class="thumbnail">
				<img src="{{$rss_category->image_url}}">
			</a>
		@endif
	</div>

</div>