<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddRestaurant;
use App\Models\Category;
use DB;

class RestaurantFController extends Controller
{
    public function all_restaurants(){
        $restaurants = AddRestaurant::orderBy('name', 'ASC')->get();
        return view('frontend.page.restaurant.all_restaurant')->with(compact('restaurants'));
    }
    public function restaurants_category($division=null, $district=null, $upazila=null, $restaurant = null){
        $divisions = DB::table('divisions')->where(['name'=>$division])->first();
        $districts = DB::table('districts')->where(['name'=>$district])->first();
        $upazilas = DB::table('upazilas')->where(['name'=>$upazila])->first();
        $restaurant_id = AddRestaurant::where(['division_id'=>$divisions->id])->where(['district_id'=>$districts->id])->where(['upazila_id'=>$upazilas->id])->where(['name'=>$restaurant])->first();
        // Final
        $restaurants = Category::where(['slug'=>'restaurant'])->first();
        $restaurant_category = Category::where(['parent_id'=>$restaurants->id])->orderBy('category_name', 'ASC')->get();
        return view('frontend.page.restaurant.restaurant_category')->with(compact('divisions','districts','upazilas','restaurant','restaurant_id','restaurant_category'));
    }
    public function restaurant_user_product($division=null, $district=null, $upazila=null, $restaurant = null, $category = null){
        $divisions = DB::table('divisions')->where(['name'=>$division])->first();
        $districts = DB::table('districts')->where(['name'=>$district])->first();
        $upazilas = DB::table('upazilas')->where(['name'=>$upazila])->first();
        $categories = DB::table('categories')->where(['category_name'=>$category])->first();
        // print_r($categories);die;
        $restaurant_id = AddRestaurant::where(['division_id'=>$divisions->id])->where(['district_id'=>$districts->id])->where(['upazila_id'=>$upazilas->id])->where(['name'=>$restaurant])->first();
        $restaurant_products = DB::table('restaurant_products')->where(['restaurant_id'=>$restaurant_id->id])->where(['category_id'=>$categories->id])->orderBy('product_name', 'ASC')->get();
        return view('frontend.page.restaurant.restaurant_product')->with(compact('division','district','upazila','restaurant','category','restaurant_products'));
    }
}
