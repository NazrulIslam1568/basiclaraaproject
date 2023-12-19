<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Admin LiveChat</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
    <style>
        .container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 100%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%;
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
  cursor:pointer;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

 .sent_msg p {
  background: #ed2024;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin-top: 5px; margin-bottom: 5px}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #ed2024;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
    </style>
    <script>
      function AutoRefresh(t){
        setTimeout("location.reload(true);",t);
      }
    </script>
</head>
<body onload="Javascript:AutoRefresh(5000);">
    <div class="container">
        <h3 class=" text-center">Live Chat</h3>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                <div class="headind_srch">
                    <div class="recent_heading">
                    <h4>Recent</h4>
                    </div>
                    <div class="srch_bar">
                    <div class="stylish-input-group">
                        <input type="text" class="search-bar"  placeholder="Search" >
                        <span class="input-group-addon">
                        <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                        </span> </div>
                    </div>
                </div>
                <div class="inbox_chat">
                    @foreach($msg as $key => $user)
                    <?php $msg_check_count = DB::table('livechat_messages')->where(['user_id'=>$user->user_id])->where(['msg_user_admin'=>'user'])->orderBy('sl', 'DESC')->count();
                      $msg_check = DB::table('livechat_messages')->where(['user_id'=>$user->user_id])->where(['msg_user_admin'=>'user'])->orderBy('sl', 'DESC')->first();  
                      $msg_admin_check = DB::table('livechat_messages')->where(['user_id'=>$user->user_id])->where(['msg_user_admin'=>'admin'])->where(['user_off'=>1])->orderBy('sl', 'DESC')->first();
                      $msg_admin_check_count = DB::table('livechat_messages')->where(['user_id'=>$user->user_id])->where(['msg_user_admin'=>'admin'])->where(['user_off'=>1])->orderBy('sl', 'DESC')->count();
                      $msg_user_check = DB::table('users')->where(['id'=>$user->user_id])->first();
                      if($msg_admin_check_count > 0){
                        $msg_admin_check_user = DB::table('users')->where(['id'=>$msg_admin_check->admin_rep_id])->first();
                        $msg_admin_check_user_count = DB::table('users')->where(['id'=>$msg_admin_check->admin_rep_id])->count();
                      }
                    ?>
                    @if($msg_check_count > 0)
                    <a target="_blank" href="{{route('admin_message',$msg_user_check->id)}}">
                        <div class="chat_list @if($key == 0) active_chat @endif " us_id="{{$msg_user_check->id}}">
                            <div class="chat_people">
                                <div class="chat_img"> <img style="width: 70px; height: 70px;" src="{{asset('/frontend/img/user/'.$msg_user_check->image)}}"> </div>
                                <div class="chat_ib">
                                <h5>{{$msg_user_check->name}} || @if($msg_admin_check_count > 0) @if($msg_admin_check_user_count > 0) {{$msg_admin_check_user->name}} is chatting @endif @endif<span class="chat_date">Dec 25</span></h5>
                                <p>{{$msg_check->msg}}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endif
                    @endforeach
                </div>
                </div>
            </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </body>
</html>