@section('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet"/>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
@endsection
<?php
$tagService = app('App\Nrna\Services\TagService');
$tags = $tagService->getList();
$countryService = app('App\Nrna\Services\CountryService');
$countries = $countryService->getList();
$questionService = app('App\Nrna\Services\QuestionService');
$questions = $questionService->getList();
?>
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('metadata[title]', null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('metadata[description]', null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    {!! Form::label('type', 'Type: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('metadata[type]',[''=>'']+config('post_type'),null, ['class' =>
        'form-control','id'=>'post_type']) !!}
        {!! $errors->first('metadata.type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div style="display: none" class="form-group content-type  type-text {{ $errors->has('content') ? 'has-error' : ''}}">
    {!! Form::label('content', 'Content: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::textArea('metadata[data][content]',null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.content', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div style="display: none"
     class="form-group content-type  type-video {{ $errors->has('media_url') ? 'has-error' : ''}}">
    {!! Form::label('media_url', 'Media Url: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('metadata[data][media_url]',null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.media_url', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div style="display: none" class="form-group content-type type-audio {{ $errors->has('audio') ? 'has-error' : ''}}">
    {!! Form::label('audio', 'Audio: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('metadata[data][audio]', ['class'=>'form-control required' , 'id' => 'file'])!!}
        {!! $errors->first('audio', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('source') ? 'has-error' : ''}}">
    {!! Form::label('source', 'Source: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('metadata[source]', null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.source', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('language') ? 'has-error' : ''}}">
    {!! Form::label('language', 'Language: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('metadata[language]', config('language'),null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.language', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('stage') ? 'has-error' : ''}}">
    {!! Form::label('stage', 'Stage: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('metadata[stage]', config('stage'), null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.stage', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('tag') ? 'has-error' : ''}}">
    {!! Form::label('tag', 'Tags: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('tag[]', $tags, isset($post)?$post->tags->lists('id')->toArray():null, ['class' =>
        'form-control','multiple'=>'']) !!}
        {!! $errors->first('tag', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
    {!! Form::label('country', 'Country: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('country[]', $countries, isset($post)?$post->countries->lists('id')->toArray():null, ['class'
        =>
        'form-control','multiple'=>'']) !!}
        {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('question') ? 'has-error' : ''}}">
    {!! Form::label('question', 'Question: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('question[]', $questions, isset($post)?$post->questions->lists('id')->toArray():null, ['class'
        =>
        'form-control','multiple'=>'']) !!}
        {!! $errors->first('question', '<p class="help-block">:message</p>') !!}
    </div>
</div>