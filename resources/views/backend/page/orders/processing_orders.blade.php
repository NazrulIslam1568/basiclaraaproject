@extends('backend.mastering.master')
@section('title')
<title>Processing Orders - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Processing Orders </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Processing Orders</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card" id="Processing_Orders_table">
            <div class="card">
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Status</th>
                                <th>User Name</th>
                                <th>User Phone</th>
                                <th>Shipped Name</th>
                                <th>Shipped Phone</th>
                                <th>Amount</th>
                                <th>Discount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php $orders = DB::table('orders')->where(['status'=>'Processing'])->orderBy('id', 'DESC')->get(); ?>
                        @foreach($orders as $order)
                        <?php $user = DB::table('users')->where(['id'=>$order->user_id])->first(); ?>
                        @if($user)
                        <tbody>
                            <tr>
                                <td>{{$order->order_no}}</td>
                                <td>{{$order->status}}</td>
                                <td>{{$order->ship_name}}</td>
                                <td>{{$order->ship_phone}}</td>
                                <td>{{$order->total_amount}}</td>
                                <td>{{$order->discount_amount}}</td>
                                <td>
                                    <a target="_blank" href="{{route('invoice_pdf',$order->id)}}" style="background: blue; color: #fff; padding: 5px 10px; text-decoration:none;">Print</a>
                                    <a href="{{route('download_invoice_pdf',$order->id)}}" style="background: blue; color: #fff; padding: 5px 10px; text-decoration:none;">Download</a>
                                    @if(Auth::user()->role_as == 'Admin')
                                    <a target="_blank" href="{{route('order_details_change',$order->id)}}" style="background: #ed2024; color: #fff; padding: 5px 10px; text-decoration:none;">Details</a>
                                    @endif
                                </td>
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