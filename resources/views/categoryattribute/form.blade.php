<?php
use App\Nrna\Models\CategoryAttribute;
$categories = CategoryAttribute::where('section_id', $section_id)
                                    ->where('parent_id', 0)
                                    ->lists('title', 'id')->toArray();
?>
<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : ''}}">
    {!! Form::label('parent_id', 'Parent : ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('parent_id', ['0'=>'Select if subcategory']+$categories,null, ['class' => 'form-control']) !!}
        {!! $errors->first('parent_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('main_image') ? 'has-error' : ''}}">
    {!! Form::label('main_image', 'Main Image: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('main_image', null, ['class' => 'form-control']) !!}
        {!! $errors->first('main_image', '<p class="help-block">:message</p>') !!}
        @if(isset($categoryattribute))
            <a href = "#" class = "thumbnail">
                <img src = "{{$categoryattribute->main_image_link}}">
            </a>
        @endif
    </div>
</div>
<div class="form-group {{ $errors->has('icon') ? 'has-error' : ''}}">
    {!! Form::label('icon', 'Icon: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('icon', null, ['class' => 'form-control']) !!}
        {!! $errors->first('icon', '<p class="help-block">:message</p>') !!}
        @if(isset($categoryattribute))
            <a href = "#" class = "thumbnail">
                <img src = "{{$categoryattribute->icon_link}}">
            </a>
        @endif
    </div>
</div>
<div class="form-group {{ $errors->has('small_icon') ? 'has-error' : ''}}">
    {!! Form::label('small_icon', 'Small Icon: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('small_icon', null, ['class' => 'form-control']) !!}
        {!! $errors->first('small_icon', '<p class="help-block">:message</p>') !!}
        @if(isset($categoryattribute))
            <a href = "#" class = "thumbnail">
                <img src = "{{$categoryattribute->small_icon_link}}">
            </a>
        @endif

    </div>
</div>
