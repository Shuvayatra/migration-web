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
			@forelse($notices as $notice)
				<tr data-itemId="{{ $notice->id }}">
					<td>
						{{$notice->title}}
						<span style="font-size: 10px;color: #3d3d3d;margin-top: 4px;display: block;"
							  class="post-updated_on">

							 Created at: {{ $notice->created_at->format('Y-m-d H:m') }}
							/ Updated at: {{ $notice->updated_at->format('Y-m-d H:m') }}</span>
					</td>
					<td>
						@if(isset($notice->screen->screen_type)&&$notice->screen->screen_type =="home")
							<span class="label label-success">Home</span>
						@endif
						@if(isset($notice->screen->screen_type)&&$notice->screen->screen_type =="dynamic")
							@if(!is_null($notice->dynamic_screen))
								<span class="label label-default">
								{{$notice->dynamic_screen->title}}
							</span>
							@endif
						@endif
						@if(isset($notice->screen->screen_type)&&$notice->screen->screen_type =="country")
							<span class="label label-default">{{$notice->destination->title}}</span>
						@endif
					</td>
					<td class="sortable-handle"><a href="{{ route('notice.edit', $notice->id) }}">
							<button type="submit" class="btn btn-primary btn-xs table-button">Edit</button>
						</a>
						/{!! Form::open([
							'method'=>'DELETE',
							'route' => ['notice.destroy', $notice->id],
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
