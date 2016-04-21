@extends('layouts.master')

@section('content')
    <h1>Sections <a href="{{ route('section.create') }}" class="btn btn-primary pull-right btn-sm">Add New Section</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($sections as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{ url('/section', $item->id) }}">{{ $item->title }}</a></td>
                    <td><a href="{{ route('section.category.create', $item->id) }}">Create</a>/
                    <a href="{{ route('section.category.index', $item->id) }}">List</a></td>
                    <td>
                        <a href="{{ route('section.edit', $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'route' => ['section.destroy', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $sections->render() !!} </div>
    </div>

@endsection
