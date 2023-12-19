@extends('backend.mastering.master')
@section('title')
<title>Unverify Account - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <form action="{{route('send_sms_post')}}" method="post">
        @csrf
        <div class="page-header">
            <h3 class="page-title">Send Message</h3>
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Orders</a></li>
                <li class="text-center breadcrumb-item active" aria-current="page">All User Send SMS</li>
            </ol>
            </nav>
        </div>
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
        <h4 class="card-title"><input type="search" data-pass="search-to-get" id="search-result-input" placeholder = "Search Your Customer" style="width: 100%; border-radius: 30px; padding: 5px 20px; color: #000;"></h4>
        <!-- end Flash Message  -->
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card" id="view_Orders_table">
                <div class="card">
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 120px;">Check <span id="all-check-msg" style="background: #ed2024; padding: 5px; color: #fff; font-weight: 400; cursor:pointer;">All Check</span></th>
                                    <th>Name</th>
                                    <th>Phone No</th>
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Upazila</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody id="search-to-get">
                                <?php $users = DB::table('users')->where(['role_as'=>'Customer'])->where(['phone_verify'=>0])->get() ?>
                                @foreach($users as $user)
                                <tr>
                                    <td><input type="checkbox" name="mobile[]" value="88{{$user->phone_no}}" class="send-msg-check-uncheck"></td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->phone_no}}</td>
                                    <td>{{$user->division}}</td>
                                    <td>{{$user->district}}</td>
                                    <td>{{$user->upazila}}</td>
                                    <td>{{$user->bazar_name}}, {{$user->elaka_name}}, {{$user->detail_address}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection