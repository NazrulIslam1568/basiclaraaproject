
@extends('backend.mastering.master')
@section('title')
<title>View Category - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> View Category </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Product</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Category</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <form id="add-product-form" class="col-sm-12" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <label for="product_category">Category</label>
                        <select name="product_main_category" id="product_category" required class="form-control">
                            <option value="0">Choose Main Category</option>
                            <?php  $parent_categories = DB::table('add_categories')->get(); ?>
                            @foreach($parent_categories as $parent_category)
                            <option value="{{$parent_category->id}}">{{$parent_category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="sub_category_div" style="display:none">
                        <label for="">Choose Sub Category</label>
                        <select name="sub_category" id="product_sub_category" class="form-control">
                        </select>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card" id="view_product_table" style="display:none">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title"><input type="search" data-pass="category_view_format" id="search-product-input" placeholder = "Search Your Category" style="width: 100%; border-radius: 30px; padding: 5px 20px; color: #000;"></h4>
                <!-- <p class="card-description"> Add class <code>.table</code>
                </p> -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Category Image</th>
                                <th>Status</th>
                                <th>Popular</th>
                                <th>Daily</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="category_view_format">
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
    <br>
        <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>    <br>
    <h3> Main & Parent Category</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Category Image</th>
                    <th>Status</th>
                    <th>Popular</th>
                    <th>Daily</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $main_category = DB::table('categories')->where('main_category_id','>',0)->get(); ?>
                @foreach($main_category as $main)
                <tr>
                    <td>{{$main->id}}</td>
                    <td>{{$main->category_name}}</td>
                    <td><img src="{{asset('frontend/img/category/'.$main->banner_image)}}" style="width: 100px; height: 100px;"></td>
                    <th><i cat_id="{{$main->id}}" cat_table="status" class="category_hide_show fas @if($main->status == 1) fa-toggle-on @else fa-toggle-off @endif" style="color: @if($main->status == 1) blue @else #ed2024 @endif; font-size:30px; cursor:pointer"></i></th>
                        <th><i cat_id="{{$main->id}}" cat_table="popular" class="category_hide_show fas @if($main->popular == 1) fa-toggle-on @else fa-toggle-off @endif" style="color: @if($main->popular == 1) blue @else #ed2024 @endif; font-size:30px; cursor:pointer"></i></th>
                        <th><i cat_id="{{$main->id}}" cat_table="daily" class="category_hide_show fas @if($main->daily == 1) fa-toggle-on @else fa-toggle-off @endif" style="color: @if($main->daily == 1) blue @else #ed2024 @endif; font-size:30px; cursor:pointer"></i></th>
                        <th>
                            <a href="https://nimnio.com/admin/edit-category/{{$main->id}}" style="margin:2px;" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                            <a href="https://nimnio.com/admin/delete-category/{{$main->id}}" style="margin:2px;" type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection