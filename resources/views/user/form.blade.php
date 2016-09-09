<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    {!! Form::label('password', 'Password: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::password('password', ['class' => 'form-control']) !!}
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
    {!! Form::label('language', 'Language: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        <?php $language = isset($user) ? $user->language : 'ne'; ?>
        {!! Form::select('language', config('language'), $language, ['class' => 'form-control']) !!}
        {!! $errors->first('language', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@role('admin')
<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
    {!! Form::label('role', 'Role: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        <?php $role_name = isset($user) ? $user->roles->first()->name : null ?>
        {!! Form::select('role', [''=>'Select']+$roles,$role_name, ['class' => 'form-control']) !!}
        {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endrole