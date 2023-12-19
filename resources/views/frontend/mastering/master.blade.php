<!DOCTYPE html>
<html lang="en">
<!-- {{$settings->company_name}}  24 December 2021 09:54:18 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('title')
    <meta name="google-site-verification" content="ybPxoso3OP1UHdiCz1hEaoMryKHMY0GOzmwbVEFbF3A" />
    <meta name="google-site-verification" content="L-5ElrijFF2toltwBzetBPloY_SRhgkg6nvaMTxNUoI" />
    <meta name="keywords" content="nimnio, grocery, bhola, bhola sadar, bangladesh, nimnio online shop, nimnio online, shop">
    <meta name="author" content="Md. Nazrul Islam">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('image/single_logo.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('image/single_logo.png')}}">
    <link rel="shortcut icon" href="{{asset('image/single_logo.png')}}">
    <meta name="apple-mobile-web-app-title" content="{{$settings->company_name}}">
    <meta name="application-name" content="{{$settings->company_name}}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{asset('frontend/assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css')}}">
    <!-- Font Awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css" integrity="sha512-X/RSQYxFb/tvuz6aNRTfKXDnQzmnzoawgEQ4X8nZNftzs8KFFH23p/BA6D2k0QCM4R0sY1DEy9MIY9b3fwi+bg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- LightSlider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css" integrity="sha512-yJHCxhu8pTR7P2UgXFrHvLMniOAL5ET1f5Cj+/dzl+JIlGTh5Cz+IeklcXzMavKvXP8vXqKMQyZjscjf3ZDfGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.css" integrity="sha512-+1GzNJIJQ0SwHimHEEDQ0jbyQuglxEdmQmKsu8KI7QkMPAnyDrL9TAnVyLPEttcTxlnLVzaQgxv2FpLCLtli0A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/skins/skin-demo-4.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/demos/demo-4.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
    <style>

    </style>
</head>

<body>
    <input type="hidden" id="order_check_verify">
    <div class="page-wrapper">
        <header class="header header-intro-clearance header-4">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                        <a href="tel:01710621166"><i class="icon-phone"></i>Call: 01710621166</a>
                    </div><!-- End .header-left -->

                    <div class="header-right">

                        <ul class="top-menu">
                            <li>
                                <a></a>
                            </li>
                        </ul><!-- End .top-menu -->
                    </div><!-- End .header-right -->

                </div><!-- End .container -->
            </div><!-- End .header-top -->
            <div class="header-middle">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>

                        <a href="{{route('home')}}" class="main-logo">
                            <img src="{{asset('image/nimnio_logo.png')}}" alt="{{$settings->company_name}}" width="150" height="50">
                        </a>
                    </div><!-- End .header-left -->
                    <div class="header-center position-relative">
                        <!-- Start Personal search bar -->
                        <div class="right-side" style="width: 100%;">
                            <div class="d-flex">
                                <button type="submit" class="searchButton">
                                    <i class="fa fa-search"></i>
                                </button>
                                <span class="position-relative" style="width: 100%;">
                                    <input type="text" style="width: 100%;" class="bottom-menu search-bar main-search-bar" placeholder="Search for Product.........">
                                    <i class="search-result-close fa fa-close"></i>
                                </span>
                            </div>
                        </div>
                        <!-- End -->
                    </div>
                    <div class="header-right">
                        <!-- Pore addd korte hobe class .cartlist -->
                        <div class="dropdown cart-dropdown ">
                            <a style="cursor:pointer" class="dropdown-toggle" id="cart-icon" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <div class="icon">
                                    <i class="icon-shopping-cart"></i>
                                    <?php
                                    $session_id = Session::getId();
                                    if(Auth::check()){
                                        $cart_count = DB::table('carts')->where(['user_id'=>Auth::user()->id])->count();
                                        $cart_get = DB::table('carts')->where(['user_id'=>Auth::user()->id])->get();
                                        $cart_sum = DB::table('carts')->where(['user_id'=>Auth::user()->id])->sum('total_price');
                                    }else{
                                        $cart_count = DB::table('carts')->where(['session_id'=>$session_id])->count();
                                        $cart_get = DB::table('carts')->where(['session_id'=>$session_id])->get();
                                        $cart_sum = DB::table('carts')->where(['session_id'=>$session_id])->sum('total_price');
                                    }
                                ?>
                                    <span class="cart-count" id="small-cart-count">{{$cart_count}}</span>
                                </div>
                                <p>Cart</p>
                            </a>
                        </div><!-- End .cart-dropdown -->
                        <div class="dropdown cart-dropdown avatar">
                            @if(Auth::check())
                                <div class="icon position-relative" style="height: 100%">
                                    <img class="profile-image-change" style="cursor:pointer; width: 40px; height: 40px; border-radius: 50%;" src="{{asset('frontend/img/user/'.Auth::user()->image)}}" alt="{{Auth::user()->name}}">
                                    <div class="close-icon">
                                        <i class="fa fa-close" style="font-size: 30px;"></i>
                                    </div>
                                    <div class="profile-update position-absolute" style="overflow: hidden; padding: 10px 20px; z-index: 33333333333333;right: 0; top: calc(100% + 10px); box-shadow:inset 18px 8px 40px #ccc; width: 220px; background: #fff; border-radius: 20px;">
                                        <i class="fa-solid fa-image" style="margin-right: 10px;"></i>
                                        <form id="profile-picture-update-form">
                                            <label style="margin:0; display:flex; justify-content:center; align-items:center;  cursor:pointer; position: absolute; width: 100%; height: 100%; left: 5px; top:0;" for="profile-picture-update">Update Profile Picture</label>
                                            <input id="profile-picture-update" name="image" type="file" style="display:none">
                                        </form>
                                    </div>
                                </div>
                            @else
                            <a href="{{route('login')}}">
                                <div class="icon">
                                    <img style="cursor:pointer; width: 40px; height: 40px; border-radius: 50%;" src="{{asset('frontend/img/user/avatar.png')}}" alt="{{$settings->company_name}}">
                                </div>
                            </a>
                            @endif
                        </div><!-- End .compare-dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->
            <div class="header-bottom sticky-header">
                <div class="container">
                    <div class="header-left">
                        <div class="dropdown category-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Choose Product">
                                Choose Category <i class="icon-angle-down"></i>
                            </a>
                            <div class="dropdown-menu">
                                <nav class="side-nav">
                                    <ul class="menu-vertical sf-arrows">
                                        <?php $categories = DB::table('categories')->where('main_category_id','>',0)->orderBy('id', 'DESC')->get(); ?>
                                        @foreach($categories as $category)
                                        <?php $sub_category =  DB::table('categories')->where(['parent_id'=>$category->id])->count();?>
                                        @if($sub_category >0)
                                        <li><a href="{{route('frontend_sub_category_view',$category->slug)}}">{{$category->category_name}}</a></li>
                                        @endif
                                        @endforeach
                                    </ul><!-- End .menu-vertical -->
                                </nav><!-- End .side-nav -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .category-dropdown -->
                    </div><!-- End .header-left -->

                    <div class="header-center">
                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="menu-left">
                                    <a href="{{route('home')}}" class="main-active sf-with-l">Home</a>
                                </li>
                                <li class="menu-left">
                                    <a href="{{route('shop')}}" class="sf-with-l">Product</a>
                                </li>
                                <li class="menu-left">
                                    <a href="{{route('contact_us')}}" class="sf-with-l">Contact Us</a>
                                </li>
                                <li class="menu-left">
                                    <a href="{{route('about')}}" class="sf-with-l">About</a>
                                </li>
                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-center -->
                    <div class="header-right">
                        @if(Auth::check())
                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="menu-left">
                                    <a href="{{route('user_profile')}}" class="sf-with-l">Profile</a>
                                </li>
                                <li class="menu-left">
                                    <a href="{{route('orders_history')}}" class="sf-with-l">Order</a>
                                </li>
                                <li class="menu-left">
                                    <?php $msg_check_count = DB::table('livechat_messages')->where(['user_id'=>Auth::user()->id])->where(['msg_user_admin'=>'admin'])->where(['user_off'=>1])->orderBy('sl', 'DESC')->count(); ?>
                                    <a href="{{route('user_livechat',Auth::user()->id)}}" class="sf-with-l">Chat @if($msg_check_count != 0) ({{$msg_check_count}}) @endif</a>
                                </li>
                                <li class="menu-left">
                                    <a href="{{route('user_balance')}}" class="sf-with-l">Balance</a>
                                </li>
                                <li class="menu-left">
                                    <a href="{{route('change_password',Auth::user()->phone_no)}}" class="sf-with-l">Change Password</a>
                                </li>
                                <li class="menu-left">
                                    <a href="{{route('logout')}}" class="sf-with-l">Logout</a>
                                </li>
                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                        @else
                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="menu-left">
                                    <a href="{{route('login')}}" class="sf-with-l">Login</a>
                                </li>
                                <li class="menu-left">
                                    <a href="{{route('register')}}" class="sf-with-l">Register</a>
                                </li>
                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                        @endif
                    </div>
                </div><!-- End .container -->
            </div><!-- End .header-bottom -->
        </header><!-- End .header -->
        @yield('main_layouts')
        <footer class="footer">
	        <div class="footer-bottom">
	        	<div class="container">
	        		<p class="text-center">Copyright © 2021 {{$settings->company_name}} Store. All Rights Reserved.</p>
	        	</div><!-- End .container -->
	        </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->
    <!-- <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button> -->
    <!-- Footer Menu -->
    <div class="bottom-menu-bar" >
        <div class="mbl-menu-btm" id="all-menu-mbl" style="width: 100%;border-top: 1px solid #ccc; background: #fff;">
            <nav>
                <ul class="d-flex" style="display:">
                    <li style="width:20%; text-align:center; font-size:25px"><a href="{{ URL::previous() }}"><i class="fa-sharp fa-solid fa-arrow-left"></i></a></li>
                    <li class="mobile-menu-toggler" style="width:20%; text-align:center; font-size:25px"><a><i class="fa-solid fa-bars"></i></a></li>
                    <li style="width:20%; text-align:center; font-size:25px"><a href=""><i class="fa fa-home" aria-hidden="true"></i></a></li>
                    <li style="width:20%; text-align:center; font-size:25px" id="product-search-bar"><a style="cursor:pointer "><i class="fas fa-search"></i></a></li>
                    @if(Auth::user())
                    <li style="width:20%; text-align:center; font-size:25px"><a href="{{route('user_livechat',Auth::user()->id)}}">@if($msg_check_count != 0) <span style="position: absolute;color: white;font-size: 15px;margin-left: 4px;font-weight: 600;margin-top: 5px;"> {{$msg_check_count}} </span>@endif<i class="fa-solid fa-message"></i></a></li>
                    @else
                    <li style="width:20%; text-align:center; font-size:25px"><a href="{{route('login')}}"><i class="fa-solid fa-message"></i></a></li>
                    @endif
                </ul>
            </nav>
        </div>
        <div class="product-search-mbl" style="display:none" id="product-search-bar-bar">
            <div class="d-flex">
                <button type="submit" class="searchButton">
                    <i class="fa fa-search"></i>
                </button>
                <span class="position-relative" style="width: 100%;">
                    <input type="text" style="width: 100%;" class="bottom-menu search-bar main-search-bar" placeholder="Search for Product.........">
                    <i class="search-result-close fa fa-close"></i>
                </span>
            </div>
        </div>
    </div>
    <!-- Search Result -->
    <div class="header-search-item-show">
        <div class="search-result">
            <h6 class="text-center"><span id="search-name"></span> <strong id="search-value" style="color:#ed2024"></strong></h6>
            <!-- Product View -->
            <div class="container">
                <div class="cat-blocks-container w-100">
                    <div class="row w-100">
                    </div>
                </div>
            </div>
            <!-- End Product View -->
        </div>
    </div>

    <!-- Cart Sidebar add -->
    <div id="cart-sidebar">
        <div class="top-side" >
            <div class="close-cart">Close</div>
        </div>
        <div class="cart-item-all mb-1 mt-1 position-relative">
            <?php
            $session_id = Session::getId();
            $coupon_amount = Session::get('coupon_amount');
            if(Auth::check()){
                $cart_gets = DB::table('carts')->where(['user_id'=>Auth::user()->id])->get();
                $cart_count = $cart_gets->count();
                $cart_sum = DB::table('carts')->where(['user_id'=>Auth::user()->id])->sum('total_price');
            }else{
                $cart_gets = DB::table('carts')->where(['session_id'=>$session_id])->get();
                $cart_count = $cart_gets->count();
                $cart_sum = DB::table('carts')->where(['session_id'=>$session_id])->sum('total_price');
            }
            $minimum_amount = DB::table('setting')->first();
            ?>

            <div class="not-cart @if($cart_count == 0) d-flex @endif text-center"><h6>Your Cart is empty. Start Shopping</h6></div>

            <ul id="cart-all-item">
                @foreach($cart_gets as $cart)
                @if($cart->type == 'restaurant')
                <?php $product = DB::table('restaurant_products')->where(['id'=>$cart->product_id])->first();
                    $main_product = DB::table('products')->where(['id'=>$product->main_product_id])->first();
                ?>
                <li id="cart-item-{{$cart->id}}" type="restaurant" class="d-flex">
                    <div class="plus-minus-cart">
                        <i class="product-cart-page-plus fas fa-plus" cart_id="{{$cart->id}}"></i>
                        <span option="sidebar" class="cart-quantity product_qty_input-{{$cart->id}}">{{$cart->quantity}}</span>
                        @if($cart->quantity < 2)
                        <i class="fas fa-minus cart-sidebar" style="opacity:0.5" cart_id="{{$cart->id}}"></i>
                        @else
                        <i class="product-cart-page-minus fas fa-minus" cart_id="{{$cart->id}}"></i>
                        @endif
                    </div>
                    <div class="cart-image">
                        <img loading="lazy" src="{{asset('frontend/img/product/'.$main_product->image)}}" alt="{{$product->product_name}}">
                    </div>
                    <div class="text-and-price">
                        <div class="all-details">
                            <h6>{{$product->product_name}}</h6>
                            <div class="price-and-quantity">
                                <p>৳ {{$product->product_price}}/ {{$product->product_weight}}</p>
                            </div>
                            <div class="total-price">
                                <h5>৳ <span class="cart-price">{{$cart->total_price}}</span></h5>
                            </div>
                        </div>
                    </div>
                    <div class="delete-cart">
                        <i type="restaurant" cart_id ="{{$cart->id}}" class="cart-delete far fa-times-circle"></i>
                    </div>
                </li>
                @else
                <?php $product = DB::table('products')->where(['id'=>$cart->product_id])->first(); ?>
                <li id="cart-item-{{$cart->id}}" class="d-flex">
                    <div class="plus-minus-cart">
                        <i class="product-cart-page-plus fas fa-plus" cart_id="{{$cart->id}}"></i>
                        <span option="sidebar" class="cart-quantity product_qty_input-{{$cart->id}}">{{$cart->quantity}}</span>
                        @if($cart->quantity < 2)
                        <i class="fas fa-minus cart-sidebar" style="opacity:0.5" cart_id="{{$cart->id}}"></i>
                        @else
                        <i class="product-cart-page-minus fas fa-minus " cart_id="{{$cart->id}}"></i>
                        @endif
                    </div>
                    <div class="cart-image">
                        <img loading="lazy" src="{{asset('frontend/img/product/'.$product->image)}}" alt="{{$product->product_name}}">
                    </div>
                    <div class="text-and-price">
                        <div class="all-details">
                            <h6>{{$product->product_name}}</h6>
                            <div class="price-and-quantity">
                                <p>৳ {{$product->product_price}}/ {{$product->product_weight}}</p>
                            </div>
                            <div class="total-price">
                                <h5>৳ <span class="cart-price">{{$cart->total_price}}</span></h5>
                            </div>
                        </div>
                    </div>
                    <div class="delete-cart">
                        <i cart_id ="{{$cart->id}}" class="cart-delete far fa-times-circle"></i>
                    </div>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
        <div class="bottom-side position-relative">
            <p id="minimum-order-amount-div" style="position:absolute; bottom: 100%;  width: 100%; text-align:center; display:none;">Order amount at least ৳ {{$minimum_amount->minimum_amount_order}}</p>
            <div class="item-sub-total d-flex">
                <div class="cart-item">
                    <h3><span id="cart-count-all">{{$cart_count}}</span> @if($cart_count > 1)<span id="item_plural">Items</span>@else <span id="item_plural">Item</span> @endif</h3>
                </div>
                <div class="sub-total">
                    <h5>৳ <span id="cart-sub-total">{{$cart_sum}}</span></h5>
                </div>
            </div>
            <button id="main-place-order" class="position-relative">Place Order</button>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->
    <div class="mobile-menu-container mobile-menu-light">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>
            <ul class="nav nav-pills-mobile nav-border-anim" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="mobile-menu-link" data-toggle="tab" href="#mobile-menu-tab" role="tab" aria-controls="mobile-menu-tab" aria-selected="true">Menu & Category</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="mobile-menu-tab" role="tabpanel" aria-labelledby="mobile-menu-link">
                    <nav class="mobile-nav">
                        <ul class="mobile-menu">
                            <li class="active">
                                <a>Category</a>
                                <ul>
                                    <?php $categories = DB::table('categories')->where('main_category_id','>',0)->orderBy('id', 'DESC')->get(); ?>
                                    @foreach($categories as $category)
                                    <?php $sub_category =  DB::table('categories')->where(['parent_id'=>$category->id])->count();?>
                                    @if($sub_category >0)
                                    <li><a href="{{route('frontend_sub_category_view',$category->slug)}}">{{$category->category_name}}</a></li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a href="{{route('home')}}">Home</a>
                                @if(Auth::check())
                                <a href="{{route('orders_history')}}">Order</a>
                                <a href="{{route('user_balance')}}">Balance</a>
                                <a href="{{route('user_profile')}}">Profile</a>
                                <a href="{{route('change_password',Auth::user()->phone_no)}}">Change Password</a>
                                <a href="{{route('logout')}}">Logout</a>
                                @if(Auth::user()->role_as == 'Support' || Auth::user()->role_as == 'Admin')
                                <a href="{{route('admin_dashboard')}}">Admin Dashboard</a>
                                @endif
                                @else
                                <a href="{{route('login')}}">Login</a>
                                <a href="{{route('register')}}">Register</a>
                                @endif
                            </li>
                        </ul>
                    </nav><!-- End .mobile-nav -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
            <div class="social-icons">
                <a href="https://www.facebook.com/nimnioonlineshop" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->
    <!-- Plugins JS File -->
    <script src="{{asset('frontend/assets/js/jquery.min.js')}}"></script>
    <!-- Main JS File -->
    <script src="{{asset('frontend/assets/js/main.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{asset('frontend/script/auth_script.js')}}"></script>
    <script src="{{asset('frontend/script/custom.js')}}"></script>
    <script src="{{asset('frontend/script/search_script.js')}}"></script>
    <script src="{{asset('frontend/script/user_script.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js" integrity="sha512-9CWGXFSJ+/X0LWzSRCZFsOPhSfm6jbnL+Mpqo0o8Ke2SYr8rCTqb4/wGm+9n13HtDE1NQpAEOrMecDZw4FXQGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js" integrity="sha512-Gfrxsz93rxFuB7KSYlln3wFqBaXUc1jtt3dGCp+2jTb563qYvnUBM/GP2ZUtRC27STN/zUamFtVFAIsRFoT6/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js" integrity="sha512-Gfrxsz93rxFuB7KSYlln3wFqBaXUc1jtt3dGCp+2jTb563qYvnUBM/GP2ZUtRC27STN/zUamFtVFAIsRFoT6/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>
    <script>
        $(document).ready(function(){
            $("img").lazyload({
                load:function(){
                    $(this).parent().children(".lazy-loader").remove();
                },
            });
        })
    </script>
</body>

</html>
