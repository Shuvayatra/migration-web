<?php
$countryService = app('App\Nrna\Services\CountryService');
$pages = ['home' => 'Home', 'destination' => 'Destination', 'journey' => 'Journey'];
$categories = \App\Nrna\Models\Category::where('depth', '1')->lists('title', 'id')->toArray();
$countries = \App\Nrna\Models\Category::whereSection('country')->first()->getImmediateDescendants()->lists(
		'title',
		'id'
)->toArray();
$journeys = \App\Nrna\Models\Category::whereSection('categories')->first()->getImmediateDescendants()->lists(
		'title',
		'id'
)
									 ->toArray();
$layouts = [
		'list'           => 'List',
		'slider'         => 'Slider',
		'country_widget' => 'Country Widget',
		'radio_widget'   => 'Radio Widget',
		'notice'         => 'Notice'
];
$page = request()->get('page', 'home');
?>
{!! Form::hidden('page', $page) !!}
{!! Form::hidden('metadata[country_id]',request()->get('country_id')) !!}
@if(request()->has('country_id'))
	{!! Form::hidden('country_id', request()->get('country_id')) !!}
@endif

<div class="form-group {{ $errors->has('metadata.layout') ? 'has-error' : ''}}">
	{!! Form::label('layout', 'Layout: * ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('metadata[layout]', [''=>'Select']+$layouts, null, ['class'=>
		'form-control block-layout required']) !!}
		{!! $errors->first('metadata.layout', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<?php $show_home_fields = false;
if (isset($block) && in_array($block->metadata->layout, ['list', 'slider'])) {
	$show_home_fields = true;
}
?>

<div style="display:@if($page=="home")block @else none @endif" class="form-group post-field">
	{!! Form::label('Country', 'Show in country: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('show_country_id', [null]+$countries, null,
		['class' =>'form-control']) !!}
		{!! $errors->first('show_country_id', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div style="display:@if($show_home_fields)block @else none @endif" class="block-content-type-post block-fields">
	<div class="form-group {{ $errors->has('metadata.title') ? 'has-error' : ''}} post-field radio-field">
		{!! Form::label('title', 'Title: *', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::text('metadata[title]', null, ['class' => 'form-control required']) !!}
			{!! $errors->first('metadata.title', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group {{ $errors->has('metadata.description') ? 'has-error' : ''}} post-field radio-field">
		{!! Form::label('description', 'Description: ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::textArea('metadata[description]', null, ['class' => 'form-control']) !!}
			{!! $errors->first('metadata.description', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group post-field">
		{!! Form::label('content tags', 'Category:* ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::select('metadata[category_id][]', $journeys, null,
			['class' =>
			'form-control','multiple'=>'','id'=>'tags']) !!}
			{!! $errors->first('metadata.category_id', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group post-field">
		{!! Form::label('metadata.post_type', 'Post Type: ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::select('metadata[post_type][]', config('post_type'), null,
			['class' =>
			'form-control','multiple'=>'','id'=>'tags']) !!}
			{!! $errors->first('metadata.post_type', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group post-field">
		{!! Form::label('content', 'Number of posts: * ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::selectRange('metadata[number_of_post]', 5, 15,null,['class' =>'form-control']) !!}
			{!! $errors->first('metadata.number_of_posts', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group {{ $errors->has('metadata.show_view_more') ? 'has-error' : ''}} post-field">
		{!! Form::label('view_more', 'Show view more link: *', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::checkbox('metadata[show_view_more_flag]') !!}
			{!! $errors->first('metadata.show_view_more', '<p class="help-block">:message</p>') !!}
			<div class="form-group view-more-fields">
				{!! Form::label('metadata.show_view_more.title', 'View more text: * ', ['class' => 'control-label']) !!}
				{!! Form::text('metadata[show_view_more][title]', (isset($block)&&isset($block->show_view_more->title))
				?$block->show_view_more->title:'थप हेर्नुहोस्',
				['class' =>
				'form-control
				required'])
				 !!}
				{!! Form::label('metadata[show_view_more][url]', 'URL: * ', ['class' => 'control-label']) !!}
				{!! Form::text('metadata[show_view_more][url]', (isset($block)&&isset($block->show_view_more->url))?$block->show_view_more->url:'shuvayatra://feed', ['class' => 'form-control required']) !!}
			</div>
		</div>
	</div>
</div>
@section('script')
	<script>
		$(function () {
					@if(isset($block))
			var field = "{{$block->metadata->layout}}";
			if (field == 'list' || field == 'slider') {
				field = 'post';
			}
			if (field == 'radio_widget') {
				$('.block-content-type-post').show();
				$('.post-field').hide();
				$('.radio-field').show();
			}
			$('.block-content-type-' + field).show();
			@endif
			$(document).on('change', '.block-page', function () {
				$('.page-type').hide();
				$('select').select2({width: '100%', placeholder: "Select", allowClear: true, theme: "classic"});
				var field = $(this).val();
				$('.block-page-' + field).show();
			});
			$(document).on('change', '.block-layout', function () {
				$('.block-fields').hide();
				$('select').select2({width: '100%', placeholder: "Select", allowClear: true, theme: "classic"});
				var field = $(this).val();
				if (field == 'list' || field == 'slider') {
					field = 'post';
				}
				if (field == 'radio_widget') {
					$('.block-content-type-post').show();
					$('.post-field').hide();
					$('.radio-field').show();
				}
				$('.block-content-type-' + field).show();
			});
		});
	</script>
@endsection


