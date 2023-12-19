@extends('frontend.mastering.master')
@section('title')
<title>Change Password - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')
<main class="main">
<div class="container">
    <div class="wrapper">
        <h6 class="text-center error-message" style="color: #ed2024"></h6>
        <div class="m-auto">
            <h3 class="mt-2 text-center"><strong>Change Password</strong></h3>
        </div>
        @if(Auth::check())
        @if(Auth::user()->forgot_password ==1)
        <p class="m-auto text-center">Check your phone. We have sent Demo Password. <strong id="change-password-phone">@if(Auth::check()){{Auth::user()->phone_no}} @endif</strong>.</p>
        @else
        <p class="m-auto text-center d-none"><strong id="change-password-phone">@if(Auth::check()){{Auth::user()->phone_no}} @endif</strong.</p>

        @endif
        @else
        <p class="m-auto text-center">Check your phone. We have sent Demo Password. <strong id="change-password-phone">{{$phone_no}}</strong>.</p>
        @endif
        <form class="p-3 mt-3" id="change-password">
            @if(Auth::check())
                @if(Auth::user()->forgot_password ==1)
                <div class="position-relative form-field d-flex align-items-center"> <span class="fas fa-key"></span> <input id="demo-password" type="password" name="demo-password" placeholder="Demo Password" autocomplete="off" required> 
                    <div  id="eye" style="margin-right: 5px"><i icon="fa-eye" style="cursor:pointer" input="demo-password" class="password-hide-show fas fa-eye"></i></div>
                </div>
                @else
                <div class="position-relative form-field d-flex align-items-center"> <span class="fas fa-key"></span> <input id="old-password" type="password" name="current-password" placeholder="Current Password" autocomplete="off" required> 
                    <div  id="eye" style="margin-right: 5px"><i icon="fa-eye" style="cursor:pointer" input="old-password" class="password-hide-show fas fa-eye"></i></div>
                </div>
                @endif
            @else
            <div class="position-relative form-field d-flex align-items-center"> <span class="fas fa-key"></span> <input id="demo-password" type="password" name="demo-password" placeholder="Demo Password" autocomplete="off" required> 
                <div  id="eye" style="margin-right: 5px"><i icon="fa-eye" style="cursor:pointer" input="demo-password" class="password-hide-show fas fa-eye"></i></div>
            </div>
            @endif
            <div class="position-relative form-field d-flex align-items-center"> <span class="fas fa-key"></span> <input id="new-password" type="password" name="new-password" placeholder="New Password" autocomplete="off" required> 
                <div  id="eye" style="margin-right: 5px"><i icon="fa-eye" style="cursor:pointer" input="new-password" class="password-hide-show fas fa-eye"></i></div>
            </div>
            <div class="position-relative form-field d-flex align-items-center"> <span class="fas fa-key"></span> <input id="confirm-password" type="password" name="confirm-password" placeholder="Confirm Password" autocomplete="off" required> 
                <div  id="eye" style="margin-right: 5px"><i icon="fa-eye" style="cursor:pointer" input="confirm-password" class="password-hide-show fas fa-eye"></i></div>
            </div>
            <button type="submit" class="btn" id="forgot-button">Change Password</button>
        </form>
    </div>
</div>
</main>
@endsection