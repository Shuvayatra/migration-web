@extends('layouts.master')

@section('content')

    <h1>Tag</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Name</th><th>Code</th><th>Image</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $tag->id }}</td> <td> {{ $tag->name }} </td><td> {{ $tag->code }} </td><td> {{ $tag->image }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection