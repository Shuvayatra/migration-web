@extends('layouts.master')

@section('content')

    <h1>Posts <a href="{{ route('post.create') }}" class="btn btn-primary pull-right btn-sm">Add New Post</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Title</th>
                    <th>Stage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($posts as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{route('post.show',$item->id)}}">{{ $item->metadata->title }}</a>
                        <span class="label label-info pull-right">{{$item->metadata->type}}</span>
                        @if(isset($item->metadata->data->audio))
                            <a target="_blank" class="pull-right" href="{{$item->metadata->data->audio}}">play</a>
                        @endif
                    </td>
                    <td>
                        @if(is_array($item->metadata->stage))
                            @foreach($item->metadata->stage as $key=>$value)
                                @if($value != '')
                                    {!!$value!!} <br>
                                @endif
                            @endforeach
                        @else
                            {{$item->metadata->stage}}
                        @endif

                    </td>
                    <td>
                        <a href="{{ route('post.edit', $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'route' => ['post.destroy', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $posts->render() !!} </div>
    </div>

@endsection
