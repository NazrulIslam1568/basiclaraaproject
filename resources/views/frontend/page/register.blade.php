@extends('frontend.mastering.master')
@section('title')
<title>Register - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')  
<main class="main">
<div class="container">
    <div class="wrapper">
        <div class="logo"> <img src="{{asset('image/nimnio_logo.png')}}" alt="{{$settings->company_name}}"> </div>
        <form class="p-3 mt-3" id="register_form">
            <div class="form-field d-flex align-items-center"> <span class="far fa-user"></span> <input type="text" name="fullname" id="userName" placeholder="Full Name"  autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"> </div>
            <span style="position:relative;">
                <div class="form-field d-flex align-items-center"> <span class="fas fa-phone"></span> <input type="number" name="phone" id="register-phone" placeholder="Phone Number"  autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"> </div>
                <span class="phone-no-checked"></span>
            </span>
            <div class="form-field d-flex align-items-center"> <span class="fas fa-key"></span> <input type="password" name="password" id="password" placeholder="Password"  autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"> 
                <div  id="eye" style="margin-right: 5px"><i icon="fa-eye" style="cursor:pointer" input="password" class="password-hide-show fas fa-eye"></i></div>
            </div>
            <span style="position:relative;">
            <div class="form-field d-flex align-items-center"> <span class="fas fa-key"></span> <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" autocomplete="off"  readonly onfocus="this.removeAttribute('readonly');"> 
                <div  id="eye" style="margin-right: 5px"><i icon="fa-eye" style="cursor:pointer" input="confirm_password" class="password-hide-show fas fa-eye"></i></div>
            </div>
                <span class="password-matched-checked"></span>
            </span>
            <button type="submit" class="btn mt-3" id="register-button">Register</button>
        </form>
        <div class="text-center fs-6"> <span>Already have an account?</span> or <a href="{{route('login')}}">Log In</a> </div>
    </div>
</div>
</main>
@endsection