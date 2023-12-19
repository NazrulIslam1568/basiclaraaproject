@extends('frontend.mastering.master')
@section('title')
<title>Restaurant - {{$settings->company_name}}</title>
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
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="container">
        <div class="top-side">
            <div class="left-side">
                <h2 class="title mb-4">Restaurants</h2><!-- End .title text-center -->
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
                @foreach($restaurants as $restaurant)
                <?php
                $division = DB::table('divisions')->where(['id'=>$restaurant->division_id])->first();
                $district = DB::table('districts')->where(['id'=>$restaurant->district_id])->first();
                $upazila = DB::table('upazilas')->where(['id'=>$restaurant->upazila_id])->first();
                 ?>
                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="{{route('restaurants_category',[$division->name,$district->name,$upazila->name,$restaurant->name])}}" class="cat-block">
                        <figure>
                            <div style="background: #d7d7d7;" class="lazy-loader">
                                <img style="opacity:0.1; width: 80%" src="https://nimnio.com/image/nimnio_logo.png">
                            </div>
                            <img data-original="{{asset('frontend/img/restaurant/'.$restaurant->image)}}" alt="{{$restaurant->name}}">
                        </figure>
                        <h3 class="cat-block-title">{{$restaurant->name}}</h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-sm-4 col-lg-2 -->
                @endforeach
            </div><!-- End .row -->
        </div><!-- End .cat-blocks-container -->
    </div><!-- End .container -->
</main><!-- End .main -->
@endsection