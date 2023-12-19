<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function view_users(){
        return view('backend.page.users.view_users');
    }
    public function view_admin(){
        return view('backend.page.users.view_admin');
    }
    public function view_support(){
        return view('backend.page.users.view_support');
    }
    public function view_customer(){
        return view('backend.page.users.view_customer');
    }
    public function user_not_verify(){
        return view('backend.page.users.user_not_verify');
    }
    public function user_details_page($user_id=null){
        $user = User::where(['id'=>$user_id])->first();
        return view('backend.page.users.user_details')->with(compact('user'));
    }
    public function update_role(Request $request){
        User::where(['id'=>$request->user_id])->update(['role_as'=>$request->user_role]);
        return redirect()->back();
    }
    public function update_balance(Request $request){
        $user = User::where(['id'=>$request->user_id])->first();
        $cashback_balance = $request->cashback_balance+$user->cashback_balance;
        $return_balance = $request->return_balance+$user->return_balance;
        $register_balance = $request->register_balance+$user->register_balance;
        User::where(['id'=>$request->user_id])->update([
            'cashback_balance'=>$cashback_balance,
            'return_balance'=>$return_balance,
            'register_balance'=>$register_balance,
        ]);
        return redirect()->back();
    }
    public function user_phone_verify(Request $request){
        User::where(['id'=>$request->user_id])->update(['phone_verify'=>$request->phone_verify]);
        return redirect()->back();
    }
    public function user_not_verify_sms($id=null){
        $code = mt_rand(2000,9000);
        User::where(['id'=>$id])->update(['security_code'=>$code]);
        $user = User::where(['id'=>$id])->first();
        // StartSend Message Phone
        $api_key = "bmF6cnVscGFydmVzMTU2ODpuYXpydWxwYXJ2ZXMxNTY4";
        $to = $user->phone_no;
        $from = "8804445620764";
        $sms = "Your Nimnio Account Not Verified. Verify your account Or Call : 01710-621166. Verification code : $code ";

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
    public function user_account_verify(Request $request){
        User::where(['id'=>$request->user_id])->update(['account_verify'=>$request->account_verify]);
        return redirect()->back();
    }
}
