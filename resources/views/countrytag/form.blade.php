<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
{{--<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">--}}
    {{--{!! Form::label('status', 'Status: ', ['class' => 'col-sm-3 control-label']) !!}--}}
    {{--<div class="col-sm-6">--}}
        {{--<div class="checkbox">--}}
            {{--<label>{!! Form::radio('status', '1') !!} Yes</label>--}}
        {{--</div>--}}
        {{--<div class="checkbox">--}}
            {{--<label>{!! Form::radio('status', '0', true) !!} No</label>--}}
        {{--</div>--}}
        {{--{!! $errors->first('status', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}
