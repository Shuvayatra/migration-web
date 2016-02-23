<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NRNA App</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    @yield('css')
    <style>
        body {
            padding-top: 70px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('home')}}">NRNA App</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @if (!Auth::guest())
                    <li><a href="{{route('tag.index')}}">Tags</a></li>
                    <li><a href="{{route('country.index')}}">Country</a></li>
                    <li><a href="{{route('question.index')}}">Questions</a></li>
                    <li><a href="{{route('post.index')}}">Posts</a></li>
                    <li><a href="javascript:void();">Welcome  {{ Auth::user()->email }}</a></li>
                    <li><a href="{{ url('/auth/logout') }}">Logout</a></li>

                @endif
            </ul>
        </div>

    </div>
    <!-- /.container-fluid -->
</nav>

<div class="container">
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
</div>

<hr/>

<div class="footer">
</div>

<!-- Scripts -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script >
    $('form .btn-danger').click(function (e) {
        return confirm("Are you sure you want to delete ?");
        e.preventDefault();
    });
</script>
<link href="{{asset('css/style.css')}}" rel="stylesheet"/>
@yield('script')
</body>
</html>