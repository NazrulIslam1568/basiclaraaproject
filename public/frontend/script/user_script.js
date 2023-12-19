$(document).ready(function(){
    $('.change-address').click(function(){
        location="/change-address";
    })
    $('.cancel-address').click(function(){
        location="/user-profile";
    })
    $('.update-address').submit(function(e){
        e.preventDefault();
        $('.update-address-btn').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>');
        let addForm = new FormData($('.update-address')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/update-address',
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                swal({
                    title: response.title,
                    text: response.message,
                    icon: response.icon,
                    button: "Ok",
                });
                if(response.title == 'Success'){
                    if($(location).attr('pathname') == '/change-address'){
                        location="/user-profile";
                    }else{
                        location.reload();
                    }
                }
                $('.update-address-btn').html('Update Password');

            },
            error:function(response){
                console.log(response);
            }
        });
    });
})