@extends('layouts.master')

@section('content')

    <h1>Rss News Feeds <a href="{{ route('rssnewsfeeds.fetch') }}" class="btn btn-primary pull-right btn-sm">Fetch
            Rss News Feeds</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Rss</th>
                <th>Title</th>
                <th>Description</th>
                <th>Post Date</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($rssnewsfeeds as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->rss->title }}</td>
                    <td><a href="{{ url('/rssnewsfeeds', $item->id) }}">{{ $item->title }}</a></td>
                    <td>{!! $item->description !!}</td>
                    <td>{{ $item->post_date }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-xs" href="{{route('post.create',['rss_id'=>$item->id])}}">Add to Post</a>
                        <br>
                        <br>
                        <a href="{{ route('rssnewsfeeds.edit', $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a>
                        <br>
                        <br>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'route' => ['rssnewsfeeds.destroy', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $rssnewsfeeds->render() !!} </div>
    </div>

@endsection
