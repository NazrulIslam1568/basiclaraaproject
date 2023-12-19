@extends('frontend.mastering.master')
@section('title')
<title>{{$restaurant}} Restaurant - {{$settings->company_name}}</title>
<meta name="description" content="Choose your Restaurant. Order Now : 01710621166">
<meta property="og:description" content="Choose your Restaurant. Order Now : 01710621166" />
<meta property="og:title" content="Restaurant || Nimnio.com" />
<meta property="og:url" content="https://nimnio.com/restaurants" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="en-us" />
<meta property="og:locale:alternate" content="en-us" />
<meta property="og:site_name" content="nimnio.com" />
<meta property="og:image" content="https://nimnio.com/frontend/img/category/Restaurant.webp" />
<meta property="og:image:url" content="https://nimnio.com/frontend/img/category/Restaurant.webp" />
<meta property="og:image:size" content="300" />
@endsection
@section('main_layouts')  
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('all_restaurants')}}">Restaurant</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$restaurant}}  Restaurant</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="container">
        <div class="top-side">
            <div class="left-side">
                <h2 class="title mb-4">{{$restaurant}}  Restaurant</h2><!-- End .title text-center -->
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
                <!-- Soft Drinks start -->
                <?php $soft_drinks = DB::table('categories')->where(['slug'=>'soft-drinks'])->first();
                $main_cagegory = DB::table('categories')->where(['id'=>$soft_drinks->parent_id])->first(); ?>
                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="{{route('category_product_view',[$main_cagegory->slug,$soft_drinks->slug])}}" class="cat-block">
                        <figure>
                            <div style="background: #d7d7d7;" class="lazy-loader">
                                <img style="opacity:0.1; width: 80%" src="https://nimnio.com/image/nimnio_logo.png">
                            </div>
                            <img data-original="{{asset('frontend/img/category/'.$soft_drinks->banner_image)}}" alt="{{$soft_drinks->category_name}}">
                        </figure>
                        <h3 class="cat-block-title">{{$soft_drinks->category_name}}</h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-sm-4 col-lg-2 -->
                <!-- Soft Drinks div end -->
                @foreach($restaurant_category as $restaurant_cat)
                <?php 
                    $cat_image = DB::table('restaurant_products')->where(['restaurant_id'=>$restaurant_id->id])->where(['category_id'=>$restaurant_cat->id])->count();
                    if($cat_image > 0){
                        $category_first = DB::table('restaurant_products')->where(['restaurant_id'=>$restaurant_id->id])->where(['category_id'=>$restaurant_cat->id])->first();
                        $product_image = DB::table('products')->where(['id'=>$category_first->main_product_id])->first();
                    }
                ?>
                @if($cat_image > 0)
                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="{{route('restaurant_user_product',[$divisions->name,$districts->name,$upazilas->name,$restaurant_id->name,$restaurant_cat->category_name])}}" class="cat-block">
                        <figure>
                            <div style="background: #d7d7d7;" class="lazy-loader">
                                <img style="opacity:0.1; width: 80%" src="https://nimnio.com/image/nimnio_logo.png">
                            </div>
                            <img data-original="{{asset('frontend/img/product/'.$product_image->image)}}" alt="{{$restaurant_cat->category_name}}">
                        </figure>
                        <h3 class="cat-block-title">{{$restaurant_cat->category_name}}</h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-sm-4 col-lg-2 -->
                @endif
                @endforeach
            </div><!-- End .row -->
        </div><!-- End .cat-blocks-container -->
    </div><!-- End .container -->
</main><!-- End .main -->
@endsection