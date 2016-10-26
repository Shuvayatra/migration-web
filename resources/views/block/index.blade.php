@extends('layouts.master')

@section('content')
	<div class="">
		<h2>Manage App content</h2>
	</div>
	<ul>
		<li><a href="{{route('blocks.create')}}">Add Block</a></li>
		<li><a href="{{route('blocks.index',['page'=>'home'])}}">Home Page Blocks</a></li>
		<li><a href="{{route('blocks.index',['page'=>'destination'])}}">Destination Page Blocks</a></li>
		<li><a href="{{route('blocks.index',['page'=>'journey'])}}">Journey Page Blocks</a></li>

	</ul>

	<div class="block-list-wrap">
		<h3>List of Blocks in {{request()->get('page','home')}} page</h3>
		<div style="display: @if(in_array(request()->get('page'),['destination','journey'])) block @else none @endif">
			{!! Form::open(['route' => 'blocks.store','method'=>'get', 'class' => 'form-horizontal block-form']) !!}
			<?php
			$countries = \App\Nrna\Models\Category::find(1)->getImmediateDescendants()->lists('title', 'id')->toArray();
			$journeys = \App\Nrna\Models\Category::find(2)->getImmediateDescendants()->lists('title', 'id')->toArray();

			?>
			<div style="display: @if(request()->get('page')=="destination")block @else none @endif"
				 class="form-group {{ $errors->has('metadata.country_id') ?
			'has-error' : ''}}">
				{!! Form::label('country', 'Destination: * ', ['class' => 'col-sm-3 control-label']) !!}
				<div class="col-sm-6">
					{!! Form::select('country_id', [''=>'Select']+$countries, request()->get('country_id'), ['class'=>
					'form-control']) !!}
				</div>
			</div>
			<div style="display: @if(request()->get('page')=="journey")block @else none @endif" class="form-group {{
			$errors->has('metadata.journey_id') ? 'has-error' : ''}}">
				{!! Form::label('journey', 'Journey: * ', ['class' => 'col-sm-3 control-label']) !!}
				<div class="col-sm-6">
					{!! Form::select('journey_id', [''=>'Select']+$journeys, request()->get('journey_id'), ['class'=>
					'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3"></div>
				<div class="col-sm-3">
					{!! Form::hidden('page',request()->get('page','home')) !!}
					{!! Form::submit('Filter', ['class' => 'btn btn-primary form-control']) !!}
				</div>
			</div>
			{!! Form::close() !!}
		</div>
		<table class="table table-bordered table-striped table-hover">
			<tbody class="sortable" data-entityname="block">
			@forelse($blocks as $block)
				<tr data-itemId="{{ $block->id }}">
					<td class="sortable-handle" style="width: 0px;"><span class="glyphicon glyphicon-sort"></span></td>

					@if(request()->get('page')=="destination")
						<td class="sortable-handle">{{$block->country->title}}</td>
					@endif
					@if(request()->get('page')=="journey")
						<td>{{$block->journey->title}}</td>
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
	</div>
@endsection
