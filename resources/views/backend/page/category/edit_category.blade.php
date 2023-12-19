@extends('backend.mastering.master')
@section('title')
<title>Edit Category - {{$settings->company_name}}</title>
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
            <form action="{{route('edit_category',$category->id)}}" class="col-sm-12" enctype="multipart/form-data" method="post">
                @csrf
                    <div class="form-group">
                        <label for="">Category Name</label>
                        <input type="text" class="form-control" value="{{$category->category_name}}" name="category_name" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Banner Image</label>
                        <input type="file" class="form-control" name="banner_image" id="image">
                        <img src="{{asset('frontend/img/category/'.$category->banner_image)}}" style="width: 200px; height: 200px;">
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