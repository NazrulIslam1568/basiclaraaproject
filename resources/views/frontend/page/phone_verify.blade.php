@extends('frontend.mastering.master')
@section('title')
<title>Phone Verify - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts') 
<main class="main"> 
<div class="container">
    <div class="wrapper">
        <div class="col-lg-12 col-md-12">
            <div class="phone-verify">
                <div class="m-auto">
                    <h3 class="mt-2"><strong>Verify Your Phone</strong></h3>
                </div>
                <p class="m-auto text-center">Check your Phone. We have sent a 4-digit PIN in your phone <strong>@if(Auth::check()){{Auth::user()->phone_no}}@endif</strong>.</p>
                <div class="input-sub-field text-center d-flex">
                    <input id="verify_first" autocomplete="off"  maxlength="1" class="col-md-3 text-center form-field d-flex align-items-center" type="number">
                    <input id="verify_second" autocomplete="off"  maxlength="1" class="col-md-3 text-center form-field d-flex align-items-center" type="number">
                    <input id="verify_third" autocomplete="off"  maxlength="1" class="col-md-3 text-center form-field d-flex align-items-center" type="number">
                    <input id="verify_fourth" autocomplete="off"  maxlength="1" class="col-md-3 text-center form-field d-flex align-items-center" type="number">
                </div>
                <div class="col-lg-12 text-center" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" class="btn" id="submit_verify">Verify</button>
                </div>
                <div class="col-lg-12 text-center mt-1">
                    @if(Auth::check())
                    <a href="{{route('resend_code',Auth::user()->phone_no)}}" class="p-2 main-color">Resend Code</a>  
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection

