<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\Cart;
use Session;
use Str;
use Auth;

class ProductFController extends Controller
{
    public function single_product($product_url = null){
        $product = Product::where(['product_url'=>$product_url])->first();
        $single_product_count = Product::where(['product_url'=>$product_url])->count();
        if($single_product_count > 0){
            $total_review = Review::where(['product_id'=>$product->id])->count();
            $session_id = Session::getId();
            if($total_review > 0){
                $total_review_eq = Review::where(['product_id'=>$product->id])->sum('review');
                $review_star = ($total_review_eq/$total_review)*20;
            }else{
                $review_star = 0;
            }
            $current_time = Carbon::now()->toTimeString() ;
            $current_date = Carbon::now()->format('d/m/Y') ;
            $tomorrow_date = Carbon::tomorrow()->format('d/m/Y');
            return view('frontend.page.single_product')->with(compact('product','total_review','review_star','current_time','current_date','tomorrow_date','session_id'));
        }else{
            abort(412, 'Page not found');
        }
    }
    public function category_product_view(Request $request, $main_category_name=null, $category_name){
        $fist_capital_category = Str::title($main_category_name);
        $second_capital_product = Str::title($category_name);
        $category_get = Category::where(['slug'=>$category_name])->first();
        $products = Product::where(['parent_category_id'=>$category_get->id])->where(['visible'=>1])->orderBy('product_name', 'ASC')->get();
        return view('frontend.page.category_product_view')->with(compact('category_get','category_name','products','fist_capital_category','second_capital_product','main_category_name'));
    }
    public function ramadan_product(){
        $cat_name = 'Romjan';
        $products = Product::where(['choice'=>$cat_name])->orderBy('product_name', 'ASC')->get();
        return view('frontend.page.ramadan_product')->with(compact('products'));
    }
    public function offer_product(){
        $products = Product::where(['offer'=>1])->orderBy('product_name', 'ASC')->get();
        return view('frontend.page.ramadan_product')->with(compact('products'));
    }
}
