@extends('layouts.post_layout')

@section('content')

    <h1>Post Detail</h1>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>{{$post->metadata->title}}</strong>
                    <span class="pull pull-right"><a href="{{route('post.edit',$post->id)}}?{{request()->getQueryString() }}">Edit</a></span>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>

                        @foreach($post->metadataWithPath as $title=>$metadata)
                        <tr>
                            <th class="head">{{ucfirst($title)}}</th>
                            <td>@if(is_object($metadata) || is_array($metadata))
                                    @foreach($metadata as $key=>$value)
                                        @if($value != '' && !is_array($value))
                                            {!!$value!!} <br>
                                        @endif
                                    @endforeach
                                @else
                                   @if(!filter_var($metadata, FILTER_VALIDATE_URL) === false)
                                    <img src="{{$metadata}}">
                                    @else
                                    {!!$metadata !!}
                                    @endif
                                @endif
                            </td>
                        </tr>

                    @endforeach
                        @if($post->metadata->type=='text')
                            <tr><th>Files</th>
                                <td>
                                    <ul>
                                        @foreach($post->metadataWithPath->data->file as $file)
                                            <li>{{$file->description}}  </li>
                                            <a target="_blank" href="{{$file->file_name}}">link</a>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endif
                        <tr>
                        @if($post->metadata->type=='audio')
                            <tr><td>
                                </td>
                                <td><audio controls>
                                        <source src="{{$post->audioUrl()}}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio></td></tr>
                        @endif
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
                        <tr><th>Country</th>
                            <td><ul>
                                @foreach($post->countries as $country)
                                    <li><a href="{{route('country.edit',$country->id)}}">{{$country->name}}</a></li>
                                @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>Views</th>
                            <td>{{$post->view_count}}</td>
                        </tr>
                        <tr>
                            <th>Likes</th>
                            <td>{{$post->likes}}</td>
                        </tr>
                        <tr>
                            <th>Shares</th>
                            <td>{{$post->share_count}}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

@endsection