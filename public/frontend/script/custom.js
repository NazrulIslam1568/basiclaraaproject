$(document).ready(function(){
        var current = location.pathname;
        $('.menu-left a').each(function(){
            if(current == '/'){
                // alert('hlw');
                $('.menu-left a.main-active').addClass('active');
            }else{
                var $this = $(this);
                if($this.attr('href').indexOf(current) != -1){
                    $this.addClass('active');
                }
            }
        });

        // Ajax Page Load to Place Order Content
        page_load_place_order();
        function page_load_place_order(){
            $.ajax({
                type:'get',
                url:'/page-load-place-order',
                dataType:'json',
                success: function(response){
                    body = $('head');
                    body.append('<style>#main-place-order:before{content: "";background: black;width: '+response.percent+'%;height: 100%;position: absolute;left: 0;top: 0;opacity: 0.3; transition:0.5s}</style>');
                    $('#order_check_verify').val(response.percent);
                    $('#minimum-order-amount-div').hide();
                },
                error:function(response){
                }
            });
        }
        // Product Button to Check
        $(document).on('click','.product-cart-page-plus',function(){
            // alert('hw');
            $cart_id = $(this).attr('cart_id');
            $qty = $('.product_qty_input-'+$cart_id).text()+1;
            $('#cart-item-'+$cart_id).fadeIn(1000).css('background-color','rgba(255, 0, 0, 0.3)');
            var data={
                'product_qty': 8,
            }
            $.ajax({
                type:'get',
                url:'/product-increase-database/'+$cart_id,
                data: data,
                dataType:'json',
                success: function(response){
                    page_load_place_order();
                    $('#cart-item-'+$cart_id+' .cart-quantity').text(response.product_qty);
                    $('#cart-item-'+$cart_id+' .cart-price').text(response.total_price);
                    $('.product_qty_input-'+$cart_id).text(response.product_qty);
                    $('#cart-sub-total').text(response.subtotal_price);
                    $('#cart-item-'+$cart_id).css('background-color','#fff');
                    if($qty > 1){
                        $('#cart-item-'+$cart_id+' .fas.fa-minus').addClass('product-cart-page-minus');
                        $('#cart-item-'+$cart_id+' .fas.fa-minus').css('opacity',1);
                    }
                    $('.not-cart').removeClass('d-flex');
                },
                error:function(response){
                }
            });
        });
        
        $(document).on('click','.product-cart-page-minus',function(){
            $cart_id = $(this).attr('cart_id');
            if($(this).attr('option')=='sidebar'){
                $qty = parseInt($('.sidebar.product_qty_input-'+$cart_id).text())-1;
            }else{
                $qty = parseInt($('.product.product-3 .product_qty_input-'+$cart_id).text())-1;
            }
            $('#cart-item-'+$cart_id).fadeIn(1000).css('background-color','rgba(255, 0, 0, 0.3)');
            if($qty < 1){
                $.ajax({
                    type:'get',
                    url:'/cancel_cart/'+$cart_id,
                    dataType:'json',
                    success: function(response){
                        $('#cart-item-'+$cart_id).remove();
                        $('#cart-all-product .product').remove();
                        $('#small-cart-count').text(response.cart_count);
                        $('#cart-count-all').text(response.cart_count);
                        if(response.cart_count == 0){
                            $('#cart-sub-total').text('0');
                            $('.not-cart').addClass('d-flex');
                        }else{
                            $('#cart-sub-total').text(response.subtotal_price);
                        }
                        if(response.type == 'restaurant'){
                            $('.product-body .product-main.product-id-'+response.product_id).html('<button id="shop-cart-button" product_id ="'+response.product_id+'" class="product-button product-add-cart-button"  type="restaurant" style="width: 100%">Add to Cart</button>');
                            $('#product-details-action').html('<button id="cart-button" class="cart-button btn btn-product btn-cart">Add to cart</button>');
                        }else{
                            $('.product-body .product-main.product-id-'+response.product_id).html('<button id="shop-cart-button" product_id ="'+response.product_id+'" class="product-button product-add-cart-button" style="width: 100%">Add to Cart</button>');
                            $('#product-details-action').html('<button id="cart-button" class="cart-button btn btn-product btn-cart">Add to cart</button>');
                        }
                        $('#cart-item-'+$cart_id).css('background-color','#fff');
                        if(response.cart_count < 2){
                            $('#item_plural').text('Item');
                        }
                        page_load_place_order();
                    },
                    error:function(response){
                    }
                });
            }else{
                var data={
                    'product_qty': $qty,
                }
                $.ajax({
                    type:'get',
                    url:'/product-decrease-database/'+$cart_id,
                    data: data,
                    dataType:'json',
                    success: function(response){
                        $('#cart-item-'+$cart_id+' .cart-quantity').text(response.product_qty);
                        $('#cart-item-'+$cart_id+' .cart-price').text(response.total_price);
                        $('.product_qty_input-'+$cart_id).text(response.product_qty);
                        $('#cart-sub-total').text(response.subtotal_price);
                        $('#cart-item-'+$cart_id).css('background-color','#fff');
                        if($qty < 2){
                            $('#cart-item-'+$cart_id+' .fas.fa-minus').removeClass('product-cart-page-minus');
                            $('#cart-item-'+$cart_id+' .fas.fa-minus').css('opacity',0.5);
                        }
                        page_load_place_order();
                    },
                    error:function(response){
                    }
                }); 
            }
        });


    $('.product-qty-increase').click(function(e){
        if($('#product_ekok').text() == 'gm'){
            $qty = parseInt($('#product_qty_input').val()) + 250;
        }else{
            $qty = parseInt($('#product_qty_input').val()) + 1;
        }
        $('#product_qty_input').val($qty);
    });
    $('.product-qty-decrease').click(function(){
        if($('#product_ekok').text() == 'gm'){
            $qty = parseInt($('#product_qty_input').val()) - 250;
        }else{
            $qty = parseInt($('#product_qty_input').val()) - 1;
        }
        if($('#product_ekok').text() == 'gm'){
            if($qty < 250){
                swal({
                title: "Sorry",
                text: "Minimum quantity "+ $('#product_qty_input').val()+'gm',
                icon: "warning",
                button: 'Ok',
                });
            }else{
                $('#product_qty_input').val($qty);
            }
        }else{
            if($qty < 1){
                swal({
                title: "Sorry",
                text: "Minimum quantity 1",
                icon: "warning",
                button: 'Ok',
                });
            }else{
                $('#product_qty_input').val($qty);
            }
        }
    });
    //-----------------------Cart Button Add Work----------------------//
    $(document).on('click','#cart-button',function(e){
        var data={
                'session_id': $('.user-session-id').val(),
                'user_id': $('.user-id').val(),
                'product_id': $('#product_id').val(),
                'quantity': $('#product_qty_input').val(),
            }
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'get',
            url: '/add_cart',
            data: data,
            datatype:'json',
            success: function(response){
                $('#cart-all-product .product').remove();
                $('#cart-button').remove();
                $('#product-details-action').html(
                    '<span class="d-flex" style="width: 200px">\
                    <div class="cart-plus product-cart-page-plus" cart_id="'+response.cart_id+'" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">\
                        <i class="d-flex align-items-center h-100 fas fa-plus"></i>\
                    </div>\
                    <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"><span class="product_qty_input-'+response.cart_id+'" style="font-size: 14px">'+response.cart_quantity+'</span> in Cart</button>\
                    <div class="cart-plus product-cart-page-minus" cart_id="'+response.cart_id+'" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">\
                        <i class="d-flex align-items-center h-100 fas fa-minus"></i>\
                    </div>\
                </span>'
                    );
                $('.details-filter-row.details-row-size').hide();
                $('.cart-dropdown .dropdown-menu.dropdown-menu-right').css({
                    'visibility':'visible',
                    'opacity': 1,
                });
                $('#small-cart-count').text(response.cart_count+1);
                $('#cart-count-all').text(response.cart_count+1);
                $('#cart-sub-total').text(response.sub_total);
                if(response.cart_count+1 > 1){
                    $('#item_plural').text('Items');
                }
            },
            error:function (response){
            }
        });
    });
    // 
    $(document).on('click','.product-add-cart-button',function(e){
        // alert('hlw');
        $product_id = $(this).attr('product_id');
        $type = $(this).attr('type');
        // alert($type);die();
        $(this).html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>');
        var data={
                'session_id': $('.user-session-id').val(),
                'user_id': $('.user-id').val(),
                'product_id': $('#product_id').val(),
                'quantity': $('#product_qty_input').val(),
                'type':$type,
            };
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'get',
            url: '/add_cart/'+$product_id,
            data: data,
            datatype:'json',
            success: function(response){
                $('.not-cart').removeClass('d-flex');
                $('.product-body .product-main.product-id-'+$product_id).html(
                    '<span class="d-flex">\
                    <div class="cart-plus product-cart-page-plus" cart_id="'+response.cart_id+'" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">\
                        <i class="d-flex align-items-center h-100 fas fa-plus"></i>\
                    </div>\
                    <button class="product-button" style="color: #fff; background:#ed2024; border:2px solid #ed2024; width: 100%;"><span class="product_qty_input-'+response.cart_id+'" style="font-size: 14px">'+response.cart_quantity+'</span> in Cart</button>\
                    <div class="cart-plus product-cart-page-minus" cart_id="'+response.cart_id+'" style="padding: 5px; color: #fff; background: #ed2024; border: 1px solid #000;">\
                        <i class="d-flex align-items-center h-100 fas fa-minus"></i>\
                    </div>\
                </span>'
                    );
                page_load_place_order();
                $('#cart-sidebar').css({
                    "right":0,
                });
                if(response.type == 'restaurant'){
                    $img_url = 'https://nimnio.com/frontend/img/product/'+response.image;
                    $('#cart-all-item').append(
                        '<li id="cart-item-'+response.cart_id+'" class="d-flex restaurant">\
                        <div class="plus-minus-cart">\
                            <i class="product-cart-page-plus fas fa-plus" cart_id="'+response.cart_id+'"></i>\
                            <span class="cart-quantity">'+response.cart_quantity+'</span>\
                            <i class="fas fa-minus cart-sidebar" style="opacity:0.5" cart_id="'+response.cart_id+'"></i>\
                        </div>\
                        <div class="cart-image">\
                            <img src="'+$img_url+'" alt="'+response.product.product_name+'">\
                        </div>\
                        <div class="text-and-price">\
                            <div class="all-details">\
                                <h6>'+response.product.product_name+'</h6>\
                                <div class="price-and-quantity">\
                                    <p>৳ '+response.product.product_price+'/ '+response.product.product_weight+'</p>\
                                </div>\
                                <div class="total-price">\
                                    <h5>৳ <span class="cart-price">'+response.total_price+'</span></h5>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="delete-cart">\
                            <i type="restaurant" cart_id ="'+response.cart_id+'" class="cart-delete far fa-times-circle"></i>\
                        </div>\
                    </li>'
                    );
                }else{
                    $img_url = 'https://nimnio.com/frontend/img/product/'+response.product.image;
                    $('#cart-all-item').append(
                        '<li id="cart-item-'+response.cart_id+'" class="d-flex">\
                        <div class="plus-minus-cart">\
                            <i class="product-cart-page-plus fas fa-plus" cart_id="'+response.cart_id+'"></i>\
                            <span class="cart-quantity">'+response.cart_quantity+'</span>\
                            <i class="fas fa-minus cart-sidebar" style="opacity:0.5" cart_id="'+response.cart_id+'"></i>\
                        </div>\
                        <div class="cart-image">\
                            <img src="'+$img_url+'" alt="'+response.product.product_name+'">\
                        </div>\
                        <div class="text-and-price">\
                            <div class="all-details">\
                                <h6>'+response.product.product_name+'</h6>\
                                <div class="price-and-quantity">\
                                    <p>৳ '+response.product.product_price+'/ '+response.product.product_weight+'</p>\
                                </div>\
                                <div class="total-price">\
                                    <h5>৳ <span class="cart-price">'+response.total_price+'</span></h5>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="delete-cart">\
                            <i cart_id ="'+response.cart_id+'" class="cart-delete far fa-times-circle"></i>\
                        </div>\
                    </li>'
                    );
                }
                // Cart Add Product
                $('#small-cart-count').text(response.cart_count+1);
                $('#cart-count-all').text(response.cart_count+1);
                $('#cart-sub-total').text(response.sub_total);
                if(response.cart_count+1 > 1){
                    $('#item_plural').text('Items');
                }
            },
            error:function (response){
            }
        });
    });
    $('#cart-close-popup').click(function(){
        $('.cart-dropdown .dropdown-menu.dropdown-menu-right').css({
            'visibility':'hidden',
            'opacity': 0,
        });
    });
    $('.dropdown-toggle#cart-icon').click(function(){
        $('.cart-dropdown .dropdown-menu.dropdown-menu-right').css({
            'visibility':'visible',
            'opacity': 1,
        });
    });
    function view_cart_ajax(){
        $.ajax({
            type:'get',
            url:'/view-cart-ajax',
            dataType:'json',
            success: function(response){
                $.each(response.carts, function(key, item){
                    $('#subtotal_cart').text(response.total_price);
                    $('#cart_coupon_get').val(response.total_price);
                    $('#cart-page-subtotal').text(response.total_price);
                    $('#cart-page-total').text(response.total_price - response.session);
                    $img_url = 'https://nimnio.com/frontend/img/product/'+item.product_image;
                    $product_url = 'http://'+document.location.host+'/single_product/'+item.product_url;
                    $('#cart-all-product').append(
                    '<div class="product">\
                    <div class="product-cart-details">\
                        <h4 class="product-title">\
                            <a href="'+$product_url+'" target="_blank">'+item.product_name+'</a>\
                        </h4>\
                        <span class="cart-product-info">\
                            <span class="cart-product-qty">'+item.quantity+'</span>\
                            x '+item.product_price+' = ৳ '+item.total_price+'\
                        </span>\
                    </div>\
                    <figure class="product-image-container">\
                        <a href="'+$product_url+'" target="_blank" class="product-image" target="_blank">\
                            <img src="'+$img_url+'" alt="product">\
                        </a>\
                    </figure>\
                    <button href="#" class="btn-remove" cart_id="'+item.id+'" id="cart-delete"  title="Remove Product"><i class="icon-close"></i></button>\
                </div>'
                    )
                });
            },
            error:function(response){
            }
        });
    }
    $(document).on('click','.cart-delete',function(e){
        $cart_id =$(this).attr('cart_id');
        $type = $(this).attr('type');
        // alert($type);die();
        $('#cart-item-'+$cart_id).fadeIn(1000).css('background-color','rgba(255, 0, 0, 0.3)');
        $.ajax({
            type:'get',
            url:'/cancel_cart/'+$cart_id,
            dataType:'json',
            success: function(response){
                $('#cart-item-'+$cart_id).remove();
                $('#cart-all-product .product').remove();
                $('#small-cart-count').text(response.cart_count);
                $('#cart-count-all').text(response.cart_count);
                if(response.cart_count == 0){
                    $('#cart-sub-total').text('0');
                    $('.not-cart').addClass('d-flex');
                }else{
                    $('#cart-sub-total').text(response.subtotal_price);
                }
                if($type == 'restaurant'){
                    $('.product-body .product-main.product-id-'+response.product_id).html('<button id="shop-cart-button" product_id ="'+response.product_id+'" class="product-button product-add-cart-button"  type="restaurant" style="width: 100%">Add to Cart</button>');
                    $('#product-details-action').html('<button id="cart-button" class="cart-button btn btn-product btn-cart">Add to cart</button>');
                }else{
                    $('.product-body .product-main.product-id-'+response.product_id).html('<button id="shop-cart-button" product_id ="'+response.product_id+'" class="product-button product-add-cart-button" style="width: 100%">Add to Cart</button>');
                    $('#product-details-action').html('<button id="cart-button" class="cart-button btn btn-product btn-cart">Add to cart</button>');
                }
                $('#cart-item-'+$cart_id).css('background-color','#fff');
                if(response.cart_count < 2){
                    $('#item_plural').text('Item');
                }
                page_load_place_order();
            },
            error:function(response){
            }
        });
    });

    // Apply Coupon
    $('#apply_coupon').submit(function(e){
        e.preventDefault();
        // alert('hlw');
        let addForm = new FormData($('#apply_coupon')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/apply-coupon',
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                if(response.session){
                    $('#cancel_coupon').show();
                }
                if(response.message == 'Coupon Successful'){
                    $('.cart-page-discount-div').css('display','table-row');
                    $('#cart-page-total').text(response.total_amount - response.session);
                    $('#cart-page-discount').text(response.session);
                    $('.checkout__order__subtotal.discount').css('display','block');
                    $('.checkout__order__subtotal.return').css('display','none');
                    $('.checkout__order__subtotal.register').css('display','none');
                    $('.checkout__order__subtotal.cashback').css('display','none');
                }
                $('#apply_coupon_input').val('');
                swal({
                    title: response.title,
                    text: response.message,
                    icon: response.icon,
                    button: "Ok",
                });
            },
            error:function (response){
            }
        });
        });
        // Cancel Coupon
        $('#cancel_coupon').click(function(e){
            e.preventDefault();
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type:'post',
                    url: '/cancel-session',
                    success: function(response){
                        $('.cart-page-discount-div').css('display','none');
                        $('#cart-page-total').text(response.total_amount);
                        $('.checkout__order__subtotal.discount').css('display','none');
                        swal({
                            title: 'Your Discount has been Deleted!',
                            text: 'Success',
                            icon: 'success',
                            button: "Ok",
                        });
                        if(response.return_balance > 0){
                            $('#cart-page-return').text(response.return_balance);
                            $('.checkout__order__subtotal.return').css('display','block');
                        }
                        if(response.register_balance > 0){
                            $('#cart-page-register').text(response.register_balance);
                            $('.checkout__order__subtotal.register').css('display','block');
                        }
                        if(response.cashback_balance > 0){
                            $('#cart-page-cashback').text(response.cashback_balance);
                            $('.checkout__order__subtotal.cashback').css('display','block');
                        }
                        $('#cancel_coupon').hide();
                    },
                    error:function (response){
                    }
            });
        });
    //-----------------------End Cart Button Add Work----------------------//

    //-------- Start Cart Page to Database Increase & decrease ------------//
    $('.product-cart-page-increase').click(function(e){
        $cart_id = $(this).attr('cart_id');
        $qty = parseInt($('#product_qty_input.cart-'+$cart_id).val()) + 1;
        var data={
            'product_qty': $qty,
        }
        $.ajax({
            type:'get',
            url:'/product-increase-database/'+$cart_id,
            data: data,
            dataType:'json',
            success: function(response){
                $('#product_qty_input.cart-'+$cart_id).val(response.product_qty);
                $('#cart-page-product-price-'+$cart_id).text(response.total_price);
                $('#cart-all-product .product').remove();
            },
            error:function(response){
            }
        });
    });

    $('.product-cart-page-decrease').click(function(e){
        $cart_id = $(this).attr('cart_id');
        $qty = parseInt($('#product_qty_input.cart-'+$cart_id).val()) - 1;
        if($qty < 1){
            swal({
            title: "Sorry",
            text: "Minimum quantity 1",
            icon: "warning",
            button: 'Ok',
            });
        }else{
            var data={
                'product_qty': $qty,
            }
            $.ajax({
                type:'get',
                url:'/product-decrease-database/'+$cart_id,
                data: data,
                dataType:'json',
                success: function(response){
                    $('#product_qty_input.cart-'+$cart_id).val(response.product_qty);
                    $('#cart-page-product-price-'+$cart_id).text(response.total_price);
                    $('#cart-all-product .product').remove();
                    
                    
                },
                error:function(response){
                }
            }); 
        }
    });



    $('.productrt-page-decrease').click(function(){
        $qty = parseInt($('#product_qty_input').val()) - 1;
        if($qty < 1){
            swal({
            title: "Sorry",
            text: "Minimum quantity 1",
            icon: "warning",
            button: 'Ok',
            });
        }else{
            $('#product_qty_input').val($qty);
        }
    });
    //-------- End Cart Page to Database Increase & decrease ------------//
    
    // ----------------- Checkout Page--------------- script--------------//

    // District Dropdown
    $(document).on('change','.nim-division',function(e){
        $('#nim-district option').remove();
        $district_id = $(this).val();
        $.ajax({
                type:'get',
                url:'/all-district-view/'+$district_id,
                dataType:'json',
                success: function(response){
                    $('.checkout__input.district').show();
                    $('#nim-district').append(
                        '<option value="0">Select Your District</option>'
                    )
                    $.each(response.districts, function(key, item){
                        $('#nim-district').append(
                            '<option value="'+item.district_id+'">'+item.name+'</option>');
                    });
                },
                error:function(response){
                }
            });
    });
    $(document).on('change','#nim-district',function(e){
        $('#nim-upazila option').remove();
        $upazila_id = $(this).val();
        $.ajax({
            type:'get',
            url:'/all-upazila-view/'+$upazila_id,
            dataType:'json',
            success: function(response){
                $('.checkout__input.upazila').show();
                $('#nim-upazila').append(
                    '<option value="0">Select Your Upazila</option>'
                )
                $.each(response.upazilas, function(key, item){
                    $('#nim-upazila').append(
                        '<option value="'+item.upazila_id+'">'+item.name+'</option>');
                });
            },
            error:function(response){
            }
        });
    });
    $(document).on('change','#nim-upazila',function(e){
        $bazar_name_id = $(this).val();
        $('#nim-bazar_name option').remove();
        $.ajax({
            type:'get',
            url:'/all-bazar_name-view/'+$bazar_name_id,
            dataType:'json',
            success: function(response){
                $('.checkout__input.bazar_name').show();
                $('#nim-bazar_name').append(
                    '<option value="0">Select Your Nearest Town</option>'
                )
                $.each(response.bazar_names, function(key, item){
                    $('#nim-bazar_name').append(
                        '<option value="'+item.bazar_name_id+'">'+item.bazar_name+'</option>');
                });
            },
            error:function(response){
            }
        });
    });
    $(document).on('change','#nim-bazar_name',function(e){
        $elaka_name_id = $(this).val();
        $('#nim-elaka_name option').remove();
        $.ajax({
            type:'get',
            url:'/all-elaka_name-view/'+$elaka_name_id,
            dataType:'json',
            success: function(response){
                $('.checkout__input.elaka_name').show();
                $('#nim-elaka_name').append(
                    '<option value="0">Select Your Home Address</option>'
                )
                $.each(response.elaka_names, function(key, item){
                    $('#nim-elaka_name').append(
                        '<option value="'+item.elaka_name_id+'">'+item.elaka_name+'</option>');
                });
            },
            error:function(response){
            }
        });
    });
    $(document).on('change','#nim-elaka_name',function(e){
        $('.checkout__input.detail_address').show();
    });

    // Different Address Div
    $(document).on('change','.nim-different-division',function(e){
        $('#nim-different-district option').remove();
        $district_id = $(this).val();
        $.ajax({
                type:'get',
                url:'/all-district-view/'+$district_id,
                dataType:'json',
                success: function(response){
                    $('.checkout__input.different-district').show();
                    $('#nim-different-district').append(
                        '<option value="0">Select Your District</option>'
                    )
                    $.each(response.districts, function(key, item){
                        $('#nim-different-district').append(
                            '<option value="'+item.district_id+'">'+item.name+'</option>');
                    });
                },
                error:function(response){
                }
            });
    });
    $(document).on('change','#nim-different-district',function(e){
        $('#nim-different-upazila option').remove();
        $upazila_id = $(this).val();
        $.ajax({
            type:'get',
            url:'/all-upazila-view/'+$upazila_id,
            dataType:'json',
            success: function(response){
                $('.checkout__input.different-upazila').show();
                $('#nim-different-upazila').append(
                    '<option value="0">Select Your Upazila</option>'
                )
                $.each(response.upazilas, function(key, item){
                    $('#nim-different-upazila').append(
                        '<option value="'+item.upazila_id+'">'+item.name+'</option>');
                });
            },
            error:function(response){
            }
        });
    });
    $(document).on('change','#nim-different-upazila',function(e){
        $bazar_name_id = $(this).val();
        $('#nim-different-bazar_name option').remove();
        $.ajax({
            type:'get',
            url:'/all-bazar_name-view/'+$bazar_name_id,
            dataType:'json',
            success: function(response){
                $('.checkout__input.different-bazar_name').show();
                $('#nim-different-bazar_name').append(
                    '<option value="0">Select Your Home Address</option>'
                )
                $.each(response.bazar_names, function(key, item){
                    $('#nim-different-bazar_name').append(
                        '<option value="'+item.bazar_name_id+'">'+item.bazar_name+'</option>');
                });
            },
            error:function(response){
            }
        });
    });
    $(document).on('change','#nim-different-bazar_name',function(e){
        $elaka_name_id = $(this).val();
        $('#nim-different-elaka_name option').remove();
        $.ajax({
            type:'get',
            url:'/all-elaka_name-view/'+$elaka_name_id,
            dataType:'json',
            success: function(response){
                $('.checkout__input.different-elaka_name').show();
                $('#nim-different-elaka_name').append(
                    '<option value="0">Select Your Nearest Town</option>'
                )
                $.each(response.elaka_names, function(key, item){
                    $('#nim-different-elaka_name').append(
                        '<option value="'+item.elaka_name_id+'">'+item.elaka_name+'</option>');
                });
            },
            error:function(response){
            }
        });
    });
                // Same Address CHeckout Page

    $('#same-address').click(function(){
        $('#different-address').prop('checked', false);
        $('.checkout-different-address').hide();
        $('.checkout__input.different-elaka_name').hide();
        $('.checkout__input.different-bazar_name').hide();
        $('.checkout__input.different-upazila').hide();
        $('.checkout__input.different-district').hide();
        $('.checkout__input.different-detail_address').hide();
        $('.checkout__input.different input').attr("required", false);
    });
    $('#different-address').click(function(){
        $('#same-address').prop('checked', false);
        if($(this).prop('checked') == true){
            $('.checkout-different-address').show();
            $('.checkout__input.different-detail_address').show();
            $('.checkout__input.different input').attr("required", "true");
        }else{
            $('.checkout-different-address').hide();
            $('.checkout__input.different-detail_address').hide();
            $('.checkout__input.different input').attr("required", false);
        }
    });
    $(document).on('change','#nim-different-elaka_name',function(e){
        $('.checkout__input.different-detail_address').show();
    });
    $('.payment-method-checkout#cod').click(function(){
        $('.payment-method-checkout#Bkash').prop('checked', false);
        $('.payment-method-checkout#cod').prop('checked', true);
    });
    $('.payment-method-checkout#Bkash').click(function(){
        $('.payment-method-checkout#cod').prop('checked', false);
        $('.payment-method-checkout#Bkash').prop('checked', true);
    });
    // Checkout Page Submit Order
    $('#checkout-button-form').submit(function(e){
        e.preventDefault();
        $('#checkout-button').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>');
        let addForm = new FormData($('#checkout-button-form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/checkout-post',
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                $('#checkout-button').html('PLACE ORDER');
                swal({
                    title: response.title,
                    text: response.message,
                    icon: response.icon,
                    button: "Ok",
                });
                if(response.payment_method == "Bkash"){
                    location="https://shop.bkash.com/nimnio01710621166/paymentlink/default-payment"
                }
                if(response.payment_method == "COD"){
                    location="/";
                }
            },
            error:function (response){
            }
        });
    });
    // Search Product 
    $(".category_product_search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#category_product_view .col-6.col-md-4.col-lg-2").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
        // alert(value);
        if(value.length < 1){
            $('#search_span').hide();
        }else{
            $('#search_span').show();
        }
        $('#search_span #search_result').text(value);
        var $div = ($("#category_product_view .col-6.col-md-4.col-lg-2").filter(function() {
            return $(this).css('display') !== 'none';
        }).length);
        if($div < 1){
            $('#category_product_view h4.no-product').removeClass('d-none');
        }else{
            $('#category_product_view h4.no-product').addClass('d-none');
        }
    });
    $(".sub_category_search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#sub_category_view .col-6.col-sm-4.col-lg-2").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
        if(value.length < 1){
            $('#search_span').hide();
        }else{
            $('#search_span').show();
        }
        $('#search_span #search_result').text(value);
        var $div = ($("#sub_category_view .col-6.col-sm-4.col-lg-2").filter(function() {
            return $(this).css('display') !== 'none';
        }).length);
        if($div < 1){
            $('#sub_category_view h4.no-product').removeClass('d-none');
        }else{
            $('#sub_category_view h4.no-product').addClass('d-none');
        }
    });

    $('.carousesl-bottom-icon').click(function(){
        $('#carouselExampleIndicators .carousel-indicators li').removeClass('active');
        $('#carouselExampleIndicators .carousel-inner div').removeClass('active');
        $(this).addClass('active');
        $slide_no = $(this).attr('data-to');
        // alert($slide_no);
        $('#carouselExampleIndicators .carousel-inner .carousel-item.'+$slide_no).addClass('active');
    });
    $('.carousel-control-next').click(function(){
        $('#carouselExampleIndicators .carousel-indicators').find('.carousesl-bottom-icon.active').next().addClass('active');
        $('#carouselExampleIndicators .carousel-indicators').find('.carousesl-bottom-icon.active').prev().removeClass('active');
        $('#carouselExampleIndicators .carousel-inner').find('.carousel-item.active').next().addClass('active');
        $('#carouselExampleIndicators .carousel-inner').find('.carousel-item.active').prev().removeClass('active');
    });
    $('.carousel-control-prev').click(function(){
        $('#carouselExampleIndicators .carousel-indicators').find('.carousesl-bottom-icon.active').prev().addClass('active');
        $('#carouselExampleIndicators .carousel-indicators').find('.carousesl-bottom-icon.active').next().removeClass('active');
        $('#carouselExampleIndicators .carousel-inner').find('.carousel-item.active').prev().addClass('active');
        $('#carouselExampleIndicators .carousel-inner').find('.carousel-item.active').next().removeClass('active');
    });


    $(".home-slider").lightSlider({
        item: 1,
        autoWidth: false,
        slideMove: 1, // slidemove will be 1 if loop is true
        slideMargin: 10,
 
        addClass: '',
        mode: "slide",
        useCSS: true,
        cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
        easing: 'linear', //'for jquery animation',////
 
        speed: 400, //ms'
        auto: true,
        loop: true,
        slideEndAnimation: true,
        pause: 2000,
 
        keyPress: false,
        controls: false,
        prevHtml: '',
        nextHtml: '',
 
        rtl:false,
        adaptiveHeight:false,
 
        vertical:false,
        verticalHeight:500,
        vThumbWidth:100,
 
        thumbItem:10,
        pager: true,
        gallery: false,
        galleryMargin: 5,
        thumbMargin: 5,
        currentPagerPosition: 'middle',
 
        enableTouch:true,
        enableDrag:true,
        freeMove:true,
        swipeThreshold: 40,
 
        responsive : [
            {
                breakpoint: 800,
                settings: {
                    item: 1,
                    slideMove: 1,
                    slideMargin: 6,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    item: 1,
                    slideMove: 1,
                }
            }
        ],
 
        onBeforeStart: function (el) {},
        onSliderLoad: function (el) {},
        onBeforeSlide: function (el) {},
        onAfterSlide: function (el) {},
        onBeforeNextSlide: function (el) {},
        onBeforePrevSlide: function (el) {}
    });
    $(".restaurant-slider").lightSlider({
        item: 5,
        autoWidth: false,
        slideMove: 1, // slidemove will be 1 if loop is true
        slideMargin: 100,
 
        addClass: '',
        mode: "slide",
        useCSS: true,
        cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
        easing: 'linear', //'for jquery animation',////
 
        speed: 600, //ms'
        auto: true,
        loop: true,
        slideEndAnimation: true,
        pause: 2000,
 
        keyPress: false,
        controls: false,
        prevHtml: '',
        nextHtml: '',
 
        rtl:false,
        adaptiveHeight:false,
 
        vertical:false,
        verticalHeight:500,
        vThumbWidth:100,
 
        thumbItem:10,
        pager: true,
        gallery: false,
        galleryMargin: 5,
        thumbMargin: 5,
        currentPagerPosition: 'middle',
 
        enableTouch:true,
        enableDrag:true,
        freeMove:true,
        swipeThreshold: 40,
 
        responsive : [
            {
                breakpoint: 800,
                settings: {
                    item: 3,
                    slideMove: 1,
                    slideMargin: 20,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    item: 2,
                    slideMove: 1,
                }
            }
        ],
 
        onBeforeStart: function (el) {},
        onSliderLoad: function (el) {},
        onBeforeSlide: function (el) {},
        onAfterSlide: function (el) {},
        onBeforeNextSlide: function (el) {},
        onBeforePrevSlide: function (el) {}
    });
    $(".sub-category-slider").lightSlider({
        item: 6,
        autoWidth: false,
        slideMove: 1, // slidemove will be 1 if loop is true
        slideMargin: 100,
 
        addClass: '',
        mode: "slide",
        useCSS: true,
        cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
        easing: 'linear', //'for jquery animation',////
 
        speed: 600, //ms'
        auto: false,
        loop: false,
        slideEndAnimation: true,
        pause: 2000,
 
        keyPress: false,
        controls: false,
        prevHtml: '',
        nextHtml: '',
 
        rtl:false,
        adaptiveHeight:false,
 
        vertical:false,
        verticalHeight:500,
        vThumbWidth:100,
 
        thumbItem:10,
        pager: true,
        gallery: false,
        galleryMargin: 5,
        thumbMargin: 5,
        currentPagerPosition: 'middle',
 
        enableTouch:true,
        enableDrag:true,
        freeMove:true,
        swipeThreshold: 40,
 
        responsive : [
            {
                breakpoint: 800,
                settings: {
                    item: 3,
                    slideMove: 1,
                    slideMargin: 20,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    item: 2,
                    slideMove: 1,
                }
            }
        ],
 
        onBeforeStart: function (el) {},
        onSliderLoad: function (el) {},
        onBeforeSlide: function (el) {},
        onAfterSlide: function (el) {},
        onBeforeNextSlide: function (el) {},
        onBeforePrevSlide: function (el) {}
    });
    $('#cart-sidebar .close-cart').click(function(){
        $('#cart-sidebar').css({
            "right":"-450px",
        });
    });
    $('#cart-icon').click(function(){
        $('#cart-sidebar').css({
            "right":0,
        });
    });
    // Submit Checkout
    $('#main-place-order').click(function(){
        if($('#order_check_verify').val() > 100-0.1){
            location="/checkout";
        }else{
            $('#minimum-order-amount-div').show();
        }
    });
    $('#forgot-password').submit(function(e){
        e.preventDefault();
        $('.phone-no-checked').text('');
        const three_number_get = $('#forgot-password-phone').val();
        $three_number = three_number_get.slice(0, 3);
        if($three_number == '013' || $three_number == '016' || $three_number == '017' || $three_number == '018' || $three_number == '015'  || $three_number == '019'    || $three_number == '014'){
            if(three_number_get.length == 11){
                $.ajax({
                    type:'get',
                    url:'/forgot-password-send/'+three_number_get,
                    dataType:'json',
                    success: function(response){
                        if(response.message == 'Phone no does not exist.'){
                            $('.phone-no-checked').text(response.message);
                        }else{
                            location="/user/change-password/"+three_number_get;
                        }
                    },
                    error:function(response){
                    }
                });
            }else{
                $('.phone-no-checked').text('Phone Number 11 characters.');
            }
        }else{
            $('.phone-no-checked').text('Phone Number Incorrect.');
        }
    });
    $('.password-hide-show').click(function(){
        $input = $(this).attr('input');
        if($(this).attr('icon')=='fa-eye'){
            $('#'+$input).attr('type','text');
            $(this).attr('icon','fa-eye-slash');
            $(this).removeClass('fa-eye');
            $(this).addClass('fa-eye-slash');
        }else{
            $('#'+$input).attr('type','password');
            $(this).attr('icon','fa-eye');
            $(this).removeClass('fa-eye-slash');
            $(this).addClass('fa-eye');
        }
        // alert($class);
    });
    $('#change-password').submit(function(e){
        $('.error-message').text('');
        e.preventDefault();
        $phone_no = $('#change-password-phone').text();
        let addForm = new FormData($('#change-password')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url:'/user/change-password-verify/'+$phone_no,
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                if(response.icon=="success"){
                    location="/login";
                }else{
                    $('.error-message').text(response.message);
                }
            },
            error:function (response){
            }
        });
    });
    $('#product-search-bar').click(function(){
        $('#all-menu-mbl').css('display','none');
        $('#product-search-bar-bar').css('display','block');
    })

});