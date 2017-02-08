@if(request()->ajax())
	<script src="{{asset('js/app.min.js')}}"></script>
@endif
<table class="table table-striped table-hover">
	<tbody class="sortable" data-entityname="block_posts">

	@foreach ($custom_posts as $key=>$post)
		<tr data-itemId="{{ $post->id }}" data-parentId="{{ $block->id }}">
			<td class="sortable-handle"><span class="glyphicon glyphicon-sort"></span></td>
			<th class="sortable-handle"><a href="{{route("post.show",$post->id)}}">{{$post->id}}</a>
			</th>
			<th class="sortable-handle">{{$post->title}}</th>
			<th class="sortable-handle">
				<button data-itemId="{{ $post->id }}" data-parentId="{{ $block->id }}"
						class="unpin_post">Remove
				</button>
			</th>
		</tr>
	@endforeach
	</tbody>
</table>
