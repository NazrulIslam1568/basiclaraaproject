<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Product;
use Session;
use Auth;
use DB;
use App\Models\Cart;

class CouponController extends Controller
{
    public function apply_coupon(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
            $total_cart_amount = $data['cart_coupon_get'];
            $couponCount = Coupon::where('coupon_code',$data['coupon_code'])->count();
            if(Session::get('coupon_amount')){
                return response()->json([
                    'message'=>'Coupon already used!',
                    'icon'=>'warning',
                    'title'=>'Error',
                    'session'=>Session::get('coupon_amount'),
                ]);
            }else{
                if($couponCount == 0){
                    return response()->json([
                        'message'=>'Coupon code does not exists',
                        'icon'=>'warning',
                        'title'=>'Error',
                    ]);
                }else{
                    $couponDetails = Coupon::where('coupon_code',$data['coupon_code'])->first();
                    // Coupon Code status
                    if($couponDetails->status==0){
                        return response()->json([
                            'message'=>'Coupon code is not active',
                            'icon'=>'warning',
                            'title'=>'Error',
                        ]);
                    }else{
                        $expiry_date = $couponDetails->expiry_date;
                        $current_date = date('Y-m-d');
                        if($expiry_date < $current_date){
                            return response()->json([
                                'message'=>'Coupon Code is Expired!',
                                'icon'=>'warning',
                                'title'=>'Error',
                            ]);
                        }else{
                            if($couponDetails->amount_type=="Free Product"){
                                return response()->json([
                                    'message'=>'Sorry.',
                                    'icon'=>'warning',
                                    'title'=>'Error',
                                ]);
                            }
                            if(Auth::check()){
                                $user_id = Auth::user()->id;
                                $cart_count = Cart::where(['user_id'=>$user_id])->sum('carts.total_price');

                                $product = Product::where(['product_code'=>$data['coupon_code']])->where(['choice'=>'Offer Price'])->count();
                                if($product > 0){
                                    $product = Product::where(['product_code'=>$data['coupon_code']])->where(['choice'=>'Offer Price'])->first();
                                    if(Cart::where(['user_id'=>$user_id])->where(['product_id'=>$product->id])->count() > 0){
                                        $product_check_cart = Cart::where(['user_id'=>$user_id])->where(['product_id'=>$product->id])->first();
                                        if($couponDetails->amount_type=="Fixed"){
                                            $couponAmount = $couponDetails->amount;
                                        }else{
                                            $couponAmount = (int)($product_check_cart->total_price * ($couponDetails->amount/100));
                                        }
                                        Session::put('offer_price',$couponAmount);
                                    }else{
                                        return response()->json([
                                            'message'=>'Current Product Not use Coupon',
                                            'icon'=>'warning',
                                            'title'=>'Error',
                                        ]);
                                    }
                                }else{
                                    if($couponDetails->amount_type=="Fixed"){
                                        $couponAmount = $couponDetails->amount;
                                    }else{
                                        $couponAmount = (int)($total_cart_amount * ($couponDetails->amount/100));
                                    }
                                }
                                Session::put('coupon_amount',$couponAmount);
                                Session::put('coupon_code',$data['coupon_code']);
                                return response()->json([
                                    'message'=>'Coupon Successful',
                                    'icon'=>'success',
                                    'title'=>'Success',
                                    'discount'=>$couponAmount,
                                    'session'=>Session::get('coupon_amount'),
                                    'total_amount'=>$cart_count,
                                ]);
                            }else{
                                $session_id = Session::getId();
                                $cart_count = DB::table('carts')->where(['session_id'=>$session_id])->sum('carts.total_price');
                                $product = Product::where(['product_code'=>$data['coupon_code']])->where(['choice'=>'Offer Price'])->count();
                                if($product > 0){
                                    $product = Product::where(['product_code'=>$data['coupon_code']])->where(['choice'=>'Offer Price'])->first();
                                    $product_check_cart = Cart::where(['user_id'=>$user_id])->where(['product_id'=>$product->id])->first();
                                    if($couponDetails->amount_type=="Fixed"){
                                        $couponAmount = $couponDetails->amount;
                                    }else{
                                        $couponAmount = $product_check_cart->total_price * ($couponDetails->amount/100);
                                    }
                                }else{
                                    if($couponDetails->amount_type=="Fixed"){
                                        $couponAmount = $couponDetails->amount;
                                    }else{
                                        $couponAmount = $total_cart_amount * ($couponDetails->amount/100);
                                    }
                                }
                                if($couponDetails->amount_type=="Fixed"){
                                    $couponAmount = $couponDetails->amount;
                                }else{
                                    $couponAmount = $total_cart_amount * ($couponDetails->amount/100);
                                }
                                Session::put('coupon_amount',$couponAmount);
                                Session::put('coupon_code',$data['coupon_code']);
                                return response()->json([
                                    'message'=>'Coupon Successful',
                                    'icon'=>'success',
                                    'title'=>'Success',
                                    'discount'=>$couponAmount,
                                    'session'=>Session::get('coupon_amount'),
                                    'total_amount'=>$cart_count,
                                ]);
                            }
                            
                        }
                    }
                }
            }
        }
    }
    public function cancel_coupon(){
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $sub_total = Cart::where(['user_id'=>$user_id])->sum('carts.total_price');
            // All Balance Check
            $return_balance = Auth::user()->return_balance;
            if($return_balance > 0){
                $return_balance_first = $return_balance;
            }else{
                $return_balance_first = 0;
            }
            $register_balance_divided = DB::table('setting')->first();
            $register_balance = (Auth::user()->register_balance)/$register_balance_divided->register_balance_divided;
            if($register_balance > 0){
                $register_balance_first = $register_balance_divided->register_balance_divided;
            }else{
                $register_balance_first = 0;
            }
            $cashback_balance =  Auth::user()->cashback_balance;
            if($cashback_balance > 0){
                $cashback_balance_first = $cashback_balance;
            }else{
                $cashback_balance_first = 0;
            }
            $cart_count = $sub_total -($return_balance_first+$register_balance_first+$cashback_balance_first);
            Session::forget('coupon_amount');
            Session::forget('offer_price');
            Session::forget('coupon_code');
            return response()->json([
                'total_amount'=>$cart_count,
                'return_balance'=>$return_balance_first,
                'register_balance'=>$register_balance_first,
                'cashback_balance'=>$cashback_balance_first,
            ]);
        }else{
            $session_id = Session::getId();
            $cart_count = Cart::where(['session_id'=>$session_id])->sum('carts.total_price');
            Session::forget('coupon_amount');
            Session::forget('offer_price');
            Session::forget('coupon_code');
            return response()->json([
                'total_amount'=>$cart_count,
            ]);
        }
    }
}
