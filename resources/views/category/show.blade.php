@extends('layouts.master')
@section('content')
    <div class="container">
        <?php
        $categories = $category->getImmediateDescendants();
        ?>
        <h1>{{$category->title}} <a href="{{ route('category.create') }}?section_id={{$category->id}}" class="btn btn-primary pull-right btn-sm">Add Category</a></h1>
        <ul class="nav nav-tabs">
            @foreach($categories as $category)
                <li class="@if($categories->first() == $category) active @endif" ><a data-toggle="tab" href="#category-{{$category->id}}">{{$category->title}}</a></li>
            @endforeach
        </ul>
        <div class="tab-content">
            <br>
            <br>
            @foreach($categories as $category)
                <div id="category-{{$category->id}}" class="tab-pane fade in @if($categories->first() == $category) active @endif">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="x_panel">
                                <div class="x_content">
                                    {!! Form::model($category, [
                                    'method' => 'PATCH',
                                    'route' => ['category.update', $category->id],
                                    'class' => 'form-horizontal',
                                    'files' =>true
                                    ]) !!}
                                    <label for="title">Title * :</label>
                                    {!! Form::text('title', null, ['class' => 'form-control']) !!}
                                    <br>
                                    <div class="form-group {{ $errors->has('main_image') ? 'has-error' : ''}}">
                                        {!! Form::label('main_image', 'Main Image: ', ['class' => ' control-label']) !!}
                                        <div class="">
                                            {!! Form::file('main_image', null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('main_image', '<p class="help-block">:message</p>') !!}
                                            @if(isset($category))
                                                <a href="#" class="thumbnail">
                                                    <img src="{{$category->main_image_link}}">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('icon') ? 'has-error' : ''}}">
                                        {!! Form::label('icon', 'Icon: ', ['class' => ' control-label']) !!}
                                        <div class="">
                                            {!! Form::file('icon', null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('icon', '<p class="help-block">:message</p>') !!}
                                            @if(isset($category))
                                                <a href="#" class="thumbnail">
                                                    <img src="{{$category->icon_link}}">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('small_icon') ? 'has-error' : ''}}">
                                        {!! Form::label('small_icon', 'Small Icon: ', ['class' => ' control-label']) !!}
                                        <div class="">
                                            {!! Form::file('small_icon', null, ['class' => 'form-control']) !!}
                                            {!! $errors->first('small_icon', '<p class="help-block">:message</p>') !!}
                                            @if(isset($category))
                                                <a href="#" class="thumbnail">
                                                    <img src="{{$category->small_icon_link}}">
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                    {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}

                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="x_panel">
                                <label>Drop Down</label> <a class="btn btn-primary pull-right" href="{{ route('category.create') }}?section_id={{$category->id}}">Add</a>
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody>
                                    {{-- */$x=0;/* --}}
                                    @foreach($category->getImmediateDescendants() as $item)
                                        {{-- */$x++;/* --}}
                                        <tr>
                                            <td>{{ $item->title }}</td>
                                            <td>
                                                <a href="{{ route('category.edit' , $item->id) }}" class="btn btn-primary btn-xs">Update</a>

                                                {!! Form::open([
                                                'method'=>'DELETE',
                                                'route' => ['category.destroy', $item->id],
                                                'style' => 'display:inline'
                                                ]) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="table">
        </div>

    </div>
@endsection
