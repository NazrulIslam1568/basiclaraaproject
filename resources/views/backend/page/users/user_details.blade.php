@extends('backend.mastering.master')
@section('title')
<title>User Details - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> View Users </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Users</li>
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
                                <tr>
                                    <td class="taskDesc">User Image</td>
                                    <td class="taskStatus"><img src="{{asset('/image/user/'.$user->image)}}" alt="{{$user->name}}" style="width: 150px; height: 150px;"></td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">User Name</td>
                                    <td class="taskStatus">{{$user->name}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">User Phone</td>
                                    <td class="taskStatus">{{$user->phone_no}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">User Address</td>
                                    <td class="taskStatus">{{$user->division}}, {{$user->district}}, {{$user->upazila}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">User Detail Address</td>
                                    <td class="taskStatus">{{$user->bazar_name}}, {{$user->elaka_name}}, {{$user->detail_address}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Cashback Balance</td>
                                    <td class="taskStatus">{{$user->cashback_balance}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Return Balance</td>
                                    <td class="taskStatus">{{$user->return_balance}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Register Balance</td>
                                    <td class="taskStatus">{{$user->register_balance}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="w-50">
                        <div class="panel panel-bd lobidrag">
                            <div class="panel-heading">
                                <div class="btn-group" id="buttonexport">
                                    <a href="#">
                                        <h4>Change User Role</h4>
                                    </a>
                                </div>
                            </div>
                        <div class="card-body">
                            <form action="{{route('update_role')}}" method="post" > @csrf
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <table style="width:100%">
                                    <tr>
                                        <td>
                                            <select name="user_role" id="order_status" class="form-control">
                                                <option value="Admin" @if($user->role_as=="Admin") selected @endif>Admin</option>
                                                <option value="Support" @if($user->role_as=="Support") selected @endif>Support</option>
                                                <option value="Customer" @if($user->role_as=="Customer") selected @endif>Customer</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="submit" class="btn btn-success" value="Update Role">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        </div>
                    </div>
                    <div class="w-50">
                        <div class="panel panel-bd lobidrag">
                            <div class="panel-heading">
                                <div class="btn-group" id="buttonexport">
                                    <a href="#">
                                        <h4>User Account Balance</h4>
                                    </a>
                                </div>
                            </div>
                        <div class="card-body">
                            <form action="{{route('update_balance')}}" method="post" > @csrf
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <table style="width:100%">
                                    <tr>
                                        <td>
                                            <label for="cashback_balance">Cashback Balance</label>
                                            <input name="cashback_balance" id="cashback_balance" type="number" >
                                        </td>
                                        <td>
                                            <label for="return_balance">Return Balance</label>
                                            <input name="return_balance" id="return_balance" type="number" >
                                        </td>
                                        <td>
                                            <label for="register_balance">Register Balance</label>
                                            <input name="register_balance" id="register_balance" type="number" >
                                        </td>
                                        <td>
                                            <input type="submit" class="btn btn-success" value="Update Balance">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        </div>
                    </div>
                    <div class="w-50">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="btn-group" id="buttonexport">
                                <a href="#">
                                    <h4>User Phone Verify</h4>
                                </a>
                            </div>
                        </div>
                    <div class="card-body">
                        <form action="{{route('user_phone_verify')}}" method="post" > @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <table style="width:100%">
                                <tr>
                                    <td>
                                    @if($user->phone_verify == 0)
                                    <input type="number" value="{{$user->security_code}}" disabled>
                                    @endif
                                    </td>
                                    <td>
                                        <select name="phone_verify" id="order_status" class="form-control">
                                            <option value="0" @if($user->phone_verify=="0") selected @endif>Not Verify</option>
                                            <option value="1" @if($user->phone_verify=="1") selected @endif>Verified</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" class="btn btn-success" value="Update Phone Verify">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    </div>
                </div>
                <div class="w-50">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="btn-group" id="buttonexport">
                                <a href="#">
                                    <h4>User Account Verify</h4>
                                </a>
                            </div>
                        </div>
                    <div class="card-body">
                        <form action="{{route('user_account_verify')}}" method="post" > @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <table style="width:100%">
                                <tr>
                                    <td>
                                        <select name="account_verify" id="order_status" class="form-control">
                                            <option value="0" @if($user->account_verify=="0") selected @endif>Not Verify</option>
                                            <option value="1" @if($user->account_verify=="1") selected @endif>Verified</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" class="btn btn-success" value="Update Account Verify">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
                <!-- End Table -->
            </div>
        </div>
    </div>
</div>
@endsection