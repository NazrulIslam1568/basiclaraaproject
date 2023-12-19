<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\OrderProduct;
use App\Models\user;


class OrdersController extends Controller
{
    public function orders_history(){
        return view('frontend.partials.orders_history');
    }
    public function order_details_get($order_id=null){
        $order = Order::where(['order_no'=>$order_id])->first();
        $order_date = Carbon::parse($order->created_at)->format('D, d-m-Y g:i a');
        $products = OrderProduct::where(['order_id'=>$order->id])->get();
        return view('frontend.partials.order_details')->with(compact('order','order_date','products'));
    }
}
