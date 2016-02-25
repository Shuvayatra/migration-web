@extends('layouts.master')

@section('content')

    <h1>Posts <a href="{{ route('post.create') }}" class="btn btn-primary pull-right btn-sm">Add New Post</a></h1>
    {!! Form::open(['route' => 'post.index', 'method' => 'get', 'class'=>'form-inline']) !!}
    {!! Form::select('stage', config('stage'), Input::get('stage'), ['class' => 'form-control','placeholder'=>'Select Stage']) !!}
    {!! Form::select('post_type',config('post_type'),Input::get('post_type'), ['class' =>'form-control','placeholder'=>'Select Post type']) !!}

    {!! Form::submit('filter', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Title</th>
                    <th>Stage</th>
                    <th>Info</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @forelse($posts as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{route('post.show',$item->id)}}">{{ $item->metadata->title }}</a>
                        <span class="label label-info pull-right">{{$item->metadata->type}}</span>
                    </td>
                    <td>
                        @foreach($item->metadata->stage as $stage)
                        {{ $stage }}<br>
                        @endforeach
                    </td>
                    <td>{{ $item->created_at }}<br>{{ $item->updated_at }}</td>

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
                @empty
                    <tr><td colspan="4" align="center"> No Posts Available.</td></tr>
            @endforelse
            </tbody>
        </table>
        @if ($posts->lastPage()>1)
          <div class="pagination">{!! $posts->appends($app->request->all())->render() !!}</div>
          <div class="pagination-text">Showing {{($posts->currentPage()==1)?"1":($posts->currentPage()-1)*$posts->perPage()}} to {{($posts->currentPage()== $posts->lastPage())?$posts->total():($posts->currentPage())*$posts->perPage()}} of {{$posts->total()}} posts</div>
        @endif
    </div>

@endsection

