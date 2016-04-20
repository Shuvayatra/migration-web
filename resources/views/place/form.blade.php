<?php
$countryService = app('App\Nrna\Services\CountryService');
$countries = $countryService->getList()->toArray();
?>
<div class="form-group {{ $errors->has('country_id') ? 'has-error' : ''}}">
    {!! Form::label('country_id', 'Country: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('country_id', [''=>'Select']+$countries, isset($place)?$place->country->id:null, ['class'=>
        'form-control']) !!}
        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('metadata.title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('metadata[title]', null, ['class' => 'form-control required']) !!}
        {!! $errors->first('metadata.title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('metadata.phone') ? 'has-error' : ''}}">
    {!! Form::label('phone', 'Phone: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('metadata[phone][0]', null, ['class' => 'form-control required']) !!}
        {!! $errors->first('metadata.phone', '<p class="help-block">:message</p>') !!}
    </div>
    <button type="button" class="btn btn-default add-new-phone" id="add-new-phone">Add More
    </button>
</div>
<div class="phone">
    <div class="phone-item">
        @if(old('metadata.phone') || isset($place))
            <?php
              $j = 0;
              $phones = old('metadata.phone');
              if(isset($place)){
                 $phones = $place->metadata->phone;
              }

            unset($phones[0]);
            ?>
            @foreach($phones as $key=>$phone_title)
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                    {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                        {!! Form::text("metadata[phone][$key]", $phone_title, ['class' => 'form-control required']) !!}
                    </div>
                    <div data-id="{{$key}}" class="delete delete-old-phone-field btn btn-danger">X</div>
                </div>
            <?php $j++;?>
            @endforeach
        @endif
    </div>
</div>

<div class="form-group {{ $errors->has('metadata.address') ? 'has-error' : ''}}">
    {!! Form::label('address', 'Address: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('metadata[address]', null, ['class' => 'form-control required']) !!}
        {!! $errors->first('metadata.address', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('metadata.description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::textArea('metadata[description]', null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.description', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    {!! Form::label('image', 'Image: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('image', null, ['class' => 'form-control']) !!}
        {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
        @if(isset($place))
            <img class="img-thumbnail" width="100" height="100" src="{{$place->image_link}}"/>
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
@include('templates.templates')
@section('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet"/>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/mustache.min.js')}}"></script>
    <script>
        $(function () {

            var j = {{$j or 0}};
            $('.add-new-phone').on('click', function (e) {
                e.preventDefault();
                j += 1;
                var template = $('#place_phone_field').html();
                Mustache.parse(template);
                var rendered = Mustache.render(template, {count: j});
                $('.phone .phone-item:last-child').append(rendered);

            });

            $(document).on('click', '.delete-phone-field', function (e) {
                e.preventDefault();
                $(this).parent().remove();
                j -= 1;
            });
            $(document).on('click', '.delete-old-phone-field', function (e) {
                e.preventDefault();

            });
        })
    </script>
@endsection
