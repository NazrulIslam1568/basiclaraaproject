$(document).ready(function(){
    $('#register-phone').keyup(function(){
        if($(this).val().length > 0){
            
        const three_number_get = $(this).val();
        $three_number = three_number_get.slice(0, 3);
        // alert($three_number);
        if($three_number == '013' || $three_number == '016' || $three_number == '017' || $three_number == '018' || $three_number == '015'  || $three_number == '019' || $three_number == '015'   || $three_number == '014'){
            // alert('Correct Number');
            
            // Database Check Your Phone No
                $phone_no = $(this).val();
                if($phone_no.length == 11){
                    $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type:'get',
                        url: '/phone-check/'+$phone_no,
                        success: function(response){
                            $('.phone-no-checked').text(response.message);
                            $('.phone-no-checked').css('color',response.color);
                        },
                        error:function (response){
                            console.log(response);
                        }
                    });
                }else{
                    $('.phone-no-checked').text('Minimum 11 Characters');
                    $('.phone-no-checked').css('color','blue'); 
                }
                
        }else{
            $('.phone-no-checked').text('Invalid Phone Number');
            $('.phone-no-checked').css('color','red');
        }
    }
    });
    $('#confirm_password').keyup(function(){
        $password = $('#password').val();
        if($(this).val().length > 0){
            if($password == $(this).val()){
                $('.password-matched-checked').text('Password Matched');
                $('.password-matched-checked').css('color','green');
            }else{
                $('.password-matched-checked').text('Password Not Matched');
                $('.password-matched-checked').css('color','red');
            }
        }else{
            $('.password-matched-checked').text('');
        }
    });
    $('#password').keyup(function(){
        $password = $('#confirm_password').val();
        if($(this).val().length > 0){
            if($password.length > 0){
                if($password == $(this).val()){
                    $('.password-matched-checked').text('Password Matched');
                    $('.password-matched-checked').css('color','green');
                }else{
                    $('.password-matched-checked').text('Password Not Matched');
                    $('.password-matched-checked').css('color','red');
                }
            }
            
        }else{
            $('.password-matched-checked').text('');
        }
    });

    $('#register_form').submit(function(e){
        e.preventDefault();
        $phone_no = $('#register-phone').val();
        $password = $('#password').val();
        $confirm_password = $('#confirm_password').val();
        $phone_check_text = $('.phone-no-checked').text();
        $message_check_text = $('.password-matched-checked').text();
        if($('.phone-no-checked').text() == 'Invalid Phone Number' || $('.phone-no-checked').text() == 'Minimum 11 Characters'){
            swal({
                title: 'Sorry',
                text: $('.phone-no-checked').text(),
                icon: 'warning',
                button: "Ok",
            });
        }else{
            if($('.password-matched-checked').text() == 'Password Not Matched'){
                swal({
                    title: 'Sorry',
                    text: $('.password-matched-checked').text(),
                    icon: 'warning',
                    button: "Ok",
                });
            }else{
                if($phone_no.length == 11){
                    $('#register-button').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>');
                    $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type:'get',
                        url: '/phone-check/'+$phone_no,
                        success: function(response){
                            if(response.message == 'Phone Number Already Used'){
                                swal({
                                    title: 'Sorry',
                                    text: $('.phone-no-checked').text(),
                                    icon: 'warning',
                                    button: "Ok",
                                });
                                $('#register-button').text('Register');
                            }else{
                                 // Data Insert In Users
                                if($password == $confirm_password){
                                    let addForm = new FormData($('#register_form')[0]);
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                        type:'post',
                                        url: '/register',
                                        data: addForm,
                                        contentType:false,
                                        processData:false,
                                        success: function(response){
                                            $('#register-button').html('Submitted');
                                            if(response.phone_no){
                                                location="/user/phone-verify/"+response.phone_no;
                                            }else{
                                                location="/user/phone-verify";
                                            }
                                        },
                                        error:function (response){
                                            console.log(response);
                                        }
                                    });
                                }   
                            }
                        },
                        error:function (response){
                            console.log(response);
                        }
                    });
                }
            }
        }
    });
    $('#login_form').submit(function(e){
        e.preventDefault();
        $phone_no = $('#login-phone').val();
        if($phone_no.length == 11){
            $('#login-button').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>');
            let addForm = new FormData($('#login_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type:'post',
                url: '/login',
                data: addForm,
                contentType:false,
                processData:false,
                success: function(response){
                    if(response.phone_verify == 0){
                        location="/user/phone-verify";
                    }
                    if(response.phone_verify == 1){
                        location="/";
                    }
                    if(response.phone_verify == 'not_login'){
                        swal({
                            title: 'Sorry',
                            text: 'Phone No & Password Incorrect',
                            icon: 'warning',
                            button: "Ok",
                        });
                    }
                    $('#login-button').text('Login');
                },
                error:function (response){
                    console.log(response);
                }
            });
        };
    });
    $('#login-phone').keyup(function(){
        if($(this).val().length > 0){
            
        const three_number_get = $(this).val();
        $three_number = three_number_get.slice(0, 3);
        // alert($three_number);
        if($three_number == '013' || $three_number == '016' || $three_number == '017' || $three_number == '018' || $three_number == '015'  || $three_number == '019' || $three_number == '015'   || $three_number == '014'){
            // alert('Correct Number');
            
            // Database Check Your Phone No
                $phone_no = $(this).val();
                if($phone_no.length == 11){
                    $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type:'get',
                        url: '/phone-check/'+$phone_no,
                        success: function(response){
                            if(response.message == 'Phone Number Already Used'){
                                $('.phone-no-checked').text('Correct Phone Number');
                                $('.phone-no-checked').css('color','green');
                            }else{
                                $('.phone-no-checked').text('Incorrect Phone Number');
                                $('.phone-no-checked').css('color','red');
                            }
                        },
                        error:function (response){
                            console.log(response);
                        }
                    });
                }else{
                    $('.phone-no-checked').text('Minimum 11 Characters');
                    $('.phone-no-checked').css('color','blue'); 
                }
                
        }else{
            $('.phone-no-checked').text('Invalid Phone Number');
            $('.phone-no-checked').css('color','red');
        }
    }
    });

    // Phone Verify 
    $("#verify_first").on("keyup", function(){
        if($("#verify_first").val().length > 0){
            $("#verify_second").focus();
        }
    });
    $("#verify_second").on("keyup", function(){
        if($("#verify_second").val().length > 0){
            $("#verify_third").focus();
        }
        if($("#verify_second").val().length == 0){
            $("#verify_first").focus();
        }
    });
    $("#verify_third").on("keyup", function(){
        if($("#verify_third").val().length > 0){
            $("#verify_fourth").focus();
        }
        if($("#verify_third").val().length == 0){
            $("#verify_second").focus();
        }
    });
    $("#verify_fourth").on("keyup", function(){
        if($("#verify_fourth").val().length == 0){
            $("#verify_third").focus();
        }
    });
    $("#submit_verify").click(function(e){
        e.preventDefault();
        $verify_first = $("#verify_first").val();
        $verify_second = $("#verify_second").val();
        $verify_third = $("#verify_third").val();
        $verify_fourth = $("#verify_fourth").val();
        // alert($one_input)
        $code = $verify_first + $verify_second + $verify_third + $verify_fourth;
        if($code.length == 4){
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'get',
                url: '/submit-verify/'+$code,
                success: function(response){
                    console.log(response);
                    if(response.message == 'not valid'){
                        swal({
                            title: 'Not Found Verification Code.',
                            text: 'Nimnio Online Shop',
                            icon: 'success',
                            button: "Next",
                        });
                    }else{
                        swal({
                            title: 'Contratulations! Your account has been successfully activated.',
                            text: 'Nimnio Online Shop',
                            icon: 'success',
                            button: "Ok",
                        });
                        location="/login";
                    }

                },
                error:function (response){
                    console.log(response);
                }
            });
        }else{
            swal({
                title: 'Invalid Verification Code',
                // text: 'Success',
                // icon: 'success',
                // button: "Ok",
            });
        }
    });
    $('.profile-image-change').click(function(){
        $('.avatar .profile-update').css({'opacity':1, 'display':'block'});
        $('.avatar .close-icon').css('display','flex');
    });
    $('.avatar .close-icon').click(function(){
        $(this).hide();
        $('.avatar .profile-update').css({'opacity':0, 'display':'none'});
    });
    $('#profile-picture-update').on('change', function () {
        let addForm = new FormData($('#profile-picture-update-form')[0]);
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type:'post',
                url: '/profile-picture-update',
                data: addForm,
                contentType:false,
                processData:false,
                success: function(response){
                    console.log(response);
                    $('.avatar .profile-update').css({'opacity':0, 'display':'none'});
                    $('.avatar .close-icon').hide();
                    $img_url = 'https://nimnio.com/frontend/img/user/'+response.image_link;
                    $('.profile-image-change').attr('src',$img_url);
                },
                error:function (response){
                    console.log(response);
                }
            });
    });
});