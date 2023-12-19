<ul class="nav">
    <li class="nav-item profile">
    <div class="profile-desc">
        <div class="profile-pic">
        <div class="count-indicator">
            <?php $user_image = Auth::user()->image;
            $user_name = Auth::user()->name; 
            $user_role = Auth::user()->role_as; ?>
            <img class="img-xs rounded-circle" src="{{asset('frontend/img/user/'.$user_image)}}" alt="{{$user_name}}">
            <span class="count bg-success"></span>
        </div>
        <div class="profile-name">
            <h5 class="mb-0 font-weight-normal">{{$user_name}}</h5>
            <span>{{$user_role}}</span>
        </div>
        </div>
        <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
        <a href="#" class="dropdown-item preview-item">
            <div class="preview-thumbnail">
            <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-settings text-primary"></i>
            </div>
            </div>
            <div class="preview-item-content">
            <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
            </div>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item preview-item">
            <div class="preview-thumbnail">
            <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-onepassword  text-info"></i>
            </div>
            </div>
            <div class="preview-item-content">
            <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
            </div>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item preview-item">
            <div class="preview-thumbnail">
            <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-calendar-today text-success"></i>
            </div>
            </div>
            <div class="preview-item-content">
            <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
            </div>
        </a>
        </div>
    </div>
    </li>
    <li class="nav-item nav-category">
    <span class="nav-link">Navigation</span>
    </li>
    <!-- Dashboard Page -->
    @if(Auth::user()->role_as == 'Admin' && Auth::user()->name == 'Rimu Islam')
    <li class="nav-item menu-items">
        <a class="nav-link" href="{{route('admin_dashboard')}}">
            <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
            </span>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>
    <!-- Add Product Route -->
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#add_product" aria-expanded="false" aria-controls="add_product">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Product</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="add_product">
            <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('add_product')}}">Add Product</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('view_product')}}">View Products</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('visible_product')}}">Unvisible Products</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('offer_product')}}">Offer Products</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('editable_product')}}">Editable Products</a></li>
            </ul>
        </div>
    </li>
    <!--Restaurant System Add-->
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#add_restaurant" aria-expanded="false" aria-controls="add_restaurant">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Restaurant</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="add_restaurant">
            <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('add_restaurants')}}">Add Restaurant</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('add_restaurant_product')}}">Add Product</a></li>
            </ul>
        </div>
    </li>
    <!-- Add Product Route -->
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#add_category" aria-expanded="false" aria-controls="add_category">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Add Category</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="add_category">
            <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('main_category')}}">Add Main Category</a></li>
            <?php $main_categories = DB::table('add_categories')->get(); ?>
            @foreach($main_categories as $main_category)
            <li class="nav-item"> <a class="nav-link" href="{{route('sub_category',$main_category->id)}}">Add {{$main_category->name}} Category</a></li>
            @endforeach
            <li class="nav-item"> <a class="nav-link" href="{{route('view_category')}}">View Category</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#add_banner" aria-expanded="false" aria-controls="add_banner">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Banner</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="add_banner">
            <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('add_banner')}}">Add Add Banner</a></li>
            <li class="nav-item"> <a class="nav-link" href="">View Products</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#add_address" aria-expanded="false" aria-controls="add_address">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Address</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="add_address">
            <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('add_address')}}">Add Address</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('view_address')}}">View Address</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#add_orders" aria-expanded="false" aria-controls="add_orders">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Orders</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="add_orders">
            <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="">Add Orders</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('processing_orders')}}">Processing Orders</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('confirm_orders')}}">Confirm Orders</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('complete_orders')}}">Complete Orders</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('view_orders')}}">View Orders</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#add_users" aria-expanded="false" aria-controls="add_users">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Users</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="add_users">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('view_admin')}}">Admins</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('view_support')}}">Supports</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('view_customer')}}">Customers</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('user_not_verify')}}">Unverified Account</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#khoroch-list" aria-expanded="false" aria-controls="khoroch-list">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Khoroch List</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="khoroch-list">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('add_product_khoroch')}}">Product Khoroch</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('add_personal_khoroch')}}">Personal Khoroch</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#coupon" aria-expanded="false" aria-controls="coupon">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Coupons</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="coupon">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('add_coupon')}}">Coupon</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#update-product" aria-expanded="false" aria-controls="coupon">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Update Product Price</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="update-product">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('update_product_price')}}">Update Product price</a></li>
                @if(Auth::user()->role_as=='Admin')
                <li class="nav-item"> <a class="nav-link" href="{{route('product_update_check')}}">Product Update Check</a></li>
                @endif
            </ul>
        </div>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#message" aria-expanded="false" aria-controls="coupon">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Send Message</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="message">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('all_user_send_msg')}}">All Message</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('unverified_msg')}}">Unverified Account</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('not_order_msg')}}">Not Order Account</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('order_account')}}">Order Account</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('address_not_set_up_account')}}">Address Not Setup Account</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('custom_no_add')}}">Add Phone Number</a></li>
            </ul>
        </div>
    </li>
    @endif
    @if(Auth::user()->phone_no=='01854766511')
        <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#add_orders" aria-expanded="false" aria-controls="add_orders">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Orders</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="add_orders">
            <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="">Add Orders</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('processing_orders')}}">Processing Orders</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('confirm_orders')}}">Confirm Orders</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('complete_orders')}}">Complete Orders</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('view_orders')}}">View Orders</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#add_users" aria-expanded="false" aria-controls="add_users">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Users</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="add_users">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('view_admin')}}">Admins</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('view_support')}}">Supports</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('view_customer')}}">Customers</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('user_not_verify')}}">Unverified Account</a></li>
            </ul>
        </div>
    </li>
        <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#update-product" aria-expanded="false" aria-controls="coupon">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Update Product Price</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="update-product">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('update_product_price')}}">Update Product price</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#message" aria-expanded="false" aria-controls="coupon">
            <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Send Message</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="message">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('all_user_send_msg')}}">All Message</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('unverified_msg')}}">Unverified Account</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('not_order_msg')}}">Not Order Account</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('order_account')}}">Order Account</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('address_not_set_up_account')}}">Address Not Setup Account</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('custom_no_add')}}">Add Phone Number</a></li>
            </ul>
        </div>
    </li>
    @endif
</ul>