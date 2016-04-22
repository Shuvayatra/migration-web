@extends('layouts.master')

@section('content')
    <style>
        table {
            width: 100%;
            table-layout: fixed;
        }
        th,
        td {
            word-break: break-all;
        }

        th {
            width: 20%;
        }
        td {
            width: 80%;
        }
    </style>

    <h1>API Log</h1>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                        <tr>
                            <th>Entry Id</th>
                            <td>{{ $log->id }}</td>
                        </tr>
                        <tr>
                            <th>Request URL</th>
                            <td>{{ $log->request_url }}</td>
                        </tr>
                        <tr>
                            <th>Request Data</th>
                            <td>{{ $log->request_data }}</td>
                        </tr>
                        <tr>
                            <th>Request Header</th>
                            <td>{{ $log->header }}</td>
                        </tr>
                        <tr>
                            <th>Method</th>
                            <td>{{ $log->method }}</td>
                        </tr>
                        <tr>
                            <th>Response</th>
                            <td>{{ $log->response }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $log->status }}</td>
                        </tr>
                        <tr>
                            <th>Host</th>
                            <td>{{ $log->host }}</td>
                        </tr>
                        <tr>
                            <th>Created on</th>
                            <td>{{ $log->created_at->toDateString() }}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

@endsection