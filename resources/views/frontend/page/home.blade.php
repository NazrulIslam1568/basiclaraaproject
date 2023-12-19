@extends('frontend.mastering.master')
@section('title')
<title>{{$settings->company_name}}</title>
<meta name="description" content="nimnio.com is Bangladeshi online grocery shop, founded in 2021. From here you can easily order all your daily necessities in free delivery. Phone : 01710-621166, Email: support@nimnio.com.">
<meta property="og:description" content="nimnio.com is Bangladeshi online grocery shop, founded in 2021. From here you can easily order all your daily necessities in free delivery. Phone : 01710-621166, Email: support@nimnio.com." />
<meta property="og:title" content="Nimnio Online Shop" />
<meta property="og:url" content="https://nimnio.com/" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="en-us" />
<meta property="og:locale:alternate" content="en-us" />
<meta property="og:site_name" content="nimnio.com" />
<meta property="og:image" content="https://nimnio.com/image/nimnio_logo.png" />
<meta property="og:image:url" content="https://nimnio.com/image/nimnio_logo.png" />
<meta property="og:image:size" content="300" />
@endsection
@section('main_layouts')
<main class="main">
    <div class="container">
        <?php $sliders = DB::table('sliders')->get(); ?>
        <div class="popular-category carousel home">
            <ul class="home-slider">
                @foreach($sliders as $banner)
                @if($banner->image_url)
                <li>
                    <a target="_blank" rel="noreferrer" style="width:100%" href="{{$banner->image_url}}">
                        <img class="d-block w-100" src="{{asset('/image/banner/'.$banner->image)}}" alt="nimnio">
                    </a>
                </li>
                @else
                <li>
                    <a rel="noreferrer" style="width:100%">
                        <img class="d-block w-100" src="{{asset('/image/banner/'.$banner->image)}}" alt="nimnio">
                    </a>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
        <!-- Restaurant Product -->
        <div class="popular-category carousel home">
            <h2 class="title text-center">Restaurant</h2>
            <ul class="restaurant-slider">
                <?php $restaurants = DB::table('add_restaurants')->get(); ?>
                @foreach($restaurants as $restaurant)
                <li>
                    <?php
                    $division = DB::table('divisions')->where(['id'=>$restaurant->division_id])->first();
                    $district = DB::table('districts')->where(['id'=>$restaurant->district_id])->first();
                    $upazila = DB::table('upazilas')->where(['id'=>$restaurant->upazila_id])->first();
                    ?>
                    <div class="">
                        <a href="{{route('restaurants_category',[$division->name,$district->name,$upazila->name,$restaurant->name])}}" class="cat-block">
                            <figure>
                                <div style="background: #d7d7d7" class="lazy-loader">
                                    <img style="opacity:0.1; width: 80%" src="https://nimnio.com/image/nimnio_logo.png">
                                </div>
                                <img data-original="{{asset('frontend/img/restaurant/'.$restaurant->image)}}" alt="{{$restaurant->name}}">
                            </figure>
                            <h3 class="cat-block-title">{{$restaurant->name}}</h3><!-- End .cat-block-title -->
                        </a>
                    </div><!-- End .col-sm-4 col-lg-2 -->
                </li>
                @endforeach
            </ul>
        </div>
        <!-- Product Categories -->
        <div class="popular-category carousel home">
            <h2 class="title text-center">Product Categories</h2>
            <?php $categories = DB::table('categories')->where('main_category_id','>',0)->orderBy('category_name', 'ASC')->where(['status'=>1])->get(); ?>
            <div class="row">
            @foreach($categories as $category)
            <?php $category_check =  DB::table('categories')->where(['parent_id'=>$category->id])->count(); ?>
            @if($category_check > 0)
            <div class="col-6 col-sm-4 col-lg-2">
                <a href="{{route('frontend_sub_category_view',$category->slug)}}" class="cat-block">
                    <figure>
                        <div style="background: #d7d7d7" class="lazy-loader">
                            <img style="opacity:0.1; width: 80%" src="https://nimnio.com/image/nimnio_logo.png">
                        </div>
                        <img data-original="{{asset('frontend/img/category/'.$category->banner_image)}}" alt="{{$category->category_name}}">
                    </figure>
                    <h3 class="cat-block-title">{{$category->category_name}}</h3><!-- End .cat-block-title -->
                </a>
            </div><!-- End .col-sm-4 col-lg-2 -->
            @endif
            @endforeach
            </div>
        </div>
        <!-- All Category Detail Show -->
        <!-- Restaurant Product -->
        @foreach($categories as $category)
        <div class="popular-category sub-category carousel home">
            <h2 class="title">{{$category->category_name}}</h2>
            <ul class="sub-category-slider">
                <?php $sub_categories = DB::table('categories')->where(['parent_id'=>$category->id])->get(); ?>
                @foreach($sub_categories as $sub_category)
                <?php
                    $categoryparent_id = DB::table('categories')->where(['parent_id'=>$sub_category->parent_id])->first();
                    $main_cagegory = DB::table('categories')->where(['id'=>$categoryparent_id->parent_id])->first();
                ?>
                <li>
                    <div class="">
                        <a href="{{route('category_product_view',[$main_cagegory->slug,$sub_category->slug])}}" class="cat-block">
                            <figure>
                                <!-- <div style="background: #d7d7d7" class="lazy-loader">
                                    <img style="opacity:0.1; width: 80%" src="https://nimnio.com/image/nimnio_logo.png">
                                </div> -->
                                <img src="{{asset('frontend/img/category/'.$sub_category->banner_image)}}" alt="{{$sub_category->category_name}}">
                            </figure>
                            <h3 class="cat-block-title">{{$sub_category->category_name}}</h3><!-- End .cat-block-title -->
                        </a>
                    </div><!-- End .col-sm-4 col-lg-2 -->
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div><!-- End .container -->
</main><!-- End .main -->
@endsection