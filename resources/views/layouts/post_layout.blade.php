<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shuvayatra Web</title>

    <!-- Bootstrap -->
    <link href="{{asset("css/vendors.min.css")}}" rel="stylesheet">
        <!-- Custom Theme Style -->
    <link href="{{asset("css/app.min.css")}}" rel="stylesheet">
    <!-- Bootstrap -->
    @yield('css')
</head>

<body>
        @include('layouts.partials.top_menu')
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (\Session::has('success'))
                <div class="alert alert-success fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    {{Session::get('success')}}
                </div>
            @endif
            @if (\Session::has('error'))
                <div class="alert alert-danger fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    {{Session::get('error')}}
                </div>
            @endif
            <div class="parent-wrapper">
                <?php
                use App\Nrna\Models\Category;
                ?>
                <?php
                $post_column = 12;
                ?>
                    @if(request()->has('category'))
                        <?php
                        $post_column = $post_column-2;
                        ?>
                    <div class="sidebar-wrap col-md-4 col-xs-12 clearfix">
                        <div class="row">
                        <div class="col-md-6 col-xs-12 main-sidebar">
                            <?php
                            $category = Category::find(request()->get('category'));
                            ?>
                            <div id="main-menu" class="list-group row">
                                <span class="list-group-item min-menu">
                                    <strong>{{$category->title}}</strong>
                                    <a class="pull pull-right" href="{{route('category.create')}}?section_id={{$category->id}}"><i class="glyphicon glyphicon-plus add-icon"></i>Add
                                    </a>
                                </span>
                                <div class="list-group-level1 collapse in" aria-expanded="true">
                                    @foreach($category->getimmediateDescendants() as $child)
                                        <?php
                                        $url = route('post.index')."?".request()->getQueryString();
                                        ?>
                                        <a  href="{{removeParam($url,['sub_category','sub_category1'])}}&sub_category={{$child->id}}" class="list-group-item @if(request()->has('sub_category')&& request()->get('sub_category') == $child->id) active @endif" data-parent="#sub-menu">{{$child->title}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(request()->has('sub_category'))
                        <?php
                        $post_column = $post_column-2;
                        $sub_category = Category::find(request()->get('sub_category'));
                        ?>
                        <div class="col-md-6 col-xs-12 sub-sidebar">
                            <div class="list-group row">
                                <span class="list-group-item"><strong>{{$sub_category->title}}</strong><a class="pull pull-right" href="{{route('category.create')}}?section_id={{$sub_category->id}}" ><i class="glyphicon glyphicon-plus add-icon"></i>Add</a></span>
                                @foreach($sub_category->getimmediateDescendants() as $child)
                                    <a href="{{removeParam($url,'sub_category1')}}&sub_category1={{$child->id}}" class="list-group-item @if(request()->has('sub_category1')&& request()->get('sub_category1') == $child->id) active @endif">{{$child->title}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                        </div>
                    </div>
                        <div class="col-md-{{$post_column}} col-xs-12 panel_content col-md-offset-4">
                            <div class="x_panel">
                                <div class="x_content">
                                       @yield('content')
                                    </div>
                            </div>
                        </div>

</div>
                <div class="clearfix"></div>

        @include('layouts.partials.footer')

<script src="{{asset("js/vendors.min.js")}}"></script>

<script src="{{asset("js/tinymce/tinymce.min.js")}}"></script>
<script src="{{asset("js/app.min.js")}}"></script>

        @yield('script')
        <!-- Custom Theme Scripts -->
@include('layouts.partials.notification')

</body>
</html>
