@extends('layouts.master')

@section('content')

    <h1>Post Detail</h1>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>{{$post->metadata->title}}</strong>
                    <span class="pull pull-right"><a href="{{route('post.edit',$post->id)}}">Edit</a></span>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                        @foreach($post->metadata as $title=>$metadata)
                        <tr>
                            <th class="head">{{ucfirst($title)}}</th>
                            <td>@if(is_object($metadata) || is_array($metadata))
                                    @foreach($metadata as $key=>$value)
                                        @if($value != '')
                                            {!!$value!!} <br>
                                        @endif
                                    @endforeach
                                @else
                                    {{$metadata }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <th>Created At</th>
                            <td>{{$post->created_at}}</td>
                        </tr>
                        @if($post->created_at->timestamp != $post->updated_at->timestamp)
                        <tr>
                            <th>Updated At</th>
                            <td>{{$post->updated_at}}</td>
                        </tr>
                        @endif
                        <tr><th>Tags</th>
                            <td><ul>
                                @foreach($post->tags as $tag)
                                    <li>{{$tag->title}}</li>
                                @endforeach
                                </ul>
                            </td>

                        </tr>
                        <tr><th>Questions</th>
                            <td><ul>
                                @foreach($post->questions as $question)
                                    <li>{{$question->metadata->title}}</li>
                                @endforeach
                                </ul>
                            </td>
                            </tr>
                        <tr><th>Country</th>
                            <td><ul>
                                @foreach($post->countries as $country)
                                    <li>{{$country->name}}</li>
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