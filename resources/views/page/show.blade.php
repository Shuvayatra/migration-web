@extends('layouts.master')

@section('content')

	<h1>Page {{ $page->id }}</h1>
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover">
			<tbody>
			<tr>
				<th>ID.</th>
				<td>{{ $page->id }}</td>
			</tr>
			<tr>
				<th> {{ trans('pages.slug') }} </th>
				<td> {{ $page->slug }} </td>
			</tr>
			<tr>
				<th> {{ trans('pages.content') }} </th>
				<td> {!! $page->content !!}  </td>
			</tr>
			</tbody>
			<tfoot>
			<tr>
				<td colspan="2">
					<a href="{{ url('pages/' . $page->id . '/edit') }}" class="btn btn-primary btn-xs"
					   title="Edit Page"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
					{!! Form::open([
						'method'=>'DELETE',
						'url' => ['pages', $page->id],
						'style' => 'display:inline'
					]) !!}
					{!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
							'type' => 'submit',
							'class' => 'btn btn-danger btn-xs',
							'title' => 'Delete Page',
							'onclick'=>'return confirm("Confirm delete?")'
					));!!}
					{!! Form::close() !!}
				</td>
			</tr>
			</tfoot>
		</table>
	</div>

@endsection