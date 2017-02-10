<table class="table table-striped table-bordered table-hover">
	<tbody>
	<?php
	$i = 0;
	?>
	@foreach($block->all_posts as $key=>$post)
		<?php
		$is_pinned = false;
		if ($custom_posts->count() > 0) {
			$is_pinned = !$custom_posts->where('id', $post->id)
									   ->isEmpty();
		}
		?>
		@if($is_pinned)
			{!! Form::hidden('posts[]',$post->id) !!}
		@else
			<tr>
				<th><a href="{{route("post.show",$post->id)}}">{{$post->id}}</a></th>
				<th>{{$post->title}}</th>
				@if($block->metadata->country->type !== "user-selected")
					<th>{!! Form::checkbox("posts[]",$post->id,false,['class' =>'post']) !!}</th>
				@endif
			</tr>
		@endif
		<?php $i++;?>
	@endforeach
	</tbody>
</table>