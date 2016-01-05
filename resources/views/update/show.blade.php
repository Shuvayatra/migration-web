@extends('layouts.master')

@section('content')

    <h1>Country Update Detail</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>{{$update->title}}</strong>
                    <span class="pull pull-right"><a href="{{route('update.edit',$update->id)}}">Edit</a></span>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                        <tr>
                            <th>Country </th>
                            <td>{{$update->country->name}}</td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td>{{$update->title}}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{!!$update->description!!}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{$update->created_at}}</td>
                        </tr>
                        @if($update->created_at->timestamp != $update->updated_at->timestamp)
                            <tr>
                                <th>Updated At</th>
                                <td>{{$update->updated_at}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

@endsection