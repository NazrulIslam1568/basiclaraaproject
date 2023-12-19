@extends('frontend.mastering.master')
@section('title')
<title>Users Orders - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')
<main class="main">
    <div class="container mt-4">
        <h4>My Orders</h4>
        <div class="row position-relative">
            <div class="col-lg-12 grid-margin stretch-card" id="order-table" style="z-index: 10">
                <div class="card">
                    <div class="">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th class="mobile-device-none">Payment Method</th>
                                        <th class="mobile-device-none">Date & Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $user_id = Auth::user()->id;
                                        $orders = DB::table('orders')->where(['user_id'=>$user_id])->get();
                                    ?>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>#{{$order->order_no}}</td>
                                        <td>{{$order->status}}</td>
                                        <td>{{$order->total_amount}}</td>
                                        <td class="mobile-device-none">{{$order->payment_method}}</td>
                                        <td class="mobile-device-none">{{ date('d-m-Y g:i a', strtotime($order->created_at))}}</td>
                                        <td>
                                            <a style="background: #ed2024; color: #fff; border: none; padding: 5px 20px;" href="{{route('order_details_get',$order->order_no)}}">Details</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Product  -->
            <div class="order-details" id="order-details-page">
                <div class="card" style="background: #edeff2; padding: 10px;">
                    <div class="top-order-details d-flex">
                        <div class="status" style="width: 50%; text-align: left">
                            <div style=" font-size: 20px; font-weight: 800; color: #000;" class="order-details-status"></div>
                        </div>
                        <div  style="width: 50%; text-align: right; ">
                            <div style="font-size: 15px; font-weight: 500; color: #000; cursor:pointer" class="order-details-cancel">Cancel</div>
                        </div>
                    </div>
                    <hr>
                    <div class="order-top-history">
                        <div class="order-no">
                            <span>Order No </span> <br><strong class="order-no-details"></strong>
                        </div>
                        <div class="delivery-time">
                            <span>Delivery Time </span> <br><strong><span class="request-order-date"></span>, <span class="request-order-time-start"></span>-<span class="request-order-time-end"></span> </strong>
                        </div>
                        <div class="order-amount">
                            <span>Total Amount </span> <br><strong>৳ <span class="order-total-amount"></span></strong>
                        </div>
                    </div>
                    <h5 class="mt-2 mb-0">Order Information</h5>
                    <div class="order-information-history">
                        <div class="order-information">
                            <span>Shipping Address : </span><br>
                            <span class="name order_details_ship_name"></span><br>
                            <span class="normal order_details_ship_division"></span><br>
                            <span class="normal order_details_ship_district"></span><span class="normal order_details_ship_upazila"></span><br>
                            <span class="normal order_details_ship_bazar_name"></span><br>
                            <span class="normal order_details_ship_elaka_name"></span><br>
                            <span class="normal order_details_ship_detail_address"></span><br>
                            <span class="normal order_details_ship_phone"></span><br>
                        </div>
                        <div class="order-information">
                            <span>Delivered To :  </span><br>
                            <span class="normal delivered-confirmed-name"></span><br><br>
                            <span>Delivered Time :  </span><br>
                            <span><span class="normal confirm-order-time"></span></span><br><br>
                            <span>Delivery  :  </span><br>
                            <span class="normal order-payment-method-details"></span>
                        </div>
                        <div class="order-information">
                            <span>Order Time :  </span><br>
                            <span class="normal order-details-date"></span><br><br>
                            <span>Discount :  </span><br>
                            <span>৳ <span class="normal order-details-discount"></span></span><br><br>
                            <span>Delivery Cost :  </span><br>
                            <span>৳ <span class="normal order-details-delivery-cost"></span></span>
                        </div>

                    </div>
                    <hr>
                    <h5 class="mt-2 mb-0">Products</h5>
                    <div class="order-top-history">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody id="order-details-products">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><!-- End .main -->
@endsection
