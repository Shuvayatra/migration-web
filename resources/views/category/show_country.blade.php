<div class="tab-wrap">
	<a href="{{ route('category.create') }}?section_id={{$category->id}}"
	   class="btn btn-primary btn-sm add-btn float-btn">Add Category</a>
	<div class="tab-header">
		<div class="scroller scroller-left"><i class="glyphicon glyphicon-chevron-left"></i></div>
		<div class="scroller scroller-right"><i class="glyphicon glyphicon-chevron-right"></i></div>
		<div class="wrapper">
			<ul class="nav nav-tabs list" id="myTab">
				@foreach($categories as $category)
					<li class="{{activeCategoryTab($categories,$category)}}"><a data-toggle="tab"
																				href="#category-{{$category->id}}">{{$category->title}}</a>
					</li>
				@endforeach
			</ul>
		</div>
	</div>

	<div class="tab-content">
		@foreach($categories as $category)
			<div id="category-{{$category->id}}"
				 class="tab-pane fade in {{activeCategoryTab($categories,$category)}}">
				<div class="row">
					<div class="col-md-6">
						<div class="x_panel">
							<div class="x_content green-content">
								{!! Form::model($category, [
								'method' => 'PATCH',
								'route' => ['category.update', $category->id],
								'class' => 'form-horizontal',
								'files' =>true
								]) !!}
								<label for="title">Title * :</label>
								{!! Form::text('title', null, ['class' => 'form-control']) !!}
								<br>
								<label for="title_en">Title(English) :</label>
								{!! Form::text('title_en', null, ['class' => 'form-control']) !!}
								<br>
								<div class="form-group {{ $errors->has('main_image') ? 'has-error' : ''}}">
									{!! Form::label('main_image', 'Main Image: ', ['class' => ' control-label']) !!}
									<div class="">
										{!! Form::file('main_image', null, ['class' => 'form-control']) !!}
										{!! $errors->first('main_image', '<p class="help-block">:message</p>') !!}
										@if(isset($category))
											<a href="#" class="thumbnail">
												<img src="{{$category->main_image_link}}">
											</a>
										@endif
									</div>
								</div>
								<div class="form-group {{ $errors->has('icon') ? 'has-error' : ''}}">
									{!! Form::label('icon', 'Icon: ', ['class' => ' control-label']) !!}
									<div class="">
										{!! Form::file('icon', null, ['class' => 'form-control']) !!}
										{!! $errors->first('icon', '<p class="help-block">:message</p>') !!}
										@if(isset($category))
											<a href="#" class="thumbnail">
												<img src="{{$category->icon_link}}">
											</a>
										@endif
									</div>
								</div>
								<div class="form-group {{ $errors->has('small_icon') ? 'has-error' : ''}}">
									{!! Form::label('small_icon', 'Small Icon: ', ['class' => ' control-label']) !!}
									<div class="">
										{!! Form::file('small_icon', null, ['class' => 'form-control']) !!}
										{!! $errors->first('small_icon', '<p class="help-block">:message</p>') !!}
										@if(isset($category))
											<a href="#" class="thumbnail">
												<img src="{{$category->small_icon_link}}">
											</a>
										@endif

									</div>
								</div>

								@if(isset($category))
									<div style="display:{{$category->getRoot()
											->section=='country'?'block':'none'}}">
										<button type="button" class="btn btn-default add-new-country-info"
												id="add-new-country-info">Add info +
										</button>
										<div class="country-info-wrap">
											@if(isset($category->country_info))
												<?php $j = 0;?>
												@foreach($category->country_info as $key=>$info)
													<div class="form-group county-info-item">
														{!! Form::text("country_info[$key][attribute]",
														null, ['class' => 'form-control']) !!}
														<br>
														{!! Form::text("country_info[$key][value]", null, ['class' => 'form-control']) !!}
														<div class="delete delete-phone-field btn btn-danger">X
														</div>
													</div>
													<?php $j++;?>
												@endforeach
											@endif
										</div>
									</div>
									<hr>
								@endif
								<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
									{!! Form::label('display', 'Display in app:', ['class' => 'control-label']) !!}
									<div class="">
										{!! Form::checkbox('status') !!}
										{!! $errors->first('status', '<p class="help-block">:message</p>') !!}
									</div>
								</div>
								{!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
								{!! Form::close() !!}
							</div>
						</div>
					</div>

				</div>
			</div>
		@endforeach
	</div>
</div>
<br>
<div class="sort-category">
	<h2>Sort</h2>
	<table class="table table-bordered table-striped">
		<tbody class="sortable" data-entityname="category">
		{{-- */$x=0;/* --}}
		@foreach($categories as $item)
			{{-- */$x++;/* --}}
			<tr data-itemId="{{{ $item->id }}}">
				<td class="sortable-handle"><span class="glyphicon glyphicon-sort"></span></td>
				<td class="sortable-handle">{{ $item->title }}</td>
				<td>
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