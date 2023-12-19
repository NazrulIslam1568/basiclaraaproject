@extends('frontend.mastering.master')
@section('title')
<title>{{$category}} - {{$settings->company_name}}</title>
<meta name="description" content="Choose your {{$category}} product. Order Now : 01710621166">
<meta property="og:description" content="Choose your {{$category}} product. Order Now : 01710621166" />
<meta property="og:title" content="{{$category}} || Nimnio.com"/>
<meta property="og:url" content="" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="en-us" />
<meta property="og:locale:alternate" content="en-us" />
<meta property="og:site_name" content="nimnio.com" />
<meta property="og:image" content="" />
<meta property="og:image:url" content="" />
<meta property="og:image:size" content="100" />
@endsection
@section('main_layouts')
<input type="hidden" id="category_name" value="{{$category}}">
<main class="main category-product-page-load">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('all_restaurants')}}">Restaurant</a></li>
                <li class="breadcrumb-item"><a href="{{route('restaurants_category',[$division,$district,$upazila,$restaurant])}}">{{$restaurant}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$category}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="container">
        <div class="top-side">
            <div class="left-side">
                <h2 class="title mb-4">{{$category}} </h2><!-- End .title text-center -->
            </div>
            <div class="right-side">
                <div class="d-flex">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                    <input type="text" class="category_product_search" placeholder="Search your {{$category}}">
                </div>
            </div>
        </div>
        <h6 id="search_span" style="margin-top: 10px; display:none; text-align:center; font-size: 15px">Search Result for : <strong style="color:#ed2024" id="search_result"></strong></h6>
        <div class="cat-blocks-container">
            <div class="row" id="category_product_view">
                <h4 class="no-product text-center mt-5 w-100 d-none">No Product View</h4>
                @foreach($restaurant_products as $product)
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="product product-3">
                        <figure class="product-media">
                            <div style="background: #d7d7d7;" class="lazy-loader">
                                <img src="{{asset('image/logo product.webp')}}">
                            </div>
                            <span class="product-label text-white">{{$product->product_code}}</span>
                            <?php $product_image = DB::table('products')->where(['id'=>$product->main_product_id])->first(); ?>
                            @if($product_image)
                            <img data-original="{{asset('frontend/img/product/'.$product_image->image)}}" alt="{{$product->product_name}}" class="product-image" >
                            @endif
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-main product-id-{{$product->id}}">
                            <?php
                                $session_id = Session::getId();
                                if(Auth::check()){
                                    $cart_user_count = DB::table('carts')->where(['user_id'=>Auth::user()->id])->where(['product_id'=>$product->id])->count();
                                    $cart = DB::table('carts')->where(['user_id'=>Auth::user()->id])->where(['product_id'=>$product->id])->first();
                                }else{
                                    $cart_session_count = DB::table('carts')->where(['session_id'=>$session_id])->where(['product_id'=>$product->id])->count();
                                    $cart = DB::table('carts')->where(['session_id'=>$session_id])->where(['product_id'=>$product->id])->first();
                                }
                            ?>
                            @if(Auth::check())
                                @if($cart_user_count > 0)
                                <span class="d-flex">
                                    <div class="cart-plus product-cart-page-plus" cart_id="{{$cart->id}}" type="restaurant" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                                        <i class="d-flex align-items-center h-100 fas fa-plus"></i>
                                    </div>
                                    <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"><span class="product_qty_input-{{$cart->id}}" style="font-size: 14px">{{$cart->quantity}}</span> in Cart</button>
                                    <div class="cart-plus product-cart-page-minus" cart_id="{{$cart->id}}" type="restaurant" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                                        <i class="d-flex align-items-center h-100 fas fa-minus"></i>
                                    </div>
                                </span>
                                @else
                                @if($product->status == 1)
                                <button id="shop-cart-button" product_id ="{{$product->id}}" class="product-button product-add-cart-button" type="restaurant" style="width: 100%">Add to Cart</button>
                                @else
                                <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"> Stock Out</button>
                                @endif
                                @endif
                            @else
                                @if($cart_session_count > 0)
                                <span class="d-flex">
                                    <div class="cart-plus product-cart-page-plus" cart_id="{{$cart->id}}" type="restaurant" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                                        <i class="d-flex align-items-center h-100 fas fa-plus"></i>
                                    </div>
                                    <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"><span class="product_qty_input-{{$cart->id}}" style="font-size: 14px">{{$cart->quantity}}</span> in Cart</button>
                                    <div class="cart-plus product-cart-page-minus" cart_id="{{$cart->id}}" type="restaurant" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                                        <i class="d-flex align-items-center h-100 fas fa-minus"></i>
                                    </div>
                                </span>
                                @else
                                @if($product->visible == 1)
                                <button id="shop-cart-button" product_id ="{{$product->id}}" class="product-button product-add-cart-button" type="restaurant" style="width: 100%">Add to Cart</button>
                                @else
                                <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"> Stock Out</button>
                                @endif
                                @endif
                            @endif
                            </div><!-- End .product-action -->
                            <h4 class="product-title text-center" style="height: auto"><a>{{$product->product_name}}</a></h4><!-- End .product-title -->
                            <h4 class="product-title product-weight">{{$product->product_weight}}</h4><!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">৳ {{$product->product_price}}</span>
                            </div><!-- End .product-price -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                </div><!-- End .col-sm-6 col-lg-3 -->
                @endforeach
            </div><!-- End .row -->
        </div><!-- End .cat-blocks-container -->
    </div><!-- End .container -->
</main><!-- End .main -->
@endsection