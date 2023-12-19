@extends('backend.mastering.master')
@section('title')
<title>Add Restaurant Product - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Add Restaurant Product </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('restaurant_all_item',$restaurant->id)}}">{{$restaurant->name}} Restaurant</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Restaurant Product</li>
        </ol>
        </nav>
    </div>
    <h1 class="text-center"> {{$restaurant->name}} || {{$category->category_name}}</h1>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row" id="sub_category_view">
                    <h4 class="no-product text-center mt-5 w-100 d-none">No Category View</h4>
                    @foreach($products as $product)
                    <?php $res_product = DB::table('restaurant_products')->where(['restaurant_id'=>$restaurant->id])->where(['main_product_id'=>$product->id])->count(); ?>
                    @if($res_product < 1)
                    <div class="col-6 col-sm-4 col-lg-2 text-center restaurant-product-click" style="cursor:pointer" prod_id="{{$product->id}}">
                        <span class="cat-block">
                            <figure>
                                <img src="{{asset('frontend/img/product/'.$product->image)}}" style="width:150px;" alt="{{$product->name}}">
                            </figure>
                            <h4 class="product-name {{$product->id}}">{{$product->product_name}}</h4>
                        </span>
                    </div><!-- End .col-sm-4 col-lg-2 -->
                    @endif
                    @endforeach
                </div><!-- End .row -->
            <form action="{{route('add_restaurant_product_post',[$restaurant->id,$category->id])}}" class="col-sm-12" enctype="multipart/form-data" method="post">
                @csrf
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" placeholder="Product Name" name="product_name" id="product_name" required>
                        <input type="hidden" name="main_product_id" id="main_product_id" required>
                    </div>
                    <div class="form-group">
                        <label for="">Product Weight</label>
                        <input type="text" class="form-control" placeholder="Product Weight" name="product_weight" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Product Price</label>
                        <input type="number" class="form-control" placeholder="Product Price" name="price" id="" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Product</button>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Visible</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $products = DB::table('restaurant_products')->where(['restaurant_id'=>$restaurant->id])->where(['category_id'=>$category->id])->get(); ?>
                            @foreach($products as $product)
                            <?php $products_first = DB::table('products')->where(['id'=>$product->main_product_id])->first(); ?>
                            <tr>
                                <td>{{$product->id}}</td>
                                <td class="product-name {{$products_first->id}}">{{$product->product_name}}</td>
                                <td>{{$product->product_price}}</td>
                                <td><i cat_id="{{$product->id}}" field_name="status" db_name="restaurant_products" class="all_hide_show fas @if($product->status == 1) fa-toggle-on @else fa-toggle-off @endif " style="color: @if($product->status == 1) blue @else #ed2024 @endif; font-size:30px; cursor:pointer"></i></td>
                                <td><img class="restaurant-product-click" src="{{asset('frontend/img/product/'.$products_first->image)}}" prod_id="{{$products_first->id}}" style="cursor: pointer; width: 200px; height: 150px;"></td>
                                <td>
                                    <a href="{{route('edit_restaurant_product',$product->id)}}" style="margin:2px;" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                </td>
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