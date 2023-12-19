@extends('frontend.mastering.master')
@section('title')
<title>User Balance - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')
<main class="main">
    <div class="container mb-4 mt-4">
        <h3>Your Balance History</h3>
        <div class="cashback-balance balance-div mt-2" style="border : 1px solid #ccc; padding: 10px">
            <div class="balance-text d-flex">
                <h4>Cashback Balance</h4>
            </div>
            <div class="balance-amount d-flex">
                <h4 class="mb-0">৳ <span id="cashback-balance-amount">{{Auth::user()->cashback_balance}}</span></h4>
                @if(Auth::user()->cashback_pending_balance > 0)
                <h6 class="mb-0 ml-4">Hold Balance ৳ <span id="cashback-balance-amount">{{Auth::user()->cashback_pending_balance}}</span></h6>
                @endif
            </div>
        </div>
        <div class="register-balance balance-div mt-2" style="border : 1px solid #ccc; padding: 10px">
            <div class="balance-text">
                <h4>Register Balance</h4>
            </div>
            <div class="balance-amount">
                <h4 class="mb-0">৳ <span id="register-balance-amount">{{Auth::user()->register_balance}}</span></h4>
            </div>
        </div>
        <div class="return-balance balance-div mt-2" style="border : 1px solid #ccc; padding: 10px">
            <div class="balance-text">
                <h4>Return Balance</h4>
            </div>
            <div class="balance-amount">
                <h4 class="mb-0">৳ <span id="return-balance-amount">{{Auth::user()->return_balance}}</span></h4>
            </div>
        </div>
        <div class="return-balance balance-div mt-2" style="border : 1px solid #ccc; padding: 10px">
            <a href="https://shop.bkash.com/nimnio01710621166/paymentlink/default-payment">
                <div class="balance-text">
                    <h4>Bkash Payment</h4>
                </div>
                <div class="balance-amount">
                    <h4 class="mb-0">বিকাশের মাধ্যমে পেমেন্ট করতে এখানে ক্লিক করুন।</h4>
                </div>
            </a>
        </div>
    </div>
</main><!-- End .main -->
@endsection