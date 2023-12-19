@extends('frontend.mastering.master')
@section('title')
<title>{{$brand_first->name}} - {{$settings->company_name}}</title>
<meta name="description" content="Nimnio Online Shop">
@endsection
@section('main_layouts')  

<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Shop</a></li>
                <li class="breadcrumb-item"><a href="{{route('shop')}}">Oil</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$brand_first->name}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="container">
        <div class="top-side">
            <div class="left-side">
                <h2 class="title mb-4">{{$brand_first->name}}</h2><!-- End .title text-center -->
            </div>
            <div class="right-side">
                <div class="d-flex">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                    <input type="text" class="category_product_search" placeholder="Search your {{$brand_first->name}}">
                </div>
            </div>
        </div>
        
        <div class="cat-blocks-container" id="category_product_view">
            <div class="row">
                @include('frontend.partials.product.product')
            </div><!-- End .row -->
        </div><!-- End .cat-blocks-container -->
    </div><!-- End .container -->
</main><!-- End .main -->
@endsection