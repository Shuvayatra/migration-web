@section('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet"/>
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
        {!! Form::text('metadata[title]', null, ['class' => 'form-control required']) !!}
        {!! $errors->first('metadata.title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('metadata[description]', null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    {!! Form::label('type', 'Type: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('metadata[type]',[''=>'']+config('post_type'),null, ['class' =>
        'form-control required','id'=>'post_type']) !!}
        {!! $errors->first('metadata.type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div style="display:@if(isset($post) && $post->metadata->type === 'text' || old('metadata.type') =="text") block @else none @endif"
     class="content-type  type-text">
    @include('post.partials.type_text')
</div>

<div style="display: @if(isset($post) && $post->metadata->type === 'video' || old('metadata.type') =="video") block @else none @endif"
     class="form-group content-type  type-video {{ $errors->has('media_url') ? 'has-error' : ''}}">
    {!! Form::label('media_url', 'Media Url: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('metadata[data][media_url]',null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.media_url', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="content-type type-audio" style="display: @if(isset($post) && $post->metadata->type === 'audio'|| old('metadata.type') =="audio")block @else none @endif">
    @include('post.partials.type_audio')
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
        {!! Form::select('metadata[stage][]', config('stage'), null, ['class' => 'form-control
        required','multiple'=>true]) !!}
        {!! $errors->first('metadata.stage', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('tag') ? 'has-error' : ''}}">
    {!! Form::label('tag', 'Tags: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('tag[]', $tags, isset($post)?$post->tags->lists('id')->toArray():null, ['class' =>
        'form-control','multiple'=>'','id'=>'tags']) !!}
        {!! $errors->first('tag', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
    {!! Form::label('country', 'Country: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('country[]', $countries, isset($post)?$post->countries->lists('id')->toArray():null, ['class'=>
        'form-control','multiple'=>'']) !!}
        {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('question') ? 'has-error' : ''}}">
    {!! Form::label('question', 'Question: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::select('question_select',[''=>''] + $questions->toArray(),null, ['class'=>'form-control
        select-questions']) !!}
        {!! $errors->first('question', '<p class="help-block">:message</p>') !!}
        <span class="help-block">selecting question will show answer below.</span>
    </div>
</div>

@if(old('question'))
    <?php
    $questions = empty(old('question')) ? [$post->questions] : old('question');
    $j = 0;
    ?>
    @foreach($questions as $question => $answer)
        @include('question.partials.answers')
    @endforeach
@endif
@if(isset($post))
    <?php
    $questions = $post->questions;
    $j = 0;
    ?>
    @foreach($questions as $question)
        @include('question.partials.answers')
    @endforeach
@endif

<div id="question_answers"></div>

@section('script')
    <script type="text/javascript" src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
    <script>
        $(function () {
            $('.post-form').validate();
            $(".select-questions").on("change", function (e) {
                var questions = $(this).val();
                var url = '{{route('ajax.question.answers')}}'
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {'question': questions},
                    success: function (data) {
                        $('#question_answers').append(data);
                    },
                    error: function () {
                        alert('oops error loading answers.')
                    }
                });
            });
        });
    </script>
@endsection
