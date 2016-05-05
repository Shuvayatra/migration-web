@extends('layouts.master')
@section('content')
<div class="container">

    <h1>Category <a href="{{ route('category.create') }}" class="btn btn-primary pull-right btn-sm">Add</a></h1>
    <div class="x_panel">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($categories as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td><a href="{{ url('category', $item->id) }}">{{ $item->title }}</a></td>
                    <td>
                        <a href="{{ url('/category/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs">Update</a>

                        {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['/category', $item->id],
                        'style' => 'display:inline'
                        ]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>

</div>
@endsection
