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
        {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    {!! Form::label('type', 'Type: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('type',[''=>'Select', 'post'=>'Post'],null, ['class' =>'form-control required','id'=>'post_type']) !!}
        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('content_id') ? 'has-error' : ''}}">
    {!! Form::label('content_id', 'Content Id: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('content_id',['0'=>'Select']+$contentOptions,null, ['class' =>'form-control required','id'=>'post_type']) !!}
        {!! $errors->first('content_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@section('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet"/>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
@endsection