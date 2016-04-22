@extends('layouts.master')

@section('content')
    <h1>API Log</h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>S.No</th>
                <th>URL</th>
                <th>IP</th>
                <th>Status</th>
                <th>Method</th>
                <th>Created On</th>
            </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($apiLogs as $log)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{ route('apilogs.show', $log->id) }}">{{ $log->request_url }}</a> </td>
                    <td>{{ $log->host }}</td>
                    <td>{{ $log->status }}</td>
                    <td>{{ $log->method }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $apiLogs->render() !!} </div>
    </div>

@endsection
