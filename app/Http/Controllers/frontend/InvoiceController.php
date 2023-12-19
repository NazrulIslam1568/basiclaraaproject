<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OrderProduct;
use App\Models\Order;
use Auth;

class InvoiceController extends Controller
{
    public function invoice($id=null){
        $user_id_count = Order::where(['id'=>$id])->where(['user_id'=>Auth::user()->id])->count();
        if($user_id_count > 0){
            $order = Order::where(['id'=>$id])->first();
            $billing_address = User::where(['id'=>$order->user_id])->first();
            $order_products = OrderProduct::where(['order_id'=>$id])->get();
            return view('frontend.page.invoice')->with(compact('id','order','billing_address','order_products'));
        }else{
            return redirect(route('home'));
        }
    }
}
