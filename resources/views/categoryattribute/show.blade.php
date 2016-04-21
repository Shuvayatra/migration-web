@extends('layouts.master')

@section('content')

    <h1>Category attribute</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Title</th><th>Description</th><th>Main Image</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $categoryattribute->id }}</td> <td> {{ $categoryattribute->title }} </td><td> {{ $categoryattribute->description }} </td><td> {{ $categoryattribute->main_image }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection