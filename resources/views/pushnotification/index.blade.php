@extends('layouts.master')

@section('content')

    <h1>Push Notifications <a href="{{ route('pushnotification.create') }}" class="btn btn-primary pull-right btn-sm">Send
             Push Notification</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Type</th>
                <th>Response</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($pushnotifications as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{ url('/pushnotification', $item->id) }}">{{ $item->title }}</a></td>
                    <td>{{ $item->description }}</td>
                    <td>{{ !empty($item->type)?$item->type:'General' }}</td>
                    <td>{{ $item->response }}</td>
                    <td>
                        <a href="{{ route('pushnotification.edit', $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-xs">Resend</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'route' => ['pushnotification.destroy', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $pushnotifications->render() !!} </div>
    </div>

@endsection
