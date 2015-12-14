@extends('layouts.master')

@section('content')

    <h1>Login</h1>
    <hr/>

    <form method="POST" action="/login" accept-charset="UTF-8" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="form-group ">
            <label for="name" class="col-sm-3 control-label">Email: </label>
            <div class="col-sm-6">
                <input class="form-control" value="{{ old('email') }}" name="email" type="text" id="email">
            </div>
        </div>
        <div class="form-group ">
            <label for="age" class="col-sm-3 control-label">Password: </label>
            <div class="col-sm-6">
                <input class="form-control" type="password" name="password" id="password">

            </div>
        </div>
        <div class="form-group ">
            <label for="message" class="col-sm-3 control-label"></label>
            <div class="col-sm-6">
                <input type="checkbox" name="remember"> Remember Me
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <input class="btn btn-primary form-control" type="submit" value="Login">
            </div>
        </div>
    </form>

@endsection
