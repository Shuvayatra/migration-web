<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
	{!! Form::label('title', trans('category.title'), ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('title', null, ['class' => 'form-control']) !!}
		{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('title_en') ? 'has-error' : ''}}">
	{!! Form::label('title_en', "Title(English)", ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('title_en', null, ['class' => 'form-control']) !!}
		{!! $errors->first('title_en', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
	{!! Form::label('description', 'Description: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::textarea('description', null, ['class' => 'form-control tinymce']) !!}
		{!! $errors->first('description', '<p class="help-block">:message</p>') !!}
	</div>
</div>

@if(!request()->has('section_id'))
	<div class="form-group {{ $errors->has('section') ? 'has-error' : ''}}">
		{!! Form::label('section', trans('category.section'), ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::text('section', null, ['class' => 'form-control']) !!}
			{!! $errors->first('section', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
@endif
{!! Form::hidden('parent_id', request()->get('section_id', null), ['class' => 'form-control']) !!}
<?php
$main_category = false;
if (request()->has('section_id')) {
	$main_category = \App\Nrna\Models\Category::find(request()->get('section_id'));
}
?>
@if($main_category && $main_category->getLevel()==0)

	<div class="form-group {{ $errors->has('main_image') ? 'has-error' : ''}}">
		{!! Form::label('main_image', 'Main Image: ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::file('main_image', null, ['class' => 'form-control']) !!}
			{!! $errors->first('main_image', '<p class="help-block">:message</p>') !!}
			@if(isset($category))
				<a href="#" class="thumbnail">
					<img src="{{$category->main_image_link}}">
				</a>
			@endif
		</div>
	</div>
	<div class="form-group {{ $errors->has('icon') ? 'has-error' : ''}}">
		{!! Form::label('icon', 'Icon: ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::file('icon', null, ['class' => 'form-control']) !!}
			{!! $errors->first('icon', '<p class="help-block">:message</p>') !!}
			@if(isset($category))
				<a href="#" class="thumbnail">
					<img src="{{$category->icon_link}}">
				</a>
			@endif
		</div>
	</div>
	<div class="form-group {{ $errors->has('small_icon') ? 'has-error' : ''}}">
		{!! Form::label('small_icon', 'Small Icon: ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::file('small_icon', null, ['class' => 'form-control']) !!}
			{!! $errors->first('small_icon', '<p class="help-block">:message</p>') !!}
			@if(isset($category))
				<a href="#" class="thumbnail">
					<img src="{{$category->small_icon_link}}">
				</a>
			@endif

		</div>
	</div>
	<div style="display:@if($main_category->getRoot()->section=="country") block @else none @endif">
		<button type="button" class="btn btn-default add-new-country-info"
				id="add-new-country-info">Add info +
		</button>
		<div class="country-info-wrap">
		</div>
	</div>
	<hr>
@endif
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
	{!! Form::label('display', 'Display in app:', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::checkbox('status') !!}
		{!! $errors->first('status', '<p class="help-block">:message</p>') !!}
	</div>
</div>
{!! Form::hidden('prev_url',URL::previous())!!}

@section('script')
	<script id="country-info-field" type="x-tmpl-mustache">
		<div class="form-group county-info-item">
		<div class="col-sm-3">{!! Form::text('country_info[@{{count}}][attribute]', null, ['class' => 'form-control',
			'Placeholder'=>'Attribute'])
			 !!}</div>
		<div class="col-sm-6">

        {!! Form::text('country_info[@{{count}}][value]', null, ['class' => 'form-control','placeholder'=>'Value']) !!}
		</div>
		<br>
		<div class="delete delete-country-info btn btn-danger">X</div>
	</div>


	</script>
	<script>
		$(function () {
			var j = {{$j or 0}};
			$('.add-new-country-info').on('click', function (e) {
				e.preventDefault();
				var template = $('#country-info-field').html();
				Mustache.parse(template);
				var rendered = Mustache.render(template, {count: j});
				j += 1;
				$('.country-info-wrap:last-child').append(rendered);
			});

			$(document).on('click', '.delete-country-info', function (e) {
				e.preventDefault();
				$(this).parent().remove();
				j -= 1;
			});
		})
	</script>

@append