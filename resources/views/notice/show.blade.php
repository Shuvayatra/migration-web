@extends('layouts.master')

@section('content')

    <h1>Place</h1>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>{{$place->metadata->title}}</strong>
                    <span class="pull pull-right"><a href="{{route('place.edit',$place->id)}}">Edit</a></span>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                        <tr>
                            <th>Title </th>
                            <td>{{$place->metadata->title}}</td>
                        </tr>
                        <tr>
                            <th>Phones</th>
                            <td>

                                @foreach($place->metadata->phone as $phone)
                                  {{$phone}} <br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{!!$place->metadata->address!!}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{!!$place->metadata->description!!}</td>
                        </tr>
                        <tr>
                            <th>Image </th>
                            <td><a target="_blank" href="{{$place->image_link}}"> <img src="{{$place->image_link}}"/></a></td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{$place->created_at}}</td>
                        </tr>
                        @if($place->created_at->timestamp != $place->updated_at->timestamp)
                            <tr>
                                <th>Updated At</th>
                                <td>{{$place->updated_at}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

@endsection