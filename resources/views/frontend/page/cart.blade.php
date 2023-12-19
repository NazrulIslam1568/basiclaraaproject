
@extends('frontend.mastering.master')
@section('title')
<title>Cart - {{$settings->company_name}}</title>
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

    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th style="width: 40%">Product</th>
                                    <th style="width: 15%">Price</th>
                                    <th style="width: 30%">Quantity</th>
                                    <th style="width: 12%">Total</th>
                                    <th style="width: 12%"></th>
                                </tr>
                            </thead>
                            <hr>
                            <tbody id="cart-page-product">
                                <h2 id="my_name_is_nazrul">My Name Is Nazrul</h2>
                                @foreach($carts as $cart)
                                <tr>
                                    <td class="product-col" >
                                        <div class="product" style="background:transparent">
                                            <figure class="product-media">
                                                <a href="{{route('single_product',$cart->product_url)}}" target="_blank">
                                                    <img src="{{asset('frontend/img/product/'.$cart->product_image)}}" alt="{{$cart->product_name}}">
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a href="{{route('single_product',$cart->product_url)}}" target="_blank">{{$cart->product_name}}</a>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">৳ {{$cart->product_price}}</td>
                                    <td class="quantity-col">
                                        <div class="product-details-quantity d-flex">
                                            <span class="product-cart-page-increase" title="Increase Product" cart_id="{{$cart->id}}"><i class="d-flex align-items-center h-100 fas fa-plus"></i></span>
                                            <span class="product-qty-input d-flex">
                                                <input id="product_qty_input" class="cart-{{$cart->id}}" type="number" id="qty" value="{{$cart->quantity}}" min="1" max="10" step="1" data-decimals="0" disabled>
                                            </span>
                                            <span class="product-cart-page-decrease" title="Decrease Product" cart_id="{{$cart->id}}"><i class="d-flex align-items-center h-100 fas fa-minus"></i></span>
                                        </div><!-- End .product-details-quantity -->
                                    </td>
                                    <?php   $cart->total_price = $cart->quantity*$cart->product_price;?>
                                    <td class="total-col" >৳ <span id="cart-page-product-price-<?Php echo$cart->id ?>"><?Php echo$cart->total_price ?></span></td>
                                    <td class="remove-col"><a href="{{route('cart_product_remove',$cart->id)}}" class="btn-remove" cart_id="{{$cart->id}}" title="Remove Product"><i class="icon-close"></i></a></td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table><!-- End .table table-wishlist -->

                        <div class="cart-bottom">
                            <div class="cart-discount">
                                <form id="apply_coupon">
                                    <div class="input-group d-flex">
                                        <input type="hidden" name="cart_coupon_get" id="cart_coupon_get" value="{{$coupon_count}}">
                                        <input id="apply_coupon_input" type="text" class="form-control" name="coupon_code" required placeholder="coupon code" style="background:#03A9F4; color: #fff;">
                                        <button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
                                    </div><!-- End .input-group -->
                                </form>
                                <button @if($coupon_amount) style="display:inline-block" @else style="display:none" @endif id="cancel_coupon" class="btn btn-danger" style="padding: 5px 10px;">cancel Coupon</button>
                            </div><!-- End .cart-discount -->
                        </div><!-- End .cart-bottom -->
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td>৳ <span id="cart-page-subtotal">{{$coupon_count}}</span></td>
                                    </tr><!-- End .summary-subtotal -->
                                    <tr class="summary-subtotal">
                                        <td>Free Shipping:</td>
                                        <td>৳ <span id="cart-page-subtotal">0</span></td>
                                    </tr><!-- End .summary-subtotal -->
                                    <tr class="summary-subtotal cart-page-discount-div" @if($coupon_amount) style="display:table-row" @else style="display:none" @endif>
                                        <td>Discount:</td>
                                        <td>৳ <span id="cart-page-discount">{{$coupon_amount}}</span></td>
                                    </tr><!-- End .summary-subtotal -->

                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td>৳ <span id="cart-page-total">{{$coupon_count - $coupon_amount}}</span></td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->

                            <a href="{{route('checkout')}}" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                        </div><!-- End .summary -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@endsection