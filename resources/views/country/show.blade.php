@extends('layouts.master')

@section('content')

    <h1>Country Detail</h1>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>{{$country->name}}</strong>
                    <span class="pull pull-right"><a href="{{route('country.edit',$country->id)}}">Edit</a></span>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                        <tr>
                            <th>Name </th>
                            <td>{{$country->name}}</td>
                        </tr>
                        <tr>
                            <th>Code </th>
                            <td>{{$country->code}}</td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td><a target="_blank" href="{{$country->image}}"> <img width="200px" height="100px" src="{{$country->image}}"/></a></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{!!$country->description!!}</td>
                        </tr>
                        <tr>
                            <th>Contact</th>
                            <td>{!!$country->contact!!}</td>
                        </tr>
                        <tr>
                            <th>Do and Dont</th>
                            <td>{!!$country->do_and_dont!!}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{$country->created_at}}</td>
                        </tr>
                        @if($country->created_at->timestamp != $country->updated_at->timestamp)
                            <tr>
                                <th>Updated At</th>
                                <td>{{$country->updated_at}}</td>
                            </tr>
                        @endif
                        <tr><th>Posts</th>
                            <td><ul>
                                    @foreach($country->posts as $post)
                                        <li><a href="{{route('post.edit',$post->id)}}">{{$post->metadata->title}}</a></li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr><th>Updates</th>
                            <td><ul>
                                    @foreach($country->updates as $update)
                                        <li><a href="{{route('update.edit',$update->id)}}">{{$update->title}}</a></li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

@endsection