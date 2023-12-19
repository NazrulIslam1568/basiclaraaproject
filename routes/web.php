<?php

use Illuminate\Support\Facades\Route;

// Frontend Controller
use App\Http\Controllers\frontend\UserController;
use App\Http\Controllers\frontend\VerifyController;
use App\Http\Controllers\frontend\PageFController;
use App\Http\Controllers\frontend\ProductFController;
use App\Http\Controllers\frontend\CartFController;
use App\Http\Controllers\frontend\CouponController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\frontend\AddressController;
use App\Http\Controllers\frontend\InvoiceController;
use App\Http\Controllers\frontend\PDFController;
use App\Http\Controllers\frontend\SearchController;
use App\Http\Controllers\frontend\PageLoadController;
use App\Http\Controllers\frontend\OrdersController;
use App\Http\Controllers\frontend\DeliveryManController;
use App\Http\Controllers\frontend\FrogotPassword;
use App\Http\Controllers\frontend\ImageController;
use App\Http\Controllers\frontend\ChatController;
use App\Http\Controllers\frontend\RestaurantFController;



// Backend Controller
use App\Http\Controllers\backend\PageController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\BannerController;
use App\Http\Controllers\backend\AddressBController;
use App\Http\Controllers\backend\OrdersBController;
use App\Http\Controllers\backend\UsersController;
use App\Http\Controllers\backend\KhorochController;
use App\Http\Controllers\backend\CouponBController;
use App\Http\Controllers\backend\msgController;
use App\Http\Controllers\backend\RestaurantController;


use App\Http\Controllers\testController;



Route::match(['get','post'], '/',[PageFController::class, 'home'])->name('home');



//-------------------All User Usable Route--------------------//

// Login & Register Route
Route::match(['get', 'post'], '/register',[UserController::class, 'register'])->name('register');
Route::match(['get', 'post'], '/login',[UserController::class, 'login'])->name('login');
Route::match(['get','post'], '/logout',[UserController::class, 'logout'])->name('logout');
Route::match(['get','post'], '/shop',[PageFController::class, 'shop'])->name('shop');

// Product View All Page
// Route::match(['get','post'], 'catedfdsfdgory/{category_id}',[PageFController::class, 'category_product_view'])->name('category_product_view');
Route::match(['get','post'], 'category/{product_url}',[PageFController::class, 'frontend_sub_category_view'])->name('frontend_sub_category_view');
Route::match(['get','post'], 'brand/{brand_id}',[PageFController::class, 'brand_product_view'])->name('brand_product_view');



Route::match(['get','post'], '/single-product/{product_url}',[ProductFController::class, 'single_product'])->name('single_product');

Route::match(['get','post'], '/category/{category_name}/{product_name}',[ProductFController::class, 'category_product_view'])->name('category_product_view');

// Cart Route
Route::match(['get','post'], '/add_cart',[CartFController::class, 'add_cart'])->name('add_cart');
Route::match(['get','post'], '/add_cart/{product_id}',[CartFController::class, 'add_cart_shop'])->name('add_cart_shop');
Route::match(['get'], '/view-cart-ajax',[CartFController::class, 'view_cart_ajax'])->name('view_cart_ajax');
Route::match(['get'], '/cancel_cart/{cart_id}',[CartFController::class, 'cancel_cart'])->name('cancel_cart');
Route::match(['get'], '/cart-product-remove/{cart_id}',[CartFController::class, 'cart_product_remove'])->name('cart_product_remove');
Route::match(['get'], '/contact-us',[PageFController::class, 'contact_us'])->name('contact_us');
Route::match(['get'], '/about',[PageFController::class, 'about'])->name('about');
// Checkout Controller


// All Address get
Route::match(['get'], '/all-district-view/{district_id}',[AddressController::class, 'add_district_view'])->name('add_district_view');
Route::match(['get'], '/all-upazila-view/{division_id}',[AddressController::class, 'add_upazila_view'])->name('add_upazila_view');
Route::match(['get'], '/all-bazar_name-view/{upazila_id}',[AddressController::class, 'add_bazar_name_view'])->name('add_bazar_name_view');
Route::match(['get'], '/all-elaka_name-view/{upazila_id}',[AddressController::class, 'add_elaka_name_view'])->name('add_elaka_name_view');
Route::match(['get'], '/all-elaka_name-view/{upazila_id}',[AddressController::class, 'add_elaka_name_view'])->name('add_elaka_name_view');
Route::match(['get'], '/resenc-code/{phone_no}',[VerifyController::class, 'resend_code'])->name('resend_code');


// Apply Coupon

Route::match(['get','post'], '/apply-coupon',[CouponController::class, 'apply_coupon'])->name('apply_coupon');
Route::match(['get','post'], '/cancel-session',[CouponController::class, 'cancel_coupon'])->name('cancel_coupon');
Route::match(['get'], '/cart',[CartFController::class, 'cart'])->name('cart');
Route::match(['get'], '/checkout',[CheckoutController::class, 'checkout'])->name('checkout');
// Product Cart Increase
Route::match(['get'], '/product-increase-database/{id}',[CartFController::class, 'cart_increase'])->name('cart_increase');
Route::match(['get'], '/product-decrease-database/{id}',[CartFController::class, 'cart_decrease'])->name('cart_decrease');

// /searchsuggestion
Route::match(['get'], '/search-product-value/{value}',[SearchController::class, 'search_product_value'])->name('search_product_value');
Route::match(['get'], '/search-product-check/{product_id}',[SearchController::class, 'search_product_check'])->name('search_product_check');

// Terms & Condition Page
Route::match(['get'], '/terms-and-condition',[PageFController::class, 'terms_and_condition'])->name('terms_and_condition');

// Page Load Place Order
Route::match(['get'], '/page-load-place-order',[PageLoadController::class, 'page_load_place_order'])->name('page_load_place_order');

// Forgot Password Verify
Route::match(['get'], '/forgot-password',[FrogotPassword::class, 'forgot_password'])->name('forgot_password');
Route::match(['get'], '/forgot-password-send/{phone_number}',[FrogotPassword::class, 'forgot_password_send'])->name('forgot_password_send');
Route::match(['get'], '/user/change-password/{phone_no}',[FrogotPassword::class, 'change_password'])->name('change_password');
Route::match(['get','post'], '/user/change-password-verify/{phone_no}',[FrogotPassword::class, 'change_password_verify'])->name('change_password_verify');

Route::match(['get','post'], '/profile-picture-update',[ImageController::class, 'profile_picture_update'])->name('profile_picture_update');
Route::match(['get','post'], '/ramadan',[ProductFController::class, 'ramadan_product'])->name('ramadan_product');
Route::match(['get','post'], '/offer',[ProductFController::class, 'offer_product'])->name('offer_product');


//------------------- End All User Usable Route--------------------//



// Phone Verify Code
Route::match(['get','post'], '/user/phone-verify',[VerifyController::class, 'phone_verify'])->name('phone_verify');
Route::match(['get','post'], '/user/phone-verify/{phone_no}',[VerifyController::class, 'phone_verify_not_login'])->name('phone_verify_not_login');
// Phone No Database Check
Route::match(['get', 'post'], '/phone-check/{phone_no}',[UserController::class, 'phone_check'])->name('phone_check');
Route::match(['get','post'], '/submit-verify/{code}',[VerifyController::class, 'submit_verify'])->name('submit_verify');
// Restaurant System Add
Route::match(['get','post'], '/restaurants',[RestaurantFController::class, 'all_restaurants'])->name('all_restaurants');
Route::match(['get','post'], '/restaurants/{division}/{district}/{upazila}/{restaurant}',[RestaurantFController::class, 'restaurants_category'])->name('restaurants_category');
Route::match(['get','post'], '/restaurants/{division}/{district}/{upazila}/{restaurant}/{category}',[RestaurantFController::class, 'restaurant_user_product'])->name('restaurant_user_product');
// All Restaurant Product status & visible 0
Route::match(['get','post'], '/restaurants-product-visible-status',[RestaurantController::class, 'restaurant_visible_status_0'])->name('restaurant_visible_status_0');








//-------------------- Not Phone verify not access route-----------//
Route::group(['middleware'=>['auth','phone_verify']],function(){
    Route::match(['get'], '/checkout',[CheckoutController::class, 'checkout'])->name('checkout');
    Route::match(['post'], '/checkout-post',[CheckoutController::class, 'checkout_post'])->name('checkout_post');
    // User Order, Balance, Profile Route
    Route::match(['get','post'], '/orders',[PageFController::class, 'orders'])->name('orders');
    Route::match(['get','post'], '/balance-history',[PageFController::class, 'balance_history'])->name('balance_history');
    Route::match(['get','post'], '/user-profile',[PageFController::class, 'user_profile'])->name('user_profile');
    // Change address route
    Route::match(['get','post'], '/update-address',[PageFController::class, 'update_address'])->name('update_address');
    Route::match(['get','post'], '/change-address',[PageFController::class, 'change_address'])->name('change_address');
    Route::match(['get','post'], '/user-balance',[PageFController::class, 'user_balance'])->name('user_balance');
    Route::match(['get','post'], '/orders-history',[OrdersController::class, 'orders_history'])->name('orders_history');
    Route::match(['get','post'], '/order-details/{order_id}',[OrdersController::class, 'order_details_get'])->name('order_details_get');
    Route::match(['get','post'], '/livechat/{user_name}',[ChatController::class, 'user_livechat'])->name('user_livechat');
    Route::match(['get','post'], '/livechat_post/{user_name}',[ChatController::class, 'livechat_message_post'])->name('livechat_message_post');
    Route::match(['get','post'], '/admin-livechat',[ChatController::class, 'admin_livechat'])->name('admin_livechat');
    Route::match(['get','post'], '/admin-livechat_post/{user_name}',[ChatController::class, 'admin_message_post'])->name('admin_message_post');
    Route::match(['get','post'], '/admin-message/{user_id}',[ChatController::class, 'admin_message'])->name('admin_message');
    Route::match(['get','post'], '/welcome-message-send/{user_id}',[ChatController::class, 'welcome_msg'])->name('welcome_msg');
    Route::match(['get','post'], '/close-user-chat',[ChatController::class, 'close_chat_user'])->name('close_chat_user');

    
});
//-------------------- End Not Phone verify not access route-----------//

Route::group(['middleware'=>['auth','support']],function(){
// Delivery Man Route
Route::match(['get','post'], '/admin/dashboard',[PageController::class, 'admin_dashboard'])->name('admin_dashboard');
Route::match(['get','post'], '/admin/confirm-orders',[OrdersBController::class, 'confirm_orders'])->name('confirm_orders');
Route::match(['get','post'], '/delivery-confirm/{order_id}/{code}/{name}',[DeliveryManController::class, 'delivery_confirm_code'])->name('delivery_confirm_code');
Route::match(['get','post'], '/invoice/{id}',[InvoiceController::class, 'invoice'])->name('invoice');
Route::match(['get','post'], '/invoice-pdf/{id}',[PDFController::class, 'invoice_pdf'])->name('invoice_pdf');
Route::match(['get','post'], '/download-invoice-pdf/{id}',[PDFController::class, 'download_invoice_pdf'])->name('download_invoice_pdf');
    
});





Route::group(['middleware'=>['auth','admin']],function(){
//--------------Start Admin Dashboard All Route---------------------------//
// admin Dashboard
Route::match(['get','post'], '/admin/dashboard',[PageController::class, 'admin_dashboard'])->name('admin_dashboard');
// Product Route
Route::match(['get','post'], '/admin/add_product',[ProductController::class, 'add_product'])->name('add_product');
Route::match(['post'], '/admin/add-product-post',[ProductController::class, 'add_product_post'])->name('add_product_post');
Route::match(['get','post'], '/admin/view_product',[ProductController::class, 'view_product'])->name('view_product');

// Ajax View Product
Route::match(['get'], '/admin/view-product-ajax',[ProductController::class, 'view_product_ajax'])->name('view_product_ajax');

// Delete Product
Route::match(['get'], '/admin/delete-product/{id}',[ProductController::class, 'delete_product'])->name('delete_product');

// Edit Product
Route::match(['get'], '/admin/edit-product/{id}',[ProductController::class, 'edit_product'])->name('edit_product');

// Update Product
Route::match(['post'], '/admin/update-product-post/{id}',[ProductController::class, 'update_product_post'])->name('update_product_post');
// Add Categories
Route::match(['get','post'], '/admin/main-category',[CategoryController::class, 'main_category'])->name('main_category');
Route::match(['get','post'], '/admin/sub-category/{category_name}',[CategoryController::class, 'category'])->name('sub_category');
Route::match(['get','post'], '/admin/category-post',[CategoryController::class, 'category_post'])->name('category_post');
// View Category
Route::match(['get','post'], '/admin/view-category',[CategoryController::class, 'view_category'])->name('view_category');
Route::match(['get','post'], '/admin/delete-category/{id}',[CategoryController::class, 'delete_category'])->name('delete_category');
Route::match(['get','post'], '/admin/edit-category/{id}',[CategoryController::class, 'edit_category'])->name('edit_category');
// Category table hide show

Route::match(['get','post'], '/admin/category-table-hide-show/{cat_id}/{table_name}',[CategoryController::class, 'category_hide_show'])->name('category_hide_show');


Route::match(['get','post'], '/admin/sub-category-view/{id}',[CategoryController::class, 'sub_category_view'])->name('sub_category_view');
Route::match(['get','post'], '/admin/parent-category-view/{id}',[CategoryController::class, 'parent_category_view'])->name('parent_category_view');
// Banner System Add
Route::match(['get','post'], '/admin/add-banner',[BannerController::class, 'add_banner'])->name('add_banner');
// Address Add
Route::match(['get','post'], '/admin/add-address',[AddressBController::class, 'add_address'])->name('add_address');
Route::match(['get','post'], '/admin/add-address-post',[AddressBController::class, 'add_address_post'])->name('add_address_post');
Route::match(['get','post'], '/admin/view-address',[AddressBController::class, 'view_address'])->name('view_address');
Route::match(['get','post'], '/admin/address-table-hide-show/{cat_id}/{table_name}/{click}',[AddressBController::class, 'address_hide_show'])->name('address_hide_show');

// All Address get
Route::match(['get'], '/admin/all-district-view/{district_id}',[AddressBController::class, 'add_district_view'])->name('add_district_view');
Route::match(['get'], '/admin/all-upazila-view/{division_id}',[AddressBController::class, 'add_upazila_view'])->name('add_upazila_view');
Route::match(['get'], '/admin/all-bazar_name-view/{upazila_id}',[AddressBController::class, 'add_bazar_name_view'])->name('add_bazar_name_view');
Route::match(['get'], '/admin/all-elaka_name-view/{upazila_id}',[AddressBController::class, 'add_elaka_name_view'])->name('add_elaka_name_view');
Route::match(['get','post'], '/admin/address-delete/{address_id}/{click}',[AddressBController::class, 'address_delete'])->name('address_delete');
Route::match(['get','post'], '/admin/view-orders',[OrdersBController::class, 'view_orders'])->name('view_orders');
Route::match(['get','post'], '/admin/order-details-change/{order_id}',[OrdersBController::class, 'order_details_change'])->name('order_details_change');
Route::match(['get','post'], '/invoice/{id}',[InvoiceController::class, 'invoice'])->name('invoice');
Route::match(['get','post'], '/invoice-pdf/{id}',[PDFController::class, 'invoice_pdf'])->name('invoice_pdf');
Route::match(['get','post'], '/download-invoice-pdf/{id}',[PDFController::class, 'download_invoice_pdf'])->name('download_invoice_pdf');
Route::match(['get','post'], '/admin/order-status-change',[OrdersBController::class, 'order_status_change'])->name('order_status_change');
Route::match(['get','post'], '/admin/complete-orders',[OrdersBController::class, 'complete_orders'])->name('complete_orders');
Route::match(['get','post'], '/admin/processing-orders',[OrdersBController::class, 'processing_orders'])->name('processing_orders');
Route::match(['get','post'], '/admin/view-users',[UsersController::class, 'view_users'])->name('view_users');
Route::match(['get','post'], '/admin/user-details/{id}',[UsersController::class, 'user_details_page'])->name('user_details_page');
Route::match(['get','post'], '/admin/update-role',[UsersController::class, 'update_role'])->name('update_role');
Route::match(['get','post'], '/admin/update-balance',[UsersController::class, 'update_balance'])->name('update_balance');
Route::match(['get','post'], '/admin/update-admin',[UsersController::class, 'view_admin'])->name('view_admin');
Route::match(['get','post'], '/admin/update-support',[UsersController::class, 'view_support'])->name('view_support');
Route::match(['get','post'], '/admin/update-customer',[UsersController::class, 'view_customer'])->name('view_customer');
Route::match(['get','post'], '/admin/user-not-verify',[UsersController::class, 'user_not_verify'])->name('user_not_verify');
Route::match(['get','post'], '/admin/user-not-verify-sms/{id}',[UsersController::class, 'user_not_verify_sms'])->name('user_not_verify_sms');
Route::match(['get','post'], '/admin/user-account-verify',[UsersController::class, 'user_account_verify'])->name('user_account_verify');
Route::match(['get','post'], '/admin/user_phone_verify',[UsersController::class, 'user_phone_verify'])->name('user_phone_verify');
Route::match(['get','post'], '/admin/add-product-khoroch',[KhorochController::class, 'add_product_khoroch'])->name('add_product_khoroch');
Route::match(['get','post'], '/admin/add-personal-khoroch',[KhorochController::class, 'add_personal_khoroch'])->name('add_personal_khoroch');
Route::match(['get','post'], '/admin/add-coupon',[CouponBController::class, 'add_coupon'])->name('add_coupon');
Route::match(['get','post'], '/coupon-status-change/{coupon_id}',[CouponBController::class, 'coupon_status_change'])->name('coupon_status_change');
Route::match(['get','post'], '/coupon_delte/{id}',[CouponBController::class, 'coupon_delete'])->name('coupon_delete');


// admin & delivery man route
Route::match(['get','post'], '/admin/confirm-orders',[OrdersBController::class, 'confirm_orders'])->name('confirm_orders');
Route::match(['get','post'], '/delivery-confirm/{order_id}/{code}/{name}',[DeliveryManController::class, 'delivery_confirm_code'])->name('delivery_confirm_code');
Route::match(['get','post'], 'all-user-send-msg',[msgController::class, 'all_user_send_msg'])->name('all_user_send_msg');
Route::match(['get','post'], 'send-sms-post',[msgController::class, 'send_sms_post'])->name('send_sms_post');
Route::match(['get','post'], 'not-order-msg',[msgController::class, 'not_order_msg'])->name('not_order_msg');
Route::match(['get','post'], 'unverified-msg',[msgController::class, 'unverified_msg'])->name('unverified_msg');
Route::match(['get','post'], 'order-account',[msgController::class, 'order_account'])->name('order_account');
Route::match(['get','post'], 'address-not-set-up-account',[msgController::class, 'address_not_set_up_account'])->name('address_not_set_up_account');
Route::match(['get','post'], 'address-not-set-up-account',[msgController::class, 'address_not_set_up_account'])->name('address_not_set_up_account');
Route::match(['get','post'], '/product_update_check',[ProductController::class, 'product_update_check'])->name('product_update_check');
Route::match(['get','post'], 'admin/offer_product',[ProductController::class, 'offer_product'])->name('offer_product');
Route::match(['get','post'], 'admin/editable_product',[ProductController::class, 'editable_product'])->name('editable_product');
Route::match(['get','post'], '/admin/all-hide-show/{id}/{field_name}/{db_name}',[ProductController::class, 'all_hide_show'])->name('all_hide_show');
Route::match(['get','post'], '/admin/cartoon-top-print/{order_id}',[PDFController::class, 'cartoon_top_print'])->name('cartoon_top_print');
Route::match(['get','post'], '/admin/visible-product',[ProductController::class, 'visible_product'])->name('visible_product');

Route::match(['get','post'], '/admin/web_update_product_status_change/{table_name}/{column_name}',[ProductController::class, 'web_update_product_status_change'])->name('web_update_product_status_change');

Route::match(['get','post'], '/admin/custom-no-add',[msgController::class, 'custom_no_add'])->name('custom_no_add');
Route::match(['get','post'], '/admin/custom-no-add-post',[msgController::class, 'custom_no_add_post'])->name('custom_no_add_post');
Route::match(['get','post'], '/order-msg-access/{phone_no}',[OrdersBController::class, 'order_msg_access'])->name('order_msg_access');
Route::match(['get','post'], '/order-msg-access/{phone_no}',[OrdersBController::class, 'order_msg_access'])->name('order_msg_access');
// all Restaurant System Add
Route::match(['get','post'], '/add-restaurants',[RestaurantController::class, 'add_restaurants'])->name('add_restaurants');
Route::match(['get','post'], '/add-restaurants-post',[RestaurantController::class, 'add_restaurants_post'])->name('add_restaurants_post');
Route::match(['get','post'], '/edit-restaurants/{id}',[RestaurantController::class, 'edit_restaurants'])->name('edit_restaurants');
Route::match(['get','post'], '/edit-restaurants-post/{id}',[RestaurantController::class, 'edit_restaurants_post'])->name('edit_restaurants_post');
Route::match(['get','post'], '/add-restaurants-product',[RestaurantController::class, 'add_restaurant_product'])->name('add_restaurant_product');
Route::match(['get','post'], '/restaurant-all-item/{restaurant_id}',[RestaurantController::class, 'restaurant_all_item'])->name('restaurant_all_item');
Route::match(['get','post'], '/restaurant-all-item/{restaurant_id}/{category_id}',[RestaurantController::class, 'restaurant_add_product'])->name('restaurant_add_product');
Route::match(['get','post'], '/add-final-restaurant-product-add/{restaurant_id}/{category_id}',[RestaurantController::class, 'add_restaurant_product_post'])->name('add_restaurant_product_post');
Route::match(['get','post'], '/edit-final-restaurant-product-edit/{restaurant_product_id}',[RestaurantController::class, 'edit_restaurant_product'])->name('edit_restaurant_product');
Route::match(['get','post'], '/edit-final-restaurant-product-post/{restaurant_product_id}',[RestaurantController::class, 'edit_restaurant_product_post'])->name('edit_restaurant_product_post');


});
Route::match(['get','post'], 'all-user-send-msg',[msgController::class, 'all_user_send_msg'])->name('all_user_send_msg');
Route::match(['get','post'], 'send-sms-post',[msgController::class, 'send_sms_post'])->name('send_sms_post');
Route::match(['get','post'], 'not-order-msg',[msgController::class, 'not_order_msg'])->name('not_order_msg');
Route::match(['get','post'], 'unverified-msg',[msgController::class, 'unverified_msg'])->name('unverified_msg');
Route::match(['get','post'], 'order-account',[msgController::class, 'order_account'])->name('order_account');
Route::match(['get','post'], 'address-not-set-up-account',[msgController::class, 'address_not_set_up_account'])->name('address_not_set_up_account');
Route::match(['get','post'], 'address-not-set-up-account',[msgController::class, 'address_not_set_up_account'])->name('address_not_set_up_account');

Route::match(['get','post'], '/admin/dashboard',[PageController::class, 'admin_dashboard'])->name('admin_dashboard');
Route::match(['get','post'], 'update_product_price',[ProductController::class, 'update_product_price'])->name('update_product_price');
Route::match(['get','post'], '/product-price-update-support/{product_price}/{product_id}',[ProductController::class, 'product_price_update_support'])->name('product_price_update_support');
Route::match(['get','post'], '/admin/confirm-orders',[OrdersBController::class, 'confirm_orders'])->name('confirm_orders');
Route::match(['get','post'], '/delivery-confirm/{order_id}/{code}/{name}',[DeliveryManController::class, 'delivery_confirm_code'])->name('delivery_confirm_code');




//----------------End Admin Dashboard All Route ------------------------//

