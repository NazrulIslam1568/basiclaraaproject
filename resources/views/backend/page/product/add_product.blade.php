
@extends('backend.mastering.master')
@section('title')
<title>Add Product - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Add Product </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Product</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Product</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <form id="add-product-form" class="col-sm-12" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <label for="">Category</label>
                        <select name="product_main_category" id="product_category" required class="form-control">
                            <option value="0">Select Parent Category</option>
                            <?php  $parent_categories = DB::table('add_categories')->get(); ?>
                            @foreach($parent_categories as $parent_category)
                            <option value="{{$parent_category->id}}">{{$parent_category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="sub_category_div" style="display:none">
                        <label for="">Sub Category</label>
                        <select name="sub_category" id="product_sub_category" class="form-control">
                        </select>
                    </div>
                    <div class="form-group" id="parent_category_div" style="display:none">
                        <label for="">Parent Category</label>
                        <select name="parent_category" id="product_parent_category" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Product Type</label>
                        <select name="type" id="" required class="form-control">
                            <option value="grocery">Grocery</option>
                            <option value="restaurant">Restaurant</option>
                            <option value="hotel">Hotel</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Product Name</label>
                        <input type="text" class="form-control" placeholder="Product Name" name="product_name" id="" required>
                    </div>
                    <div class="form-group">
                        <label for="">Product Weight</label>
                        <input type="text" class="form-control" placeholder="Product Weight" name="product_weight" id="" required>
                    </div>
                    <div class="form-group">
                        <label for="">Product Description</label>
                        <textarea name="product_description" id="" cols="30" rows="5" placeholder="Product Description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Product Stock</label>
                        <input type="number" class="form-control" placeholder="Product Stock" name="stock" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Product Price</label>
                        <input type="number" class="form-control" placeholder="Product Price" name="price" id="" required>
                    </div>
                    <div class="form-group">
                        <label for="">MRP </label>
                        <input type="number" class="form-control" placeholder="Old Price" name="old_price" id="">
                    </div>
                    <div class="form-group">
                        <label for="">Buy Price</label>
                        <input type="number" class="form-control" placeholder="Buy Price" name="buy_price" id="">
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image" required>
                    </div>
                    <div class="form-group">
                        <label for="">Brand</label>
                        <select name="brand" id="" required class="form-control">
                            <option value="0">Select Brand</option>
                            <?php  $brands = DB::table('add_brands')->get(); ?>
                            @foreach($brands as $brand)
                            <option value="{{$brand->name}}">{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Choice</label>
                        <select name="choice" id="" required class="form-control">
                            <option value="0">Select Choice</option>
                            <?php  $choices = DB::table('add_choices')->get(); ?>
                            @foreach($choices as $choice)
                            <option value="{{$choice->name}}">{{$choice->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Add Product</button>
                    <a href="{{route('view_product')}}" class="btn btn-primary">View Product</a>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection