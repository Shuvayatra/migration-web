<div style="display: none" class="form-group {{ $errors->has('audio') ? 'has-error' : ''}}">
    {!! Form::label('content', 'Content: ', ['class' => 'control-label']) !!}

        {!! Form::textArea('metadata[data][content]',null, ['class' => 'form-control description tinymce']) !!}
        {!! $errors->first('metadata.content', '<p class="help-block">:message</p>') !!}

</div>

<div class="form-group {{ $errors->has('metadata.data.file.0.file_name') ? 'has-error' : ''}}">
    {!! Form::label('file', 'File: ', ['class' => 'control-label']) !!}

        {!! Form::file('metadata[data][file][][file_name]', ['class'=>'form-control' , 'id' => 'text_file'])!!}
        <p class="help-block">pdf,docs files only.</p>
        {!! $errors->first('metadata.data.file.0.file_name', '<p class="help-block">:message</p>') !!}

    @if(isset($post) && $post->metadata->type == "text" )
        <div>
            @if(isset($post->metadataWithPath->data->file[0]))
            <a target="_blank" href="{{$post->metadataWithPath->data->file[0]->file_name}}">check</a>
            @endif
        </div>
    @endif
</div>


<div class="form-group {{ $errors->has('metadata.data.file') ? 'has-error' : ''}}">
    {!! Form::label('title', 'File description: ', ['class' => 'control-label']) !!}

        {!! Form::text('metadata[data][file][0][description]', null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.data.file.0.description', '<p class="help-block">:message</p>') !!}
</div>
<hr>
