<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Auth;

class VerifyController extends Controller
{
    public function phone_verify(){
        if(Auth::check()){
            if(Auth::user()->phone_verify == 1){
                return redirect(route('home'));
            }else{
                return view('frontend.page.phone_verify');
            }
        }else{
            return redirect(route('home'));
        }
    }
    public function phone_verify_not_login($phone_no=null){
        if(User::where(['phone_no'=>$phone_no])->first()){
            if(Auth::check()){
                if(Auth::user()->phone_verify == 1){
                    return redirect(route('home'));
                }else{
                    return view('frontend.page.phone_verify');
                }
            }else{
                return view('frontend.page.phone_verify_not_login')->with(compact('phone_no'));
            }
        }else{
            return redirect(route('home'));
        }

    }
    public function submit_verify($code=null){
        $phone_no = DB::table('users')->where(['security_code'=>$code])->count();
        if($phone_no == 1){
            DB::table('users')->where(['security_code'=>$code])->update([
                'phone_verify'=>'1', 'security_code'=>'',
            ]);
            return response()->json([
                'logged'=>'login',
            ]);
        }else{
            return response()->json([
                'message'=>'not valid',
            ]);
        }
    }
    public function resend_code($phone_no=null){
        $security_code = mt_rand(2000,9000);
        User::where(['phone_no'=>$phone_no])->update(['security_code'=>$security_code]);
        if(Auth::check()){
            $phone = Auth::user()->phone_no;
        }else{
            $phone = $phone_no;
        }
         // StartSend Message Phone
         $main_sms_key_sender_id = DB::table('setting')->first();
        $api_key = $main_sms_key_sender_id->sms_api_key;
        $from = $main_sms_key_sender_id->sms_sender_id;
         $sms = "ভেরিফিকেশন কোড : $security_code. nimnio.com";
         $to=$phone_no;

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
         return redirect()->back();
    }
}
