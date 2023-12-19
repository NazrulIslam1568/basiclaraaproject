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
            <li class="breadcrumb-item"><a href="#">Restaurant Product</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Restaurant Product</li>
        </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row" id="sub_category_view">
                    <h4 class="no-product text-center mt-5 w-100 d-none">No Category View</h4>
                    @foreach($restaurants as $restaurant)
                    <div class="col-6 col-sm-4 col-lg-2 text-center">
                        <a href="{{route('restaurant_all_item',$restaurant->id)}}" class="cat-block">
                            <figure>
                                <img src="{{asset('frontend/img/restaurant/'.$restaurant->image)}}" style="width:150px;" alt="{{$restaurant->name}}">
                            </figure>
                        </a>
                    </div><!-- End .col-sm-4 col-lg-2 -->
                    @endforeach
                </div><!-- End .row -->
            </div>
        </div>
        </div>
    </div>
</div>
@endsection