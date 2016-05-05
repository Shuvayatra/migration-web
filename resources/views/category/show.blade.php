@extends('layouts.master')
@section('content')
    <div class="container">
        <?php
        $categories = $category->getImmediateDescendants();
        ?>
        <h1>{{$category->title}} <a href="{{ route('category.create') }}?section_id={{$category->id}}" class="btn btn-primary pull-right btn-sm">Add</a></h1>
        <ul class="nav nav-tabs">
            @foreach($categories as $category)
                <li class="@if($categories->first() == $category) active @endif" ><a data-toggle="tab" href="#{{str_slug($category->title)}}">{{$category->title}}</a></li>
            @endforeach
        </ul>
        <div class="tab-content">
            <br>
            <br>
            @foreach($categories as $category)
                <div id="{{str_slug($category->title)}}" class="tab-pane fade in @if($categories->first() == $category) active @endif">
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
                                    {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}

                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="x_panel">
                                <label>Drop Down</label> <a href="{{ route('category.create') }}?section_id={{$category->id}}">Add</a>
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody>
                                    {{-- */$x=0;/* --}}
                                    @foreach($category->getImmediateDescendants() as $item)
                                        {{-- */$x++;/* --}}
                                        <tr>
                                            <td><a href="{{ url('category', $item->id) }}">{{ $item->title }}</a></td>
                                            <td>
                                                <a href="{{ url('/category/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs">Update</a>

                                                {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/category', $item->id],
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
