<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
	{!! Form::label('name', 'Internal Title: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('name', null, ['class' => 'form-control slug-source']) !!}
		{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
	{!! Form::label('title', 'App Title: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('title', null, ['class' => 'form-control']) !!}
		{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
	{!! Form::label('slug', 'Url slug: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('slug', null, ['class' => 'form-control slug-target']) !!}
		{!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group {{ $errors->has('icon_image') ? 'has-error' : ''}}">
	{!! Form::label('icon_image', 'Icon Image: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::file('icon_image', null, ['class' => 'form-control']) !!}
		{!! $errors->first('icon_image', '<p class="help-block">:message</p>') !!}
		@if(isset($screen))
			<img height="100px" width="100px" class="thumbnail" src="{{$screen->icon_image_path}}"/>
		@endif
	</div>
</div>

@if(!isset($screen))
	<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
		{!! Form::label('type', 'Type: ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::select('type', ['block'=> 'Block', 'feed'=> 'Feed'], null, ['class' => 'form-control'] ) !!}
			{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
@endif

<div class="form-group {{ $errors->has('visibility') ? 'has-error' : ''}}">
	{!! Form::label('visibility', 'Visibility: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('visibility[country_id][]', $countries, null, ['class' => 'form-control', 'multiple'=>true, 'id'=>'visibility-country'] ) !!}
		{!! Form::select('visibility[gender]', $gender, null, ['class' => 'form-control'] ) !!}
		{!! $errors->first('visibility', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group {{ $errors->has('is_published') ? 'has-error' : ''}}">
	{!! Form::label('is_published', 'Published: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('is_published', $publishState, null, ['class' => 'form-control'] ) !!}
		{!! $errors->first('is_published', '<p class="help-block">:message</p>') !!}
	</div>
</div>

@section('script')
	<script src="{{asset("js/vendor/speakingurl.min.js")}}"></script>
	<script src="{{asset("js/vendor/slugify.min.js")}}"></script>
	<script>
		jQuery(function ($) {
			$('.slug-target').slugify('.slug-source'); // Type as you slug
		});
	</script>
@endsection
