<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Hash;
use Auth;
use DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class FrogotPassword extends Controller
{
    public function forgot_password(){
        return view('frontend.page.forgot_password');
    }
    public function forgot_password_send($phone_no){
        $phone_check = User::where(['phone_no'=>$phone_no])->count();
        if($phone_check > 0){
            $auto_password = Str::random(6);
            User::where(['phone_no'=>$phone_no])->update(['forgot_password'=>1,'password'=>Hash::make($auto_password)]);
            // StartSend Message Phone
            $main_sms_key_sender_id = DB::table('setting')->first();
            $api_key = $main_sms_key_sender_id->sms_api_key;
            $from = $main_sms_key_sender_id->sms_sender_id;
            $to = $phone_no;
            $sms = "Nimnio Demo Password : $auto_password. Support from Nimnio.";

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
                'phone_no'=>$phone_no,
            ]);
        }else{
            return response()->json([
                'message'=>'Phone no does not exist.',
            ]);
        }
    }
    public function change_password($phone_no){
        $user_check = User::where(['phone_no'=>$phone_no])->first();
        $user_check_count = User::where(['phone_no'=>$phone_no])->count();
        if($user_check_count > 0){
            if(Auth::check()){
                return view('frontend.page.change_password')->with(compact('phone_no'));
            }else{
                if($user_check->forgot_password ==1){
                    return view('frontend.page.change_password')->with(compact('phone_no'));
                }else{
                    return redirect()->back();
                }
            }
        }else{
            return redirect()->back();
        }

    }
    public function change_password_verify(Request $request, $phone_no){
        $user_check = User::where(['phone_no'=>$phone_no])->first();
        $data= $request->all();
        if(Auth::check()){
            if(Auth::user()->forgot_password == 1){
                if(Hash::check($data['demo-password'],Auth::user()->password)){
                    if($data['new-password']==$data['confirm-password']){
                        User::where(['phone_no'=>Auth::user()->phone_no])->update(['password'=>Hash::make($data['new-password'])]);
                        return response()->json([
                            'title'=>'Success',
                            'message'=>'Password successfully change.',
                            'icon'=>'Success',
                        ]);
                    }else{
                        return response()->json([
                            'title'=>'Alert',
                            'message'=>'Password Not Matched.',
                            'icon'=>'danger',
                            'button'=>'warning',
                        ]);
                    }
                }else{
                    return response()->json([
                        'title'=>'Alert',
                        'message'=>'Demo Password Not Defined',
                        'icon'=>'danger',
                        'button'=>'warning',
                    ]);
                }
            }else{
                if(Hash::check($data['current-password'],Auth::user()->password)){
                    if($data['new-password']==$data['confirm-password']){
                        User::where(['phone_no'=>Auth::user()->phone_no])->update(['password'=>Hash::make($data['new-password'])]);
                        return response()->json([
                            'title'=>'Success',
                            'message'=>'Password successfully change.',
                            'icon'=>'success',
                        ]);
                    }else{
                        return response()->json([
                            'title'=>'Alert',
                            'message'=>'Password Not Matched.',
                            'icon'=>'warning',
                        ]);
                    }
                }else{
                    return response()->json([
                        'title'=>'Alert',
                        'message'=>'Current Password Not Defined',
                        'icon'=>'warning',
                    ]);
                }
            }

        }else{
            if(Hash::check($data['demo-password'],$user_check->password)){
                if($data['new-password']==$data['confirm-password']){
                        User::where(['phone_no'=>$phone_no])->update(['forgot_password'=>0,'password'=>Hash::make($data['new-password'])]);
                        return response()->json([
                            'title'=>'Success',
                            'message'=>'Password successfully change.',
                            'icon'=>'success',
                        ]);
                    }else{
                        return response()->json([
                            'title'=>'Alert',
                            'message'=>'Password Not Matched.',
                            'icon'=>'warning',
                        ]);
                    }
            }else{
                return response()->json([
                    'title'=>'Alert',
                    'message'=>'Demo Password Not Defined',
                    'icon'=>'warning',
                ]);
            }
        }

    }
}
