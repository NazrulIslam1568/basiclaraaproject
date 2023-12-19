@extends('frontend.mastering.master')
@section('title')
<title>Invoice - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')  
<main class="main container">
    <div class="row">
        <!-- BEGIN INVOICE -->
        <div class="col-md-12">
            <div class="grid invoice">
                <div class="grid-body">
                    <div class="invoice-title">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h2><strong>Invoice</strong><br>
                                <span class="small">order # {{$id}}</span></h2>
                            </div>
                        </div>
                        <div class="text-center">
                            <a target="_blank" href="{{route('invoice_pdf',$id)}}"><button class="btn btn-lg" style="background: #03A9F4; color: #fff;">View</button></a>
                            <a href="{{route('download_invoice_pdf',$id)}}"><button class="btn btn-lg" style="background: #03A9F4; color: #fff;">Download</button></a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <strong>Billed To:</strong><br>
                                <strong style="font-size:25px;">{{Auth::user()->name}}</strong><br>
                                {{Auth::user()->division}}, {{Auth::user()->district}},<br>
                                {{Auth::user()->upazila}}, {{Auth::user()->bazar_name}},<br>
                                {{Auth::user()->elaka_name}}, {{Auth::user()->detail_address}}.<br>
                                <abbr title="Phone">Phone:</abbr> {{Auth::user()->phone_no}}
                            </address>
                        </div>
                        <div class="col-md-6 text-right">
                            <address>
                            <strong>Shipped To:</strong><br>
                            <strong style="font-size:25px;">{{$order->ship_name}}</strong><br>
                                {{$order->ship_division}}, {{$order->ship_district}}<br>
                                {{$order->ship_upazila}}, {{$order->ship_bazar_name}}.<br>
                                {{$order->ship_elaka_name}}, {{$order->ship_detail_address}}.<br>
                                <abbr title="Phone">Phone:</abbr> {{$order->ship_phone}}
                            </address>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <address>
                                <strong>Payment Method:</strong><br>
                                @if($order->payment_method == 'COD')
                                Cash On Delivery<br>
                                @else
                                {{$order->payment_method}}
                                @endif
                            </address>
                        </div>
                        <div class="col-md-6 text-right">
                            <address>
                                <strong>Order Date:</strong><br>
                                {{ date('d-m-Y g:i a', strtotime($order->created_at))}}
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <h3><strong>ORDER SUMMARY</strong></h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr class="line">
                                        <td><strong>No</strong></td>
                                        <td class="text-left"><strong>Product Name</strong></td>
                                        <td class="text-center"><strong>Price</strong></td>
                                        <td class="text-center"><strong>Quantity</strong></td>
                                        <td class="text-right"><strong>Amount</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order_products as $key => $order_product)
                                    <?php $product = DB::table('products')->where(['id'=>$order_product->product_id])->first(); ?>
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td class="text-left">{{$product->product_name}}<br></td>
                                        <td class="text-center">৳ {{$product->product_price}}</td>
                                        <td class="text-center">{{$order_product->product_quantity}}</td>
                                        <td class="text-right">৳ {{$product->product_price*$order_product->product_quantity}}</td>
                                    </tr>
                                    @endforeach
                                    
                                    @if($order->discount_amount > 0)
                                    <tr>
                                        <td colspan="3">
                                        </td><td class="text-right"><strong>Sub Amount</strong></td>
                                        <td class="text-right"><strong>৳ {{$order->sub_amount}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                        </td><td class="text-right"><strong>Discount</strong></td>
                                        <td class="text-right"><strong>৳ {{$order->discount_amount}}</strong></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3">
                                        </td><td class="text-right"><strong>Total Amount</strong></td>
                                        <td class="text-right"><strong>৳ {{$order->total_amount}}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>									
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right identity">
                            
                            <p>Invoice identity<br><strong>Md. Nazrul Islam</strong><br>CEO & Founder</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END INVOICE -->
    </div>
</main><!-- End .main -->

@endsection