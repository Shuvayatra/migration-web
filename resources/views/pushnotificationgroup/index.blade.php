@extends('layouts.master')

@section('content')

    <h1>Push Notification Groups <a href="{{ route('pushnotificationgroup.create') }}" class="btn btn-primary pull-right btn-sm">
             Add New Group</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Destination</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($pushnotificationgroups as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ json_decode($item->properties, true)['age'] }}</td>
                    <td>{{ json_decode($item->properties, true)['gender'] }}</td>
                    <td>{{ json_decode($item->properties, true)['destination']}}</td>
                    <td>{{ str_replace("c_", "", json_decode($item->properties, true)['country'])}}</td>
                    <td>
                        <a href="{{ route('pushnotificationgroup.edit', $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-xs">Edit</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'route' => ['pushnotificationgroup.destroy', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $pushnotificationgroups->render() !!} </div>
    </div>

@endsection
