<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Carbon\Carbon;
use Auth;
use DB;

class DeliveryManController extends Controller
{
    public function delivery_confirm_code($order_id=null, $code=null, $name=null){
        $main_sms_key_sender_id = DB::table('setting')->first();
        if(Auth::user()->role_as == 'Admin' || Auth::user()->role_as == 'Support'){
            $code_count = Order::where(['id'=>$order_id])->where(['order_code'=>$code])->count();
            $code_first = Order::where(['id'=>$order_id])->where(['order_code'=>$code])->first();
            if($code_count > 0){
                $product_list = OrderProduct::where(['order_id'=>$order_id])->get();
                foreach($product_list as $product){
                   $product_first = Product::where(['id'=>$product->product_id])->first();
                   $product_total = $product_first->total_order +1;
                   Product::where(['id'=>$product->product_id])->update(['total_order'=>$product_total]);
                }
                $delivery_time = Carbon::now()->format('D, d-m-Y g:i a');
                Order::where(['id'=>$order_id])->where(['order_code'=>$code])->update([
                    'order_code'=>'',
                    'delivery_time'=>$delivery_time,
                    'delivered_name'=>$name,
                    'status'=>'Complete',
                ]);
                // StartSend Message Phone
                $api_key = $main_sms_key_sender_id->sms_api_key;
                $to = $code_first->ship_phone;
                $from = $main_sms_key_sender_id->sms_sender_id;
                $sms = "আপনার অর্ডারটি কমপ্লিট হয়েছে। nimnio.com";
    
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
                return response()->json([
                    'message'=>'Completed',
                ]);
            }else{
                return response()->json([
                    'message'=>'Not Found Code',
                ]);
            }
        }else{
            return redirect()->back();
        }
        
    }
}
