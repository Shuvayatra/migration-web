@extends('layouts.master')
@section('content')
	<div class="container">
		<h1>Category <a href="{{ route('category.create') }}" class="btn btn-primary pull-right btn-sm">Add Section</a>
		</h1>
		<div class="x_panel">
			<table class="table table-bordered table-striped table-hover">
				<tbody class="sortable" data-entityname="category">
				{{-- */$x=0;/* --}}
				@foreach($categories->sortBy('title') as $item)
					{{-- */$x++;/* --}}
					@if($item->id !=2)
					<tr data-itemId="{{{ $item->id }}}">

						<td class="sortable-handle">
							<a href="{{ route('category.show', $item->id) }}">{{ $item->title }}</a>
						</td>
						<td width="250px">
							<a href="{{ route('category.edit' , $item->id) }}"
							   class="btn btn-primary btn-xs table-button">Edit</a>
							{!! Form::open([
							'method'=>'DELETE',
							'route' => ['category.destroy', $item->id],
							'style' => 'display:inline'
							]) !!}
							{!! Form::submit('Remove', ['class' => 'btn btn-danger btn-xs table-button']) !!}
							{!! Form::close() !!}
						</td>
					</tr>
					@endif
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection
