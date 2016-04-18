@extends('layouts.master')

@section('content')

    <h1>Journey</h1>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>{{$journey->title}}</strong>
                    <span class="pull pull-right"><a href="{{route('journey.edit',$journey->id)}}">Edit</a></span>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                        <tr>
                            <th>Title </th>
                            <td>{{$journey->title}}</td>
                        </tr>
                        <tr>
                            <th>Menu Image </th>
                            <td><a target="_blank" href="{{$journey->menu_image_link}}"> <img src="{{$journey->menu_image_link}}"/></a></td>
                        </tr>
                        <tr>
                            <th>Small Menu Image </th>
                            <td><a target="_blank" href="{{$journey->small_menu_image_link}}"> <img src="{{$journey->small_menu_image_link}}"/></a></td>
                        </tr>
                        <tr>
                            <th>Featured Image</th>
                            <td><a target="_blank" href="{{$journey->featured_image_link}}"> <img src="{{$journey->featured_image_link}}"/></a></td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{$journey->created_at}}</td>
                        </tr>
                        @if($journey->created_at->timestamp != $journey->updated_at->timestamp)
                            <tr>
                                <th>Updated At</th>
                                <td>{{$journey->updated_at}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')

    @endsection