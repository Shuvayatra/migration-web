@extends('layouts.master')

@section('content')

    <h1>Places <a href="{{ route('place.create') }}" class="btn btn-primary pull-right btn-sm">Add New Place</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th>title</th><th>Country</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($places as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{ url('/place', $item->id) }}">{{ $item->metadata->title }}</a></td>
                    <td>{{ $item->country->name }}</td>
                    </td>
                    <td>
                        <a href="{{ route('place.edit', $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'route' => ['place.destroy', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $places->render() !!} </div>
    </div>

@endsection
