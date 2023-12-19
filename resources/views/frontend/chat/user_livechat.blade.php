<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>LiveChat</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
    <style>
        .container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
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
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 5px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #000;
  border-radius: 3px;
  color: #fff;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #000;
  display: block;
  font-size: 14px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 5px;
  width: 100%;
}

 .sent_msg p {
  background: #ed2024;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin-top: 2.5px; margin-bottom: 2.5px}
.incoming_msg{ overflow:hidden; margin-top: 2.5px; margin-bottom: 2.5px}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
  padding-right: 35px;
}

.type_msg {position: relative;}
.msg_send_btn {
  background: #ed2024;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  margin-right:5px;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: calc(100vh - 140px);
  overflow-y: auto;
}
label[for="user_img"]{
    display: inline-block;
    margin-bottom: 0.5rem;
    font-size: 30px;
    font-weight: 800;
    cursor:pointer;
}
    </style>
</head>
<body>
    <div class="container">
        <h3 class="position-relative text-center">Live Nimnio <span style="position:absolute; top: 0; right: 0; cursor:pointer;"><a style="background: #ed2024; color: #fff; font-size: 16px; padding: 5px 10px; border-radius: 10px;" href="{{route('close_chat_user')}}">Close</a></span></h3>
        <div class="messaging">
            <div class="inbox_msg">
                <div class="mesgs">
                <div class="msg_history all_messages_livechat user-{{Auth::user()->id}}" id="all_messages_livechat">
                    <div class="incoming_msg first-msg">
                            <div class="received_msg">
                                <div class="received_withd_msg">
                                <p>দয়া করে অপেক্ষা করুন। খুব দ্রুত আমাদের একজন প্রতিনিধি আপনার সাথে যুক্ত হবেন।</p>
                            </div>
                        </div>
                    </div>
                    @foreach($msg as $key => $msges)
                    @if($key == 0)
                    <span class="time_date text-center"> {{ date('d-m-Y', strtotime($msges->created_at))}}    |    {{ date('g:i a', strtotime($msges->created_at))}}</span>                             
                    @endif
                    @if($msges->msg_user_admin == 'user')
                    <div class="outgoing_msg">
                        <div class="sent_msg">
                            @if(!empty($msges->img))
                            <img src="{{asset('/frontend/img/livechat/'.$msges->img)}}"> 
                            @endif
                            @if(!empty($msges->msg))
                            <p>{{$msges->msg}}</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($msges->msg_user_admin == 'admin')
                    <?php $user = DB::table('users')->where(['id'=>$msges->user_id])->first();?>
                    <div class="incoming_msg @if($key == 1) welcome @endif">
                        <!-- <div class="incoming_msg_img"> <img src="{{asset('/frontend/img/user/'.$user->image)}}" alt="{{$user->name}}"> </div> -->
                            <div class="received_msg">
                                <div class="received_withd_msg">
                                @if(!empty($msges->img))
                                <img src="{{asset('/frontend/img/livechat/'.$msges->img)}}"> 
                                @endif
                                @if(!empty($msges->msg))
                                <p>{{$msges->msg}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="type_msg">
                    <form id="send-message-form">
                        <input type="hidden" name="user_id" id="livechat_user_id" value="{{Auth::user()->id}}">
                        <div class="input_msg_write d-flex">
                            <label for="user_img">+</label>
                            <input style="display:none;" type="file" class="form-control" name="image" id="user_img">
                            <input id="user_msg_input" type="text" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" name="msg" class="write_msg" placeholder="Type a message" />
                            <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="../../../js/app.js"></script>
    </body>
</html>