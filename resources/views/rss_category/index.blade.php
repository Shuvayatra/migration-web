@extends('layouts.master')

@section('content')

	<h1>Categories <a href="{{ route('rss_category.create') }}" class="btn btn-primary pull-right btn-sm">Add New
		</a></h1>
	<div class="table">
		<table class="table table-bordered table-striped table-hover">
			<thead>
			<tr>
				<th>S.No</th>
				<th>Title</th>
				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
			{{-- */$x=0;/* --}}
			@foreach($rss_categories as $item)
				{{-- */$x++;/* --}}
				<tr>
					<td>{{ $x }}</td>
					<td>{{ $item->title }}</td>
					<td>
						<a href="{{ route('rss_category.edit', $item->id) }}">
							<button type="submit" class="btn btn-primary btn-xs">Update</button>
						</a> /
						{!! Form::open([
							'method'=>'DELETE',
							'route' => ['rss_category.destroy', $item->id],
							'style' => 'display:inline'
						]) !!}
						{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>

	</div>

@endsection
