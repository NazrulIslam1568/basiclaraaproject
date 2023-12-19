<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\LivechatMessage;
use App\Models\LiveChatUser;
use Carbon\Carbon;
use Image;
use Auth;

// Axios notification
use Illuminate\Http\Response;
use App\Events\UserLiveChat;
use App\Events\AdminLiveChat;
use App\Events\AutoMessageSend;


class ChatController extends Controller
{
    public function user_livechat(){
        $livechat_msg = new LivechatMessage;
        $livechat_msg->user_id = Auth::user()->id;
        $livechat_msg->msg_user_admin = 'user';
        $livechat_msg->msg = 'আমি আপনাদের সাথে কথা বলতে চাচ্ছি।';
        $livechat_msg->user_off = 0;
        $livechat_msg->save();
        $msg = LivechatMessage::where(['user_off'=>1])->where(['user_id'=>Auth::user()->id])->get();
        $sub_hour_first = Carbon::now()->subHour()->format('m/d/Y h:i a');
        return view('frontend.chat.user_livechat')->with(compact('msg','sub_hour_first'));
    }
    public function livechat_message_post(Request $request, $user_id = null){
        // Start User add
        $user_id = Auth::user()->id;
        $live_us = LiveChatUser::where(['user_id'=>$user_id])->delete();
        $livechat_user = new LiveChatUser;
        $livechat_user->user_id = $user_id;
        $livechat_user->save();
        // End User Add
        if($user_id == Auth::user()->id){
            if($request->ismethod('post')){
                $data = $request->all();
                $livechat_msg = new LivechatMessage;
                if(empty($request->hasfile('image')) && $data['msg'] == ''){
    
                }else{
                    $livechat_msg->user_id = $user_id;
                    $livechat_msg->msg_user_admin = 'user';
                    $livechat_msg->msg = $data['msg'];
                    if($request->hasfile('image')){
                        $img_tmp = $request->file('image');
                        if($img_tmp->isvalid()){
                        //image path code
                        $file_name = $img_tmp->getClientOriginalName();
                        $filename = 'livechat_img'.$user_id.'.'.$file_name;
                        $img_name = str_replace(' ','-',$filename);
                        $img_path = 'frontend/img/livechat/'.$img_name;
                        //image resize
                        Image::make($img_tmp)->encode('webp', 90)->save($img_path);
                        $livechat_msg->img = $img_name;
                        }
                    }
                    $livechat_msg->save();
                }
                event(
                    new UserLiveChat(
                        $request->input('user_id'),
                        $livechat_msg->msg_user_admin,
                        $request->input('msg'),
                        $livechat_msg->img
                    )
                );
            }
        }
    }
    public function admin_livechat($user_id = null){
        if(Auth::user()->role_as !== 'Customer'){
            $msg = LiveChatUser::orderBy('id', 'DESC')->get();
            $sub_hour_first = Carbon::now()->subHour()->format('m/d/Y h:i a');
            $user_msg = DB::table('users')->get();
            return view('backend.chat.admin_livechat')->with(compact('msg','sub_hour_first','user_msg'));
        }else{
            return redirect(route('home'));
        }
    }
    public function admin_message_post(Request $request, $user_id = null){
        if($request->ismethod('post')){
            $data = $request->all();
            $livechat_msg = new LivechatMessage;
            if(empty($request->hasfile('image')) && $data['msg'] == ''){

            }else{
                $livechat_msg->user_id = $user_id;
                $livechat_msg->admin_rep_id = Auth::user()->id;
                $livechat_msg->msg_user_admin = 'admin';
                $livechat_msg->msg = $data['msg'];
                if($request->hasfile('image')){
                    $img_tmp = $request->file('image');
                    if($img_tmp->isvalid()){
                    //image path code
                    $file_name = $img_tmp->getClientOriginalName();
                    $filename = 'livechat_img'.$user_id.'.'.$file_name;
                    $img_name = str_replace(' ','-',$filename);
                    $img_path = 'frontend/img/livechat/'.$img_name;
                    //image resize
                    Image::make($img_tmp)->encode('webp', 90)->save($img_path);
                    $livechat_msg->img = $img_name;
                    }
                }
                $livechat_msg->save();
            }
            event(
                new AdminLiveChat(
                    $request->input('user_id'),
                    $livechat_msg->msg_user_admin,
                    $request->input('msg'),
                    $livechat_msg->img
                )
            );
        }
    }
    public function admin_message($user_id=null){
        $user = DB::table('users')->where(['id'=>$user_id])->first();
        if(Auth::user()->role_as !== 'Customer'){
            $msg_text = 'নিমনিও.কম এর পক্ষ থেকে আমি'.' ' .Auth::user()->name.' '. 'আপনাকে স্বাগতম জানাচ্ছি। আপনাকে কিভাবে সহযোগিতা করতে পারি?';
            $msg = LivechatMessage::where(['user_off'=>1])->where(['user_id'=>$user_id])->where(['msg'=>$msg_text])->orderBy('sl', 'DESC')->count();
            // Admin Auto welcome Messages
            if($msg < 1){
                event(
                    new AutoMessageSend(
                        $msg_text,
                        $user_id
                    )
                );
                $livechat_msg = new LivechatMessage;
                $livechat_msg->user_id = $user_id;
                $livechat_msg->msg_user_admin = 'admin';
                $livechat_msg->msg = $msg_text;
                $livechat_msg->save();
            }
            // Admin Auto Message End
            $msg = LivechatMessage::where(['user_id'=>$user_id])->get();
            $sub_hour_first = Carbon::now()->subHour()->format('m/d/Y h:i a');
            return view('backend.chat.admin_message')->with(compact('msg','sub_hour_first','user'));
        }else{
            return redirect(route('home'));
        }
        
    }
    public function welcome_msg($user_id=null){
        $user = DB::table('users')->where(['id'=>$user_id])->first();
        $msg_text = 'নিমনিও.কম এর পক্ষ থেকে আমি'.' ' .$user->name.' '. 'আপনাকে স্বাগতম জানাচ্ছি। আপনাকে কিভাবে সহযোগিতা করতে পারি?';
        event(
            new AutoMessageSend(
                $msg_text,
                $user_id
            )
        );
    }
    public function close_chat_user(){
        LivechatMessage::where(['user_id'=>Auth::user()->id])->update(['user_off'=>0]);
        return redirect(route('home'));
    }
}
