@extends('layouts.master')

@section('content')

    <h1>Journeys <a href="{{ route('journey.create') }}" class="btn btn-primary pull-right btn-sm">Add New Journey</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Position</th><th>Title</th><th>Featured Image</th><th>Actions</th>
                </tr>
            </thead>
            <tbody class="sortable" data-entityname="journey">
            {{-- */$x=0;/* --}}
            @foreach($journeys as $item)
                {{-- */$x++;/* --}}
                <tr data-itemId="{{{ $item->id }}}">
                    <td class="sortable-handle"><span class="glyphicon glyphicon-sort"></span></td>
                    <td class="sortable-handle"><a href="{{ url('/journey', $item->id) }}">{{ $item->title }}</a></td>
                    <td class="sortable-handle"><img src="{{ $item->featured_image_link }}"/></td>
                    <td>
                        <a href="{{ route('journey.edit', $item->id) }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'route' => ['journey.destroy', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $journeys->render() !!} </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('js/jquery-ui-1.10.4.custom.min.js')}}"></script>
    <script src="{{asset('js/sort.js')}}"></script>
@endsection
