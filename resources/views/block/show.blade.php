@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong> Block Detail</strong>
					<span class="pull pull-right"><a href="{{route('blocks.edit',$block->id)}}">Edit</a></span>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover">
						<tbody>
						<tr>
							<th>Layout</th>
							<th>{{$block->metadata->layout}}</th>
						</tr>
						<tr>
							<th>Title</th>
							<th>{{$block->metadata->title}}</th>
						</tr>
						<tr>
							<th>Description</th>
							<td>{{$block->metadata->description}}</td>
						</tr>
						<tr>
							<th>Visible to</th>
							<td>
								<label>Country</label>
								@if(!is_null($block->visibility) && isset($block->visibility['country_id']))
									@foreach($block->visibility['country_id'] as $country)
										@if($country==0)
											<span class="label label-default">All country</span>
										@else
											<?php $countryObject = \App\Nrna\Models\Category::find($country);?>
											<span class="label label-default">{{$countryObject->title}}</span>
										@endif

									@endforeach
								@endif
								<br>
								<label>Gender</label>
								<span class="label label-default">
									{{config('screen.gender.'.$block->visibility['gender'])}}
								</span>
							</td>
						</tr>
						<tr>
							<th>Categories</th>
							<td>@foreach($block->getCategories() as $category)
									<span class="label label-default">
									{{$category->title}}
								</span>&nbsp;
								@endforeach
							</td>
						</tr>
						<tr>
							<th>Countries</th>
							<td>{{isset($block->metadata->country->type)?$block->metadata->country->type:''}}
								@if(isset($block->metadata->country->type) &&
								$block->metadata->country->type=="country")
									<br>
									@foreach($block->getSpecificCountries() as $country)
										<span class="label label-default">
									{{$country->title}}
								</span>&nbsp;
									@endforeach
								@endif

							</td>
						</tr>
						<tr>
							<th>No of posts</th>
							<td>{{$block->metadata->number_of_post}}</td>
						</tr>

						<tr>
							<th>Created At</th>
							<td>{{$block->created_at}}</td>
						</tr>
						@if($block->created_at->timestamp != $block->updated_at->timestamp)
							<tr>
								<th>Updated At</th>
								<td>{{$block->updated_at}}</td>
							</tr>
						@endif
						</tbody>
					</table>

				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong> Posts</strong>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover">
						<tbody>
						{!! Form::open(['route' => ['blocks.posts.store',$block->id], 'class' => 'form-horizontal
						block-form','id'=>'block-posts-form'])
						 !!}
						<?php
						$custom_posts = $block->custom_posts;
						$i = 0;
						?>
						@foreach($block->all_posts as $key=>$post)
							<tr>
								<th><a href="{{route("post.show",$post->id)}}">{{$post->id}}</a></th>
								<th>{{$post->title}}</th>
								<?php
								$select_post = false;
								if ($custom_posts->count() > 0) {
									$select_post = !$custom_posts->where('id', $post->id)
																 ->isEmpty();
								} else {
									$select_post = $i < $block->metadata->number_of_post;
								}
								?>
								<th>{!! Form::checkbox("posts[]",$post->id,$select_post,
								['class' =>
								 'post']) !!} </th>
							</tr>
							<?php $i++;?>
						@endforeach
						{!! Form::close() !!}

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection
@section('script')
	<script>
		$(function () {
			$(document).on('click', '.post', function (e) {
				var $form = $('#block-posts-form');
				var formData = $form.serialize();
				var save_url = $form.attr('action');
				$.ajax({
					'url': save_url,
					'type': 'POST',
					'data': formData,
					'success': function (data) {
						if (data.success) {
							App.notify.success('Saved!');
						} else {
							App.notify.validationError(data.errors);
						}
					},
					'error': function () {
						App.notify.danger('Something wrong!');
					}
				});
			});

		});
	</script>
@endsection