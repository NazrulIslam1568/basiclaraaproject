@extends('frontend.mastering.master')
@section('title')
<title>{{$second_capital_product}} - {{$settings->company_name}}</title>
<meta name="description" content="Choose your {{$second_capital_product}} product. Order Now : 01710621166">
<meta property="og:description" content="Choose your {{$second_capital_product}} product. Order Now : 01710621166" />
<meta property="og:title" content="{{$second_capital_product}} || Nimnio.com"/>
<meta property="og:url" content="https://nimnio.com/category/{{$main_category_name}}/{{$category_name}}" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="en-us" />
<meta property="og:locale:alternate" content="en-us" />
<meta property="og:site_name" content="nimnio.com" />
<meta property="og:image" content="https://nimnio.com/frontend/img/category/{{$category_get->banner_image}}" />
<meta property="og:image:url" content="https://nimnio.com/frontend/img/category/{{$category_get->banner_image}}" />
<meta property="og:image:size" content="100" />
@endsection
@section('main_layouts')
<input type="hidden" id="category_name" value="{{$second_capital_product}}">
<main class="main category-product-page-load">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a >Category</a></li>
                <li class="breadcrumb-item"><a href="{{route('frontend_sub_category_view',$main_category_name)}}">{{$fist_capital_category}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$second_capital_product}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="container">
        <div class="top-side">
            <div class="left-side">
                <h2 class="title mb-4">{{$second_capital_product}} </h2><!-- End .title text-center -->
            </div>
            <div class="right-side">
                <div class="d-flex">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                    <input type="text" class="category_product_search" placeholder="Search your {{$second_capital_product}}">
                </div>
            </div>
        </div>
        <h6 id="search_span" style="margin-top: 10px; display:none; text-align:center; font-size: 15px">Search Result for : <strong style="color:#ed2024" id="search_result"></strong></h6>
        <div class="cat-blocks-container">
            <div class="row" id="category_product_view">
                <h4 class="no-product text-center mt-5 w-100 d-none">No Product View</h4>
             @include('frontend.partials.product.product')
            </div><!-- End .row -->
        </div><!-- End .cat-blocks-container -->
    </div><!-- End .container -->
</main><!-- End .main -->
@endsection