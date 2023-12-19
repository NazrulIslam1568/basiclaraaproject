
@extends('backend.mastering.master')
@section('title')
<title>Main Category - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Main Category </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Category</a></li>
            <li class="breadcrumb-item active" aria-current="page">Main</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <form action="{{route('main_category')}}" class="col-sm-12" enctype="multipart/form-data" method="post">
                @csrf
                    <div class="form-group">
                        <label for="">Category Name</label>
                        <input type="text" class="form-control" placeholder="Category Name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <button type="submit" class="btn btn-success">Add Main Category</button>
                    <a href="" class="btn btn-primary">View Category</a>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection