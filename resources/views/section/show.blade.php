@extends('layouts.master')

@section('content')

    <a href="{{ route('section.category.create',$section->id) }}" class="btn btn-primary pull-right btn-sm">Add New Category</a>
    <h1>Section</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Name</th><th>Section</th><th>Is Locked</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $section->id }}</td> <td> {{ $section->name }} </td><td> {{ $section->section }} </td><td> {{ $section->is_locked }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection