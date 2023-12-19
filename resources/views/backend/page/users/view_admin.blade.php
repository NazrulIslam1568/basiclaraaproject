@extends('backend.mastering.master')
@section('title')
<title>View Admins - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> View Admins </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admins</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Admins</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card" id="view_Orders_table">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title"><input type="search" data-pass="search_filter" id="search-product-input" placeholder = "Search....." style="width: 100%; border-radius: 30px; padding: 5px 20px; color: #000;"></h4>
                <div class="table-responsive">
                    <table class="table" id="search_filter">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Total Order</th>
                                <th>Total Amount</th>
                                <th>Role</th>
                                <th>Address</th>
                                <th>Detail Address</th>
                                <th>Register Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php $users = DB::table('users')->where(['role_as'=>'Admin'])->orderBy('id', 'DESC')->get(); ?>
                        @foreach($users as $user)
                        <?php 
                            $total_order = DB::table('orders')->where(['user_id'=>$user->id])->where(['status'=>'Complete'])->count();
                            $total_amount = DB::table('orders')->where(['user_id'=>$user->id])->where(['status'=>'Complete'])->sum('total_amount');
                        ?>
                        <tbody>
                            <tr>
                                <td><img src="{{asset('/frontend/img/user/'.$user->image)}}" alt="{{$user->name}}" style="width: 80px; height: 80px;"></td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->phone_no}}</td>
                                <td>{{$total_order}}</td>
                                <td>{{$total_amount}}</td>
                                <td>{{$user->role_as}}</td>
                                <td>{{$user->division}}, {{$user->district}}, {{$user->upazila}}</td>
                                <td>{{$user->bazar_name}}, {{$user->elaka_name}}, {{$user->detail_address}}</td>
                                <td>{{ date('d-m-Y g:i a', strtotime($user->created_at))}}</td>
                                <td><?php $order_msg = DB::table('setting')->first(); ?>
                                    @if($order_msg->order_message == $user->phone_no)
                                    <a target="_blank" href="{{route('user_details_page',$user->id)}}" style="background: #ed2024; color: #fff; padding: 5px 10px; text-decoration:none;">Details</a>
                                    @else
                                    <a href="{{route('order_msg_access',$user->phone_no)}}" style="background: #ed2024; color: #fff; padding: 5px 10px; text-decoration:none;">Msg</a>
                                    <a target="_blank" href="{{route('user_details_page',$user->id)}}" style="background: #ed2024; color: #fff; padding: 5px 10px; text-decoration:none;">Details</a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection