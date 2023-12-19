@extends('backend.mastering.master')
@section('title')
<title>Editable Product - {{$settings->company_name}}</title>
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
            <div class="card-body">
            <h4 class="card-title"><input type="search" data-pass="product_view_format" id="search-product-input" placeholder = "Search Your Product" style="width: 100%; border-radius: 30px; padding: 5px 20px; color: #000;"></h4>
            <!-- <p class="card-description"> Add class <code>.table</code>
            </p> -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $products = DB::table('products')->where(['edit'=>1])->get(); ?>
                        @foreach($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->product_code}}</td>
                            <td>{{$product->product_name}}</td>
                            <td>{{$product->product_price}}</td>
                            <td><img src="{{asset('/frontend/img/product/'.$product->image)}}" style="width: 100px; height: 100px;"></td>
                        </tr>
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