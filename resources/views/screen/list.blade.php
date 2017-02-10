<h3>Dynamic Screens <a href="{{ route('screen.create') }}" class="btn btn-primary pull-right btn-sm">Create New
		Screen</a></h3>
<div>
	<table class="table table-bordered table-striped table-hover">
		<thead>
		<tr>
			<th></th>
			<th>Icon</th>
			<th>Name</th>
			<th>Title</th>
			<th>Type</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody class="sortable" data-entityname="screen">
		@forelse($screens as $screen)
			<tr data-itemId="{{ $screen->id }}">
				<td class="sortable-handle"><span class="glyphicon glyphicon-sort"></span></td>
				<td class="sortable-handle"><img width="100px" height="80px" src="{{ $screen->icon_image_path
				}}"/></td>
				<td class="sortable-handle"><a href="{{ route('screen.edit', [$screen->id]) }}">{{ $screen->name }}</a>
				</td>
				<td class="sortable-handle">{{ $screen->title }}</td>
				<td class="sortable-handle">{{ $screen->type }}</td>
				<td>
					<a href="{{ route('screen.edit', $screen->id) }}">
						<button type="submit" class="btn btn-primary btn-xs table-button">Update</button>
					</a> /
					@if($screen->type=="block")
					<a href="{{ route('blocks.index', ["page"=>'dynamic',"screen_id"=>$screen->id]) }}">
						<button type="button" class="btn btn-primary btn-xs table-button">Manage</button>
					</a>
					@endif
					@if($screen->type=="feed")
						<a href="{{ route('screen.feed.create', $screen->id) }}">
							<button type="button" class="btn btn-primary btn-xs table-button">Manage</button>
						</a>
					@endif
							/
					{!! Form::open([
						'method'=>'DELETE',
						'route' => ['screen.destroy', $screen->id],
						'style' => 'display:inline'
					]) !!}
					{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs table-button']) !!}
					{!! Form::close() !!}
				</td>
			</tr>
		@empty
			<tr>
				<td>No Record Found</td>
			</tr>
		@endforelse
		</tbody>
	</table>
</div>