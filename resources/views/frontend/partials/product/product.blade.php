@foreach($products as $product)
<div class="col-6 col-md-4 col-lg-2">
    <div class="product product-3">
        <figure class="product-media">
            <div style="background: #d7d7d7;" class="lazy-loader">
                <img src="{{asset('image/logo product.webp')}}">
            </div>
            <span class="product-label text-white">{{$product->product_code}}</span>
            <img data-original="{{asset('frontend/img/product/'.$product->image)}}" alt="{{$product->product_name}}" class="product-image" >
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
                    <div class="cart-plus product-cart-page-plus" cart_id="{{$cart->id}}" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                        <i class="d-flex align-items-center h-100 fas fa-plus"></i>
                    </div>
                    <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"><span class="product_qty_input-{{$cart->id}}" style="font-size: 14px">{{$cart->quantity}}</span> in Cart</button>
                    <div class="cart-plus product-cart-page-minus" cart_id="{{$cart->id}}" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                        <i class="d-flex align-items-center h-100 fas fa-minus"></i>
                    </div>
                </span>
                @else
                @if($product->visible == 1)
                <button id="shop-cart-button" product_id ="{{$product->id}}" class="product-button product-add-cart-button" style="width: 100%">Add to Cart</button>
                @else
                <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"> Stock Out</button>
                @endif
                @endif
            @else
                @if($cart_session_count > 0)
                <span class="d-flex">
                    <div class="cart-plus product-cart-page-plus" cart_id="{{$cart->id}}" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                        <i class="d-flex align-items-center h-100 fas fa-plus"></i>
                    </div>
                    <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"><span class="product_qty_input-{{$cart->id}}" style="font-size: 14px">{{$cart->quantity}}</span> in Cart</button>
                    <div class="cart-plus product-cart-page-minus" cart_id="{{$cart->id}}" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">
                        <i class="d-flex align-items-center h-100 fas fa-minus"></i>
                    </div>
                </span>
                @else
                @if($product->visible == 1)
                <button id="shop-cart-button" product_id ="{{$product->id}}" class="product-button product-add-cart-button" style="width: 100%">Add to Cart</button>
                @else
                <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"> Stock Out</button>
                @endif
                @endif
            @endif
            </div><!-- End .product-action -->
            <h4 class="product-title text-center"><a>{{$product->product_name}}</a></h4><!-- End .product-title -->
            <h4 class="product-title product-weight">{{$product->product_weight}}</h4><!-- End .product-title -->
            <div class="product-price">
                <span class="new-price">৳ {{$product->product_price}}</span>
                @if($product->old_price)
                <span class="old-price text-decoration-line-through"> ৳ {{$product->old_price}}</span>
                @endif
            </div><!-- End .product-price -->
        </div><!-- End .product-body -->
    </div><!-- End .product -->
</div><!-- End .col-sm-6 col-lg-3 -->
@endforeach