<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice PDF</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('image/single_logo.png')}}">
    <style>
        table{
            border: 1px solid #000;
        }
        table thead td{
            text-align: center;
        }
        table thead tr{
            border: 1px solid #000;
        }
        table tbody td{
            border: 1px solid #000;
        }
        table tbody tr{
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <main class="main container">
        <div class="row">
            <!-- BEGIN INVOICE -->
            <div class="col-md-12">
                <div class="grid invoice">
                    <div class="company-detail" >
                        <div class="header-top" style="display:flex">
                            <div class="header-left" style="width: 50%;">
                                <img style="width: 250px; height: 100px; margin-bottom: 10px;" src="https://nimnio.com/image/nimnio_logo.png" alt="nimnio">
                            </div>
                            <div class="header-right" style="float:right; width: 50%; text-align:right;">
                                <h2 style="margin: 0; padding: 0; margin-top: 40px;">Invoice</h2>
                                <p style="margin: 0; padding: 0;">Invoice No : 850{{$order->id}}</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                        <div class="row" style="display:flex; margin-top: 30px; margin-bottom: 30px;">
                            <div class="col-md-6" style="width: 50%;">
                                <address><?php $user_id =  $order->user_id;
                                    $user = DB::table('users')->where(['id'=>$user_id])->first();
                                ?>
                                    <strong style="font-size: 20px;">Billed To:</strong><br>
                                    <strong style="font-size:25px;">{{$user->name}} </strong><br>
                                    {{$user->division}}, {{$user->district}},<br>
                                    {{$user->upazila}}, {{$user->bazar_name}},<br>
                                    {{$user->elaka_name}}, {{$user->detail_address}}.<br>
                                    <abbr title="Phone">Phone:</abbr> {{$user->phone_no}}
                                </address>
                            </div>
                            <div class="col-md-6 text-right" style="width: 50%; float:right; text-align:right;">
                                <address>
                                <strong style="font-size: 20px;">Shipped To:</strong><br>
                                <strong style="font-size:25px;">{{$order->ship_name}}</strong><br>
                                    {{$order->ship_division}}, {{$order->ship_district}}<br>
                                    {{$order->ship_upazila}}, {{$order->ship_bazar_name}}.<br>
                                    {{$order->ship_elaka_name}}, {{$order->ship_detail_address}}.<br>
                                    <abbr title="Phone">Phone:</abbr> {{$order->ship_phone}}
                                </address>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-2" style="display: flex; margin-top: 20px; margin-bottom: 20px;">
                            <div class="col-md-6" style="width: 50%;">
                                <address>
                                    <strong>Payment Method :</strong><br>
                                    {{$order->payment_method}}
                                </address>
                            </div>
                            <div class="col-md-6 text-right" style="width: 50%; float:right; text-align:right;">
                                <address>
                                    <strong>Order Date :</strong><br>
                                    {{ date('d-m-Y g:i a', strtotime($order->created_at))}}
                                </address>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <h3><strong>ORDER SUMMARY</strong></h3>
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr class="line">
                                            <td style="border: 1px solid #000;"><strong>No</strong></td>
                                            <td class="text-left" style="border: 1px solid #000;"><strong>Product Name</strong></td>
                                            <td class="text-center" style="border: 1px solid #000;"><strong>Weight</strong></td>
                                            <td class="text-center" style="border: 1px solid #000;"><strong>Price</strong></td>
                                            <td class="text-center" style="border: 1px solid #000;"><strong>Quantity</strong></td>
                                            <td class="text-right" style="border: 1px solid #000;"><strong>Amount</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody><?php $order_products = DB::table('order_products')->where(['order_id'=>$order->id])->get(); ?>
                                        @foreach($order_products as $key => $order_product)
                                        <?php 
                                            if($order_product->type == "restaurant"){
                                                $product = DB::table('restaurant_products')->where(['id'=>$order_product->product_id])->first();
                                                $restaurant = DB::table('add_restaurants')->where(['id'=>$product->restaurant_id])->first();
                                            }else{
                                                $product = DB::table('products')->where(['id'=>$order_product->product_id])->first();
                                            }
                                        ?>
                                        <tr style="padding: 5px;">
                                            <td style="text-align: center; padding: 5px;">{{$key + 1}}</td>
                                            <td style="text-align: left; padding: 5px;">{{$product->product_name}} @if($order_product->type == "restaurant") ({{$restaurant->name}}) @endif <br></td>
                                            <td style="text-align: center; padding: 5px;">{{$product->product_weight}}<br></td>
                                            <td style="text-align: right; padding: 5px;">Tk. {{$order_product->product_price}}</td>
                                            <td style="text-align: center; padding: 5px;">{{$order_product->product_quantity}}</td>
                                            <td style="text-align: right; padding: 5px; padding-right: 10px;">Tk {{$order_product->product_price*$order_product->product_quantity}}</td>
                                        </tr>
                                        @endforeach
                                        @if($order->delivery_cost > 0)
                                        <tr>
                                            <td colspan="4">
                                            </td><td class="text-right" style="text-align:right; padding: 5px; padding-right: 10px;"><strong>SubTotal :</strong></td>
                                            <td class="text-right" style="text-align:right; padding: 5px; padding-right: 10px;"><strong>Tk {{$order->sub_amount}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                            </td><td class="text-right" style="text-align:right; padding: 5px; padding-right: 10px;"><strong>Instant :</strong></td>
                                            <td class="text-right" style="text-align:right; padding: 5px; padding-right: 10px;"><strong>Tk {{$order->delivery_cost}}</strong></td>
                                        </tr>
                                        @endif
                                        @if($order->discount_amount > 0)
                                        <tr>
                                            <td colspan="4">
                                            </td><td class="text-right" style="text-align:right; padding: 5px; padding-right: 10px;"><strong>SubTotal :</strong></td>
                                            <td class="text-right" style="text-align:right; padding: 5px; padding-right: 10px;"><strong>Tk {{$order->sub_amount}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                            </td><td class="text-right" style="text-align:right; padding: 5px; padding-right: 10px;"><strong>Discount :</strong></td>
                                            <td class="text-right" style="text-align:right; padding: 5px; padding-right: 10px;"><strong>Tk {{$order->discount_amount}}</strong></td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td colspan="4">
                                            </td><td class="text-right" style="text-align:right; padding: 5px; padding-right: 10px;"><strong>Total :</strong></td>
                                            <td class="text-right" style="text-align:right; padding: 5px; padding-right: 10px;"><strong>Tk {{$order->total_amount}}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>									
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right identity"><br><p>Invoice identity<br>
                                <img style="margin-top: 5px;width: 129px; margin-bottom:-15px; height: 50px;" src="https://nimnio.com/image/signature.png"><br>
                                <h3 style="margin:0; padding:0;">(Md. Nazrul Islam)</h3>CEO & Founder<br>FB: facebook.com/nazrulparves1568 <br> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END INVOICE -->
        </div>
    </main><!-- End .main -->
</body>
</html>