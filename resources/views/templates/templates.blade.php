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