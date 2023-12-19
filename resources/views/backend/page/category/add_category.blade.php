@extends('backend.mastering.master')
@section('title')
<title>Add Category - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Add Product </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Category</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Category</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <form id="add-category-form" class="col-sm-12" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <input type="hidden" value="{{$main_category_id}}" name="main_category_id">
                        <label for="">Parent Category</label>
                        <select name="parent_id" required class="form-control">
                            <option value="0">Select Parent Category</option>
                            <?php  $parent_categories = DB::table('categories')->where(['main_category_id'=>$main_category_id])->get(); ?>
                            @foreach($parent_categories as $parent_category)
                            <option value="{{$parent_category->id}}">{{$parent_category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Category Name</label>
                        <input type="text" class="form-control" placeholder="Category Name" name="category_name" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Banner Image</label>
                        <input type="file" class="form-control" name="banner_image" id="image">
                    </div>
                    <div class="form-group">
                        <label for="image">Icon Image</label>
                        <input type="file" class="form-control" name="icon_image" id="image">
                    </div>
                    <button type="submit" class="btn btn-success">Add Category</button>
                    <a href="" class="btn btn-primary">View Category</a>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection