<?php
$screens = ['home' => 'Home'];
$countries = \App\Nrna\Models\Category::find(1)->getImmediateDescendants()->lists('title', 'id')->toArray();
$dynamic_screens = \App\Nrna\Models\Screen::all()->lists('title', 'id')->toArray();
$posts = \App\Nrna\Models\Post::all()->toArray();
?>
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
	{!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::text('title', null, ['class' => 'form-control']) !!}
		{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
	{!! Form::label('description', 'Description: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::textArea('description', null, ['class' => 'form-control']) !!}
		{!! $errors->first('description', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
	{!! Form::label('type', 'Show Notification in : ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('send_notification_to',['test'=>'Test App','global'=>"Live App"],null, ['class'
		=>'form-control',
		'id'=>'post_type']) !!}
		{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group {{ $errors->has('metadata.deeplink') ? 'has-error' : ''}}">
	{!! Form::label('deeplink', 'Deeplink:', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		<select name="deeplink" class="form-control">
			<option value="">Select</option>
			<option {{(isset($pushnotification->deeplink) && $pushnotification->deeplink =="shuvayatra://home")?"selected":""}} value="shuvayatra://home">Home</option>

			<optgroup label="Destination">
				@foreach($countries as $key => $country)
					<option {{(isset($pushnotification->deeplink) && $pushnotification->deeplink =="shuvayatra://destination?destination_id=".$key)?"selected":""}} value="shuvayatra://destination?destination_id={{$key}}">{{$country}} </option>
				@endforeach
			</optgroup>
			<optgroup label="Dynamic">
				@foreach($dynamic_screens as $key => $dynamic_screen)
					<option {{(isset($pushnotification->deeplink) && $pushnotification->deeplink =="shuvayatra://screen?screen_id=".$key)?"selected":""}} value="shuvayatra://screen?screen_id={{$key}}">{{$dynamic_screen}}</option>
				@endforeach
			</optgroup>
			<optgroup label="Post">
				@foreach($posts as $post)
					<option {{(isset($pushnotification->deeplink) && $pushnotification->deeplink =="shuvayatra://".$post['metadata']->type."?post_id=".$post['id'])?"selected":""}}  value="shuvayatra://{{$post['metadata']->type}}?post_id={{$post['id']}}">{{$post['metadata']->title}}</option>
				@endforeach
			</optgroup>

		</select>
		<p class="help-block">Please select the screen from the dropdown or type the title of the post you want to deeplink.</p>
	</div>

</div>

<div style="display: none" class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
	{!! Form::label('type', 'Type: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('type',[''=>'Select', 'post'=>'Post'],null, ['class' =>'form-control','id'=>'post_type']) !!}
		{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div style="display: none" class="form-group {{ $errors->has('content_id') ? 'has-error' : ''}}">
	{!! Form::label('content_id', 'Content Id: ', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		{!! Form::select('content_id',['0'=>'Select']+$contentOptions,null, ['class' =>'form-control','id'=>'post_type']) !!}
		{!! $errors->first('content_id', '<p class="help-block">:message</p>') !!}
	</div>
</div>