@extends('layouts.master')

@section('content')
	<h1>Tags <a href="{{ route('tag.create') }}" class="btn btn-primary pull-right btn-sm">Add New Tag</a></h1>
	<div class="table">
		<table class="table table-bordered table-striped table-hover">
			<thead>
			<tr>
				<th>Name</th>
				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
			{{-- */$x=0;/* --}}
			@forelse($tags as $item)
				{{-- */$x++;/* --}}
				<tr>
					<td>{{ $item->title }}
						<span style="font-size: 10px;color: #3d3d3d;margin-top: 4px;display: block;"
							  class="post-updated_on"> Created at: {{$item->created_at}}
							/ Last Updated at: {{$item->updated_at}}</span>
					</td>
					<td>
						<a href="{{ route('tag.edit', $item->id) }}">
							<button type="submit" class="btn btn-primary btn-xs">Update</button>
						</a> /
						{!! Form::open([
							'method'=>'DELETE',
							'route' => ['tag.destroy', $item->id],
							'style' => 'display:inline'
						]) !!}
						{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
						{!! Form::close() !!}
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="3" align="center">No tags available.</td>
				</tr>
			@endforelse
			</tbody>
		</table>
		<div class="pagination"> {!! $tags->render() !!} </div>
	</div>

@endsection
