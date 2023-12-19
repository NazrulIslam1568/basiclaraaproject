
@extends('backend.mastering.master')
@section('title')
<title>Add Banner - {{$settings->company_name}}</title>
@endsection
@section('main_layouts')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Add Banner </h3>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Banner</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Banner</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="col-sm-12" enctype="multipart/form-data" action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="slider_name">Slider Name</label>
                        <input type="name" class="form-control" placeholder="Enter Slider Name" name="slider_name" id="slider_name" required>
                    </div>
                    <div class="form-group">
                        <label for="url">Image URL</label>
                        <input type="url" class="form-control" name="url" placeholder="Add Image URL">
                    </div>
                    <div class="form-group">
                        <label for="image">Slider Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <input type="submit" class="btn btn-success" Value="Add Slide">
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection