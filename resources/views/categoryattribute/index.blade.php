@extends('layouts.master')

@section('content')
    <?php
    $section = \App\Nrna\Models\Section::find($section_id);
    $categories = \App\Nrna\Models\CategoryAttribute::where('parent_id',0)
                ->where('section_id',$section_id)
                ->lists('title','id');
    ?>
    <h1>Section : {{$section->title}}</h1>

    <h3>Categories <a href="{{ route('section.category.create',$section_id) }}" class="btn btn-primary pull-right btn-sm">Add New Category</a></h3>
    {!! Form::open(['route' => ['section.category.index',$section_id], 'method' => 'get', 'class'=>'form-inline']) !!}
    {!! Form::select('category',$categories,Input::get('category'), ['class' =>'form-control','placeholder'=>'']) !!}

    {!! Form::submit('filter', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Title</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody class="sortable" data-entityname="section_category">
            {{-- */$x=0;/* --}}
            @forelse($categoryattributes as $item)
                {{-- */$x++;/* --}}
                <tr data-itemId="{{{ $item->id }}}">
                    <td class="sortable-handle"><span class="glyphicon glyphicon-sort"></span></td>
                    <td><a href="{{ route('section.category.show',$section_id, $item->id) }}">{{ $item->title }}</a></td>
                    <td>
                        @if(!is_null($item->parent))
                            {{ $item->parent->title }}
                         @endif
                    </td>
                    <td>
                        <a href="{{ route('section.category.edit',[$section_id,$item->id]) }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a> /
                        {!! Form::open([
                        'method'=>'DELETE',
                        'route' => ['section.category.destroy',$section_id, $item->id],
                        'style' => 'display:inline'
                        ]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <p class="text-center">No Data</p>
                    </td>
                </tr>

            @endforelse

            </tbody>
        </table>
        <div class="pagination"> {!! $categoryattributes->render() !!} </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('js/jquery-ui-1.10.4.custom.min.js')}}"></script>
    <script src="{{asset('js/sort.js')}}"></script>
@endsection
