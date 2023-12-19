<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Auth;
use DB;

class OrdersBController extends Controller
{
    public function view_orders(){
        return view('backend.page.orders.view_orders');
    }
    public function confirm_orders(){
        if(Auth::user()->role_as == 'Support' || Auth::user()->role_as == 'Admin'){
            return view('backend.page.orders.confirmed_orders');    
        }else{
            return redirect()->back();
        }
        
    }
    public function order_details_change($order_id=null){
        $orders = Order::where(['id'=>$order_id])->first();
        return view('backend.page.orders.order_details')->with(compact('orders'));
    }
    public function processing_orders(){
        return view('backend.page.orders.processing_orders');
    }
    public function order_status_change(Request $request){
        $main_sms_key_sender_id = DB::table('setting')->first();
        $order_id = $request->order_id;
        $order = Order::where(['id'=>$order_id])->first();
        $user = User::where(['id'=>$order->user_id])->first();
        $code = mt_rand(20000,90000);
        $user_phone = $user->phone_no;
        if($request->order_status == $order->status){

        }else{
            if($request->order_status == 'Confirm'){
                Order::where(['id'=>$order_id])->update([
                    'status'=>$request->order_status,
                    'request_order_date'=>$request->order_deliver_date,
                    'request_order_time_start'=>$request->order_deliver_start,
                    'request_order_time_end'=>$request->order_deliver_end,
                ]);
                // StartSend Message Phone
                $api_key = $main_sms_key_sender_id->sms_api_key;
                $from = $main_sms_key_sender_id->sms_sender_id;
                $to = $user_phone;
                $sms = "অর্ডারটি নিশ্চিত করা হয়েছে। আপনার অর্ডার $request->order_deliver_date তারিখ $request->order_deliver_start হতে $request->order_deliver_end এর মধ্যে দেওয়া হবে। Support from Nimio.com";
    
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
            }
            if($request->order_status=='Pickup'){
                Order::where(['id'=>$order_id])->update([
                    'status'=>$request->order_status,
                    'order_code'=>$code
                ]);
                // StartSend Message Phone
                $api_key = $main_sms_key_sender_id->sms_api_key;
                $from = $main_sms_key_sender_id->sms_sender_id;
                $to = $order->ship_phone;
                $sms = "আপনার অর্ডার পাঠানো হয়েছে। অর্ডার কোড: $code. Nimnio.com";
    
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
            }
            if($request->order_status=='Cancel'){
                User::where(['id'=>$user->id])->update(['register_balance'=> $user->register_balance + $order->register_amount]);
                // StartSend Message Phone
                $api_key = $main_sms_key_sender_id->sms_api_key;
                $from = $main_sms_key_sender_id->sms_sender_id;
                $to = $order->ship_phone;
                $sms = "অর্ডারটি বাতিল করা হয়েছে। nimnio.com";
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
                Order::where(['id'=>$order_id])->update([
                    'status'=>$request->order_status,
                    'order_code'=>$code
                ]);
            }
            if($request->order_status=='Complete'){
                User::where(['id'=>$user->id])->update(['register_balance'=> $user->register_balance + $order->register_amount]);
                // StartSend Message Phone
                $api_key = $main_sms_key_sender_id->sms_api_key;
                $from = $main_sms_key_sender_id->sms_sender_id;
                $to = $order->ship_phone;
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
                Order::where(['id'=>$order_id])->update([
                    'status'=>$request->order_status,
                    'order_code'=>$code
                ]);
            }
        }
        return redirect()->back();
    }
    public function complete_orders(){
        return view('backend.page.orders.complete_orders');
    }
    public function order_msg_access($phone_no){
        $setting = DB::table('setting')->first();
        DB::table('setting')->where(['id'=>$setting->id])->update(['order_message'=>$phone_no]);
        return redirect()->back();
    }
}
