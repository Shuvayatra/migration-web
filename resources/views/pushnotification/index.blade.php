@extends('layouts.master')

@section('content')

    <h1>Push Notifications
        <div class=".btn-toolbar pull-right">
            <a href="{{ route('pushnotification.create') }}" class="btn btn-primary btn-sm">
                Send Push Notification
            </a>
            <a href="{{ route('pushnotificationgroup.index') }}" class="btn btn-primary btn-sm">
                Push Notification Groups
            </a>
        </div>
    </h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Scheduled Date</th>
                <th>Sent</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($pushnotifications as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{ url('/pushnotification', $item->id) }}">{{ $item->title }}</a>
                        <br>
                        <small>Sent at: {{$item->created_at}}</small>
                    </td>
                    <td>{{ $item->description }}</td>
                    <td>{{ !empty($item->scheduled_date)?$item->scheduled_date:'' }}</td>
                    <td>{{ !empty($item->response)? 'Yes' : 'No' }}</td>
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
