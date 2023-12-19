@extends('frontend.mastering.master')
@section('title')
<title>Login - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')
<main class="main">
<div class="container">
    <div class="wrapper">
        <div class="logo"> <img src="{{asset('image/nimnio_logo.png')}}" alt="{{$settings->company_name}}"> </div>
        <form class="p-3 mt-3" id="login_form">
        @csrf
            <span style="position:relative;">
                <div class="form-field d-flex align-items-center"> <span class="fas fa-phone"></span> <input type="number" name="phone" id="login-phone" placeholder="Phone Number"  autocomplete="off"> </div>
            </span>
            <div class="form-field d-flex align-items-center"> <span class="fas fa-key"></span> <input type="password" name="password" id="password" placeholder="Password" autocomplete="off"> 
                <div  id="eye" style="margin-right: 5px"><i icon="fa-eye" style="cursor:pointer" input="password" class="password-hide-show fas fa-eye"></i></div>
            </div>
            <a href="{{route('forgot_password')}}"><strong>Forgot Password?</strong></a>
            <button type="submit" class="btn" id="login-button">Login</button>
        </form>
        <div class="text-center fs-6"> <span>Don't have an account?</span> or <a href="{{route('register')}}">Register</a> </div>
    </div>
</div>
</main>
@endsection

