@extends('layouts.post_layout')

@section('content')
     <a href="{{ route('post.create') }}?{{request()->getQueryString() }}" class="btn btn-primary pull-right btn-sm button">Add New Post</a>
    {{--{!! Form::open(['route' => 'post.index', 'method' => 'get', 'class'=>'form-inline']) !!}--}}
    {{--{!! Form::select('post_type',config('post_type'),Input::get('post_type'), ['class' =>'form-control','placeholder'=>'Select Post type']) !!}--}}

    {{--{!! Form::submit('filter', ['class' => 'btn btn-primary']) !!}--}}
    {{--{!! Form::close() !!}--}}
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
            {{-- */$x=0;/* --}}
            @forelse($posts as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td class="icon-wrap"><i class="{{$item->metadata->type}} icons" aria-hidden="true"></i></td>
                    <td><a href="{{route('post.show',$item->id)}}?{{request()->getQueryString() }}">{{ $item->metadata->title }}</a>
                        <span class="label label-{{config('post.status_color.'.$item->metadata->status)}}">{{$item->metadata->status}}</span>
                        <span style="font-size: 10px;color: #3d3d3d;margin-top: 4px;display: block;" class="post-updated_on"> Created at: {{ $item->created_at->format('Y-m-d H:m') }} / Updated at: {{ $item->updated_at->format('Y-m-d H:m') }}</span>
                    </td>

                    <td width="150px">
                        <a href="{{ route('post.edit', $item->id) }}?{{request()->getQueryString() }}">
                            <button type="submit" class="btn btn-primary btn-xs table-button">Edit</button>
                        </a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'route' => ['post.destroy', $item->id,request()->getQueryString()],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Remove', ['class' => 'btn btn-danger btn-xs table-button']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @empty
                    <tr><td colspan="4" align="center"> No Posts Available.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{--@if ($posts->lastPage()>1)--}}
          {{--<div class="pagination">{!! $posts->appends($app->request->all())->render() !!}</div>--}}
          {{--<div class="pagination-text">Showing {{($posts->currentPage()==1)?"1":($posts->currentPage()-1)*$posts->perPage()}} to {{($posts->currentPage()== $posts->lastPage())?$posts->total():($posts->currentPage())*$posts->perPage()}} of {{$posts->total()}} posts</div>--}}
        {{--@endif--}}
    </div>

@endsection
