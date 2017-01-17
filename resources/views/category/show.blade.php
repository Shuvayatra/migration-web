@extends('layouts.master')
@section('content')
	<div class="container">
		<?php
		$categories = $category->getImmediateDescendants();
		$categories = $categories->sortBy('position');
		?>
		<h1><span class="title-btn">{{$category->title}} </span></h1>
		@if($category->section !=='categories')
			@include('category.show_country',['main_category'=>$category])
		@else
			@include('category.show_categories')
		@endif
	</div>
@endsection
@section('script')
	<script id="country-info-field" type="x-tmpl-mustache">
		<div class="form-group county-info-item">
			{!! Form::text('country_info[@{{count}}][attribute]', null, ['class' => 'form-control',
			'Placeholder'=>'Attribute'])
			 !!}
		<br>
		{!! Form::text('country_info[@{{count}}][value]', null, ['class' => 'form-control','placeholder'=>'Value']) !!}
		<div class="delete delete-country-info btn btn-danger">X</div>
	</div>



	</script>
	<script>
		$(function () {
			var j = {{$j or 0}};
			$('.add-new-country-info').on('click', function (e) {
				e.preventDefault();
				j += 1;
				var template = $('#country-info-field').html();
				Mustache.parse(template);
				var rendered = Mustache.render(template, {count: j});
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





