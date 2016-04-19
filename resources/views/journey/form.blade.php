<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('menu_image') ? 'has-error' : ''}}">
    {!! Form::label('menu_image', 'Menu Image: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('menu_image', null, ['class' => 'form-control']) !!}
        {!! $errors->first('menu_image', '<p class="help-block">:message</p>') !!}
        @if(isset($journey))
            <img src="{{$journey->menu_image_link}}"/>
        @endif
    </div>
</div>
<div class="form-group {{ $errors->has('featured_image') ? 'has-error' : ''}}">
    {!! Form::label('featured_image', 'Featured Image: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('featured_image', null, ['class' => 'form-control']) !!}
        {!! $errors->first('featured_image', '<p class="help-block">:message</p>') !!}
        @if(isset($journey))
            <img src="{{$journey->featured_image_link}}"/>
        @endif
    </div>
</div>
<div class="form-group {{ $errors->has('small_menu_image') ? 'has-error' : ''}}">
    {!! Form::label('small_menu_image', 'Small Menu Image: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('small_menu_image', null, ['class' => 'form-control']) !!}
        {!! $errors->first('small_menu_image', '<p class="help-block">:message</p>') !!}
        @if(isset($journey))
            <img src="{{$journey->small_menu_image_link}}"/>
        @endif
    </div>
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        <div class="checkbox">
            <label>{!! Form::radio('status', '1') !!} Yes</label>
        </div>
        <div class="checkbox">
            <label>{!! Form::radio('status', '0', true) !!} No</label>
        </div>
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>
