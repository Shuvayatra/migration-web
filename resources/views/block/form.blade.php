<?php
$countryService = app('App\Nrna\Services\CountryService');
$pages = ['home' => 'Home', 'destination' => 'Destination', 'journey' => 'Journey'];
$categories = \App\Nrna\Models\Category::where('depth', '1')->orderBy('title')->lists('title', 'id')->toArray();
$countries = \App\Nrna\Models\Category::whereSection('country')->first()->getImmediateDescendants()->lists(
		'title',
		'id'
)->toArray();
$gender = ['all' => 'select all gender'] + ['m' => 'male', 'f' => 'female', 'o' => 'other'];
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
];
$page = request()->get('page', 'home');
if (in_array($page, ['dynamic'])) {
	$layouts = [
			'list'   => 'List',
			'slider' => 'Slider',
	];
}
?>
{!! Form::hidden('page', $page) !!}
{!! Form::hidden('metadata[country_id]',request()->get('country_id')) !!}
{!! Form::hidden('metadata[screen_id]',request()->get('screen_id')) !!}
@if(request()->has('country_id'))
	{!! Form::hidden('country_id', request()->get('country_id')) !!}
@endif
@if(request()->has('screen_id'))
	{!! Form::hidden('screen_id', request()->get('screen_id')) !!}
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
if (old() && in_array(old('metadata.layout'), ['list', 'slider'])) {
	$show_home_fields = true;
}
?>

<div style="display: block" class="form-group">
	<div class="form-group {{ $errors->has('visibility') ? 'has-error' : ''}}">
		{!! Form::label('visibility', 'Visibility: ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			@if(in_array($page,['home','dynamic']))
				{!! Form::label('Country', 'Show in country: ', ['class' => 'col-sm-4 control-label']) !!}
				{!! Form::select('visibility[country_id][]',  ['0' => 'select all country'] + $countries, null, ['multiple'=> '','class' => 'form-control'] )
				 !!}
			@endif
			@if(in_array($page,['destination']))
				<input name="visibility[country_id][]" type="hidden" value="0">
			@endif

			{!! Form::label('Gender', 'Show for gender: ', ['class' => 'col-sm-4 control-label']) !!}
			{!! Form::select('visibility[gender]',  $gender, null, ['class' => 'form-control'] ) !!}
			{!! $errors->first('visibility', '<p class="help-block">:message</p>') !!}
		</div>
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
	<div class="form-group {{ $errors->has('metadata.category_id') ? 'has-error' : ''}} post-field">
		{!! Form::label('content tags', 'Category:* ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-6">
			{!! Form::select('metadata[category_id][]', $journeys, null,
			['class' =>
			'form-control','multiple'=>'','id'=>'tags']) !!}
			{!! $errors->first('metadata.category_id', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('Category', 'Enable AND logic: ', ['class' => 'col-sm-3 control-label']) !!}
		<label data-type="and-category">
			{!! Form::checkbox('metadata[category][type]','and', isset($block->metadata->category->type))!!}
		</label>
	</div>

	<div class="form-group post-field {{  $errors->has('metadata.country.type') ? 'has-error' : ''}}">
		{!! Form::label('Country', 'Country: ', ['class' => 'col-sm-3 control-label']) !!}
		<div class="checkbox">
			<label data-type="all-country" class="country-category">
				{!! Form::radio('metadata[country][type]','user-selected', false)!!}
				User Selected
			</label>
			<label data-type="all-country" class="country-category">
				{!! Form::radio('metadata[country][type]','all-country',false) !!}
				All Country
			</label>
			<label data-type="country-specific" class="country-category">
				@if(request()->has('country_id'))
					{!! Form::radio('metadata[country][type]','country',true) !!}
				@else
					{!! Form::radio('metadata[country][type]','country',false) !!}
				@endif
				Country specific
			</label>
			<?php
			$show_country_specific_list = false;
			if (isset($block) && isset($block->metadata->country->type) && $block->metadata->country->type ==
					"country"
			) {
				$show_country_specific_list = true;
			}
			?>
			<div class="country-specific-list" style="display: {{($show_country_specific_list)?"block":"none"}}">
				@foreach($countries as $country_id => $country)
					<label data-type="country">
						<?php
						$show_country = false;
						if (!empty($block->metadata->country->type) && isset($block->country->country_ids) && $block->metadata->country->type ==
								"country" && in_array(
										$country_id,
										$block->country->country_ids
								)
								|| (request()->get('country_id') == $country_id)
						) {
							$show_country = true;
						}
						?>
						{!! Form::checkbox('metadata[country][country_ids][]', $country_id,$show_country)
						!!}{{$country}}</label>
				@endforeach
			</div>

		</div>
		{!! $errors->first('metadata.country.type', '<p class="help-block">:message</p>') !!}
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
				{!! Form::hidden('metadata[show_view_more][url]', (isset($block)&&isset($block->show_view_more->url))
				?$block->show_view_more->url:'shuvayatra://feed', ['class' => 'form-control required']) !!}
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
			$(document).on('click', '.country-category', function () {
				var type = $(this).data('type');
				if (type == 'country-specific') {
					$('.country-specific-list').show();
				} else {
					$('.country-specific-list').hide();
				}
			});

			if ($('input[name="metadata[country][type]"]:checked').val() == 'country') {
				$('.country-specific-list').show();
			}

		});
	</script>
@endsection

