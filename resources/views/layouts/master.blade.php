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
<body class="">
<div class="body">
    <div class="">
        @include('layouts.partials.top_menu')
        <div class="right_col" role="main">
            <div class="x_panel">
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
                @yield('content')
                <div class="clearfix"></div>
            </div>
        </div>
        @include('layouts.partials.footer')
    </div>
</div>
<!-- jQuery -->
<script src="{{asset("js/vendors.min.js")}}"></script>
@yield('script')
<!-- Custom Theme Scripts -->
<script src="{{asset("js/app.min.js")}}"></script>
</body>
</html>
