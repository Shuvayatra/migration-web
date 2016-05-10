@extends('layouts.master')

@section('content')

    <div class="container">

        <hgroup class="mb20">
            <h1>Search Results</h1>
            <h2 class="lead"><strong class="text-danger">{{$results->count()}}</strong> results were found for the search for <strong class="text-danger">{{request()->get('q')}}</strong></h2>
        </hgroup>

        <section class="col-xs-12 col-sm-6 col-md-12">
            @foreach($results as $result)
                <article class="search-result row">
                    <div class="col-xs-12 col-sm-12 col-md-12 excerpet">
                        <h3><a href="{{route('post.show' ,$result->id)}}" title="">{{$result->metadata->title}}</a></h3>
                        <p>
                            {!!$result->metadata->description!!}
                        </p>
                    </div>
                </article>
                @endforeach
        </section>
    </div>
@endsection
