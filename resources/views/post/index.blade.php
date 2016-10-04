@extends('layouts.post_layout')

@section('content')
	<?php
	$tagService = app('App\Nrna\Services\TagService');
	$tags = $tagService->getList();
	?>
	<a href="{{ route('post.create') }}?{{request()->getQueryString() }}"
	   class="btn btn-primary pull-right btn-sm button">Add New Post</a>
	<div class="post-filter-wrap">
		{!! Form::open(['route' => 'post.index', 'method' => 'get', 'class'=>'form-inline']) !!}
		{!! Form::label('Start date:', 'Start date ', ['class' => 'control-label']) !!}
		{!! Form::text('date_from',Input::get('date_from'), ['class' =>'form-control datepicker','placeholder'=>'From']) !!}
		{!! Form::label('End date', 'End date ', ['class' => 'control-label']) !!}
		{!! Form::text('date_to',Input::get('date_to'), ['class' =>'form-control datepicker','placeholder'=>'To']) !!}
		{!! Form::label('Post type',null, ['class' => 'control-label']) !!}
		{!! Form::select('post_type',config('post_type'),Input::get('post_type'), ['class' =>'form-control','placeholder'=>'Select Post type']) !!}
		{!! Form::label('Post status', 'Post status ', ['class' => 'control-label']) !!}
		{!! Form::select('status' ,[''=>'Select Status']+config('post.status'),Input::get('status'), ['class' =>'form-control']) !!}
		{!! Form::label('tags', 'Tags ', ['class' => 'control-label']) !!}
		{!! Form::select('tags[]',$tags,Input::get('tags'), ['class' =>'form-control','multiple'=>true,]) !!}
		@if(Input::has('category'))
			{!! Form::hidden('category', Input::get('category')) !!}
		@endif
		@if(Input::has('sub_category'))
			{!! Form::hidden('sub_category', Input::get('sub_category')) !!}
		@endif
		@if(Input::has('sub_category1'))
			{!! Form::hidden('sub_category1', Input::get('sub_category1')) !!}
		@endif
		<br>
		{!! Form::submit('filter', ['class' => 'btn button btn-primary']) !!}
		{!! Form::close() !!}

	</div>
	<div class="table">
		<table class="table table-bordered table-striped table-hover">
			<tbody>
			<?php
			$posts->load('user');
			?>
			{{-- */$x=0;/* --}}
			@forelse($posts as $item)
				{{-- */$x++;/* --}}
				<tr>
					<td class="icon-wrap"><i class="{{$item->metadata->type}} icons" aria-hidden="true"></i></td>
					<td>
						<a href="{{route('post.show',$item->id)}}?{{request()->getQueryString() }}">{{ $item->metadata->title }}</a>
						<span class="label label-{{config('post.status_color.'.$item->metadata->status)}}">{{$item->metadata->status}}</span>
                        <span style="font-size: 10px;color: #3d3d3d;margin-top: 4px;display: block;"
							  class="post-updated_on">Created By: {{ $item->user->name }}
							Created at: {{ $item->created_at->format('Y-m-d H:m') }}
							/ Updated at: {{ $item->updated_at->format('Y-m-d H:m') }}</span>
					</td>

					<td width="150px">
						<a href="{{ route('post.edit', $item->id) }}?{{request()->getQueryString() }}">
							<button type="submit" class="btn btn-primary btn-xs table-button">Edit</button>
						</a>
						{!! Form::open([
							'method'=>'DELETE',
							'route' => ['post.destroy', $item->id,request()->getQueryString()],
							'style' => 'display:inline'
						]) !!}
						{!! Form::submit('Remove', ['class' => 'btn btn-danger btn-xs table-button']) !!}
						{!! Form::close() !!}
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
		$(function () {
			$(".datepicker").datepicker(
					{
						dateFormat: 'yy/mm/dd'
					}
			);
		});
	</script>
@endsection
@section('css')
	<link href="{{asset("css/jquery-ui.css")}}" rel="stylesheet">
@endsection

