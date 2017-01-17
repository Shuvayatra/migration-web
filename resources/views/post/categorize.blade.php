@extends('layouts.post_layout')

@section('content')
	<?php
	$tagService = app('App\Nrna\Services\TagService');
	$tags = $tagService->getList();
	$users = \App\Nrna\Models\User::all()->lists('name', 'id')->toArray();
	$countries = \App\Nrna\Models\Category::whereSection('country')->first()->getImmediateDescendants()->lists(
			'title',
			'id'
	)->toArray();
	$categories = \App\Nrna\Models\Category::whereSection('categories')->first()->getImmediateDescendants()->lists(
			'title',
			'id'
	)
										   ->toArray();
	?>
	<div class="post-filter-wrap">
		<h3>Filter Criteria</h3>
		<div class="row">
			{!! Form::open(['route' => 'categorize.index', 'method' => 'get', 'class'=>'form-inline']) !!}
				<div class="form-group col-md-6">
					{!! Form::label('Start date:', 'Start date ', ['class' => 'control-label']) !!}
					{!! Form::text('date_from',Input::get('date_from'), ['class' =>'form-control datepicker','placeholder'=>'From']) !!}
				</div>
				<div class="form-group col-md-6">
					{!! Form::label('End date', 'End date ', ['class' => 'control-label']) !!}
					{!! Form::text('date_to',Input::get('date_to'), ['class' =>'form-control datepicker','placeholder'=>'To']) !!}
				</div>
				<div class="form-group col-md-4">
					{!! Form::label('Post type',null, ['class' => 'control-label']) !!}
					{!! Form::select('post_type',config('post_type'),Input::get('post_type'), ['class' =>'form-control','placeholder'=>'Select Post type']) !!}
				</div>
				<div class="form-group col-md-4">
					{!! Form::label('Post status', 'Post status ', ['class' => 'control-label']) !!}
					{!! Form::select('status' ,[''=>'Select Status']+config('post.status'),Input::get('status'), ['class' =>'form-control']) !!}
				</div>
				<div class="form-group col-md-4">
					{!! Form::label('tags', 'Tags ', ['class' => 'control-label']) !!}
					{!! Form::select('tags[]',$tags,Input::get('tags'), ['class' =>'form-control','multiple'=>true,]) !!}

				</div>
				<div class="form-group col-md-4">
					{!! Form::label('user', 'Author ', ['class' => 'control-label']) !!}
					{!! Form::select('user',[''=>'Select Author']+$users,Input::get('user'), ['class' =>'form-control']) !!}

				</div>
			<div class="form-group col-md-4">
				{!! Form::label('Country', 'Country ', ['class' => 'control-label']) !!}
				{!! Form::select('sub_category1[]',[''=>'Country']+$countries,Input::get('sub_category1')[0], ['class'
				=>'form-control'])
				 !!}
			</div>
			<div class="form-group col-md-4">
				{!! Form::label('Category', 'Category ', ['class' => 'control-label']) !!}
				{!! Form::select('sub_category1[]',[''=>'Category']+$categories,Input::get('sub_category1')[1], ['class'
				=>'form-control'])
				 !!}
			</div>
		</div>

		@if(Input::has('category'))
			{!! Form::hidden('category', Input::get('category')) !!}
		@endif
		@if(Input::has('sub_category'))
			{!! Form::hidden('sub_category', Input::get('sub_category')) !!}
		@endif

		{!! Form::submit('filter', ['class' => 'btn button btn-primary']) !!}
		{!! Form::close() !!}

	</div>
	<div class="table">
		<table class="table table-bordered table-striped table-hover">
			<tbody>
			<?php
			$posts->load('user', 'categories');
			?>
			{{-- */$x=0;/* --}}
			@forelse($posts as $item)
				{{-- */$x++;/* --}}
				<tr>
					<td class="icon-wrap"><i class="{{$item->metadata->type}} icons" aria-hidden="true"></i></td>
					<td>
						<a href="{{route('post.show',$item->id)}}?{{request()->getQueryString() }}">{{ $item->metadata->title }}</a>
						<span></span>
						<span class="label label-{{config('post.status_color.'.$item->metadata->status)}}">{{$item->metadata->status}}</span>
						<span style="font-size: 10px;color: #3d3d3d;margin-top: 4px;display: block;"
							  class="post-updated_on">Created By: {{ $item->user->name }}
							Created at: {{ $item->created_at->format('Y-m-d H:m') }}
							/ Updated at: {{ $item->updated_at->format('Y-m-d H:m') }}</span>
						<br>
						New Category
						{!! Form::select('category_id[]', $categories+$countries, $item->categories->lists('id')
						->toArray(),
						['class'
						=>'form-control
						new-category',
						'data-post-id'=>$item->id,
						'multiple'=>'']) !!}

					</td>


				</tr>
			@empty
				<tr>
					<td colspan="4" align="center"> No Posts Available.</td>
				</tr>
			@endforelse
			</tbody>
		</table>
		{{--@if ($posts->lastPage()>1)--}}
		{{--<div class="pagination">{!! $posts->appends($app->request->all())->render() !!}</div>--}}
		{{--<div class="pagination-text">Showing {{($posts->currentPage()==1)?"1":($posts->currentPage()-1)*$posts->perPage()}} to {{($posts->currentPage()== $posts->lastPage())?$posts->total():($posts->currentPage())*$posts->perPage()}} of {{$posts->total()}} posts</div>--}}
		{{--@endif--}}
	</div>

@endsection
@section('script')
	<script>
		var save_url = "{{route('categorize.save')}}";
		$(function () {
			$(".datepicker").datepicker(
					{
						dateFormat: 'yy/mm/dd'
					}
			);
			$(document).on('change', '.new-category', function(e) {
				var selected = [];
				$('option:selected', this).each(function(){
					selected.push($(this).val());
				});

				var postId = $(this).data("post-id");
				var data ={data:selected,post_id:postId};
				$.ajax({
					'url': save_url,
					'type': 'POST',
					'data': data,
					'success': function(data) {
						if (data.success) {
							App.notify.success('Saved!');
						} else {
							App.notify.validationError(data.errors);
						}
					},
					'error': function(){
						App.notify.danger('Something wrong!');
					}
				});
				// console.log(this.options[e.target.selectedIndex].text);
			});

		});
	</script>
@endsection
@section('css')
	<link href="{{asset("css/jquery-ui.css")}}" rel="stylesheet">
@endsection

