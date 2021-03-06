<?php
$countries = \App\Nrna\Models\Category::whereSection('country')->first()->getImmediateDescendants()->lists(
    'title',
    'id'
)->toArray();
?>
@extends('layouts.master')

@section('content')
	<?php
	$custom_posts = $block->custom_posts;
	?>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong> Block Detail</strong>
					<?php
					$request_query = ['page' => request()->get('page', 'home')];
					if (request()->get('page') == 'destination') {
						$request_query = $request_query + ['country_id' => request()->get('country_id')];
					}
					if (request()->get('page') == 'dynamic') {
						$request_query = $request_query + ['screen_id' => request()->get('screen_id')];
					}
					?>
					<span class="pull pull-right"><a href="{{route('blocks.edit',[$block->id]+$request_query)
					}}">Edit</a></span>
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
								<br>	Using <span style="font-weight: 600">'{{$block->getCategoryOperator()}} '</span> logic

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
		@if($block->metadata->country->type !== "user-selected")
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>Pinned Posts</strong>
						<small class="pull pull-right">(Drag and drop to rearrange position)</small>
					</div>
					<div class="panel-body" id="block_custom_posts">
						@include('block.pinned_posts_table')
					</div>
				</div>
			</div>
		@endif
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<strong class="pull-left">Posts</strong>
					@if(isset($block->metadata->country->type) && $block->metadata->country->type === "user-selected")
						<div class="dropdown pull pull-right">
							<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								@if(request()->has('country_id'))
								{{ $countries[request()->get('country_id')] }}
								@else
								Select Country
								@endif
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" style="background: #f5f5f5" aria-labelledby="dropdownMenu1">
								@foreach($countries as $country_id => $country)
									<li><a href="{{Request::url().'?country_id='.$country_id}}">{{$country}}</a></li>
								@endforeach
							</ul>
						</div>
					@endif
				</div>
				<div class="panel-body" id="post_list_table">
					@include('block.all_posts_table')
				</div>
			</div>
		</div>
	</div>

@endsection
@section('script')
	<script>
		$(function () {
			$(document).on('click', '.unpin_post', function (e) {
				var unpin_url = "{{route('blocks.unpin.post',$block->id)}}";
				var post_id = $(this).data('itemid');
				$.ajax({
					'url': unpin_url,
					'type': 'POST',
					'data': {post_id: post_id},
					'success': function (data) {
						if (data.success) {
							$('#block_custom_posts').html(data.custom_posts_table);
							$('#post_list_table').html(data.all_post_table);
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
			$(document).on('click', '.post', function (e) {
				var postId = $(this).val();
				var save_url = "{{route('blocks.posts.store',$block->id)}}";
				$.ajax({
					'url': save_url,
					'type': 'POST',
					'data': {post_id: postId},
					'success': function (data) {
						if (data.success) {
							$('#block_custom_posts').html(data.custom_posts_table);
							$('#post_list_table').html(data.all_post_table);
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