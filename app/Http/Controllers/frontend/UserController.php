<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use DB;
use Hash;
use Auth;
use Session;
use App\Models\Cart;

class UserController extends Controller
{
    public function register(Request $request){
        $setting = DB::table('setting')->first();
        $session_id = Session::getId();
        if(Auth::check()){
            return redirect(route('home'));
        }else{
            if($request->ismethod('post')){
                $security_code = mt_rand(2000,9000);
                $data = $request->all();
                $register = new User;
                $register->name = $data['fullname'];
                $register->phone_no = $data['phone'];
                $register->security_code = $security_code;
                $register->password = Hash::make($data['password']);
                $register->register_balance = 0;
                $register->save();

                if(Auth::attempt(['phone_no'=>$data['phone'],'password'=>$data['password']])){
                    Cart::where(['session_id'=>$session_id])->update([
                        'user_id'=>Auth::user()->id,
                    ]);
                    if(Auth::user()->phone_verify == 0){
                        User::where(['phone_no'=>$data['phone']])->update([
                            'security_code'=>$security_code,
                        ]);
                        
                    }
                // StartSend Message Phone
                $main_sms_key_sender_id = DB::table('setting')->first();
                $api_key = $main_sms_key_sender_id->sms_api_key;
                $from = $main_sms_key_sender_id->sms_sender_id;
                $sms = "ভেরিফিকেশন কোড : $security_code. nimnio.com";
                $to = $register->phone_no;

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
                }else{
                    return response()->json([
                        'phone_no'=>$data['phone'],
                    ]);
                }
            }
            return view('frontend.page.register');
        }
    }
    public function phone_check($phone_no){
        $phone_count = DB::table('users')->where(['phone_no'=>$phone_no])->count();
        if($phone_count > 0){
            return response()->json([
                'message'=>'Phone Number Already Used',
                'color'=>'#ed2024',
            ]);
        }else{
            return response()->json([
                'message'=>'Available Phone Number',
                'color'=>'green',
            ]);
        }

    }
    public function login(Request $request){
        $session_id = Session::getId();
        if(Auth::check()){
            return redirect(route('home'));
        }else{
            if($request->ismethod('post')){
                $data = $request->all();
                if(Auth::attempt(['phone_no'=>$data['phone'],'password'=>$data['password']])){
                    Cart::where(['session_id'=>$session_id])->update([
                        'user_id'=>Auth::user()->id,
                    ]);
                    if(Auth::user()->phone_verify == 0){
                        return response()->json([
                            'phone_verify'=>0,
                            'color'=>'green',
                        ]);
                    }
                    return response()->json([
                        'phone_verify'=>1,
                        'color'=>'green',
                    ]);
                }else{
                    return response()->json([
                        'phone_verify'=>'not_login',
                    ]);
                }
            }
            return view('frontend.page.login');
        }

    }
    public function logout(Request $request) {
    Auth::logout();
    return redirect('/login');
    }
}
