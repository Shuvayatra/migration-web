@extends('layouts.master')

@section('content')
    <h1>Questions <a href="{{ route('question.create') }}" class="btn btn-primary pull-right btn-sm">Add New Question</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Question</th>
                    <th>Stage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @forelse($questions as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{route('question.show',$item->id)}}">{{ $item->metadata->title }} </a>
                        <span class="label label-default pull-right">{{$item->metadata->language}}</span></td>
                    <td>{{ $item->metadata->stage }}</td>
                    <td>
                        <a href="{{ route('question.edit', $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'route' => ['question.destroy', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center"> No question available.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="pagination"> {!! $questions->render() !!} </div>
    </div>

@endsection
