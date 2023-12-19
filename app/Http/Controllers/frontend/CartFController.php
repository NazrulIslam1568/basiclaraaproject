<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\RestaurantProduct;
use Auth;
use Session;
use DB;

class CartFController extends Controller
{
    public function cart(){
        $coupon_amount = Session::get('coupon_amount');
        $session_id = Session::getId();
        if(Auth::check()){
            $carts = Cart::where(['user_id'=>Auth::user()->id])->get();
        }else{
            $carts = Cart::where(['session_id'=>$session_id])->get();
        }
        $coupon_count = $carts->sum('total_price');
        return view('frontend.page.cart')->with(compact('carts','coupon_count','coupon_amount'));
    }
    public function add_cart(Request $request){
        $cart = new Cart;
        $cart->user_id = $request->input('user_id');
        $cart->session_id = $request->input('session_id');
        $cart->product_id = $request->input('product_id');
        $product = Product::where(['id'=>$request->input('product_id')])->first();
        $cart->product_name = $product->product_name;
        $cart->product_url = $product->product_url;
        $cart->product_image = $product->image;
        $cart->product_price = $product->product_price;
        $cart->product_weight = $product->product_weight;
        $cart->buy_price = $product->buy_price;
        $cart->product_ekok = $product->product_ekok;
        $cart->total_price = 1*$product->product_price;
        if($product->offer == 1){
            $cart->offer = 'offer';
        }
        $cart->save();
        $carts = DB::getPdo()->lastInsertId();
        $session_id = Session::getId();
        if(Auth::check()){
            $cart_count = Cart::where(['user_id'=>Auth::user()->id])->count();
        }else{
            $cart_count = Cart::where(['session_id'=>$session_id])->count();
        }
        return response()->json([
            'cart_count'=>$cart_count,
            'cart_quantity'=>1,
            'cart_id'=>$carts,
        ]);
    }
    public function view_cart_ajax(){
        $session_id = Session::getId();
        $coupon_amount = Session::get('coupon_amount');
        if(Auth::check()){
            $cart_get = Cart::where(['user_id'=>Auth::user()->id])->get();
            $cart_sum = Cart::where(['user_id'=>Auth::user()->id])->sum('total_price');
        }else{
            $cart_get = Cart::where(['session_id'=>$session_id])->get();
            $cart_sum = Cart::where(['session_id'=>$session_id])->sum('total_price');
        }
        return response()->json([
            'carts'=>$cart_get,
            'total_price'=>$cart_sum,
            'session'=>$coupon_amount,
        ]);
    }
    public function add_cart_shop(Request $request, $product_id = null){
        $session_id = Session::getId();
        $type = $request->input('type');
        if($type == 'restaurant'){
            if(Auth::check()){
                $product_check = Cart::where(['user_id'=>Auth::user()->id])->where(['product_id'=>$product_id])->count();
                $cart_count = Cart::where(['user_id'=>Auth::user()->id])->count();
                $sub_total = Cart::where(['user_id'=>Auth::user()->id])->sum('total_price');
            }else{
                $cart_count = Cart::where(['session_id'=>$session_id])->count();
                $sub_total = Cart::where(['session_id'=>$session_id])->sum('total_price');
                $product_check = Cart::where(['session_id'=>$session_id])->where(['product_id'=>$product_id])->count();
            }
            if(!$product_check > 0){
                $cart = new Cart;
                if(Auth::check()){
                    $cart->user_id = Auth::user()->id;
                }
                $cart->session_id = $session_id;
                $cart->product_id = $product_id;
                $product = RestaurantProduct::where(['id'=>$product_id])->first();
                if($product->offer == 1){
                    $cart->offer = 'offer';
                }
                $cart->type = $type;
                $cart->product_name = $product->product_name;
                $cart->product_url = $product->product_url;
                $main_product = Product::where(['id'=>$product->main_product_id])->first();
                $cart->product_image = $main_product->image;
                $cart->product_price = $product->product_price;
                $cart->product_weight = $product->product_weight;
                $cart->quantity = 1;
                $cart->total_price = $cart->quantity*$product->product_price;
                $cart->save();
                $carts = DB::getPdo()->lastInsertId();
                return response()->json([
                    'cart_count'=>$cart_count,
                    'cart_quantity'=>$cart->quantity,
                    'cart_id'=>$carts,
                    'product'=>$product,
                    'image'=>$main_product->image,
                    'total_price'=>$cart->total_price,
                    'sub_total'=>$sub_total+$product->product_price,
                    'type'=>$type,
                ]);
            }else{
                if(Auth::check()){
                    $carts = Cart::where(['user_id'=>Auth::user()->id])->where(['product_id'=>$product_id])->first();
                    $cart_count = Cart::where(['user_id'=>Auth::user()->id])->count();
                }else{
                    $cart_count = Cart::where(['session_id'=>$session_id])->count();
                    $carts = Cart::where(['session_id'=>$session_id])->where(['product_id'=>$product_id])->first();
                }
                return response()->json([
                    'cart_count'=>$cart_count,
                    'cart_quantity'=>$carts->quantity,
                    'cart_id'=>$carts->id,
                    'cart_check'=>'cart-ache',
                ]);
            }
        }else{
            if(Auth::check()){
                $product_check = Cart::where(['user_id'=>Auth::user()->id])->where(['product_id'=>$product_id])->count();
                $cart_count = Cart::where(['user_id'=>Auth::user()->id])->count();
                $sub_total = Cart::where(['user_id'=>Auth::user()->id])->sum('total_price');
            }else{
                $cart_count = Cart::where(['session_id'=>$session_id])->count();
                $sub_total = Cart::where(['session_id'=>$session_id])->sum('total_price');
                $product_check = Cart::where(['session_id'=>$session_id])->where(['product_id'=>$product_id])->count();
            }
            if(!$product_check > 0){
                $cart = new Cart;
                if(Auth::check()){
                    $cart->user_id = Auth::user()->id;
                }
                $cart->session_id = $session_id;
                $cart->product_id = $product_id;
                $product = Product::where(['id'=>$product_id])->first();
                if($product->offer == 1){
                    $cart->offer = 'offer';
                }
                $cart->product_name = $product->product_name;
                $cart->product_url = $product->product_url;
                $cart->product_image = $product->image;
                $cart->product_price = $product->product_price;
                $cart->product_weight = $product->product_weight;
                $cart->buy_price = $product->buy_price;
                $cart->product_ekok = $product->product_ekok;
                $cart->quantity = 1;
                $cart->total_price = $cart->quantity*$product->product_price;
                $cart->save();
                $carts = DB::getPdo()->lastInsertId();
                return response()->json([
                    'cart_count'=>$cart_count,
                    'cart_quantity'=>$cart->quantity,
                    'cart_id'=>$carts,
                    'product'=>$product,
                    'total_price'=>$cart->total_price,
                    'sub_total'=>$sub_total+$product->product_price,
                ]);
            }else{
                if(Auth::check()){
                    $carts = Cart::where(['user_id'=>Auth::user()->id])->where(['product_id'=>$product_id])->first();
                    $cart_count = Cart::where(['user_id'=>Auth::user()->id])->count();
                }else{
                    $cart_count = Cart::where(['session_id'=>$session_id])->count();
                    $carts = Cart::where(['session_id'=>$session_id])->where(['product_id'=>$product_id])->first();
                }
                return response()->json([
                    'cart_count'=>$cart_count,
                    'cart_quantity'=>$carts->quantity,
                    'cart_id'=>$carts->id,
                    'cart_check'=>'cart-ache',
                ]);
            }   
        }
    }
    public function cancel_cart($cart_id=null){
        $product_id = Cart::where(['id'=>$cart_id])->first();
        $session_id = Session::getId();
        Cart::where(['id'=>$cart_id])->delete();
        if(Auth::check()){
            $cart_sum = Cart::where(['user_id'=>Auth::user()->id])->sum('total_price');
            $cart_count = Cart::where(['user_id'=>Auth::user()->id])->count();
        }else{
            $cart_sum = Cart::where(['session_id'=>$session_id])->sum('total_price');
            $cart_count = Cart::where(['session_id'=>$session_id])->count();
        }
        return response()->json([
            'cart_count'=>$cart_count,
            'product_id'=>$product_id->product_id,
            'subtotal_price'=>$cart_sum+0,
            'type'=>$product_id->type,
        ]);
    }
    public function cart_product_remove($cart_id=null){
        $product_id = Cart::where(['id'=>$cart_id])->first();
        $session_id = Session::getId();
        Cart::where(['id'=>$cart_id])->delete();
        if(Auth::check()){
            $cart_count = Cart::where(['user_id'=>Auth::user()->id])->count();
        }else{
            $cart_count = Cart::where(['session_id'=>$session_id])->count();
        }
        return redirect()->back();
    }
    public function cart_increase(Request $request, $cart_id=null){
        $session_id = Session::getId();
        $coupon_amount = Session::get('coupon_amount');
        $single_product_price = Cart::where(['id'=>$cart_id])->first();
        if(Auth::check()){
            $cart_sum = Cart::where(['user_id'=>Auth::user()->id])->sum('total_price');
        }else{
            $cart_sum = Cart::where(['session_id'=>$session_id])->sum('total_price');
        }
        $product_qty = $single_product_price->quantity+1;
        $cart = Cart::where(['id'=>$cart_id])->first();
        $total_amount = $product_qty*$cart->product_price;
        Cart::where(['id'=>$cart_id])->update([
            'quantity'=>$product_qty,
            'total_price'=>$total_amount,
        ]);
        return response()->json([
            'product_qty'=>$product_qty,
            'total_price'=>$total_amount,
            'subtotal_price'=>$cart_sum+$single_product_price->product_price,
            'type'=>$cart->type,
        ]);
    }
    public function cart_decrease(Request $request, $cart_id=null){
        $session_id = Session::getId();
        $coupon_amount = Session::get('coupon_amount');
        $single_product_price = Cart::where(['id'=>$cart_id])->first();
        if(Auth::check()){
            $cart_sum = Cart::where(['user_id'=>Auth::user()->id])->sum('total_price');
        }else{
            $cart_sum = Cart::where(['session_id'=>$session_id])->sum('total_price');
        }
        $product_qty = $single_product_price->quantity-1;
        $cart = Cart::where(['id'=>$cart_id])->first();
        $total_amount = $product_qty * $cart->product_price;
        Cart::where(['id'=>$cart_id])->update([
            'quantity'=>$product_qty,
            'total_price'=>$total_amount,
        ]);
        return response()->json([
            'product_qty'=>$product_qty,
            'total_price'=>$total_amount,
            'subtotal_price'=>$cart_sum-$single_product_price->product_price
        ]);
    }
}
