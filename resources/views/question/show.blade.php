@extends('layouts.master')

@section('content')

    <h1>Question Detail</h1>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>{{$question->metadata->title}}</strong>
                    <span class="pull pull-right"><a href="{{route('question.edit',$question->id)}}">Edit</a></span>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                        @foreach($question->metadata as $title=>$metadata)
                            <tr>
                                <th class="head">{{ucfirst($title)}}</th>
                                <td>@if(is_object($metadata) || is_array($metadata))
                                        @foreach($metadata as $key=>$value)
                                            @if($value != '')
                                                {!!$value!!} <br>
                                            @endif
                                        @endforeach
                                    @else
                                        {!!$metadata !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th>Created At</th>
                            <td>{{$question->created_at}}</td>
                        </tr>
                        @if($question->created_at->timestamp != $question->updated_at->timestamp)
                            <tr>
                                <th>Updated At</th>
                                <td>{{$question->updated_at}}</td>
                            </tr>
                        @endif
                        <tr><th>Tags</th>
                            <td><ul>
                                    @foreach($question->tags as $tag)
                                        <li>{{$tag->title}}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>

                        <tr><th>Sub Questions</th>
                            <td><ul>
                                    @foreach($question->subquestions as $question)
                                        <li>{{$question->metadata->title}}
                                            <br>
                                            {!!$question->metadata->answer!!}
                                            <br>
                                            <a href="{{ route('question.edit', $question->id) }}">
                                                <button type="submit" class="btn btn-primary btn-xs">Update</button>
                                            </a> /
                                            {!! Form::open([
                                            'method'=>'DELETE',
                                            'route' => ['question.destroy', $question->id],
                                            'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                                            {!! Form::close() !!}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr><th>Answers</th>
                            <td><ul>
                                    @foreach($question->answers as $answer)
                                        <li class="col-md-12">{{$answer->title}}
                                            <div class="pull-right">
                                            <a  href="{{ route('answer.edit', $answer->id) }}">
                                                <button type="submit" class="btn btn-primary btn-xs">Update</button>
                                            </a> /
                                            {!! Form::open([
                                            'method'=>'DELETE',
                                            'route' => ['answer.destroy', $answer->id],
                                            'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                                            {!! Form::close() !!}
                                            </div>

                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

@endsection