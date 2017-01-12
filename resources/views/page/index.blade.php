@extends('layouts.master')

@section('content')
	<h1>Pages <a href="{{ route('pages.create') }}" class="btn btn-primary btn-xs" title="Add New Page"><span
					class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
	<div class="table">
		<table class="table table-bordered table-striped table-hover">
			<thead>
			<tr>
				<th>S.No</th>
				<th> {{ trans('pages.slug') }} </th>

				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
			{{-- */$x=0;/* --}}
			@foreach($pages as $item)
				{{-- */$x++;/* --}}
				<tr>
					<td>{{ $x }}</td>
					<td>{{ $item->slug }}</td>
					<td>
						<a href="{{ route('pages.show', $item->id) }}" class="btn btn-success btn-xs"
						   title="View Page"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
						<a href="{{ route('pages.edit',$item->id ) }}" class="btn btn-primary btn-xs"
						   title="Edit Page"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
						{!! Form::open([
							'method'=>'DELETE',
							'url' => ['/pages', $item->id],
							'style' => 'display:inline'
						]) !!}
						{!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Page" />', array(
								'type' => 'submit',
								'class' => 'btn btn-danger btn-xs',
								'title' => 'Delete Page',
								'onclick'=>'return confirm("Confirm delete?")'
						));!!}
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<div class="pagination"> {!! $pages->render() !!} </div>
	</div>


@endsection
