<ul class="nav nav-tabs">
	<?php $post_type_active = "text";
	if (isset($post)) {
		if (old('metadata.type')) {
			$post_type_active = old('metadata.type');
		} else {
			$post_type_active = $post->metadata->type;
		}
	}
	if (request()->has('post_type_value')) {
		$post_type_active = request()->get('post_type_value');
	}
	?>
	@foreach(config('post_type') as $key => $post_type)
		<li class="icon-wrap
		@if($post_type_active==$key) active @endif ">
			<a class="post_type {{$key}}" data-post-type="{{$key}}" href="javascript:;">
				{{$post_type}}</a>
		</li>
	@endforeach
</ul>

<?php
$tagService = app('App\Nrna\Services\TagService');
$tags = $tagService->getList();
$sectionService = app('App\Nrna\Services\SectionService');
$sections = $sectionService->all();
$categories = \App\Nrna\Models\Category::where('section', 'categories')
									   ->first()->getImmediateDescendants()->sortBy('title')->lists('title', 'id')
									   ->toArray();
$countries = \App\Nrna\Models\Category::where('section', 'country')->first()->getImmediateDescendants()->lists(
		'title',
		'id'
)
									  ->toArray();
$postService = app('App\Nrna\Services\PostService');
$posts = $postService->getAllPosts()->lists('title', 'id')->toArray();
$show_text_type = true;
if (isset($post)) {
	$show_text_type = false;
}
$post_categories = [];
if (request()->has('sub_category1')) {
	$post_categories [] = request()->get('sub_category1');
}
if (request()->has('sub_category')) {
	$post_categories [] = request()->get('sub_category');
}
if (isset($post)) {
	$post_categories = $post->categories->lists('id')->toArray();
	$post_image      = isset($post->metadata->data->news_featured_image_link) ? $post->metadata->data->news_featured_image_link : '';
}
$post_title = null;
$post_desc = null;
$post_source = null;
if (request()->has('url')) {
	if (isset($news) && !is_null($news)) {
		$post_title = $news['title'];
		$post_desc  = $news['description'];
		$post_image = $news['image'];
	}
}

?>
<div style="display:@if(isset($post)) block @else block @endif"
	 class="form-group {{ $errors->has('metadata.data.url') ? 'has-error' : ''}}">
	{!! Form::label('url', 'Url: ', ['class' => 'control-label']) !!}
	{!! Form::text('metadata[data][url]',request()->get('url'), ['class'=>'form-control feed-url'])!!}
	{!! $errors->first('metadata.data.url', '<p class="help-block">:message</p>') !!}
	{!! Form::button('Fetch news', ['class' => 'btn fetch-url-content-btn form-control']) !!}
	@if(isset($post_image))
		{!! Form::hidden('metadata[data][news_featured_image_link]',$post_image)!!}
		<a href="#" class="thumbnail">
			<img height="" width="" src="{{$post_image}}">
		</a>
	@endif
</div>

{!! Form::hidden('metadata[type]', $post_type_active, ['class' => 'post_type_value']) !!}
<div class="form-group {{ $errors->has('metadata.title') ? 'has-error' : ''}}">
	{!! Form::label('title', 'Title:* ', ['class' => 'control-label']) !!}

	{!! Form::text('metadata[title]', $post_title, ['class' => 'form-control required']) !!}
	{!! $errors->first('metadata.title', '<p class="help-block">:message</p>') !!}

</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
	{!! Form::label('description', 'Description: ', ['class' => 'control-label']) !!}

	{!! Form::textArea ('metadata[description]', $post_desc, ['class' => 'form-control description tinymce']) !!}
	{!! $errors->first('metadata.description', '<p class="help-block">:message</p>') !!}

</div>

<div style="display:@if(isset($post) && $post->metadata->type === 'text' || old('metadata.type') =="text" ||
$post_type_active=="text" || $post->metadata->type === 'place' || old('metadata.type') =="place" ||
$post_type_active=="place")
		block @else none @endif"
	 class="content-type type-text type-place form-group {{ $errors->has('metadata.featured_image') ? 'has-error' :
	 ''}}">
	{!! Form::label('file', 'Featured Image: ', ['class' => 'control-label']) !!}
	{!! Form::file('metadata[featured_image]', ['class'=>'form-control' , 'id' => 'text_file'])!!}
	{!! $errors->first('metadata.featured_image', '<p class="help-block">:message</p>') !!}
	@if(isset($post))
		<a href="#" class="thumbnail">
			<img src="{{$post->metadataWithPath->featured_image}}">
		</a>
	@endif

	{!! Form::label('file', 'Photo Credit: ', ['class' => 'control-label']) !!}
	{!! Form::text('metadata[photo_credit]',null, ['class'=>'form-control' , 'id' => 'photo_credit'])!!}
	{!! $errors->first('metadata.photo_credit', '<p class="help-block">:message</p>') !!}
</div>

<div style="display:@if(isset($post) && $post->metadata->type === 'text' || old('metadata.type') =="text" || $post_type_active=="text") block @else none @endif"
	 class="content-type type-text">
	@include('post.partials.type_text')
</div>

<div style="display: @if(isset($post) && $post->metadata->type === 'video' || old('metadata.type') =="video") block @else none @endif"
	 class="form-group content-type  type-video {{ $errors->has('media_url') ? 'has-error' : ''}}">
	{!! Form::label('media_url', 'Media Url: ', ['class' => 'control-label']) !!}

	{!! Form::text('metadata[data][media_url]',null, ['class' => 'form-control']) !!}
	{!! $errors->first('metadata.media_url', '<p class="help-block">:message</p>') !!}

</div>

<div class="content-type type-audio"
	 style="display: @if(isset($post) && $post->metadata->type === 'audio'|| old('metadata.type') =="audio")block @else none @endif">
	@include('post.partials.type_audio')
</div>
<div class="content-type type-place"
	 style="display: @if(isset($post) && $post->metadata->type === 'place'|| old('metadata.type') =="place")block @else none @endif">
	@include('post.partials.type_place')
</div>
<div class="form-group {{ $errors->has('language') ? 'has-error' : ''}}">
	{!! Form::label('language', 'Language: ', ['class' => 'control-label']) !!}

	{!! Form::select('metadata[language]', config('language'),null, ['class' => 'form-control']) !!}
	{!! $errors->first('metadata.language', '<p class="help-block">:message</p>') !!}

</div>

<div class="form-group col-md-6 {{ $errors->has('source') ? 'has-error' : ''}}">
	{!! Form::label('source', 'Source: ', ['class' => 'control-label']) !!}
	{!! Form::text('metadata[source]', $post_source, ['class' => 'form-control']) !!}
	{!! $errors->first('metadata.source', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('source_url') ? 'has-error' : ''}}">
	{!! Form::label('source_url', 'Source Url: ', ['class' => 'control-label']) !!}
	{!! Form::text('metadata[source_url]', null, ['class' => 'form-control']) !!}
	{!! $errors->first('metadata.source_url', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
	{!! Form::label('tag', 'Category:* ', ['class' => 'control-label']) !!}
	{!! Form::select('category_id[]', $categories, $post_categories,
	['class' =>
	'form-control','multiple'=>'','id'=>'tags']) !!}
	{!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
	{!! Form::label('tag', 'Country: ', ['class' => 'control-label']) !!}
	{!! Form::select('category_id[]', ['0' => 'select all country'] + $countries, $post_categories,
	['class' => 'form-control','multiple'=>true,'id'=>'tags']) !!}
</div>

<div class="form-group {{ $errors->has('tag') ? 'has-error' : ''}}">
	{!! Form::label('tag', 'Tags: ', ['class' => 'control-label']) !!}

	{!! Form::select('tag[]', $tags, isset($post)?$post->tags->lists('id')->toArray():null, ['class' =>
'form-control','multiple'=>'','id'=>'tags']) !!}
	{!! $errors->first('tag', '<p class="help-block">:message</p>') !!}

</div>


<hr>
<div class="form-group {{ $errors->has('tag') ? 'has-error' : ''}}">
	{!! Form::label('similar_posts', 'Similar Posts: ', ['class' => 'control-label']) !!}

	{!! Form::select('similar_posts[]', $posts, isset($post)?$post->similar_posts->lists('id')->toArray():null,
	['class' =>
	'form-control','multiple'=>'','id'=>'similar_posts']) !!}
	{!! $errors->first('similar_posts', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group">
	{!! Form::label('content', 'Priority: ', ['class' => 'control-label']) !!}
	{!! Form::selectRange('priority', 1, 10,isset($post)?$post->priority:10,['class' =>'form-control']) !!}
	{!! $errors->first('priority', '<p class="help-block">:message</p>') !!}
</div>
<hr>
@if(isset($post))
	<div class="form-group {{ $errors->has('created_at') ? 'has-error' : ''}}">
		{!! Form::label('created_at', 'Created At: ', ['class' => 'control-label']) !!}
		<div class='input-group date form_datetime'>
			{!! Form::text('created_at', null, ['class' => 'form-control datetime']) !!}
			<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
			{!! $errors->first('created_at', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
@endif

<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
	{!! Form::label('status', 'Status: ', ['class' => 'control-label']) !!}
	<div class="">
		{!! Form::select('metadata[status]' ,config('post.status'),null, ['class' =>
		'form-control','id'=>'post_status']) !!}
		{!! $errors->first('metadata.status', '<p class="help-block">:message</p>') !!}
	</div>
</div>
@section('script')
	<script>
		$(function () {
			$('.fetch-url-content-btn').on('click', function () {
				var url = $('.feed-url').val();
				var post_type = $('.post_type_value').val();
				if (url != '' && validateURL(url)) {
					var post_url = updateQueryStringParameter(document.location.href, 'url', url);
					post_url = updateQueryStringParameter(post_url, 'post_type_value', post_type);
					window.location = post_url;
				} else {
					alert('Please enter validate url.')
				}
			});
		});
		function updateQueryStringParameter(uri, key, value) {
			var re = new RegExp("([?|&])" + key + "=.*?(&|#|$)", "i");
			if (uri.match(re)) {
				return uri.replace(re, '$1' + key + "=" + value + '$2');
			} else {
				var hash = '';
				if (uri.indexOf('#') !== -1) {
					hash = uri.replace(/.*#/, '#');
					uri = uri.replace(/#.*/, '');
				}
				var separator = uri.indexOf('?') !== -1 ? "&" : "?";
				return uri + separator + key + "=" + value + hash;
			}
		}
		var validateURL = function (textval) {
			var urlregex = /^(https?|ftp):\/\/([a-zA-Z0-9.-]+(:[a-zA-Z0-9.&%$-]+)*@)*((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(:[0-9]+)*(\/($|[a-zA-Z0-9.,?'\\+&%$#=~_-]+))*$/;
			return urlregex.test(textval);
		}
	</script>
@append
@include('templates.templates')

