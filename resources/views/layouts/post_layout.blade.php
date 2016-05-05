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
    <link href="{{asset("vendors/bootstrap/dist/css/bootstrap.min.css")}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset("vendors/font-awesome/css/font-awesome.min.css")}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset("vendors/iCheck/skins/flat/green.css")}}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{asset("vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css")}}" rel="stylesheet">
    <!-- jVectorMap -->
    <link href="{{asset('css/maps/jquery-jvectormap-2.0.3.css')}}" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    <!-- jQuery -->
    <script src="{{asset("vendors/jquery/dist/jquery.min.js")}}"></script>
    <!-- Bootstrap -->
    @yield('css')
</head>

<body class="">
<div class="container body">
    <div class="">
        @include('layouts.partials.top_menu')
        <div class="right_col" role="main">
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
            <div class="x_panel">
                <?php
                use App\Nrna\Models\Category;
                ?>
                    <?php
                    $post_column = 12;
                    ?>
                    <div class="row">
                        @if(request()->has('category'))
                            <?php
                            $post_column = $post_column-2;
                            ?>
                            <div class="col-md-2 col-xs-12">
                                <?php
                                $category = Category::find(request()->get('category'));
                                ?>
                                <div id="main-menu" class="list-group">
                                    <a href="#sub-menu" class="list-group-item active" data-toggle="collapse" aria-expanded="true" data-parent="#main-menu">{{$category->title}} <span class="caret"></span></a>
                                    <div class="list-group-level1 collapse in" aria-expanded="true" id="sub-menu">
                                        @foreach($category->getimmediateDescendants() as $child)
                                            <?php
                                            $url = route('post.index')."?".request()->getQueryString();
                                            ?>
                                            <a href="{{removeParam($url,'sub_category')}}&sub_category={{$child->id}}" class="list-group-item" data-parent="#sub-menu">{{$child->title}}</a>
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
                            <div class="col-md-2 col-xs-12">
                                <div class="list-group">
                                    <a href="#" class="list-group-item"><strong>{{$sub_category->title}}</strong></a>
                                    @foreach($sub_category->getimmediateDescendants() as $child)
                                        <a href="#" class="list-group-item">{{$child->title}}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="col-md-{{$post_column}} col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                   @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="clearfix"></div>
            </div>
        </div>
        @include('layouts.partials.footer')
    </div>
</div>

<script src="{{asset("vendors/bootstrap/dist/js/bootstrap.min.js")}}"></script>
@yield('script')
<!-- Custom Theme Scripts -->
<script src="{{asset("js/custom.js")}}"></script>
</body>
</html>