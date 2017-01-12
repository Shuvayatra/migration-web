@extends('layouts.master')

@section('content')
	<div class="">
		<h2>Manage Notice</h2>
	</div>
	<div>
		<a href="{{route('notice.create')}}">Create New</a>
	</div>
	<div class="block-list-wrap">
		<table class="table table-bordered table-striped table-hover">
			<tbody class="sortable" data-entityname="block">
			@forelse($notices as $item)
				<tr data-itemId="{{ $item->id }}">
					<td>
						{{$item->title}}
						<span style="font-size: 10px;color: #3d3d3d;margin-top: 4px;display: block;"
							  class="post-updated_on">

							 Created at: {{ $item->created_at->format('Y-m-d H:m') }}
							/ Updated at: {{ $item->updated_at->format('Y-m-d H:m') }}</span>
					</td>
					<td>@if(!is_null($item->country)) {{$item->country->title}}@endif</td>
					<td class="sortable-handle"><a href="{{ route('notice.edit', $item->id) }}">
							<button type="submit" class="btn btn-primary btn-xs table-button">Edit</button>
						</a>
						/{!! Form::open([
							'method'=>'DELETE',
							'route' => ['notice.destroy', $item->id],
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
