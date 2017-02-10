@extends('layouts.master')

@section('content')

	<h1>Radio <a href="{{ route('rss.create') }}" class="btn btn-primary pull-right btn-sm">Add New</a></h1>
	<div class="table">
		<table class="table table-bordered table-striped table-hover">
			<thead>
			<tr>
				<th>S.No</th>
				<th>Title</th>
				<th>Category</th>
				<th>Url</th>
				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
			{{-- */$x=0;/* --}}
			@foreach($rsses as $item)
				{{-- */$x++;/* --}}
				<tr>
					<td>{{ $x }}</td>
					<td><a href="{{ url('/rss', $item->id) }}">{{ $item->title }}</a></td>
					<td>{{ ($item->category->title !== null) ? $item->category->title :'' }}</td>
					<td>{{ $item->url }}</td>
					<td>
						<a href="{{ route('rss.edit', $item->id) }}">
							<button type="submit" class="btn btn-primary btn-xs">Update</button>
						</a> /
						{!! Form::open([
							'method'=>'DELETE',
							'route' => ['rss.destroy', $item->id],
							'style' => 'display:inline'
						]) !!}
						{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<div class="pagination"> {!! $rsses->render() !!} </div>
	</div>

@endsection
