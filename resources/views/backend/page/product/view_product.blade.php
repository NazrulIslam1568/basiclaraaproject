@extends('backend.mastering.master')
@section('title')
<title>View Product - {{$settings->company_name}}</title>
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
                            <th>Weight</th>
                            <th>Image</th>
                            <th>Edit</th>
                            <th>Offer</th>
                            <th>Visible</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="product_view_format">
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
        <!-- Edit Product  -->
        <div class="col-md-12 grid-margin stretch-card" id="edit_update_form" style="display:none">
        <div class="card">
            <div class="card-body">
            <h3 id="product_title" style="text-align:center"></h3>
            <form id="update-product-form" class="col-sm-12" enctype="multipart/form-data" method="post">
                    <input type="hidden" id="product_id" value="">
                    <div class="form-group">
                        <label >Product Name</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" required>
                    </div>
                    <div class="form-group">
                        <label for="">Product Weight</label>
                        <input type="text" class="form-control" id="product_weight_product" name="product_weight" required>
                    </div>
                    <div class="form-group">
                        <label>Product Description</label>
                        <textarea name="product_description"  cols="30" rows="5" id="product_description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Product Stock</label>
                        <input type="number" class="form-control" placeholder="Product Stock" name="stock" id="product_stock">
                    </div>
                    <div class="form-group">
                        <label for="">Product Price</label>
                        <input type="text" class="form-control" name="price" id="product_price" >
                    </div>
                    <div class="form-group">
                        <label for="">Old Price</label>
                        <input type="text" class="form-control" name="old_price" id="old_price">
                    </div>
                    <div class="form-group">
                        <label for="">Buy Price</label>
                        <input type="text" class="form-control" name="buy_price" id="buy_price" >
                    </div>
                    <div class="form-group" id="imge_append">
                        <label for="">Image</label>
                        <input id="image" type="file" class="form-control" name="image">
                        <img style="width: 100px; height: 100px;" id="image_src" src="" alt="image">
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
                    <button type="submit" class="btn btn-success">Update Product</button>
                    <a id="cancel_product_form" class="btn btn-danger">Cancel Product</a>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection