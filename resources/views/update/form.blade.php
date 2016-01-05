@section('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet"/>
@endsection
<?php
$countryService = app('App\Nrna\Services\CountryService');
$countries      = $countryService->getList();
?>
<div class="form-group {{ $errors->has('country_id') ? 'has-error' : ''}}">
    {!! Form::label('country_id', 'Country*: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('country_id', $countries, isset($post)?$post->countries->lists('id')->toArray():null,
        ['class'=>
        'form-control']) !!}
        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title*: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description*: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>


@section('script')
    <script type="text/javascript" src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
@endsection

