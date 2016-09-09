<ul class="nav nav-tabs">
	<?php $post_type_active = true;
	if (isset($post)) {
		$post_type_active = false;
	}
	?>
	@foreach(config('post_type') as $key => $post_type)
		<li class="icon-wrap @if(isset($post) && $post->metadata->type === $key || old('metadata.type') ==$key) active @endif @if($post_type_active) active @endif ">
			<a class="post_type {{$key}}" data-post-type="{{$key}}" href="javascript:;">
				{{$post_type}}</a>
		</li>
		<?php $post_type_active = false;?>
	@endforeach
</ul>

<?php
$tagService = app('App\Nrna\Services\TagService');
$tags = $tagService->getList();
$sectionService = app('App\Nrna\Services\SectionService');
$sections = $sectionService->all();
$categories = \App\Nrna\Models\Category::where('depth', '!=', '0')->lists('title', 'id')->toArray();
$postService = app('App\Nrna\Services\PostService');
$posts = $postService->getAllPosts()->lists('title','id')->toArray();
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
}
$post_title = null;
$post_desc = null;
$post_source = null;
if (request()->has('rss_id')) {
	$feed = \App\Nrna\Models\RssNewsFeeds::find(request()->get('rss_id'));
	if (!is_null($feed)) {
		$post_title  = $feed->title;
		$post_desc   = $feed->description;
		$post_source = $feed->rss->title;
	}
}
?>
{!! Form::hidden('metadata[type]', ($show_text_type)?'text':null, ['class' => 'post_type_value']) !!}
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
	{!! Form::label('title', 'Title:* ', ['class' => 'control-label']) !!}

	{!! Form::text('metadata[title]', $post_title, ['class' => 'form-control required']) !!}
	{!! $errors->first('metadata.title', '<p class="help-block">:message</p>') !!}

</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
	{!! Form::label('description', 'Description: ', ['class' => 'control-label']) !!}

	{!! Form::textArea ('metadata[description]', $post_desc, ['class' => 'form-control description tinymce']) !!}
	{!! $errors->first('metadata.description', '<p class="help-block">:message</p>') !!}

</div>

<div style="display:@if(isset($post) && $post->metadata->type === 'text' || old('metadata.type') =="text" || $show_text_type) block @else none @endif"
	 class="content-type type-text form-group {{ $errors->has('metadata.featured_image') ? 'has-error' : ''}}">
	{!! Form::label('file', 'Featured Image: ', ['class' => 'control-label']) !!}
	{!! Form::file('metadata[featured_image]', ['class'=>'form-control' , 'id' => 'text_file'])!!}
	{!! $errors->first('metadata.featured_image', '<p class="help-block">:message</p>') !!}
	@if(isset($post))
		<a href="#" class="thumbnail">
			<img height="100px" width="100px" src="{{$post->metadataWithPath->featured_image}}">
		</a>
	@endif
	{!! Form::label('file', 'Photo Credit: ', ['class' => 'control-label']) !!}
	{!! Form::text('metadata[photo_credit]',null, ['class'=>'form-control' , 'id' => 'photo_credit'])!!}
	{!! $errors->first('metadata.photo_credit', '<p class="help-block">:message</p>') !!}
</div>

<div style="display:@if(isset($post) && $post->metadata->type === 'text' || old('metadata.type') =="text" || $show_text_type) block @else none @endif"
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
<div class="form-group {{ $errors->has('source') ? 'has-error' : ''}}">
	{!! Form::label('source', 'Source: ', ['class' => 'control-label']) !!}
	{!! Form::text('metadata[source]', $post_source, ['class' => 'form-control']) !!}
	{!! $errors->first('metadata.source', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('tag') ? 'has-error' : ''}}">
	{!! Form::label('tag', 'Tags: ', ['class' => 'control-label']) !!}

	{!! Form::select('tag[]', $tags, isset($post)?$post->tags->lists('id')->toArray():null, ['class' =>
	'form-control','multiple'=>'','id'=>'tags']) !!}
	{!! $errors->first('tag', '<p class="help-block">:message</p>') !!}

</div>

<div class="form-group {{ $errors->has('tag') ? 'has-error' : ''}}">
	{!! Form::label('tag', 'Content Tags:* ', ['class' => 'control-label']) !!}
	{!! Form::select('category_id[]', $categories, $post_categories,
	['class' =>
	'form-control','multiple'=>'','id'=>'tags']) !!}
	{!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
</div>

<hr>
<div class="form-group {{ $errors->has('tag') ? 'has-error' : ''}}">
	{!! Form::label('similar_posts', 'Similar Posts: ', ['class' => 'control-label']) !!}

	{!! Form::select('similar_posts[]', $posts, isset($post)?$post->similar_posts->lists('id')->toArray():null,
	['class' =>
	'form-control','multiple'=>'','id'=>'similar_posts']) !!}
	{!! $errors->first('similar_posts', '<p class="help-block">:message</p>') !!}
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
@include('templates.templates')

