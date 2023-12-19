@extends('backend.mastering.master')
@section('title')
<title>Complete Orders - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Complete Orders </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Complete Orders</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card" id="Confirm_Orders_table">
            <div class="card">
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Delivery Time</th>
                                <th>Delivered Name</th>
                                <th>Amount</th>
                                <th>Order No</th>
                                <th>Status</th>
                                <th>User Name</th>
                                <th>User Phone</th>
                                <th>Shipped Name</th>
                                <th>Shipped Phone</th>
                                <th>Discount</th>
                            </tr>
                        </thead>
                        <?php $orders = DB::table('orders')->where(['status'=>'Complete'])->orderBy('id', 'DESC')->get(); ?>
                        @foreach($orders as $order)
                        <?php $user = DB::table('users')->where(['id'=>$order->user_id])->first(); ?>
                        @if($user)
                        <tbody>
                            <tr>
                                <td>{{$order->delivery_time}}</td>
                                <td>{{$order->delivered_name}}</td>
                                <td>{{$order->total_amount}}</td>
                                <td>{{$order->order_no}}</td>
                                <td>{{$order->status}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->phone_no}}</td>
                                <td>{{$order->ship_name}}</td>
                                <td>{{$order->ship_phone}}</td>
                                <td>{{$order->discount_amount}}</td>
                            </tr>
                        </tbody>
                        @endif
                        @endforeach
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection