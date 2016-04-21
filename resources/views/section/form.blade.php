<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('section') ? 'has-error' : ''}}">
    {!! Form::label('section', 'Section: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('section', null, ['class' => 'form-control']) !!}
        {!! $errors->first('section', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('is_locked') ? 'has-error' : ''}}">
    {!! Form::label('is_locked', 'Is Locked: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        <div class="checkbox">
            <label>{!! Form::radio('is_locked', '1') !!} Yes</label>
        </div>
        <div class="checkbox">
            <label>{!! Form::radio('is_locked', '0', true) !!} No</label>
        </div>
        {!! $errors->first('is_locked', '<p class="help-block">:message</p>') !!}
    </div>
</div>
