require('./bootstrap');

$(document).ready(function(){
    $("#all_messages_livechat").animate({ scrollTop: 1000000}, 800);
    $("#admin_messages_livechat").animate({ scrollTop: 1000000}, 800);
    $('#send-message-form').submit(function(e){
        // alert('hlw');
        e.preventDefault();
        $user_id = $('#livechat_user_id').val();
        let addForm = new FormData($('#send-message-form')[0]);
        const options = {
            method: 'post',
            url:'/livechat_post/'+$user_id,
            data: addForm,
        }
        axios(options);
    });
    window.Echo.channel('user-chat').listen('.user_chats', (e) =>{
        $("#all_messages_livechat").animate({ scrollTop: 1000000}, 800);
        $("#admin_messages_livechat").animate({ scrollTop: 1000000}, 800);
        $('#user_msg_input').val('');
        $('#user_img').val('');
        $img = 'https://nimnio.com/frontend/img/livechat/'+e.img;
        if(e.msg && e.img){
            $('#all_messages_livechat.user-'+e.user_id).append(
                '<div class="outgoing_msg">\
                <div class="sent_msg">\
                <p>'+e.msg+'</p>\
                <img src="'+$img+'">\
                </div>\
                </div>\
            ');
            $('#admin_messages_livechat.user-'+e.user_id).append(
                '<div class="incoming_msg">\
                    <div class="received_msg">\
                        <div class="received_withd_msg">\
                        <p>'+e.msg+'</p>\
                        <img src="'+$img+'">\
                    </div>\
                </div>\
            </div>\
            ');
        }else{
            if(e.msg){
                $('#all_messages_livechat.user-'+e.user_id).append(
                    '<div class="outgoing_msg">\
                    <div class="sent_msg">\
                    <p>'+e.msg+'</p>\
                    </div>\
                    </div>\
                ');
                $('#admin_messages_livechat.user-'+e.user_id).append(
                    '<div class="incoming_msg">\
                        <div class="received_msg">\
                            <div class="received_withd_msg">\
                            <p>'+e.msg+'</p>\
                        </div>\
                    </div>\
                </div>\
                ');
            }
            if(e.img){
                $('#all_messages_livechat.user-'+e.user_id).append(
                    '<div class="outgoing_msg">\
                    <div class="sent_msg">\
                    <img src="'+$img+'">\
                    </div>\
                    </div>\
                ');
                $('#admin_messages_livechat.user-'+e.user_id).append(
                    '<div class="incoming_msg">\
                        <div class="received_msg">\
                            <div class="received_withd_msg">\
                            <img src="'+$img+'">\
                        </div>\
                    </div>\
                </div>\
                ');
            }
        }
    });
    $('#admin-message-form').submit(function(e){
        e.preventDefault();
        $user_id = $('#livechat_user_id').val();
        let addForm = new FormData($('#admin-message-form')[0]);
        const options = {
            method: 'post',
            url:'/admin-livechat_post/'+$user_id,
            data: addForm,
        }
        axios(options);
    });
    window.Echo.channel('admin-chat').listen('.admin_chats', (e) =>{
        $("#all_messages_livechat").animate({ scrollTop: 1000000}, 800);
        $("#admin_messages_livechat").animate({ scrollTop: 1000000}, 800);
        $('#admin_msg_input').val('');
        $('#admin_img').val('');
        $img = 'https://nimnio.com/frontend/img/livechat/'+e.img;
        if(e.msg && e.img){
            $('#all_messages_livechat.user-'+e.user_id).append(
                '<div class="incoming_msg">\
                    <div class="received_msg">\
                        <div class="received_withd_msg">\
                        <p>'+e.msg+'</p>\
                        <img src="'+$img+'">\
                    </div>\
                </div>\
            </div>\
            ');
            $('#admin_messages_livechat.user-'+e.user_id).append(
                '<div class="outgoing_msg">\
                <div class="sent_msg">\
                <p>'+e.msg+'</p>\
                <img src="'+$img+'">\
                </div>\
                </div>\
            ');
        }else{
            if(e.msg){
                $('#all_messages_livechat.user-'+e.user_id).append(
                    '<div class="incoming_msg">\
                        <div class="received_msg">\
                            <div class="received_withd_msg">\
                            <p>'+e.msg+'</p>\
                        </div>\
                    </div>\
                </div>\
                ');
                $('#admin_messages_livechat.user-'+e.user_id).append(
                    '<div class="outgoing_msg">\
                    <div class="sent_msg">\
                    <p>'+e.msg+'</p>\
                    </div>\
                    </div>\
                ');
            }
            if(e.img){
                $('#all_messages_livechat.user-'+e.user_id).append(
                    '<div class="incoming_msg">\
                        <div class="received_msg">\
                            <div class="received_withd_msg">\
                            <img src="'+$img+'">\
                        </div>\
                    </div>\
                </div>\
                ');
                $('#admin_messages_livechat.user-'+e.user_id).append(
                    '<div class="outgoing_msg">\
                    <div class="sent_msg">\
                    <img src="'+$img+'">\
                    </div>\
                    </div>\
                ');
            }
        }
    });



    $('#welcome-msg').click(function(){
        $user_id = $(this).attr('user_id');
        alert('hlw');
        const options = {
            method: 'post',
            url:'/welcome-message-send/'+$user_id,
            data:{
                auto_message_send:'username_input',
                msg_ase:'message_input',
            }
        }
        $(this).remove();
        axios(options);
    });
    window.Echo.channel('auto-message-send').listen('.auto-message-send', (e) =>{
        $("#all_messages_livechat").animate({ scrollTop: 1000000}, 800);
        $('#all_messages_livechat.user-'+e.msg_ase).append(
            '<div class="incoming_msg welcome">\
                <div class="received_msg">\
                    <div class="received_withd_msg">\
                    <p>'+e.auto_message_send+'</p>\
                </div>\
            </div>\
        </div>\
        ');
    });
});

