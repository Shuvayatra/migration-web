@section('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet"/>
@endsection
<?php
$tagService = app('App\Nrna\Services\TagService');
$tags = $tagService->getList(); ?>
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('metadata[title]', null, ['class' => 'form-control required']) !!}
        {!! $errors->first('metadata.title', '<p class="help-block">:message</p>') !!}
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
        {!! Form::select('tag[]', $tags, isset($question)?$question->tags->lists('id')->toArray():null, ['class' =>
        'form-control','multiple'=>'','id'=>'tags']) !!}
        {!! $errors->first('tag', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('metadata.answer') ? 'has-error' : ''}}">
    {!! Form::label('answer', 'Answer*: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('metadata[answer]', null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.answer', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<hr>


<div class="answer">
    <button type="button" class="btn btn-default add-new-answer" id="add_new_answer">Add Answer</button>
    @if(isset($question))
        <div class="form-group">
            {!! Form::label('answer', 'Answers:', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                <ul>
                    @foreach($question->answers as $answer)
                        <li>{{$answer->title}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="answer-item">
        @if(old('answer'))
            <?php
            $answers = empty(old('answer')) ? [] : old('answer');
            $j = 0;
            ?>
            @foreach($answers as $key => $answer)
                <div class="form-group {{ $errors->has('answer') ? 'has-error' : ''}}">
                    {!! Form::label('answer', 'Answer: ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                        {!! Form::text("answer[$key][title]",isset($answer->title)?$answer->title:null,["class"=>"form-control"])!!}
                    </div>
                    <div class="delete delete-answer-field btn btn-danger">X</div>
                </div>
                <?php $j ++;?>
            @endforeach
        @endif
    </div>
</div>
@include('templates.templates')

@section('script')
    <script type="text/javascript" src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/mustache.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
    <script>
        $(function () {
            var j = {{$j or 0}};
            $('.question-form').validate();
            $('.add-new-answer').on('click', function (e) {
                e.preventDefault();
                j += 1;
                var template = $('#answer_field').html();
                Mustache.parse(template);
                var rendered = Mustache.render(template, {count: j});
                $('.answer .answer-item:last-child').append(rendered);
            });
        });
    </script>
@endsection