@extends('layouts.master')

@section('content')

    <h1>Countrytag</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Name</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $countrytag->id }}</td> <td> {{ $countrytag->name }} </td><td> {{ $countrytag->status }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection