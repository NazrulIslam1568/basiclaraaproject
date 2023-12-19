@extends('frontend.mastering.master')
@section('title')
<title>Forgot Password - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')
<main class="main">
<div class="container">
    <div class="wrapper">
        <div class="m-auto">
            <h3 class="mt-2 text-center"><strong>Forgot Password</strong></h3>
        </div>
        <form class="p-3 mt-3" id="forgot-password">
            <div class="position-relative form-field d-flex align-items-center"> <span class="fas fa-phone"></span> <input type="number" id="forgot-password-phone" placeholder="Phone Number (Ex: 01........)" autocomplete="off"> 
                <span class="phone-no-checked" style="color: #ed2024"></span>
            </div>

            <button type="submit" class="btn" id="forgot-button">Forgot</button>
        </form>
    </div>
</div>
</main>
@endsection