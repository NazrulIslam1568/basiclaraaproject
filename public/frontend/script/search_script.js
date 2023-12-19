$(document).ready(function(){
    $('.main-search-bar').keyup(function(){
        $value = $(this).val();
        if($value.length > 0){
            $('.search-result-close').show();
            $('.header-search-item-show').show();
            $.ajax({
                type:'get',
                url:'/search-product-value/'+$value,
                dataType:'json',
                success: function(response){
                    if(response.products.length > 0){
                        $('.search-result .cat-blocks-container .row .col-6.col-md-4.col-lg-2').remove();
                        $('.search-result #search-name').text('Search result for:');
                        $('.search-result #search-value').text($value);
                        $.each(response.products, function(key, item){
                             $img_url = 'https://nimnio.com/frontend/img/product/'+item.image;
                            $('.search-result .cat-blocks-container .row').append(
                                '<div class="col-6 col-md-4 col-lg-2">\
                                    <div class="product product-3">\
                                        <figure class="product-media">\
                                            <span class="product-label text-white">'+item.product_code+'</span>\
                                            <a>\
                                                <img data-original="'+$img_url+'" alt="'+item.product_name+'" class="product-image" >\
                                            </a>\
                                        </figure>\
                                        <div class="product-body">\
                                            <div class="product-main product-id-'+item.id+'">\
                                                <button id="shop-cart-button" product_id ="'+item.id+'" class="product-button product-add-cart-button" style="width: 100%">Add to Cart</button>\
                                            </div>\
                                            <h4 class="product-title text-center"><a>'+item.product_name+'</a></h4>\
                                            <h4 class="product-title product-weight">'+item.product_weight+'</h4>\
                                            <div class="product-price">\
                                                <span class="new-price">৳ '+item.product_price+'</span>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            ');
                        });
                    }else{
                        $('.search-result .cat-blocks-container .row .col-6.col-md-4.col-lg-2').remove();
                        $('.search-result #search-value').text('');
                        $('.search-result #search-name').text('Your search did not match any product : ');
                        $('.search-result #search-value').text($value);
                    }
                },
                error:function(response){
                    
                }
            });
        }else{
            $('#product-search-bar-bar').css('display','none');
            $('#all-menu-mbl').css('display','block');
            $('.search-result-close').hide();
            $('.search-result .cat-blocks-container .row .col-6.col-md-4.col-lg-2').remove();
            $('.header-search-item-show').hide();
        }
    });
    $('.search-result-close').click(function(){
        $(this).hide();
        $('#product-search-bar-bar').css('display','none');
        $('#all-menu-mbl').css('display','block');
        $('.header-search-item-show').hide();
        $('.search-bar').val('');
    });
})