<?php
$screens = ['home' => 'Home'];
$category = \App\Nrna\Models\Category::find(1);
if($category != null){
    $countries = $category->getImmediateDescendants()->lists('title', 'id')->toArray();
}else{
    $countries = array();
}
$dynamic_screens = \App\Nrna\Models\Screen::all()->lists('title', 'id')->toArray();
$posts = \App\Nrna\Models\Post::all()->toArray();
$push_notification_groups = \App\Nrna\Models\PushNotificationGroup::all()->toArray();
if(isset($pushnotification)){
    $current_groups = $pushnotification->groups()->get();
    $current_groups_ids = array();
    foreach ($current_groups as $current_group){
        array_push($current_groups_ids, $current_group->id);
    }
}
?>
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
	{!! Form::label('title', 'Title:* ', ['class' => 'col-sm-3 control-label required']) !!}
	<div class="col-sm-6">
		{!! Form::text('title', null, ['class' => 'form-control']) !!}
		{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
	</div>
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
	{!! Form::label('description', 'Description:* ', ['class' => 'col-sm-3 control-label required']) !!}
	<div class="col-sm-6">
		{!! Form::textArea('description', null, ['class' => 'form-control']) !!}
		{!! $errors->first('description', '<p class="help-block">:message</p>') !!}
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
<div class="form-group {{ $errors->has('groups[]') ? 'has-error' : ''}}">
	{!! Form::label('groups[]', 'Send to Group(s):', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
		<select name="groups[]" class="form-control" multiple required="">
			<option {{isset($push_notification_group['id']) && ($push_notification_group['id'] == 'test')?"selected":""}} value="test">Everyone</option>
			@foreach($push_notification_groups as $push_notification_group)
				<option {{(isset($current_groups_ids) && in_array($push_notification_group['id'], $current_groups_ids))?"selected":""}} value="{{$push_notification_group['id']}}">
                    {{$push_notification_group['name']}}
                </option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group {{ $errors->has('scheduled_date') ? 'has-error' : ''}}">
	{!! Form::label('scheduled_date', 'Schedule:', ['class' => 'col-sm-3 control-label']) !!}
	<div class="col-sm-6">
        <input class="form-control" type="datetime-local" id = "scheduled_date" name="scheduled_date" value="{{isset($pushnotification->scheduled_date) ? \Carbon\Carbon::parse($pushnotification->scheduled_date)->format('Y-m-d\TH:i') : null}}">
        {!! $errors->first('scheduled_date', '<p class="help-block">:message</p>') !!}
        <p class="help-block">There can be at most of 1 minute time difference.</p>
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