<?php
$countryService = app('App\Nrna\Services\CountryService');
$pages = ['home' => 'Home', 'destination' => 'Destination', 'journey' => 'Journey'];
$categories = \App\Nrna\Models\Category::where('depth', '!=', '0')->lists('title', 'id')->toArray();
$countries = \App\Nrna\Models\Category::find(1)->getImmediateDescendants()->lists('title', 'id')->toArray();
$journeys = \App\Nrna\Models\Category::find(2)->getImmediateDescendants()->lists('title', 'id')->toArray();
$layouts = ['list'           => 'List',
			'slider'         => 'Slider',
			'country_widget' => 'Country Widget',
			'radio_widget'   => 'Radio Widget',
			'notice'         => 'Notice'
];
?>
<div class="form-group {{ $errors->has('page') ? 'has-error' : ''}}">
	{!! Form::label('page', 'Page: * ', ['class' => 'col-sm-3 control-label ']) !!}
	<div class="col-sm-6">
		{!! Form::select('page', [''=>'Select']+$pages, isset($place)?$place->country->id:null, ['class'=>
		'form-control block-page']) !!}
		{!! $errors->first('page', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div style="display: none"
	 class="form-group {{ $errors->has('metadata.country_id') ? 'has-error' : ''}} page-type block-page-destination">
	{!! Form::label('country', 'Destination: * ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('metadata[country_id]', [''=>'Select']+$countries, isset($place)?$place->country->id:null, ['class'=>
		'form-control required']) !!}
		{!! $errors->first('metadata.country_id', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div style="display: none"
	 class="form-group {{ $errors->has('metadata.journey_id') ? 'has-error' : ''}} page-type block-page-journey">
	{!! Form::label('journey', 'Journey: * ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('metadata[journey_id]', [''=>'Select']+$journeys, isset($place)?$place->country->id:null, ['class'=>
		'form-control']) !!}
		{!! $errors->first('metadata.journey_id', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('metadata.layout') ? 'has-error' : ''}}">
	{!! Form::label('layout', 'Layout: * ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('metadata[layout]', [''=>'Select']+$layouts, isset($place)?$place->country->id:null, ['class'=>
		'form-control block-layout required']) !!}
		{!! $errors->first('metadata.layout', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<?php $show_home_fields = false;
if (isset($block) && $block->page == 'home') {
	$show_home_fields = true;
}
?>
<div style="display:@if($show_home_fields)block @else none @endif" class="block-content-type-post block-fields">
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
	<div class="form-group">
		{!! Form::label('content tags', 'Content Tags:* ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::select('metadata[category_id][]', $categories, null,
			['class' =>
			'form-control','multiple'=>'','id'=>'tags']) !!}
			{!! $errors->first('metadata.category_id', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('metadata.post_type', 'Post Type:* ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::select('metadata[post_type][]', config('post_type'), null,
			['class' =>
			'form-control','multiple'=>'','id'=>'tags']) !!}
			{!! $errors->first('metadata.post_type', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('content', 'Number of posts: * ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::selectRange('metadata[number_of_post]', 5, 15,null,['class' =>'form-control']) !!}
			{!! $errors->first('metadata.number_of_posts', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group {{ $errors->has('metadata.show_view_more') ? 'has-error' : ''}}">
		{!! Form::label('view_more', 'Show view more link: *', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::checkbox('metadata[show_view_more_flag]') !!}
			{!! $errors->first('metadata.show_view_more', '<p class="help-block">:message</p>') !!}
			<div class="form-group view-more-fields">
				{!! Form::label('metadata.show_view_more.title', 'View more text: * ', ['class' => 'control-label']) !!}
				{!! Form::text('metadata[show_view_more][title]', 'View more', ['class' => 'form-control required']) !!}
				{!! Form::label('metadata[show_view_more][url]', 'URL: * ', ['class' => 'control-label']) !!}
				{!! Form::text('metadata[show_view_more][url]', null, ['class' => 'form-control required']) !!}
			</div>
		</div>
	</div>
</div>
@section('script')
	<script>
		$(function () {
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
				$('.block-content-type-' + field).show();
			});
		});
	</script>
@endsection


