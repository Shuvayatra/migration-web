<div class="form-group {{ $errors->has('audio') ? 'has-error' : ''}}">
    {!! Form::label('content', 'Content: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::textArea('metadata[data][content]',null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.content', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('metadata.data.file.0.file_name') ? 'has-error' : ''}}">
    {!! Form::label('file', 'File: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('metadata[data][file][][file_name]', ['class'=>'form-control' , 'id' => 'text_file'])!!}
        <p class="help-block">pdf,docs files only.</p>
        {!! $errors->first('metadata.data.file.0.file_name', '<p class="help-block">:message</p>') !!}
    </div>
    @if(isset($post) && $post->metadata->type == "text" )
        <div><a target="_blank" href="{{$post->metadataWithPath->data->file[0]->file_name}}">check</a></div>
    @endif
</div>


<div class="form-group {{ $errors->has('metadata.data.file') ? 'has-error' : ''}}">
    {!! Form::label('title', 'File description: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('metadata[data][file][0][description]', null, ['class' => 'form-control']) !!}
        {!! $errors->first('metadata.data.file.0.description', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<hr>