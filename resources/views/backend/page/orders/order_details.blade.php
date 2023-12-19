@extends('backend.mastering.master')
@section('title')
<title>Order Details - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> View Orders </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Orders</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card" id="view_Orders_table">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="table table-bordered table-striped">
                            <tbody>
                                <?php $user_id =  $orders->user_id;
                                    $user = DB::table('users')->where(['id'=>$user_id])->first();
                                ?>
                                <tr>
                                    <td class="taskDesc">Order Name</td>
                                    <td class="taskStatus">{{$user->name}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Order Phone No</td>
                                    <td class="taskStatus">{{$user->phone_no}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Order Date</td>
                                    <td class="taskStatus">{{$orders->created_at->format('D, d-m-Y g:i a')}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Order Status</td>
                                    <td class="taskStatus">{{$orders->status}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Total</td>
                                    <td class="taskStatus">{{$orders->total_amount}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Shipping Charge</td>
                                    <td class="taskStatus">0</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Coupon Code</td>
                                    <td class="taskStatus">{{$orders->discount_code}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Coupon Amount</td>
                                    <td class="taskStatus">{{$orders->discount_amount}}</td>
                                </tr>
                                @if(Auth::user()->phone_no == '01710621166')
                                <tr>
                                    <td class="taskDesc">Order Verify Code</td>
                                    <td class="taskStatus">{{$orders->order_code}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="taskDesc">Payment Method</td>
                                    <td class="taskStatus">{{$orders->payment_method}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="w-100">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="btn-group" id="buttonexport">
                                <a href="#">
                                    <h4>Order Status Update</h4>
                                </a>
                            </div>
                        </div>
                    <div class="card-body">
                        <form action="{{route('order_status_change')}}" method="post" > @csrf
                            <input type="hidden" name="order_id" value="{{$orders->id}}">
                            <table style="width:100%">
                                <tr>
                                    <td>
                                        <select name="order_status" id="order_status" class="form-control">
                                            <option>{{$orders->status}}</option>
                                            @if($orders->status=="Processing")
                                            <option value="Confirm" @if($orders->status=="Confirm") selected @endif>Confirm</option>
                                            <option value="Cancel" @if($orders->status=="Cancel") selected @endif>Cancel</option>
                                            @endif
                                            @if($orders->status=="Confirm")
                                            <option value="Pickup" @if($orders->status=="Pickup") selected @endif>Pickup</option>
                                            @endif
                                            @if(Auth::user()->phone_no == '01318684323')
                                            <option value="Complete" @if($orders->status=="Complete") selected @endif>Complete</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td><input placeholder ="Order Date" name="order_deliver_date" autocomplete="off" style="width: 100%" type="text" id="datepicker"></td>
                                    <td>
                                        <select name="order_deliver_start" id="order_status" class="form-control">
                                            @if($orders->status=='Processing')
                                            <option value="0">End Time</option>
                                            @else
                                            <option value="$orders->request_order_time_start">{{$orders->request_order_time_start}}</option>
                                            @endif
                                            <option value="01.00 am">01:00AM</option>
                                            <option value="02.00 am">02:00AM</option>
                                            <option value="03.00 am">03:00AM</option>
                                            <option value="04.00 am">04:00AM</option>
                                            <option value="05.00 am">05:00AM</option>
                                            <option value="06.00 am">06:00AM</option>
                                            <option value="07.00 am">07:00AM</option>
                                            <option value="08.00 am">08:00AM</option>
                                            <option value="09.00 am">09:00AM</option>
                                            <option value="10.00 am">10:00AM</option>
                                            <option value="11.00 am">11:00AM</option>
                                            <option value="12.00 am">12:00AM</option>
                                            <option value="01.00 pm">01:00PM</option>
                                            <option value="02.00 pm">02:00PM</option>
                                            <option value="03.00 pm">03:00PM</option>
                                            <option value="04.00 pm">04:00PM</option>
                                            <option value="05.00 pm">05:00PM</option>
                                            <option value="06.00 pm">06:00PM</option>
                                            <option value="07.00 pm">07:00PM</option>
                                            <option value="08.00 pm">08:00PM</option>
                                            <option value="09.00 pm">09:00PM</option>
                                            <option value="10.00 pm">10:00PM</option>
                                            <option value="11.00 pm">11:00PM</option>
                                            <option value="12.00 pm">12:00PM</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="order_deliver_end" id="order_status" class="form-control">
                                            @if($orders->status=='Processing')
                                            <option value="0">End Time</option>
                                            @else
                                            <option value="$orders->request_order_time_end">{{$orders->request_order_time_end}}</option>
                                            @endif
                                            <option value="01.00 am">01:00AM</option>
                                            <option value="02.00 am">02:00AM</option>
                                            <option value="03.00 am">03:00AM</option>
                                            <option value="04.00 am">04:00AM</option>
                                            <option value="05.00 am">05:00AM</option>
                                            <option value="06.00 am">06:00AM</option>
                                            <option value="07.00 am">07:00AM</option>
                                            <option value="08.00 am">08:00AM</option>
                                            <option value="09.00 am">09:00AM</option>
                                            <option value="10.00 am">10:00AM</option>
                                            <option value="11.00 am">11:00AM</option>
                                            <option value="12.00 am">12:00AM</option>
                                            <option value="01.00 pm">01:00PM</option>
                                            <option value="02.00 pm">02:00PM</option>
                                            <option value="03.00 pm">03:00PM</option>
                                            <option value="04.00 pm">04:00PM</option>
                                            <option value="05.00 pm">05:00PM</option>
                                            <option value="06.00 pm">06:00PM</option>
                                            <option value="07.00 pm">07:00PM</option>
                                            <option value="08.00 pm">08:00PM</option>
                                            <option value="09.00 pm">09:00PM</option>
                                            <option value="10.00 pm">10:00PM</option>
                                            <option value="11.00 pm">11:00PM</option>
                                            <option value="12.00 pm">12:00PM</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" class="btn btn-success" value="Update Status">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    </div>
                </div>
                <!-- End Table -->
                <?php $orderproducts = DB::table('order_products')->where(['order_id'=>$orders->id])->get(); ?>
                <div class="">
                    <div class="btn-group">
                        <a href="#">
                            <h4>Poduct View</h4>
                        </a>
                    </div>
                </div>
                <div class="row">
                    @foreach($orderproducts as $order_product)
                    <?php 
                        if($order_product->type == "restaurant"){
                            $product = DB::table('restaurant_products')->where(['id'=>$order_product->product_id])->first();
                            $restaurant = DB::table('add_restaurants')->where(['id'=>$product->restaurant_id])->first();
                        }else{
                            $product = DB::table('products')->where(['id'=>$order_product->product_id])->first();
                        }
                    ?>
                    <div class="col-md-4">
                        <div class="card-body">
                            <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                            <div class="table-responsive">
                                <div class="col-md-12" style="text-align:center">
                                    <img src="{{asset('/frontend/img/product/'.$order_product->product_image)}}" alt="nimnio" style="text-align: center; width:100px; height:100px;">
                                </div>
                                <table id="table_id" class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td class="taskDesc">Product Name</td>
                                            <td class="taskStatus">{{$product->product_name}} @if($order_product->type == "restaurant") ({{$restaurant->name}}) @endif</td>
                                        </tr>
                                        <tr>
                                            <td class="taskDesc">Product Weight</td>
                                            <td class="taskStatus">{{$product->product_weight}}</td>
                                        </tr>
                                        <tr>
                                            <td class="taskDesc">Product Quantity</td>
                                            <td class="taskStatus">{{$order_product->product_quantity}}</td>
                                        </tr>
                                        <tr>
                                            <td class="taskDesc">Total Price</td>
                                            <td class="taskStatus">{{$order_product->product_quantity*$order_product->product_price}}</td>
                                        </tr>
                                        <tr>
                                            <td class="taskDesc">Product Code</td>
                                            <td class="taskStatus">{{$product->product_code}}</td>
                                        </tr>
                                        <tr>
                                            <td class="taskDesc">Product Price</td>
                                            <td class="taskStatus">{{$order_product->product_price}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection