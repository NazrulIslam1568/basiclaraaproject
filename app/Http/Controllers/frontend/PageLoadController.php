<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Cart;
use Session;

class PageLoadController extends Controller
{
    public function page_load_place_order(){
        $session_id = Session::getId();
        $minimum_amount = DB::table('setting')->first();
        if(Auth::check()){
            $customer_order = Cart::where(['user_id'=>Auth::user()->id])->sum('total_price');
        }else{
            $customer_order = Cart::where(['session_id'=>$session_id])->sum('total_price');
        }
        $minimum_order = $minimum_amount->minimum_amount_order;
        $percent = ($customer_order/$minimum_order)*100;
        return response()->json([
            'percent'=>$percent,
        ]);
    }
}
