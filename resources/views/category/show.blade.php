@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Category</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>{{ trans('category.title') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $category->id }}</td> <td> {{ $category->title }} </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection