<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta name="_token" content="{!! csrf_token() !!}"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Shuvayatra Web</title>

	<!-- Bootstrap -->
	<link href="{{asset("css/vendors.min.css")}}" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="{{asset("css/app.min.css")}}" rel="stylesheet">
	<!-- Bootstrap -->
	@yield('css')
</head>

<body>
@include('layouts.partials.top_menu')
@if ($errors->any())
	<ul class="alert alert-danger">
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
@endif
@if (\Session::has('success'))
	<div class="alert alert-success fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
		{{Session::get('success')}}
	</div>
@endif
@if (\Session::has('error'))
	<div class="alert alert-danger fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
		{{Session::get('error')}}
	</div>
@endif
<div class="parent-wrapper">
	<?php $post_column = 12;
	$post_column_offset = 2;

	?>
	@include('post.partials.sidebar')
	<?php
	if (request()->has('category')) {
		$post_column = $post_column - 2;
	}
	if (request()->has('sub_category')) {
		$post_column        = $post_column - 2;
		$post_column_offset = 4;
	}
	?>
	<div class="col-md-{{$post_column}} col-xs-12 panel_content col-md-offset-{{$post_column_offset}}">
		<div class="x_panel">
			<div class="x_content">
				@yield('content')
			</div>
		</div>
	</div>

</div>

<div class="clearfix"></div>

@include('layouts.partials.footer')

<script src="{{asset("js/vendors.min.js")}}"></script>

<script src="{{asset("js/tinymce/tinymce.min.js")}}"></script>
<script src="{{asset("js/app.min.js")}}"></script>

@yield('script')
		<!-- Custom Theme Scripts -->
@include('layouts.partials.notification')
<script>
	(function ($) {
		$(window).ready(function () {
			$(".main-sidebar").mCustomScrollbar();
			$(".sub-sidebar").mCustomScrollbar();
		});
	})(jQuery);
</script>
</body>
</html>
