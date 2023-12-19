@extends('backend.mastering.master')
@section('title')
<title>Update Product Price - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> View Products </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Product</a></li>
            <li id="main_title_product" class="breadcrumb-item active" aria-current="page">View Product</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card" id="view_product_table">
        <div class="card">
            <div class="card-body" style="padding:0;">
            <h4 class="card-title"><input type="search" data-pass="search-to-get" id="search-result-input" placeholder = "Search Your Product" style="width: 100%; border-radius: 30px; padding: 5px 20px; color: #000;"></h4>
            <!-- <p class="card-description"> Add class <code>.table</code>
            </p> -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Weight</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody id="search-to-get">
                        <?php $products = DB::table('products')->where(['edit'=>1])->get(); ?>
                        @foreach($products as $product)
                        <?php $current_date = date('Y-m-d'); ?>
                        @if($current_date !== date('Y-m-d', strtotime($product->updated_at)))
                        <tr id="product-item-{{$product->id}}">
                            <td><input type="number" id="product-price-edit-{{$product->id}}" style="width:35px" value="{{$product->product_price}}" disabled> <span class="product-edit-price" product_id="{{$product->id}}" style="background: #ed2024; padding: 5px; color: #fff; font-weight: 400; cursor:pointer;">Edit</span></td>
                            <td><img style="width:50px; height: 50px;" src="{{asset('frontend/img/product/'.$product->image)}}"></td>
                            <td>{{$product->product_weight}}</td>
                            @if($product->visible ==1)
                            <td><i cat_id="{{$product->id}}" field_name="visible" db_name="products" class="all_hide_show fas fa-toggle-on" style="color: blue; font-size:30px; cursor:pointer"></i></td>
                            @else
                            <td><i cat_id="{{$product->id}}" field_name="visible" db_name="products" class="all_hide_show fas fa-toggle-off" style="color: red; font-size:30px; cursor:pointer"></i></td>
                            @endif
                            <td>{{$product->product_name}}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection