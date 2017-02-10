<div>
	<a href="{{ route('category.create') }}?section_id={{$category->id}}"
	   class="btn btn-primary btn-sm add-btn pull-right">Add Category</a>
	<table class="table table-bordered table-striped">
		<tbody>
		{{-- */$x=0;/* --}}
		@foreach($categories as $item)
			{{-- */$x++;/* --}}
			<tr data-itemId="{{{ $item->id }}}">
				<td>{{ $item->title }}</td>
				<td>
					<a href="{{ route('category.edit',$item->id) }}?section_id={{$category->id}}">
						<button type="submit" class="btn btn-primary btn-xs">Update</button>
					</a> /
					{!! Form::open([
					'method'=>'DELETE',
					'route' => ['category.destroy', $item->id],
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