<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;

use DB;

class testController extends Controller
{
    public function test(){
        // $products = Product::orderBy('total_order', 'DESC')->get();
        // $current_date = Carbon::now()->subMonth();
        
        // $current_month = Order::whereMonth('created_at', '=', 4)->count();
        // $orders = Order::whereYear('created_at', '=', $current_date)->whereMonth('created_at','=',4)->sum('total_amount');

        $revenueMonth = Order::where('created_at', '>=', Carbon::today()->startOfMonth()->subMonth())->sum('total_amount');
        
                echo "<pre>";print_r($revenueMonth);
        // foreach($orders as $order){
        //     if($current_date < $order->created_at->format('m')){
        //         // $order_get = Order::where(['created_at' => $current_date])->sum('total_amount');
        //         echo "<pre>";print_r($order->total_amount);
        //     }
        // }
    }
}
