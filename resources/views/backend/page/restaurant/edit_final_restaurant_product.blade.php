@extends('backend.mastering.master')
@section('title')
<title>Edit Restaurant Product - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Edit Restaurant Product </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Restaurant Product</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Restaurant Product</li>
        </ol>
        </nav>
    </div>
    <h1 class="text-center"> {{$restaurant_product->product_name}} </h1>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <form action="{{route('edit_restaurant_product_post',$restaurant_product->id)}}" class="col-sm-12" enctype="multipart/form-data" method="post">
                @csrf
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" placeholder="Product Name" name="product_name" id="product_name" value="{{$restaurant_product->product_name}}" required>
                    </div>
                    <div class="form-group">
                        <label for="">Product Weight</label>
                        <input type="text" class="form-control" placeholder="Product Weight" name="product_weight" value="{{$restaurant_product->product_weight}}" required>
                    </div>
                    <div class="form-group">
                        <label for="">Product Price</label>
                        <input type="number" class="form-control" placeholder="Product Price" name="price" value="{{$restaurant_product->product_price}}" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update Product</button>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection