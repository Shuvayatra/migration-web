<div class="form-group {{ $errors->has('audio') ? 'has-error' : ''}}">
	{!! Form::label('audio', 'Audio: ', ['class' => ' control-label']) !!}
	<div class="">
		{!! Form::file('metadata[data][audio]', ['class'=>'form-control' , 'id' => 'file'])!!}
		{!! $errors->first('audio', '<p class="help-block">:message</p>') !!}
	</div>
	@if(isset($post->metadata->data->audio) && $post->metadata->data->audio_url =='')
		<div><a target="_blank" href="{{$post->metadataWithPath->data->audio}}">check</a></div>
	@endif
</div>
<div class="form-group {{ $errors->has('metadata.data.audio_url') ? 'has-error' : ''}}">
	{!! Form::label('url', 'URL: ', ['class' => ' control-label']) !!}
	<div class="">
		{!! Form::text('metadata[data][audio_url]', null, ['class' => 'form-control']) !!}
		{!! $errors->first('metadata.data.audio_url', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('thumbnail') ? 'has-error' : ''}}">
	{!! Form::label('thumbnail', 'Audio Image: ', ['class' => ' control-label']) !!}
	<div class="">
		{!! Form::file('metadata[data][thumbnail]', ['class'=>'form-control' , 'id' => 'thumbnail'])!!}
		{!! $errors->first('thumbnail', '<p class="help-block">:message</p>') !!}
	</div>
	@if(isset($post->metadata->data->thumbnail ))
		<a href="#" class="thumbnail">
			<img height="100px" width="100px" src="{{$post->metadataWithPath->data->thumbnail}}">
		</a>
	@endif
</div>

<div class="form-group {{ $errors->has('thumbnail') ? 'has-error' : ''}}">
	{!! Form::label('photo_credit', 'Photo Credit: ', ['class' => ' control-label']) !!}
	<div class="">
		{!! Form::text('metadata[data][photo_credit]',null, ['class'=>'form-control' , 'id' => 'photo_credit'])!!}
		{!! $errors->first('metadata.data.photo_credit', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<hr>