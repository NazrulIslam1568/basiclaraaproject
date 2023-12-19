@extends('frontend.mastering.master')
@section('title')
<title>{{$category_first->category_name}} - {{$settings->company_name}}</title>
<meta name="description" content="Choose your {{$category_first->category_name}} product. Order Now : 01710621166">
<meta property="og:description" content="Choose your {{$category_first->category_name}} product. Order Now : 01710621166" />
<meta property="og:title" content="{{$category_first->category_name}} || Nimnio.com" />
<meta property="og:url" content="https://nimnio.com/category/{{$category_first->slug}}" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="en-us" />
<meta property="og:locale:alternate" content="en-us" />
<meta property="og:site_name" content="nimnio.com" />
<meta property="og:image" content="https://nimnio.com/frontend/img/category/{{$category_first->banner_image}}" />
<meta property="og:image:url" content="https://nimnio.com/frontend/img/category/{{$category_first->banner_image}}" />
<meta property="og:image:size" content="300" />
@endsection
@section('main_layouts')  
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$category_first->category_name}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="container">
        <div class="top-side">
            <div class="left-side">
                <h2 class="title mb-4">{{$category_first->category_name}}</h2><!-- End .title text-center -->
            </div>
            <div class="right-side">
                <div class="d-flex">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                    <input type="text" class="sub_category_search search-bar" placeholder="Search for Category...........">
                </div>
            </div>
        </div>
        <h6 id="search_span" style="display:none; margin-top: 10px; text-align:center; font-size: 15px">Search Result for : <strong style="color:#ed2024" id="search_result"></strong></h6>
        <div class="cat-blocks-container" >
            <div class="row" id="sub_category_view">
                <h4 class="no-product text-center mt-5 w-100 d-none">No Category View</h4>
                @foreach($categories as $category)
                <?php
                    $categoryparent_id = DB::table('categories')->where(['parent_id'=>$category->parent_id])->first();
                    $main_cagegory = DB::table('categories')->where(['id'=>$categoryparent_id->parent_id])->first();
                ?>
                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="{{route('category_product_view',[$main_cagegory->slug,$category->slug])}}" class="cat-block">
                        <figure>
                            <div style="background: #d7d7d7;" class="lazy-loader">
                                <img src="{{asset('image/logo product.webp')}}">
                            </div>
                            <img data-original="{{asset('frontend/img/category/'.$category->banner_image)}}" alt="{{$category->name}}">
                        </figure>
                        <h3 class="cat-block-title">{{$category->category_name}}</h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-sm-4 col-lg-2 -->
                @endforeach
            </div><!-- End .row -->
        </div><!-- End .cat-blocks-container -->
    </div><!-- End .container -->
</main><!-- End .main -->
@endsection