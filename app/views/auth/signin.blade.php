@extends('layouts/frontend')

@section('content')

<form class="form-signin" role="form" method="post">
    
    <h2 class="form-signin-heading">Please sign in</h2>
    <input type="email" class="form-control" name="email" placeholder="Email address" required autofocus>
    <input type="password" class="form-control" name="password" placeholder="Password" required>
    @if (Session::has('message'))
    <div class="text-danger flash text-center">
        <small>{{ Session::get('message') }}<small>
    </div>
    @endif    
    <label class="checkbox">
        <input type="checkbox" value="remember-me"> Remember me
    </label>
    <input type="submit" value="Sign in" class="btn btn-lg btn-primary btn-block"/>
</form>

@stop