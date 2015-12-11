@extends('layouts.master')

@section('content')

    <h1>Country</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Name</th><th>Code</th><th>Image</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $country->id }}</td> <td> {{ $country->name }} </td><td> {{ $country->code }} </td><td> {{ $country->image }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection