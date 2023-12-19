@extends('backend.mastering.master')
@section('title')
<title>Add Phone Number - {{$settings->company_name}}</title>
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
                <form id="custom_no_add" class="col-sm-12" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="coupon_name">Add Number</label>
                        <input placeholder="Phone Number" id="coupon_name" type="number" class="form-control" name="phone_no" required>
                    </div>
                    <div class="form-group">
                        <label for="nim-division">Division</label>
                        <select name="division" id="nim-division" class="form-control">
                            <option value="0">Select Division</option>
                            <?php $divisions = DB::table('divisions')->get(); ?>
                            @foreach($divisions as $division)
                            <option value="{{$division->division_id}}">{{$division->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group add-address district">
                        <label for="">District</label>
                        <select class="form-control" id="nim-district" name="district_name">
                            <option value="0">Select District</option>
                        </select>
                    </div>
                    <div class="form-group add-address upazila">
                        <label for="">Upazila</label>
                        <select class="form-control" id="nim-upazila" name="upazila_name">
                            <option value="0">Select Upazila</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="coupon_code">Details</label>
                        <input placeholder="বিস্তারিত কোন তথ্য থাকলে লিখুন"  type="text" class="form-control" name="details">
                    </div>
                    <button type="submit" class="btn btn-success">Add Address</button>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card" id="view_product_table">
            <div class="card">
                <form action="{{route('send_sms_post')}}" method="post">
                    @csrf
                    <div>
                        <textarea class="col-md-12" name="send_sms" rows="4" cols="50" placeholder="Please type your message" required></textarea>
                        <button type="submit" class="col-md-12 btn btn-success">Send Message</button>
                    </div>
                        <!-- Start Flash Message -->
                    @if(Session::has('flash_message_error'))
                    <div class="alert alert-sm alert-danger alert-block" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true" style="color:#fff">&times;</span>
                        </button>
                        <strong>{!! session('flash_message_error') !!}</strong>
                    </div>
                    @endif
                    
                    @if(Session::has('flash_message_success'))
                    <div class="alert alert-sm alert-success alert-block" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{!! session('flash_message_success') !!}</strong>
                    </div>
                    @endif
                    <div class="card-body">
                        <h4 class="card-title"><input type="search" data-pass="search_filter" id="search-product-input" placeholder = "Search Phone Number" style="width: 100%; border-radius: 30px; padding: 5px 20px; color: #000;"></h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 120px;"><span id="all-check-msg" style="background: #ed2024; padding: 5px; color: #fff; font-weight: 400; cursor:pointer;">All Check</span></th>
                                        <th>ID</th>
                                        <th>Phone Number</th>
                                        <th>Division</th>
                                        <th>District</th>
                                        <th>Upazila</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody id="search_filter" class="custom-no-add-tr">
                                    <?php $custom_number = DB::table('custom_numbers')->get(); ?>
                                    @foreach($custom_number as $custom_numbers)
                                    <tr>
                                        <td><input type="checkbox" name="mobile[]" value="88{{$custom_numbers->phone_no}}" class="send-msg-check-uncheck"></td>
                                        <td>{{$custom_numbers->id}}</td>
                                        <td>{{$custom_numbers->phone_no}}</td>
                                        <td>{{$custom_numbers->division}}</td>
                                        <td>{{$custom_numbers->district_name}}</td>
                                        <td>{{$custom_numbers->upazila_name}}</td>
                                        <td>{{$custom_numbers->details}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection