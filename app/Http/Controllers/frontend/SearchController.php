<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use App\Models\Cart;
use Session;

class SearchController extends Controller
{
    public function search_product_value($value=null){

        $products_get = Product::where(['status'=>1])->where(['status'=>1])->where(['visible'=>1])->where('product_name','LIKE','%'.$value.'%')
                                ->orwhere('product_code','LIKE','%'.$value.'%')
                                ->orwhere('category','LIKE','%'.$value.'%')
                                ->orderBy('product_name', 'ASC')->get()->take(10);
        return response()->json([
            'products'=>$products_get,
        ]);
    }
    public function search_product_check($id=null){
        $product = Product::where(['id'=>$id])->first();
        $session_id = Session::getId();
        if(Auth::check()){
            $cart_count = Cart::where(['user_id'=>Auth::user()->id])->where(['product_id'=>$product->id])->count();
            $cart = Cart::where(['user_id'=>Auth::user()->id])->where(['product_id'=>$product->id])->first();
        }else{
            $cart_count = Cart::where(['session_id'=>$session_id])->where(['product_id'=>$product->id])->count();
            $cart = Cart::where(['session_id'=>$session_id])->where(['product_id'=>$product->id])->first();
        }
        if($cart_count > 0){
            return response()->json([
                'product_id'=>$id,
                'cart_count'=>$cart_count,
                'cart_id'=>$cart->id,
                'cart_quantity'=>$cart->quantity,
            ]);
        }else{
            return response()->json([
                'product_id'=>$id,
                'cart_count'=>$cart_count,
            ]);
        }

    }
}
