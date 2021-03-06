@extends('layouts.master')

@section('content')
    <h1>Country
        <a href="{{ route('country.create') }}" class="btn btn-primary pull-right btn-sm">Add New Country</a>
        <a href="{{ route('place.create') }}" style="margin-right: 10px" class="btn btn-primary pull-right btn-sm">Add New Place</a>
        <a href="{{ route('place.index') }}" style="margin-right: 10px" class="btn btn-primary pull-right btn-sm">View all Places</a>
        <a href="{{ route('countrytag.index') }}" style="margin-right: 10px" class="btn btn-primary pull-right btn-sm">View all Tags</a>

    </h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th>Name</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($countries as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{route('country.show',$item->id)}}">{{ $item->name }}</a></td>
                    <td>
                        <a href="{{ route('country.edit', $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'route' => ['country.destroy', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $countries->render() !!} </div>
    </div>

@endsection
