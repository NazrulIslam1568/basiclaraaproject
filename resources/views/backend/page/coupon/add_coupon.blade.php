@extends('backend.mastering.master')
@section('title')
<title>Add Coupon - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Add Coupon </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Product Khoroch</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Coupon</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form action="{{route('add_coupon')}}" class="col-sm-12" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="coupon_name">Coupon Name/ Product Name</label>
                        <input id="coupon_name" type="text" class="form-control" name="coupon_name" required>
                    </div>
                    <div class="form-group">
                        <label for="coupon_code">Coupon Code</label>
                        <input id="coupon_code" type="text" class="form-control" name="coupon_code" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount/ Quantity</label>
                        <input id="amount" type="number" class="form-control" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="amount_type">Amount Type</label>
                        <select name="amount_type" class="form-control" id="amount_type" required>
                            <option value="Percent">Percent</option>
                            <option value="Fixed">Fixed</option>
                            <option value="Free Product">Free Product</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="datepicker">Expiry Date</label>
                        <input id="datepicker" type="text" class="form-control" name="expiry_date" autocomplete="off" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Coupon</button>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card" id="view_product_table">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title"><input type="search" data-pass="search_filter" id="search-product-input" placeholder = "Search Your product Khoroch" style="width: 100%; border-radius: 30px; padding: 5px 20px; color: #000;"></h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Coupon Name</th>
                                <th>Coupon Code</th>
                                <th>Amount</th>
                                <th>Amount Type</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="search_filter">
                            <?php $coupons = DB::table('coupons')->orderBy('id', 'DESC')->get(); ?>
                            @if($coupons)
                            @foreach($coupons as $coupon)
                            <tr>
                                <td>{{$coupon->id}}</td>
                                <td>{{$coupon->coupon_name}}</td>
                                <td>{{$coupon->coupon_code}}</td>
                                <td>{{$coupon->amount}}</td>
                                <td>{{$coupon->amount_type}}</td>
                                <td>{{ date('d-m-Y', strtotime($coupon->created_at))}}</td>
                                <th><i coupon_id="{{$coupon->id}}" cat_table="coupons" class="coupon_hide_show fas @if($coupon->status==1) fa-toggle-on @else fa-toggle-off @endif" style="color: @if($coupon->status==1) blue @else #ed2024 @endif; font-size:30px; cursor:pointer"></i></th>\
                                <td>
                                    <a href="{{route('coupon_delete',$coupon->id)}}" style="background: #ed2024; color: #fff; padding: 5px 10px; text-decoration:none;">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection