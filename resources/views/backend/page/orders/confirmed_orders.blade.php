@extends('backend.mastering.master')
@section('title')
<title>Confirm Orders - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Confirm Orders </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Confirm Orders</li>
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
                                <th>Action</th>
                                <th>Order No</th>
                                <th>Status</th>
                                <th>User Name</th>
                                <th>User Phone</th>
                                <th>Shipped Name</th>
                                <th>Shipped Phone</th>
                                <th>Amount</th>
                                <th>Discount</th>
                            </tr>
                        </thead>
                        <?php $orders = DB::table('orders')->where(['status'=>'Pickup'])->orderBy('id', 'DESC')->get(); ?>
                        @foreach($orders as $order)
                        <?php $user = DB::table('users')->where(['id'=>$order->user_id])->first(); ?>
                        @if($user)
                        <tbody>
                            <tr>
                                <td>
                                    <a class="order-confirm-popup-open" order_id="{{$order->id}}" style="cursor:pointer; background: blue; color: #fff; padding: 5px 10px; text-decoration:none;">Confirm Order</a>
                                </td>
                                <td>{{$order->order_no}}</td>
                                <td>{{$order->status}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->phone_no}}</td>
                                <td>{{$order->ship_name}}</td>
                                <td>{{$order->ship_phone}}</td>
                                <td>{{$order->total_amount}}</td>
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

    <div class="order-confirm-popup">
        <div class="modal open">
            <div class="modal-overlay" onclick="closeModal()" ></div>
            <div class="modal-card">
                <div class="modal-body">
                <div class="modal-header">Confirm Order</div>
                <div class="modal-content">
                    <input type="number" id="order_confirm_code" placeholder="Order Code">
                    <input type="text" id="order_confirm_name" placeholder="Delivered Name">
                </div>
                <div class="modal-footer" >
                    Footer
                    <button id="order_confirm_cancel_button" class="btn btn-danger">Cancel</button>
                    <button id="order_confirm_submit_button" order_id="" class="btn btn-success">Okay</button>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection