
<script id="answer_field" type="x-tmpl-mustache">
    <div class="form-group">
            {!! Form::label('answer', 'Answer: ', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('answer[@{{count}}][title]', null, ['class' => 'form-control required']) !!}
                {!! $errors->first('answer.title', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="delete delete-answer-field btn btn-danger">X</div>
        </div>


</script>

<script id="type_text_file_field" type="x-tmpl-mustache">
<div class="type-text-file-fields">
    <div class="form-group">
        {!! Form::label('file', 'File: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::file('metadata[data][file][@{{count}}][file_name]', ['class'=>'form-control' , 'id' => 'text_file'])!!}
            <p class="help-block">pdf,docs files only.</p>
            {!! $errors->first('audio', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('metadata[data][file][@{{count}}][title]', null, ['class' => 'form-control']) !!}
            {!! $errors->first('metadata.data.file', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

</script>


<script id="question_block" type="x-tmpl-mustache">
    <div>
        <hr>
        <div class="form-group">
            {!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('subquestion[@{{count}}][metadata][title]', null, ['class' => 'form-control required']) !!}
                {!! $errors->first('metadata.title', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('answer', 'Answer*: ', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::textarea('subquestion[@{{count}}][metadata][answer]', null, ['class' => 'myeditor form-control']) !!}
                {!! $errors->first('metadata.answer', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</script>

<script id="journey_subcategory_field" type="x-tmpl-mustache">
    <div class="form-group">
            {!! Form::label('subcategory', 'Sub category: ', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('subcategory[@{{count}}][title]', null, ['class' => 'form-control required']) !!}
                {!! $errors->first('journey.title', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="delete delete-journey-subcategory-field btn btn-danger">X</div>
        </div>
</script>

<script id="place_phone_field" type="x-tmpl-mustache">
    <div class="form-group">
            {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('metadata[phone][@{{count}}]', null, ['class' => 'form-control required']) !!}
                {!! $errors->first('place', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="delete delete-phone-field btn btn-danger">X</div>
        </div>
</script>
