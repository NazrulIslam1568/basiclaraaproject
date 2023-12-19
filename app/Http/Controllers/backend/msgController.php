<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\CustomNumber;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;

class msgController extends Controller
{
    public function all_user_send_msg(){
        if(Auth::user()->role_as == 'Support' || Auth::user()->role_as == 'Admin'){
            return view('backend.page.msg.all_user_send_msg');
        }else{
            return redirect('/');
        }
    }
    public function send_sms_post(Request $request){
        if(Auth::user()->role_as == 'Support' || Auth::user()->role_as == 'Admin'){
            if($request->ismethod('post')){
            $data = $request->all();
            if(empty($data['mobile'])){
                return redirect()->back()->with('flash_message_error','Not selected Number');
            }else{
            $mobile_number = implode('', $data['mobile']);
            $arr = str_split($mobile_number, '13');
            $mobiles = implode(",", $arr);
            // print_r($mobiles);die;
            $main_sms_key_sender_id = DB::table('setting')->first();
            $api_key = $main_sms_key_sender_id->sms_api_key;
            $from = $main_sms_key_sender_id->sms_sender_id;
            $sms = $data['send_sms'];
            $url = "https://tpsms.xyz/sms/api?action=send-sms";
            $data= array(
            'api_key'=>"$api_key",
            'from'=>"$from",
            'to'=>"$mobiles",
            'sms'=>"$sms",
            'unicode'=>"1",
            ); // Add parameters in key value
            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch); 
            return redirect()->back()->with('flash_message_success','Message successfully send.');
            }
        }
        }else{
            return redirect('/');
        }
    }
    public function not_order_msg(){
        if(Auth::user()->role_as == 'Support' || Auth::user()->role_as == 'Admin'){
            return view('backend.page.msg.not_order_msg');
        }else{
            return redirect('/');
        }
        
    }
    public function unverified_msg(){
        if(Auth::user()->role_as == 'Support' || Auth::user()->role_as == 'Admin'){
            return view('backend.page.msg.unverified_msg');
        }else{
            return redirect('/');
        }
        
    }
    public function order_account(){
        if(Auth::user()->role_as == 'Support' || Auth::user()->role_as == 'Admin'){
            return view('backend.page.msg.order_account');
        }else{
            return redirect('/');
        }
        
    }
    public function address_not_set_up_account(){
        if(Auth::user()->role_as == 'Support' || Auth::user()->role_as == 'Admin'){
            return view('backend.page.msg.address_not_set_up_account');
        }else{
            return redirect('/');
        }
        
    }
    public function custom_no_add(){
        return view('backend.page.msg.custom_no_add');
    }
    public function custom_no_add_post(Request $request){
        if($request->ismethod('post')){
            $data = $request->all();
            if(mb_strlen($data['phone_no']) == 11){
                $number_check = CustomNumber::where(['phone_no'=>$data['phone_no']])->count();
                if($number_check > 0){
                    $success = 'Error';
                    $msg = 'Number Already Used';
                }else{
                    $number = new CustomNumber;
                    $success = 'success';
                    $msg = 'Success';
                    $number->phone_no = $data['phone_no'];
                    $division_name = Division::where(['division_id'=>$data['division']])->first();
                    $district_name = District::where(['district_id'=>$data['district_name']])->first();
                    $upazila_name = Upazila::where(['upazila_id'=>$data['upazila_name']])->first();
                    if($division_name > 0){
                     $number->division = $division_name->name;   
                    }
                    if($district_name > 0){
                     $number->district_name = $district_name->name;   
                    }
                    if($upazila_name > 0){
                        $number->upazila_name = $upazila_name->name;
                    }
                    $number->details = $data['details'];
                    $number->save();
                    $last_number = DB::getPdo()->lastInsertId();
                    return response()->json([
                        'success'=>$success,
                        'msg'=>$msg,
                        'id'=>$last_number,
                        'phone_no'=>$data['phone_no'],
                        'division'=>$number->division,
                        'district_name'=>$number->district_name,
                        'upazila_name'=>$number->upazila_name,
                        'details'=>$data['details'],
                    ]);
                }
            }else{
                $success = 'Error';
                $msg = 'Please Correct Number Input';
            }
        }
        return response()->json([
            'success'=>$success,
            'msg'=>$msg,
        ]);
    }
}