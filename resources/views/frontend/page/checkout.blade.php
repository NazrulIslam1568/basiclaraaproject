@extends('frontend.mastering.master')
@section('title')
<title>Checkout - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('shop')}}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row" style="margin-bottom: 30px;">
                <div class="col-lg-12">
                    <div class="shoping__discount">
                        <h5>Discount Codes <button @if($coupon_amount) style="display:inline-block" @else style="display:none" @endif id="cancel_coupon" class="btn btn-danger">cancel Coupon</button>
                        <form id="apply_coupon" action="{{route('apply_coupon')}}" method="post">
                            <input type="hidden" name="cart_coupon_get" id="cart_coupon_get" value="{{$cart_count}}">
                            <input style="color:#000; border:1px solid #000" id="apply_coupon_input" type="text" name="coupon_code" placeholder="Enter your coupon code" required>
                            <button type="submit" style="background: #ed2024; color: #fff;" class="theme-color site-btn">APPLY COUPON</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <form id="checkout-button-form" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Full Name<span>*</span></p>
                                        <input name="full_name" type="text" value="{{Auth::user()->name}}" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Mobile No<span>*</span></p>
                                        <input name="full_name" type="number" value="{{Auth::user()->phone_no}}" name="phone" disabled>
                                    </div>
                                </div>
                            </div>
                            @if(empty($division))
                            <div class="checkout__input">
                                <p>Division<span>*</span></p>
                                <select class="form-control nim-division" name="division">
                                    <option value="0">Select Your Division</option>
                                    <?php $divisions = DB::table('divisions')->get(); ?>
                                    @foreach($divisions as $division)
                                    <option value="division-{{$division->id}}">{{$division->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="checkout__input district" style="display:none">
                                <p>District<span>*</span></p>
                                <select class="form-control" show_class="" id="nim-district" name="district">
                                </select>
                            </div>
                            <div class="checkout__input upazila" style="display:none">
                                <p>Upazila<span>*</span></p>
                                <select class="form-control" show_class="" id="nim-upazila" name="upazila">
                                </select>
                            </div>
                            <div class="checkout__input bazar_name" style="display:none">
                                <p>Nearest Town<span>*</span></p>
                                <select class="form-control" show_class="" id="nim-bazar_name" name="bazar_name">
                                </select>
                            </div>
                            <div class="checkout__input elaka_name" style="display:none">
                                <p>Home Address<span>*</span></p>
                                <select class="form-control" show_class="" id="nim-elaka_name" name="elaka_name">
                                </select>
                            </div>
                            <div class="checkout__input detail_address" style="display:none">
                                <p>Detail Address<span>*</span></p>
                                <input name="detail_address" type="text" class="checkout__input__add" placeholder="কিভাবে আপনার বাসা চিনা যাবে ঐ তথ্যটি দিন" >
                            </div>
                            @else
                            <div class="checkout__input ">
                                <p>Division<span>*</span></p>
                                <input type="hidden" value="{{Auth::user()->division}}" name="division">
                                <select class="form-control nim-division" style="-webkit-appearance: none;" name="division" disabled>
                                    <option value="{{Auth::user()->division}}">{{Auth::user()->division}}</option>
                                </select>
                            </div>
                            <div class="checkout__input district ">
                                <p>District<span>*</span></p>
                                <input type="hidden" value="{{Auth::user()->district}}" name="district">
                                <select class="form-control" style="-webkit-appearance: none;" name="district" disabled>
                                <option value="{{Auth::user()->district}}">{{Auth::user()->district}}</option>
                                </select>
                            </div>
                            <div class="checkout__input upazila ">
                                <p>Upazilla<span>*</span></p>
                                <input type="hidden" value="{{Auth::user()->upazila}}" name="upazila">
                                <select class="form-control" style="-webkit-appearance: none;" name="upazila" disabled>
                                <option value="{{Auth::user()->upazila}}">{{Auth::user()->upazila}}</option>
                                </select>
                            </div>
                            <div class="checkout__input upazila ">
                                <p>Nearest Town<span>*</span></p>
                                <input type="hidden" value="{{Auth::user()->bazar_name}}" name="bazar_name">
                                <select class="form-control" style="-webkit-appearance: none;" name="bazar_name" disabled>
                                <option value="{{Auth::user()->bazar_name}}">{{Auth::user()->bazar_name}}</option>
                                </select>
                            </div>
                            <div class="checkout__input upazila ">
                                <p>Home Address<span>*</span></p>
                                <input type="hidden" value="{{Auth::user()->elaka_name}}" name="elaka_name">
                                <select class="form-control" style="-webkit-appearance: none;" name="elaka_name" disabled>
                                <option value="{{Auth::user()->elaka_name}}">{{Auth::user()->elaka_name}}</option>
                                </select>
                            </div>
                            <div class="checkout__input ">
                                <p>Detail Address<span>*</span></p>
                                <input type="hidden" value="{{Auth::user()->detail_address}}" name="detail_address">
                                <input name="detail_address" type="text" class="checkout__input__add" value="{{Auth::user()->detail_address}}" disabled>
                            </div>
                            @endif
                            <div class="checkout__input__checkbox">
                                <label for="different-address">
                                    Ship to a different address?
                                    <input name="different-address" type="checkbox" id="different-address">
                                    <span class="checkmark" style="background:#ed2024"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="same-address">
                                    Ship to a Same address?
                                    <input name="same-address" type="checkbox" id="same-address">
                                    <span class="checkmark" style="background:#ed2024"></span>
                                </label>
                            </div>
                            <h4 class="checkout-different-address mb-0 mt-5" style="display:none">Shipped Address</h4>
                            <div class="row checkout-different-address" style="display:none">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Full Name<span>*</span></p>
                                        <input name="different-full_name" type="text"  placeholder ="Full Name"  >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Mobile No<span>*</span></p>
                                        <input name="different-phone_no" type="number"  name="phone" placeholder ="Phone Number"  >
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input division checkout-different-address" style="display:none">
                                <p>Division<span>*</span></p>
                                <select class="form-control nim-different-division" name="different_division">
                                    <option value="0">Select Your Division</option>
                                    <?php $divisions = DB::table('divisions')->get(); ?>
                                    @foreach($divisions as $division)
                                    <option value="division-{{$division->id}}">{{$division->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="checkout__input different-district " style="display:none">
                                <p>District<span>*</span></p>
                                <select class="form-control" show_class="" id="nim-different-district" name="different_district">
                                </select>
                            </div>
                            <div class="checkout__input different-upazila " style="display:none">
                                <p>Upazila<span>*</span></p>
                                <select class="form-control" show_class="" id="nim-different-upazila" name="different_upazila">
                                </select>
                            </div>
                            <div class="checkout__input different-bazar_name " style="display:none">
                                <p>Nearest Town<span>*</span></p>
                                <select class="form-control" show_class="" id="nim-different-bazar_name" name="different_bazar_name">
                                </select>
                            </div>
                            <div class="checkout__input different-elaka_name " style="display:none">
                                <p>Home Address<span>*</span></p>
                                <select class="form-control" show_class="" id="nim-different-elaka_name" name="different_elaka_name">
                                </select>
                            </div>
                            <div class="checkout__input different-detail_address" style="display:none">
                                <p>Detail Address<span>*</span></p>
                                <input name="different_detail_address" type="text" class="checkout__input__add" placeholder="কিভাবে আপনার বাসা চিনা যাবে ঐ তথ্যটি দিন" >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Your Order</h4>
                                <div class="checkout__order__products">Products</div>
                                <ul>
                                    @foreach($all_carts as $all_cart)
                                    @if($all_cart->type == 'restaurant')
                                    <?php $products = DB::table('restaurant_products')->where(['id'=>$all_cart->product_id])->first(); 
                                        $main_product = DB::table('products')->where(['id'=>$products->main_product_id])->first();
                                    ?>
                                    <li class="mt-1">
                                        <div class="product-list">
                                            <div class="product-image" style="border: 2px solid #ccc; border-radius: 20px; padding: 5px; line-height: normal">
                                                <img style="margin-left: 50%; transform: translateX(-50%);width: 100px; height: 100px;" src="{{asset('frontend/img/product/'.$main_product->image)}}" alt="{{$products->product_name}}">
                                                <p style="line-height: normal;" class="product-name">{{$all_cart->product_name}}</p>
                                                <div class="product-all-type d-flex">
                                                    <div class="product-weight text-center" style="width:30%">
                                                        <p>{{$products->product_weight}}</p>
                                                    </div>
                                                    <div class="product-pr  text-center" style="width:30%">
                                                        <p>৳ {{$all_cart->product_price}}</p>
                                                    </div>
                                                    <div class="product-quantity  text-center" style="width:10%">
                                                       <p>{{$all_cart->quantity}}</p>
                                                    </div>
                                                    <div class="product-total" style="width:30%; text-align:right;">
                                                        <p>৳ {{$all_cart->total_price}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @else
                                    <?php $products = DB::table('products')->where(['id'=>$all_cart->product_id])->first(); ?>
                                    <li class="mt-1">
                                        <div class="product-list">
                                            <div class="product-image" style="border: 2px solid #ccc; border-radius: 20px; padding: 5px; line-height: normal">
                                                <img style="margin-left: 50%; transform: translateX(-50%);width: 100px; height: 100px;" src="{{asset('frontend/img/product/'.$products->image)}}" alt="{{$products->product_name}}">
                                                <p style="line-height: normal;" class="product-name">{{$all_cart->product_name}}</p>
                                                <div class="product-all-type d-flex">
                                                    <div class="product-weight text-center" style="width:30%">
                                                        <p>{{$products->product_weight}}</p>
                                                    </div>
                                                    <div class="product-pr  text-center" style="width:30%">
                                                        <p>৳ {{$all_cart->product_price}}</p>
                                                    </div>
                                                    <div class="product-quantity  text-center" style="width:10%">
                                                       <p>{{$all_cart->quantity}}</p>
                                                    </div>
                                                    <div class="product-total" style="width:30%; text-align:right;">
                                                        <p>৳ {{$all_cart->total_price}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                                <?php 
                                    $curent_date = date('Y-m-d');
                                    $free_product = DB::table('coupons')->where(['amount_type'=>'Free Product'])->where(['status'=>1])->where('expiry_date','>=',$curent_date)->where('amount','>',0)->get();
                                ?>
                                <ul>
                                    @foreach($free_product as $key=>$product)
                                    <?php
                                        $find_product = DB::table('products')->where(['product_code'=>$product->coupon_code])->first();
                                    ?>
                                    @if($key == 0) <div class="checkout__order__products">Free Product</div> @endif
                                    <li class="mt-1">
                                        <div class="product-list">
                                            <div class="product-image" style="border: 2px solid #ccc; border-radius: 20px; padding: 5px; line-height: normal">
                                                <img style="margin-left: 50%; transform: translateX(-50%);width: 100px; height: 100px;" src="{{asset('frontend/img/product/'.$find_product->image)}}" alt="{{$products->product_name}}">
                                                <p style="line-height: normal;" class="product-name">{{$find_product->product_name}}</p>
                                                <div class="product-all-type d-flex">
                                                    <div class="product-weight text-center" style="width:30%">
                                                        <p>{{$find_product->product_weight}}</p>
                                                    </div>
                                                    <div class="product-pr  text-center" style="width:30%">
                                                        <p>৳ {{$find_product->product_price}}</p>
                                                    </div>
                                                    <div class="product-quantity  text-center" style="width:10%">
                                                        <p>1</p>
                                                    </div>
                                                    <div class="product-total" style="width:30%; text-align:right;">
                                                        <p>৳ 0</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="checkout__order__subtotal">Subtotal <span>৳ {{$cart_count}}</span></div>
                                <input type="hidden" name="total_amount" id="input_checkout_page_total_amount" value="{{$total_amount}}">
                                <input type="hidden" name="discount_amount" id="input_discount_amount" value="{{$coupon_amount}}">
                                <input type="hidden" name="sub_total" value="{{$cart_count}}">
                                <div class="checkout__order__subtotal discount" @if($coupon_amount) style="display:block" @else style="display:none" @endif>Discount <span>৳ <span id="cart-page-discount">{{$coupon_amount}}</span></span></div>
                                <div class="checkout__order__subtotal return" @if($return_balance_first > 0) style="display:block" @else style="display:none" @endif>Return Balance <span>৳ <span id="cart-page-return">{{$return_balance_first}}</span></span></div>
                                @if($offer_count < 1)
                                <div class="checkout__order__subtotal register" @if($register_balance_first > 0) style="display:block" @else style="display:none" @endif>Register Balance <span>৳ <span id="cart-page-register">{{$register_balance_first}}</span></span></div>
                                @endif
                                <div class="checkout__order__subtotal cashback" @if($cashback_balance_first > 0) style="display:block" @else style="display:none" @endif>Cashback Balance <span>৳ <span id="cart-page-cashback">{{$cashback_balance_first}}</span></span></div>
                                <input  id="total_amount_input" type="hidden" value="{{$total_amount}}">
                                <div class="checkout__order__total">Total <span>৳ <span id="cart-page-total">{{$total_amount}}</span></span></div>
                                <div class="checkout__input__checkbox">
                                    <label for="cod">
                                        Cash On Delivery
                                        <input type="checkbox" name="cod" class="payment-method-checkout" id="cod" checked>
                                        <span class="checkmark" style="background:#ed2024"></span>
                                    </label><br>
                                    <label for="Bkash">
                                        Bkash
                                        <input type="checkbox" name="Bkash" class="payment-method-checkout" id="Bkash" >
                                        <span class="checkmark" style="background:#ed2024"></span>
                                    </label>
                                </div>
                                <button type="submit" id="checkout-button" class="site-btn theme-color">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
</main><!-- End .main -->
@endsection