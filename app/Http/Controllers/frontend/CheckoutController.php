<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;;
use App\Models\OrderProduct;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\BazarName;
use App\Models\ElakaName;

class CheckoutController extends Controller
{
    public function checkout(Request $request){
        $coupon_amount = Session::get('coupon_amount');
        $name = Auth::user()->name;
        $phone = Auth::user()->phone;
        $division = Auth::user()->division;
        $district = Auth::user()->district;
        $upazila = Auth::user()->upazila;
        $detail_address = Auth::user()->detail_address;
        $user_id = Auth::user()->id;
        $all_carts = DB::table('carts')->where(['user_id'=>$user_id])->get();
        $offer_count = DB::table('carts')->where(['user_id'=>$user_id])->where(['offer'=>'offer'])->count();
        $cart_count = DB::table('carts')->where(['user_id'=>$user_id])->sum('carts.total_price');
        if(Session::get('offer_price')){
            $total_amount = $cart_count - $coupon_amount;
            $return_balance_first = 0;
            $register_balance_first = 0;
            $cashback_balance_first = 0;
        }else{
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
            if($offer_count < 1){
                $total_amount = $cart_count - ($coupon_amount+$return_balance_first+$register_balance_first+$cashback_balance_first);  
            }else{
                $total_amount = $cart_count - ($coupon_amount+$return_balance_first+$cashback_balance_first);  
            }
            
        }
        $minimum_amount = DB::table('setting')->first();
        if($cart_count >= $minimum_amount->minimum_amount_order){
            return view('frontend.page.checkout')->with(compact('all_carts','offer_count','cart_count','coupon_amount','total_amount','division','return_balance_first','register_balance_first','cashback_balance_first'));
        }else{
            return redirect()->back();
        }
    }
    public function checkout_post(Request $request){
        $data = $request->all();
        $user_id = Auth::user()->id;
        $main_sms_key_sender_id = DB::table('setting')->first();
        $all_carts = Cart::where(['user_id'=>$user_id])->get();
        $all_cart_count = Cart::where(['user_id'=>$user_id])->count();
        if($all_cart_count == 0){
            return response()->json([
                'title'=>'Error',
                'message'=>'Your Order has been Submitted.',
                'icon'=>'warning',
            ]);
        }
        $offer_count = DB::table('carts')->where(['user_id'=>$user_id])->where(['offer'=>'offer'])->count();
        if($data['division']){
            if($data['district']){
                if($data['upazila']){
                    if($data['bazar_name']){
                        if($data['elaka_name']){
                            if($data['detail_address']){
                                if($request->has('different-address')){
                                    if($data['different-full_name']){
                                        if($data['different-phone_no']){
                                            if($data['different_division']){
                                                if($data['different_district']){
                                                    if($data['different_upazila']){
                                                        if($data['different_bazar_name']){
                                                            if($data['different_elaka_name']){
                                                                if($data['different_detail_address']){
                                                                    if($request->has('cod') || $request->has('Bkash')){
                                                                        // Auth User Update
                                                                        $division_name = Division::where(['division_id'=>$data['division']])->first();
                                                                        $district_name = District::where(['district_id'=>$data['district']])->first();
                                                                        $upazila_name = Upazila::where(['upazila_id'=>$data['upazila']])->first();
                                                                        $bazar_name = BazarName::where(['bazar_name_id'=>$data['bazar_name']])->first();
                                                                        $elaka_name = ElakaName::where(['elaka_name_id'=>$data['elaka_name']])->first();
                                                                        $different_division_name = Division::where(['division_id'=>$data['different_division']])->first();
                                                                        $different_district_name = District::where(['district_id'=>$data['different_district']])->first();
                                                                        $different_upazila_name = Upazila::where(['upazila_id'=>$data['different_upazila']])->first();
                                                                        $different_bazar_name_count = BazarName::where(['bazar_name_id'=>$data['different_bazar_name']])->where(['permission'=>1])->count();
                                                                        if($different_bazar_name_count > 0){
                                                                            $different_bazar_name = BazarName::where(['bazar_name_id'=>$data['different_bazar_name']])->where(['permission'=>1])->first();
                                                                            $different_elaka_name = ElakaName::where(['elaka_name_id'=>$data['different_elaka_name']])->first();
                                                                            if(empty(Auth::user()->division)){
                                                                                $user = User::find($user_id);
                                                                                $user->division = $division_name->name;
                                                                                $user->district = $district_name->name;
                                                                                $user->upazila = $upazila_name->name;
                                                                                $user->bazar_name = $bazar_name->bazar_name;
                                                                                $user->elaka_name = $elaka_name->elaka_name;
                                                                                $user->detail_address = $data['detail_address'];
                                                                                $user->update();
                                                                            }
                                                                            $order = new Order;
                                                                            $register_balance_divided = DB::table('setting')->first();
                                                                            if($offer_count < 1){
                                                                                if(Auth::user()->register_balance >= $register_balance_divided->register_balance_divided){
                                                                                User::where(['id'=>Auth::user()->id])->update(['register_balance'=> Auth::user()->register_balance-$register_balance_divided->register_balance_divided]);
                                                                                $order->register_amount = $register_balance_divided->register_balance_divided;
                                                                                }
                                                                            }
                                                                            $order->user_id = $user_id;
                                                                            $order->sub_amount = $data['sub_total'];
                                                                            $order->discount_amount = Session::get('coupon_amount');
                                                                            $order->discount_code = Session::get('coupon_code');
                                                                            if($request->has('cod')){
                                                                                $order->payment_method = 'COD';
                                                                            }
                                                                            if($request->has('Bkash')){
                                                                                $order->payment_method = 'Bkash';
                                                                            }
                                                                            $delivery_cost = BazarName::where(['bazar_name'=>Auth::user()->bazar_name])->first();
                                                                            $order->total_amount = ($data['sub_total'] - Session::get('coupon_amount'))+$delivery_cost->delivery_cost;
                                                                            $order->delivery_cost =$delivery_cost->delivery_cost;

                                                                            $order->ship_name = $data['different-full_name'];
                                                                            $order->ship_phone = $data['different-phone_no'];
                                                                            $order->ship_division = $different_division_name->name;
                                                                            $order_no = Order::orderBy('id', 'DESC')->first();
                                                                            $order->order_no = '850'.($order_no->id+1);
                                                                            $order->ship_district = $different_district_name->name;
                                                                            $order->ship_upazila = $different_upazila_name->name;
                                                                            $order->ship_bazar_name = $different_bazar_name->bazar_name;
                                                                            $order->ship_elaka_name = $different_elaka_name->elaka_name;
                                                                            $order->ship_detail_address = $data['different_detail_address'];
                                                                            $order->offer_price = Session::get('offer_price');
                                                                            $order->save();
                                                                            if(Session::get('offer_price')){
                                                                                User::where(['id'=>Auth::user()->id])->update(['cashback_pending_balance'=>Session::get('offer_price')]);
                                                                            }
                                                                            foreach($all_carts as $all_cart){
                                                                                $order_product = new OrderProduct;
                                                                                $order_product->user_id = $user_id;
                                                                                $order_id = Order::orderBy('id', 'DESC')->first();
                                                                                $order_product->order_id = $order_id->id;
                                                                                $order_product->product_id = $all_cart->product_id;
                                                                                $order_product->product_quantity = $all_cart->quantity;
                                                                                $order_product->product_name = $all_cart->product_name;
                                                                                $order_product->product_image = $all_cart->product_image;
                                                                                $order_product->product_price = $all_cart->product_price;
                                                                                $order_product->product_weight = $all_cart->product_weight;
                                                                                $order_product->save();
                                                                            }
                                                                            // Offer Product Add
                                                                            $curent_date = date('Y-m-d');
                                                                            $free_product = DB::table('coupons')->where(['amount_type'=>'Free Product'])->where(['status'=>1])->where('expiry_date','>=',$curent_date)->where('amount','>',0)->get();
                                                                            foreach($free_product as $product){
                                                                                $find_product = DB::table('products')->where(['product_code'=>$product->coupon_code])->first();
                                                                                $free_order_product = new OrderProduct;
                                                                                $free_order_product->user_id = $user_id;
                                                                                $free_pr_order_id = Order::orderBy('id', 'DESC')->first();
                                                                                $free_order_product->order_id = $free_pr_order_id->id;
                                                                                $free_order_product->product_id = $find_product->id;
                                                                                $free_order_product->product_quantity = 1;
                                                                                $free_order_product->product_name = $find_product->product_name;
                                                                                $free_order_product->product_image = $find_product->image;
                                                                                $free_order_product->product_price = 0;
                                                                                $free_order_product->product_weight = $find_product->product_weight;
                                                                                $free_order_product->save();
                                                                            }
                                                                            // End Offer Product Add system
                                                                            Session::forget('offer_price');
                                                                            Session::forget('coupon_amount');
                                                                            Session::forget('coupon_code');
                                                                            $all_carts = Cart::where(['user_id'=>$user_id])->delete();
                                                                            $order_id = Order::orderBy('id', 'DESC')->first();
                                                                            // User Message
                                                                            $api_key = $main_sms_key_sender_id->sms_api_key;
                                                                            $to = Auth::user()->phone_no;
                                                                            $from = $main_sms_key_sender_id->sms_sender_id;
                                                                            $sms = "অর্ডার করার জন্য ধন্যবাদ। আপনি $order->total_amount টাকা অর্ডার করেছেন। nimnio.com";
                                
                                                                            $url = "https://tpsms.xyz/sms/api?action=send-sms";
                                
                                                                            $data= array(
                                                                            'api_key'=>"$api_key",
                                                                            'from'=>"$from",
                                                                            'to'=>"+88$to",
                                                                            'sms'=>"$sms",
                                                                            ); // Add parameters in key value
                                                                            $ch = curl_init(); // Initialize cURL
                                                                            curl_setopt($ch, CURLOPT_URL,$url);
                                                                            curl_setopt($ch, CURLOPT_ENCODING, '');
                                                                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                                                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                            $smsresult = curl_exec($ch);
                                                                            // Support Desk Check Message
                                                                            $support_message = DB::table('setting')->first();;
                                                                            $api_key = $main_sms_key_sender_id->sms_api_key;
                                                                            $support_to = $support_message->order_message;
                                                                            $from = $main_sms_key_sender_id->sms_sender_id;
                                                                            $name = Auth::user()->name;
                                                                            $sms = "$name & $to & $order->total_amount টাকা অর্ডার করা হয়েছে।";
                                
                                                                            $url = "https://tpsms.xyz/sms/api?action=send-sms";
                                
                                                                            $data= array(
                                                                            'api_key'=>"$api_key",
                                                                            'from'=>"$from",
                                                                            'to'=>"+88$support_to",
                                                                            'sms'=>"$sms",
                                                                            ); // Add parameters in key value
                                                                            $ch = curl_init(); // Initialize cURL
                                                                            curl_setopt($ch, CURLOPT_URL,$url);
                                                                            curl_setopt($ch, CURLOPT_ENCODING, '');
                                                                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                                                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                            $smsresult = curl_exec($ch);
                                                                            return response()->json([
                                                                                'title'=>'Success',
                                                                                'message'=>'Your Order Successful.',
                                                                                'icon'=>'success',
                                                                                'order_id'=>$order_id->id,
                                                                                'payment_method'=>$order->payment_method
                                                                            ]);
                                                                        }else{
                                                                            return response()->json([
                                                                                'title'=>'Error',
                                                                                'message'=>'Your Area unavailable',
                                                                                'icon'=>'warning',
                                                                            ]);
                                                                        }
                                                                        
                                                                    }else{
                                                                        return response()->json([
                                                                            'title'=>'Error',
                                                                            'message'=>'Please Select Payment Method',
                                                                            'icon'=>'warning',
                                                                        ]);
                                                                    }
                                                                }else{
                                                                    return response()->json([
                                                                        'title'=>'Error',
                                                                        'message'=>'Please input Your Ship Detail Address',
                                                                        'icon'=>'warning',
                                                                    ]);
                                                                }
                                                            }else{
                                                                return response()->json([
                                                                    'title'=>'Error',
                                                                    'message'=>'Please select Your Ship Home Address',
                                                                    'icon'=>'warning',
                                                                ]);
                                                            }
                                                        }else{
                                                            return response()->json([
                                                                'title'=>'Error',
                                                                'message'=>'Please select Your Ship  Nearest Town',
                                                                'icon'=>'warning',
                                                            ]);
                                                        }
                                                    }else{
                                                        return response()->json([
                                                            'title'=>'Error',
                                                            'message'=>'Please select Your Ship  Upazila',
                                                            'icon'=>'warning',
                                                        ]);
                                                    }
                                                }else{
                                                    return response()->json([
                                                        'title'=>'Error',
                                                        'message'=>'Please select Your Ship  District',
                                                        'icon'=>'warning',
                                                    ]);
                                                }
                                            }else{
                                                return response()->json([
                                                    'title'=>'Error',
                                                    'message'=>'Please select Your Ship  Division',
                                                    'icon'=>'warning',
                                                ]);
                                            }
                                        }else{
                                            return response()->json([
                                                'title'=>'Error',
                                                'message'=>'Please Input Your Ship Phone Number',
                                                'icon'=>'warning',
                                            ]);
                                        }
                                    }else{
                                        return response()->json([
                                            'title'=>'Error',
                                            'message'=>'Please Input Your Ship Full Name',
                                            'icon'=>'warning',
                                        ]);
                                    }
                                }
                                if($request->has('same-address')){
                                    if($request->has('Bkash') || $request->has('cod')){
                                        // Auth User Update
                                        if(empty(Auth::user()->division)){
                                            $bazar_name_count = BazarName::where(['bazar_name_id'=>$data['bazar_name']])->where(['permission'=>1])->count();
                                        }else{
                                            $bazar_name_count = BazarName::where(['bazar_name'=>Auth::user()->bazar_name])->where(['permission'=>1])->count();
                                        }
                                        if($bazar_name_count > 0){
                                            $division_name = Division::where(['division_id'=>$data['division']])->first();
                                            $district_name = District::where(['district_id'=>$data['district']])->first();
                                            $upazila_name = Upazila::where(['upazila_id'=>$data['upazila']])->first();
                                            $bazar_name = BazarName::where(['bazar_name_id'=>$data['bazar_name']])->first();
                                            $elaka_name = ElakaName::where(['elaka_name_id'=>$data['elaka_name']])->first();
                                            if(empty(Auth::user()->division)){
                                                $user = User::find($user_id);
                                                $user->division = $division_name->name;
                                                $user->district = $district_name->name;
                                                $user->upazila = $upazila_name->name;
                                                $user->bazar_name = $bazar_name->bazar_name;
                                                $user->elaka_name = $elaka_name->elaka_name;
                                                $user->detail_address = $data['detail_address'];
                                                $user->update();
                                            }
                                            $order = new Order;
                                            $register_balance_divided = DB::table('setting')->first();
                                            if($offer_count < 1){
                                                if(Auth::user()->register_balance >= $register_balance_divided->register_balance_divided){
                                                User::where(['id'=>Auth::user()->id])->update(['register_balance'=> Auth::user()->register_balance-$register_balance_divided->register_balance_divided]);
                                                $order->register_amount = $register_balance_divided->register_balance_divided;
                                                }
                                            }
                                            $order_no = Order::orderBy('id', 'DESC')->first();
                                            $order->order_no = '850'.($order_no->id+1);
                                            $order->user_id = $user_id;
                                            $order->sub_amount = $data['sub_total'];
                                            $order->discount_amount = Session::get('coupon_amount');
                                            $order->discount_code = Session::get('coupon_code');
                                            if($request->has('cod')){
                                                $order->payment_method = 'COD';
                                            }
                                            if($request->has('Bkash')){
                                                $order->payment_method = 'Bkash';
                                            }
                                            $delivery_cost = BazarName::where(['bazar_name'=>Auth::user()->bazar_name])->first();
                                            $order->total_amount = ($data['sub_total'] - Session::get('coupon_amount'))+$delivery_cost->delivery_cost;
                                            $order->delivery_cost =$delivery_cost->delivery_cost;
                                            
                                            $order->ship_name = Auth::user()->name;
                                            $order->ship_phone = Auth::user()->phone_no;
                                            if(empty(Auth::user()->division)){
                                            $order->ship_division = $division_name->name;
                                            $order->ship_district = $district_name->name;
                                            $order->ship_upazila = $upazila_name->name;
                                            $order->ship_bazar_name = $bazar_name->bazar_name;
                                            $order->ship_elaka_name = $elaka_name->elaka_name;
                                            $order->ship_detail_address = $data['detail_address'];
                                            }else{
                                                $order->ship_division = Auth::user()->division;
                                                $order->ship_district = Auth::user()->district;
                                                $order->ship_upazila = Auth::user()->upazila;
                                                $order->ship_bazar_name = Auth::user()->bazar_name;
                                                $order->ship_elaka_name = Auth::user()->elaka_name;
                                                $order->ship_detail_address = Auth::user()->detail_address;
                                            }
                                            $order->offer_price = Session::get('offer_price');
                                            $order->save();
                                            if(Session::get('offer_price')){
                                                User::where(['id'=>Auth::user()->id])->update(['cashback_pending_balance'=>Session::get('offer_price')]);
                                            }
                                            foreach($all_carts as $all_cart){
                                                $order_product = new OrderProduct;
                                                $order_product->user_id = $user_id;
                                                $order_id = Order::orderBy('id', 'DESC')->first();
                                                $order_product->order_id = $order_id->id;
                                                $order_product->product_id = $all_cart->product_id;
                                                $order_product->product_quantity = $all_cart->quantity;
                                                $order_product->product_name = $all_cart->product_name;
                                                $order_product->product_image = $all_cart->product_image;
                                                $order_product->product_price = $all_cart->product_price;
                                                $order_product->product_weight = $all_cart->product_weight;
                                                $order_product->type = $all_cart->type;
                                                $order_product->save();
                                            }
                                            // Offer Product Add
                                            $curent_date = date('Y-m-d');
                                            $free_product = DB::table('coupons')->where(['amount_type'=>'Free Product'])->where(['status'=>1])->where('expiry_date','>=',$curent_date)->where('amount','>',0)->get();
                                            foreach($free_product as $product){
                                                $find_product = DB::table('products')->where(['product_code'=>$product->coupon_code])->first();
                                                $free_order_product = new OrderProduct;
                                                $free_order_product->user_id = $user_id;
                                                $free_pr_order_id = Order::orderBy('id', 'DESC')->first();
                                                $free_order_product->order_id = $free_pr_order_id->id;
                                                $free_order_product->product_id = $find_product->id;
                                                $free_order_product->product_quantity = 1;
                                                $free_order_product->product_name = $find_product->product_name;
                                                $free_order_product->product_image = $find_product->image;
                                                $free_order_product->product_price = 0;
                                                $free_order_product->product_weight = $find_product->product_weight;
                                                $free_order_product->save();
                                            }
                                            // End Offer Product Add system
                                            Session::forget('offer_price');
                                            Session::forget('coupon_amount');
                                            Session::forget('coupon_code');
                                            $all_carts = Cart::where(['user_id'=>$user_id])->delete();
                                            $order_id = Order::orderBy('id', 'DESC')->first();
                                            // User Message
                                            $api_key = $main_sms_key_sender_id->sms_api_key;
                                            $to = Auth::user()->phone_no;
                                            $from = $main_sms_key_sender_id->sms_sender_id;
                                            $sms = "অর্ডার করার জন্য ধন্যবাদ। আপনি $order->total_amount টাকা অর্ডার করেছেন। nimnio.com";

                                            $url = "https://tpsms.xyz/sms/api?action=send-sms";

                                            $data= array(
                                            'api_key'=>"$api_key",
                                            'from'=>"$from",
                                            'to'=>"+88$to",
                                            'sms'=>"$sms",
                                            ); // Add parameters in key value
                                            $ch = curl_init(); // Initialize cURL
                                            curl_setopt($ch, CURLOPT_URL,$url);
                                            curl_setopt($ch, CURLOPT_ENCODING, '');
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            $smsresult = curl_exec($ch);
                                            // Support Desk Check Message
                                            $support_message = DB::table('setting')->first();;
                                            $api_key = $main_sms_key_sender_id->sms_api_key;
                                            $support_to = $support_message->order_message;
                                            $from = $main_sms_key_sender_id->sms_sender_id;
                                            $name = Auth::user()->name;
                                            $sms = "$name & $to & $order->total_amount টাকা অর্ডার করা হয়েছে।";

                                            $url = "https://tpsms.xyz/sms/api?action=send-sms";

                                            $data= array(
                                            'api_key'=>"$api_key",
                                            'from'=>"$from",
                                            'to'=>"+88$support_to",
                                            'sms'=>"$sms",
                                            ); // Add parameters in key value
                                            $ch = curl_init(); // Initialize cURL
                                            curl_setopt($ch, CURLOPT_URL,$url);
                                            curl_setopt($ch, CURLOPT_ENCODING, '');
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            $smsresult = curl_exec($ch);
                                            return response()->json([
                                                'title'=>'Success',
                                                'message'=>'Your Order Successful.',
                                                'icon'=>'success',
                                                'order_id'=>$order_id->id,
                                                'payment_method'=>$order->payment_method
                                            ]);
                                        }else{
                                            return response()->json([
                                                'title'=>'Error',
                                                'message'=>'Your Area unavailable',
                                                'icon'=>'warning',
                                            ]);
                                        }

                                    }else{
                                        return response()->json([
                                            'title'=>'Error',
                                            'message'=>'Please Select Payment Method',
                                            'icon'=>'warning',
                                        ]);
                                    }
                                }
                                // Jodi Kono Address Check Na thake tahole Ai Error Asbe
                                return response()->json([
                                    'title'=>'Error',
                                    'message'=>'Please Select Shipping Address',
                                    'icon'=>'warning',
                                ]);
                            }else{
                                return response()->json([
                                    'title'=>'Error',
                                    'message'=>'Please Select Your Detail Address',
                                    'icon'=>'warning',
                                ]);
                            }
                        }else{
                            return response()->json([
                                'title'=>'Error',
                                'message'=>'Please Select Your Home Address',
                                'icon'=>'warning',
                            ]);
                        }
                    }else{
                        return response()->json([
                            'title'=>'Error',
                            'message'=>'Please Select Your Nearest Address',
                            'icon'=>'warning',
                        ]);
                    }
                }else{
                    return response()->json([
                        'title'=>'Error',
                        'message'=>'Please Select Your Upazila',
                        'icon'=>'warning',
                    ]);
                }
            }else{
                return response()->json([
                    'title'=>'Error',
                    'message'=>'Please Select Your District',
                    'icon'=>'warning',
                ]);
            }
        }else{
            return response()->json([
                'title'=>'Error',
                'message'=>'Please Select Your Division',
                'icon'=>'warning',
            ]);
        }
    }
}