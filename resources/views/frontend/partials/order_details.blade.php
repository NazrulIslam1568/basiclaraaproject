@extends('frontend.mastering.master')
@section('title')
<title>Order Details - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')
<main class="main">
    <div class="container mt-4">
        <h3 class="text-center">My Orders</h3>
        <div class="row position-relative">
            <div class="order-details">
                <div class="card" style="background: #edeff2; padding: 10px;">
                    <div class="top-order-details d-flex">
                        <div class="status" style="width: 50%; text-align: left">
                            <div style=" font-size: 20px; font-weight: 800; color: #000;" class="order-details-status"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="order-top-history">
                        <div class="order-no">
                            <span>Order No </span> <br><strong class="order-no-details">{{$order->order_no}}</strong>
                        </div>
                        <div class="delivery-time">
                            <span>Delivery Time </span> <br><strong><span class="request-order-date">{{$order->request_order_date}}</span>, <span class="request-order-time-start">{{$order->request_order_time_start}}</span>-<span class="request-order-time-end">{{$order->request_order_time_end}}</span> </strong>
                        </div>
                        <div class="order-amount">
                            <span>Total Amount </span> <br><strong>৳ {{$order->total_amount}}<span class="order-total-amount"></span></strong>
                        </div>
                    </div>
                    <h5 class="mt-2 mb-0">Order Information</h5>
                    <div class="order-information-history">
                        <div class="order-information">
                            <span>Shipping Address : </span><br>
                            <span class="name order_details_ship_name">{{$order->ship_name}}</span><br>
                            <span class="normal order_details_ship_division">{{$order->ship_division}}</span><br>
                            <span class="normal order_details_ship_district">{{$order->ship_district}}</span><span class="normal order_details_ship_upazila">{{$order->ship_upazila}}</span><br>
                            <span class="normal order_details_ship_bazar_name">{{$order->ship_bazar_name}}</span><br>
                            <span class="normal order_details_ship_elaka_name">{{$order->ship_elaka_name}}</span><br>
                            <span class="normal order_details_ship_detail_address">{{$order->ship_detail_address}}</span><br>
                            <span class="normal order_details_ship_phone">{{$order->ship_phone}}</span><br>
                        </div>
                        <div class="order-information">
                            <span>Delivered To :  </span><br>{{$order->delivered_name}}
                            <span class="normal delivered-confirmed-name"></span><br><br>
                            <span>Delivered Time :  </span><br>{{$order->delivery_time}}
                            <span><span class="normal confirm-order-time"></span></span><br><br>
                            <span>Payment Method  :  </span><br>{{$order->payment_method}}
                            <span class="normal order-payment-method-details"></span>
                        </div>
                        <div class="order-information">
                            <span>Order Time :  </span><br> {{$order_date}}
                            <span class="normal order-details-date"></span><br><br>
                            <span>Discount :  </span><br>
                            <span>৳ <span class="normal order-details-discount">{{$order->discount_amount}}</span></span><br><br>
                            <span>Delivery Cost :  </span><br>
                            <span>৳ <span class="normal order-details-delivery-cost">{{$order->delivery_cost}}</span></span>
                        </div>
                        
                    </div>
                    <hr>
                    <h3 class="mt-2 mb-0 text-center">Products</h3>
                    <div class="order-top-history" id="order_details_product_pc">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Image</th>
                                        <th >Product Name</th>
                                        <th class="text-center">Weight</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td class="text-center"><img style="margin-left: 50%; transform: translateX(-50%);width: 100px; height: 100px;" src="{{asset('frontend/img/product/'.$product->product_image)}}" alt="{{$product->product_name}}"></td>
                                        <td >{{$product->product_name}}</td>
                                        <td class="text-center">{{$product->product_weight}}</td>
                                        <td class="text-center">{{$product->product_price}}</td>
                                        <td class="text-center">{{$product->product_quantity}}</td>
                                        <td class="text-center">{{$product->product_price * $product->product_quantity}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Mobile Menu View -->
                    <div id="order_details_product_mobile">
                        <ul>
                            @foreach($products as $product)
                            <li class="mt-1">
                                <div class="product-list">
                                    <div class="product-image" style="border: 2px solid #ccc; border-radius: 20px; padding: 5px; line-height: normal">
                                        <img style="margin-left: 50%; transform: translateX(-50%);width: 100px; height: 100px;" src="{{asset('frontend/img/product/'.$product->product_image)}}" alt="{{$product->product_name}}">
                                        <p style="line-height: normal;" class="product-name">{{$product->product_name}}</p>
                                        <div class="product-all-type d-flex">
                                            <div class="product-weight text-center" style="width:30%">
                                                <p>{{$product->product_weight}}</p>
                                            </div>
                                            <div class="product-pr  text-center" style="width:30%">
                                                <p>৳ {{$product->product_price}}</p>
                                            </div>
                                            <div class="product-quantity  text-center" style="width:10%">
                                                <p>{{$product->product_quantity}}</p>
                                            </div>
                                            <div class="product-total" style="width:30%; text-align:right;">
                                                <p>৳ {{$product->product_price * $product->product_quantity}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><!-- End .main -->
@endsection