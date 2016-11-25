@extends('layouts.master')

@section('content')
	<div class="">
		<a href="{{route('mobile.screens')}}">Back</a>
	</div>

	<div class="block-list-wrap">

		@if(request()->get('page')=='destination')
			<?php
			$countries = \App\Nrna\Models\Category::find(1)->getImmediateDescendants();
			?>
			<div>
				<h3>Destination List</h3>
				<ul class="list-group">
					@foreach($countries as $country)
						<li class="@if(request()->get('country_id')==$country->id) active @endif"><a
									href="{{route('blocks.index',['page'=>'destination','country_id'=>$country->id])
						}}">{{$country->title}}</a></li>
					@endforeach
				</ul>
			</div>
		@endif
	</div>
	@if(request()->get('page')!='destination' || request()->has('country_id'))
		<div>
			<h3>List of blocks in {{request()->get('page','home')}} @if(request()->get('page')=='destination' && request
		()->has('country_id'))
					<?php
					$country = $countries->where('id', (int) request()->get('country_id'))->first();
					?>
					{{$country->title}}
				@endif
				screen</h3>
			<?php
			$request_query = ['page' => request()->get('page', 'home')];
			if (request()->get('page') == 'destination') {
				$request_query = $request_query + ['country_id' => request()->get('country_id')];
			}
			?>
			<a href="{{route('blocks.create',$request_query)}}">Add New block</a>
		</div>
		<table class="table table-bordered table-striped table-hover">
			<tbody class="sortable" data-entityname="block">
			@forelse($blocks as $block)
				<tr data-itemId="{{ $block->id }}">
					<td class="sortable-handle" style="width: 0px;"><span class="glyphicon glyphicon-sort"></span></td>

					@if(request()->get('page')=="destination")
						<td class="sortable-handle">{{$block->country->title}}</td>
					@endif
					<td class="sortable-handle">{{$block->layout}}</td>
					<td class="sortable-handle">{{$block->title}}</td>
					<td class="sortable-handle"><a
								href="{{ route('blocks.edit', $block->id) }}?{{request()->getQueryString() }}">
							<button type="submit" class="btn btn-primary btn-xs table-button">Edit</button>
						</a>
						/{!! Form::open([
							'method'=>'DELETE',
							'route' => ['blocks.destroy', $block->id],
							'style' => 'display:inline'
						]) !!}
						{!! Form::submit('Remove', ['class' => 'btn btn-danger btn-xs table-button']) !!}
						{!! Form::close() !!}</td>
				</tr>
			@empty
				<tr>
					<td class="no-data" colspan="3">no data</td>
				</tr>
			@endforelse
			</tbody>
		</table>
	@endif
@endsection
