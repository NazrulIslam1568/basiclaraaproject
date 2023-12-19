@extends('frontend.mastering.master')
@section('title')
<title>{{$product->product_name}} - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('shop')}}">Shops</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->product_name}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <figure class="product-main-image">
                                    <img id="product-zoom product_image" src="{{asset('frontend/img/product/'.$product->image)}}" data-zoom-image="{{asset('frontend/img/product/'.$product->image)}}" alt="{{$product->product_name}}" >
                                </figure><!-- End .product-main-image -->
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="product-details">
                            <!----- Usable Input Method ------>
                            <input type="hidden" class="user-session-id" value="{{$session_id}}">
                            <input type="hidden" id="product_id" value="{{$product->id}}">
                            <input type="hidden" id="product_image" value="{{$product->image}}">
                            <input type="hidden" id="buy_price" value="{{$product->buy_price}}">
                            @if(Auth::check())
                            <input type="hidden" class="user-id" value="{{Auth::user()->id}}">
                            @endif
                            <!------ End Usable Input Method  ------>
                            <h1 class="product-title"><strong id="product_name">{{$product->product_name}}</strong></h1><!-- End .product-title -->
                            <h6>{{$product->product_desc}}</h6>

                            <div class="product-price" >
                                ৳  <span id="product_price">{{$product->product_price}}</span> 
                            </div><!-- End .product-price -->
                            <div class="product-price" >
                                <h6>{{$product->product_weight}}</h6> 
                            </div><!-- End .product-price -->
                            <?php
                                if(Auth::check()){
                                    $cart_user_count = DB::table('carts')->where(['user_id'=>Auth::user()->id])->where(['product_id'=>$product->id])->count();
                                    $cart = DB::table('carts')->where(['user_id'=>Auth::user()->id])->where(['product_id'=>$product->id])->first();
                                }else{
                                    $cart_session_count = DB::table('carts')->where(['session_id'=>$session_id])->where(['product_id'=>$product->id])->count();
                                    $cart = DB::table('carts')->where(['session_id'=>$session_id])->where(['product_id'=>$product->id])->first();
                                }

                            ?>


                            <div class="product-details-action product product-3" id="product-details-action" style="width: 200px">
                            @if(Auth::check())
                                @if($cart_user_count > 0)
                                <span class="d-flex" style="width: 200px;">
                                    <div class="cart-plus product-cart-page-plus" cart_id="{{$cart->id}}" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                                        <i class="d-flex align-items-center h-100 fas fa-plus"></i>
                                    </div>
                                    <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"><span class="product_qty_input-{{$cart->id}}" style="font-size: 14px">{{$cart->quantity}}</span> in Cart</button>
                                    <div class="cart-plus product-cart-page-minus" cart_id="{{$cart->id}}" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                                        <i class="d-flex align-items-center h-100 fas fa-minus"></i>
                                    </div>
                                </span>
                                @else
                                <button id="cart-button" product_id ="{{$product->id}}" class="product-button product-add-cart-button" style=" font-size: 20px; width: 200px">Add to Cart</button>
                                @endif
                            @else
                                @if($cart_session_count > 0)
                                <span class="d-flex" style="width: 200px;">
                                    <div class="cart-plus product-cart-page-plus" cart_id="{{$cart->id}}" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                                        <i class="d-flex align-items-center h-100 fas fa-plus"></i>
                                    </div>
                                    <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"><span class="product_qty_input-{{$cart->id}}" style="font-size: 14px">{{$cart->quantity}}</span> in Cart</button>
                                    <div class="cart-plus product-cart-page-minus" cart_id="{{$cart->id}}" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                                        <i class="d-flex align-items-center h-100 fas fa-minus"></i>
                                    </div>
                                </span>
                                @else
                                <button id="cart-button" product_id ="{{$product->id}}" class="product-button product-add-cart-button" style=" font-size: 20px; width: 200px">Add to Cart</button>
                                @endif
                            @endif
                                <div class="details-action-wrapper">
                                    <!-- <a href="#" class="btn-product btn-wishlist" title="Wishlist"><span>Add to Wishlist</span></a>
                                    <a href="#" class="btn-product btn-compare" title="Compare"><span>Add to Compare</span></a> -->
                                </div><!-- End .details-action-wrapper -->
                            </div><!-- End .product-details-action -->
                            <!-- <div>
                                <h5 class="text-center">Shipping Time: <strong style="background: #000; color: #fff; padding: 5px 10px; border-radius: 10px;">@if($current_time > 12){{ $tomorrow_date}} (01.00PM - 06.30PM)@else{{ $current_date}} (10.00AM - 01.00PM)@endif</strong></h5>
                            </div> -->
                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="#">{{$product->brand}}</a>,
                                    <a href="#">{{$product->category}}</a>,
                                    <a href="#">{{$product->choice}}</a>
                                </div><!-- End .product-cat -->
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@endsection