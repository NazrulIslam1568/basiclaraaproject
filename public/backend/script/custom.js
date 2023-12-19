$(document).ready(function(){
    $('#message-add-custom').hide();
    $('#add_brand_button').submit(function(e){
        e.preventDefault();
        var $domain_name = $('#brand_domain_name').val();
        $brand_name_val_msg = $('#brand_name_val_msg').val();
        $brand_name_msg = 'Your ' + $brand_name_val_msg + ' Added Successfully!';
        let addForm = new FormData($('#add_brand_button')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/admin/add-brand-post',
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                $('#add_brand_button input').val('');
                $('#message-add-custom').text($brand_name_msg);
                $('#message-add-custom').show();
                $('#message-add-custom').fadeOut(5000);
                $('#brand_domain_name').val($domain_name);
            },
            error:function (response){
                console.log(response);
            }
        });     
    }); 
    // Category add ajax request
    $('#add_category_button').submit(function(e){
        e.preventDefault();
        let addForm = new FormData($('#add_category_button')[0]);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/admin/add-category-post',
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                $('#add_category_button input').val('');
                $('#message-add-custom').show();
                $('#message-add-custom').text('Your Category Added Successfully!');
                $('#message-add-custom').fadeOut(5000);
            },
            error:function (response){
                console.log(response);
            }
        });     
    }); 
    $('#add_choice_button').submit(function(e){
        e.preventDefault();
        let addForm = new FormData($('#add_choice_button')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/admin/add-choice-post',
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                $('#add_choice_button input').val('');
                $('#message-add-custom').show();
                $('#message-add-custom').text('Your Category Added Successfully!');
                $('#message-add-custom').fadeOut(5000);
            },
            error:function (response){
                console.log(response);
            }
        });
    }); 
    // Product Add Ajax Request
    $('#add-product-form').submit(function(e){
        e.preventDefault();
        let addForm = new FormData($('#add-product-form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/admin/add-product-post',
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                swal({
                    title: "Success",
                    text: "Your product added successful!",
                    icon: "success",
                    button: "Ok",
                });
                $('#add-product-form input').val('');
                $('#add-product-form textarea').val('');
                // $('#add-product-form select option[value=0]').attr('selected','selected');
            },
            error:function (response){
                console.log(response);
            }
        });
    });
    // end product add 
    view_product_ajax();
    function view_product_ajax(){
        // console.log(location.hostname);
        $.ajax({
            type:'get',
            url:'/admin/view-product-ajax',
            dataType:'json',
            success: function(response){
                $.each(response.products, function(key, item){
                    $img_url = 'http://'+document.location.host+'/frontend/img/product/'+item.image;
                    if(item.edit == 1){
                        $edit_icon = 'fa-toggle-on',
                        $edit_color = 'blue'
                    }else{
                        $edit_icon = 'fa-toggle-off',
                        $edit_color = '#ed2024'
                    }
                    if(item.offer == 1){
                        $offer_icon = 'fa-toggle-on',
                        $offer_color = 'blue'
                    }else{
                        $offer_icon = 'fa-toggle-off',
                        $offer_color = '#ed2024'
                    }
                    if(item.visible == 1){
                        $visible_icon = 'fa-toggle-on',
                        $visible_color = 'blue'
                    }else{
                        $visible_icon = 'fa-toggle-off',
                        $visible_color = '#ed2024'
                    }
                    $('#product_view_format').append(
                    '<tr>\
                        <td>'+item.id+'</td>\
                        <td>'+item.product_code+'</td>\
                        <td>'+item.product_name+'</td>\
                        <td>'+item.product_price+'</td>\
                        <td>'+item.product_weight+'</td>\
                        <td><img style="width:100px; height: 100px;" src='+$img_url+'></td>\
                        <th><i cat_id="'+item.id+'" field_name="edit" db_name="products" class="all_hide_show fas '+$edit_icon+'" style="color: '+$edit_color+'; font-size:30px; cursor:pointer"></i></th>\
                        <th><i cat_id="'+item.id+'" field_name="offer" db_name="products" class="all_hide_show fas '+$offer_icon+'" style="color: '+$offer_color+'; font-size:30px; cursor:pointer"></i></th>\
                        <th><i cat_id="'+item.id+'" field_name="visible" db_name="products" class="all_hide_show fas '+$visible_icon+'" style="color: '+$visible_color+'; font-size:30px; cursor:pointer"></i></th>\
                        <td class="d-flex" style="height: 130px; padding: 45px 0;">\
                            <button id_get="'+item.id+'" style="margin:2px" type="button" class="btn btn-primary btn-sm edit_product"><i class="fa fa-pencil"></i></button>\
                            <button id_get="'+item.id+'" style="margin:2px" type="button" class="btn btn-danger btn-sm delete_product"><i class="fas fa-trash-alt"></i></button>\
                        </td>\
                    </tr>'
                    )
                });
            },
            error:function(response){
                console.log(response);
            }
        });
    }
    // All Hide Show 
        $(document).on('click','.all_hide_show',function(e){
        $id = $(this).attr('cat_id');
        $field_name = $(this).attr('field_name');
        $db_name = $(this).attr('db_name');
        $selector = $(this);
        $.ajax({
            type:'get',
            url:'/admin/all-hide-show/'+$id+'/'+$field_name+'/'+$db_name,
            dataType:'json',
            success: function(response){
                console.log(response);
                if(response.icon == 'fa-toggle-on'){
                    $selector.removeClass('fa-toggle-off');
                    $selector.addClass('fa-toggle-on');
                    $selector.css('color',response.color);
                    swal({
                        title: response.product_name+' '+$field_name+' Activate',
                        text: "Your category has been updated successfully!",
                        icon: "success",
                        buttons: true,
                        dangerMode: true,
                    });
                }else{
                    $selector.removeClass('fa-toggle-on');
                    $selector.addClass('fa-toggle-off');
                    $selector.css('color',response.color);
                    swal({
                        title: response.product_name+' '+$field_name+' Deactivate',
                        text: "Your category has been updated successfully!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                }
                
            },
            error:function(response){
                console.log(response);
            }
        });
    });
    // Search Product 
    $("#search-product-input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $('#'+$(this).attr('data-pass') +" tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      $("#search-result-input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $('#'+$(this).attr('data-pass') +" tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    // end view product ajax
    $(document).on('click','.edit_product',function(e){
        e.preventDefault();
        $id = $(this).attr('id_get');
        // alert($id);
        $.ajax({
            type:'get',
            url:'/admin/edit-product/'+$id,
            success:function(response){
                $img_url = 'http://'+document.location.host+'/frontend/img/product/'+response.product.image;
                $('#view_product_table').hide();
                $('#edit_update_form').show();
                $('#product_title').text(response.product.product_name);
                $('#product_id').val(response.product.id);
                $('#product_name').val(response.product.product_name);
                $('#product_description').val(response.product.product_desc);
                $('#product_stock').val(response.product.stock);
                $('#product_price').val(response.product.product_price);
                $('#old_price').val(response.product.old_price);
                $('#buy_price').val(response.product.buy_price);
                $('#product_weight_product').val(response.product.product_weight);
                $('#image_src').attr('src',$img_url);
                $('#brand').val(response.product.brand);
                $('#category').val(response.product.category);
                $('#choice').val(response.product.choice);
            },
            error:function(response){
                console.log(response);
            }
        });

    });
    // end update Product
    $('#update-product-form').submit(function(e){
        e.preventDefault();
        let addForm = new FormData($('#update-product-form')[0]);
        $id = $('#product_id').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/admin/update-product-post/'+$id,
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                $('#edit_update_form').hide();
                $('#view_product_table').show();
                $('#product_view_format tr').remove();
                view_product_ajax();
                swal({
                    title: "Updated Successfully",
                    text: "Your product has been updated successfully!",
                    icon: "success",
                    buttons: true,
                    dangerMode: true,
                });

            },
            error:function (response){
                console.log(response);
            }
        });
    });
    // end Update add 
    $(document).on('click','.delete_product',function(e){
        e.preventDefault();
        $id = $(this).attr('id_get');
        // alert($id);
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this Product!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            
          })
          .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type:'get',
                    url:'/admin/delete-product/'+$id,
                    success:function(response){
                        $('#product_view_format tr').hide();
                        view_product_ajax();
                        $('#edit_update_form').hide();
                        $('#view_product_table').show();
                        swal({
                            title: "Delete Successfully",
                            text: "Your product has been deleted successfully!",
                            icon: "success",
                            buttons: true,
                            dangerMode: true,
                        });
                    },
                    error:function(response){
                        console.log(response);
                    }
                });
            } else {
              swal("Your Product is safe!");
            }
          });

    });
    // end Delete Product
    $(document).on('click','#cancel_product_form',function(e){
        e.preventDefault();
        $('#edit_update_form').hide();
        $('#view_product_table').show();
    });
    // Add Category
    $(document).on('submit','#add-category-form',function(e){
        e.preventDefault();
        let addForm = new FormData($('#add-category-form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/admin/category-post',
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                swal({
                    title: "Success",
                    text: "Your Category added successful!",
                    icon: "success",
                    button: "Ok",
                });
                $('#add-category-form input').val('');
                $('#add-category-form select option[value=0]').attr('selected','selected');
            },
            error:function (response){
                console.log(response);
            }
        });     
    }); 
    // Product List Category View
    $(document).on('change','#product_category',function(e){
        $('#product_sub_category option').remove();
        $value = $(this).val();
        $.ajax({
            type:'get',
            url:'/admin/sub-category-view/'+$value,
            dataType:'json',
            success: function(response){
                $('#sub_category_div').show();
                $('#product_sub_category').append(
                    '<option value="0">Select Your Sub Category</option>'
                )
                $.each(response.categories, function(key, item){
                    $('#product_sub_category').append(
                        '<option value="'+item.id+'">'+item.category_name+'</option>');
                });
            },
            error:function(response){
                console.log(response);
            }
        });
    });
    $(document).on('change','#product_sub_category',function(e){
        $('#parent_category_div option').remove();
        $('#category_view_format tr').remove();
        $value = $(this).val();
        $.ajax({
            type:'get',
            url:'/admin/parent-category-view/'+$value,
            dataType:'json',
            success: function(response){
                $('#view_product_table').show();
                $.each(response.parent_categories, function(key, item){
                    $img_url = 'http://'+document.location.host+'/frontend/img/category/'+item.banner_image;
                    if(item.popular == 1){
                        $popular_icon = 'fa-toggle-on',
                        $popular_color = 'blue'
                    }else{
                        $popular_icon = 'fa-toggle-off',
                        $popular_color = '#ed2024'
                    }
                    if(item.daily == 1){
                        $daily_icon = 'fa-toggle-on',
                        $daily_color = 'blue'
                    }else{
                        $daily_icon = 'fa-toggle-off',
                        $daily_color = '#ed2024'
                    }
                    if(item.status == 1){
                        $status_icon = 'fa-toggle-on',
                        $status_color = 'blue'
                    }else{
                        $status_icon = 'fa-toggle-off',
                        $status_color = '#ed2024'
                    }
                    $('#category_view_format').append(
                        '<tr>\
                            <th>'+item.id+'</th>\
                            <th>'+item.category_name+'</th>\
                            <th><img style="width:100px; height: 100px;" src="'+$img_url+'"></th>\
                            <th><i cat_id="'+item.id+'" cat_table="status" class="category_hide_show fas '+$status_icon+'" style="color: '+$status_color+'; font-size:30px; cursor:pointer"></i></th>\
                            <th><i cat_id="'+item.id+'" cat_table="popular" class="category_hide_show fas '+$popular_icon+'" style="color: '+$popular_color+'; font-size:30px; cursor:pointer"></i></th>\
                            <th><i cat_id="'+item.id+'" cat_table="daily" class="category_hide_show fas '+$daily_icon+'" style="color: '+$daily_color+'; font-size:30px; cursor:pointer"></i></th>\
                            <th>\
                                <a href="https://nimnio.com/admin/edit-category/'+item.id+'" style="margin:2px;" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>\
                                <a href="https://nimnio.com/admin/delete-category/'+item.id+'" style="margin:2px;" type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>\
                            </th>\
                        </tr>')
                });
                $('#parent_category_div').show();
                $('#product_parent_category').append(
                    '<option value="0">Select Your Parent Category</option>'
                )
                $.each(response.parent_categories, function(key, item){
                    $('#product_parent_category').append(
                        '<option value="'+item.id+'">'+item.category_name+'</option>');
                });
            },
            error:function(response){
                console.log(response);
            }
        });
    });
    // Category Hide Show
    $(document).on('click','.category_hide_show',function(e){
        $category_id = $(this).attr('cat_id');
        $table_name = $(this).attr('cat_table');
        $selector = $(this);
        $.ajax({
            type:'get',
            url:'/admin/category-table-hide-show/'+$category_id+'/'+$table_name,
            dataType:'json',
            success: function(response){
                if(response.icon == 'fa-toggle-on'){
                    $selector.removeClass('fa-toggle-off');
                    $selector.addClass('fa-toggle-on');
                    $selector.css('color',response.color);
                    swal({
                        title: response.category_name+' '+$table_name+' Activate',
                        text: "Your category has been updated successfully!",
                        icon: "success",
                        buttons: true,
                        dangerMode: true,
                    });
                }else{
                    $selector.removeClass('fa-toggle-on');
                    $selector.addClass('fa-toggle-off');
                    $selector.css('color',response.color);
                    swal({
                        title: response.category_name+' '+$table_name+' Deactivate',
                        text: "Your category has been updated successfully!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                }
                
            },
            error:function(response){
                console.log(response);
            }
        });
    });
    $('#add-address-form').submit(function(e){
        e.preventDefault();
        // alert('hlw');
        let addForm = new FormData($('#add-address-form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/admin/add-address-post',
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                // console.log(response);
                $('input').val('');
                swal({
                    title: 'Success',
                    icon: 'success',
                    button: "Ok",
                });
            },
            error:function (response){
                console.log(response);
            }
        });
    });
    // Dropdown Dynamic Address
    $(document).on('change','#nim-division',function(e){
        $('#view_address_table').show();
        $('#address_view_format tr').remove();
        $('#nim-district option').remove();
        $('#add-address-input').text('District Name');
        $district_id = $(this).val();
        $.ajax({
                type:'get',
                url:'/admin/all-district-view/'+$district_id,
                dataType:'json',
                success: function(response){
                    console.log(response);
                    $('.add-address.district').show();
                    $('#nim-district').append(
                        '<option value="0">Select Your District</option>'
                    )
                    $.each(response.districts, function(key, item){
                        $('#nim-district').append('<option value="'+item.district_id+'">'+item.name+'</option>');
                    });
                    $.each(response.divisions, function(key, item){
                        $('#address_name_div').text('Division');
                        if(item.status == 1){
                            $status_icon = 'fa-toggle-on',
                            $status_color = 'blue'
                        }else{
                            $status_icon = 'fa-toggle-off',
                            $status_color = '#ed2024'
                        }
                        if(item.permission == 1){
                            $permission_icon = 'fa-toggle-on',
                            $permission_color = 'blue'
                        }else{
                            $permission_icon = 'fa-toggle-off',
                            $permission_color = '#ed2024'
                        }
                        $('#address_view_format').append(
                            '<tr>\
                                <th>'+item.id+'</th>\
                                <th>'+item.name+'</th>\
                                <th><i address_id="'+item.id+'" click="divisions" address_table="status" class="address_hide_show fas '+$status_icon+'" style="color: '+$status_color+'; font-size:30px; cursor:pointer"></i></th>\
                                <th><i address_id="'+item.id+'" click="divisions" address_table="permission" class="address_hide_show fas '+$permission_icon+'" style="color: '+$permission_color+'; font-size:30px; cursor:pointer"></i></th>\
                                <th>\
                                    <button address_id="'+item.id+'" click="divisions" style="margin:2px;" type="button" class="btn btn-primary btn-sm edit-address-admin"><i class="fa fa-pencil"></i></button>\
                                    <button address_id="'+item.id+'" click="divisions" style="margin:2px;" type="button" class="btn btn-danger btn-sm delete-address-admin"><i  class="fas fa-trash-alt"></i></button>\
                                </th>\
                            </tr>')
                    });
                },
                error:function(response){
                    console.log(response);
                }
            });
    });
    $(document).on('change','#nim-district',function(e){
        $('#address_view_format tr').remove();
        $('#nim-upazila option').remove();
        $('#add-address-input').text('Upazila Name');
        $upazila_id = $(this).val();
        $.ajax({
            type:'get',
            url:'/admin/all-upazila-view/'+$upazila_id,
            dataType:'json',
            success: function(response){
                $('.add-address.upazila').show();
                $('#nim-upazila').append(
                    '<option value="0">Select Your Upazila</option>'
                )
                $.each(response.upazilas, function(key, item){
                    $('#nim-upazila').append('<option value="'+item.upazila_id+'">'+item.name+'</option>');
                });
                $.each(response.districts, function(key, item){
                    $('#address_name_div').text('District');
                    if(item.status == 1){
                        $status_icon = 'fa-toggle-on',
                        $status_color = 'blue'
                    }else{
                        $status_icon = 'fa-toggle-off',
                        $status_color = '#ed2024'
                    }
                    if(item.permission == 1){
                        $permission_icon = 'fa-toggle-on',
                        $permission_color = 'blue'
                    }else{
                        $permission_icon = 'fa-toggle-off',
                        $permission_color = '#ed2024'
                    }
                    $('#address_view_format').append(
                        '<tr>\
                            <th>'+item.id+'</th>\
                            <th>'+item.name+'</th>\
                            <th><i address_id="'+item.id+'" click="districts" address_table="status" class="address_hide_show fas '+$status_icon+'" style="color: '+$status_color+'; font-size:30px; cursor:pointer"></i></th>\
                            <th><i address_id="'+item.id+'" click="districts" address_table="permission" class="address_hide_show fas '+$permission_icon+'" style="color: '+$permission_color+'; font-size:30px; cursor:pointer"></i></th>\
                            <th>\
                                <button style="margin:2px;" type="button" class="btn btn-primary btn-sm edit_product"><i class="fa fa-pencil"></i></button>\
                                <button address_id="'+item.id+'" click="districts" style="margin:2px;" type="button" class="btn btn-danger btn-sm delete-address-admin"><i  class="fas fa-trash-alt"></i></button>\
                            </th>\
                        </tr>')
                });
            },
            error:function(response){
                console.log(response);
            }
        });
    });
    $(document).on('change','#nim-upazila',function(e){
        $('#address_view_format tr').remove();
        $bazar_name_id = $(this).val();
        $('#add-address-input').text('Bazar Name');
        $('#nim-bazar_name option').remove();
        $.ajax({
            type:'get',
            url:'/admin/all-bazar_name-view/'+$bazar_name_id,
            dataType:'json',
            success: function(response){
                $('.add-address.bazar_name').show();
                $('#nim-bazar_name').append(
                    '<option value="0">Select Your Nearest Town</option>'
                )
                $.each(response.bazar_names, function(key, item){
                    $('#nim-bazar_name').append('<option value="'+item.bazar_name_id+'">'+item.bazar_name+'</option>');
                });
                $.each(response.upazilas, function(key, item){
                    $('#address_name_div').text('Upazila');
                    if(item.status == 1){
                        $status_icon = 'fa-toggle-on',
                        $status_color = 'blue'
                    }else{
                        $status_icon = 'fa-toggle-off',
                        $status_color = '#ed2024'
                    }
                    if(item.permission == 1){
                        $permission_icon = 'fa-toggle-on',
                        $permission_color = 'blue'
                    }else{
                        $permission_icon = 'fa-toggle-off',
                        $permission_color = '#ed2024'
                    }
                    $('#address_view_format').append(
                        '<tr>\
                            <th>'+item.id+'</th>\
                            <th>'+item.name+'</th>\
                            <th><i address_id="'+item.id+'" click="upazilas" address_table="status" class="address_hide_show fas '+$status_icon+'" style="color: '+$status_color+'; font-size:30px; cursor:pointer"></i></th>\
                            <th><i address_id="'+item.id+'" click="upazilas" address_table="permission" class="address_hide_show fas '+$permission_icon+'" style="color: '+$permission_color+'; font-size:30px; cursor:pointer"></i></th>\
                            <th>\
                                <button style="margin:2px;" type="button" class="btn btn-primary btn-sm edit_product"><i class="fa fa-pencil"></i></button>\
                                <button address_id="'+item.id+'" click="upazilas" style="margin:2px;" type="button" class="btn btn-danger btn-sm delete-address-admin"><i  class="fas fa-trash-alt"></i></button>\
                            </th>\
                        </tr>')
                });
            },
            error:function(response){
                console.log(response);
            }
        });
    });
    $(document).on('change','#nim-bazar_name',function(e){
        $('#address_view_format tr').remove();
        $elaka_name_id = $(this).val();
        $('#add-address-input').text('Elaka Name');
        $('#nim-elaka_name option').remove();
        $.ajax({
            type:'get',
            url:'/admin/all-elaka_name-view/'+$elaka_name_id,
            dataType:'json',
            success: function(response){
                $('.add-address.elaka_name').show();
                $('#nim-elaka_name').append(
                    '<option value="0">Select Your Home Address</option>'
                )
                $.each(response.elaka_names, function(key, item){
                    $('#nim-elaka_name').append('<option value="'+item.elaka_name_id+'">'+item.elaka_name+'</option>');
                });
                $.each(response.bazar_names, function(key, item){
                    $('#address_name_div').text('Bazar');
                    if(item.status == 1){
                        $status_icon = 'fa-toggle-on',
                        $status_color = 'blue'
                    }else{
                        $status_icon = 'fa-toggle-off',
                        $status_color = '#ed2024'
                    }
                    if(item.permission == 1){
                        $permission_icon = 'fa-toggle-on',
                        $permission_color = 'blue'
                    }else{
                        $permission_icon = 'fa-toggle-off',
                        $permission_color = '#ed2024'
                    }
                    $('#address_view_format').append(
                        '<tr>\
                            <th>'+item.id+'</th>\
                            <th>'+item.bazar_name+'</th>\
                            <th><i address_id="'+item.id+'" click="bazar_names" address_table="status" class="address_hide_show fas '+$status_icon+'" style="color: '+$status_color+'; font-size:30px; cursor:pointer"></i></th>\
                            <th><i address_id="'+item.id+'" click="bazar_names" address_table="permission" class="address_hide_show fas '+$permission_icon+'" style="color: '+$permission_color+'; font-size:30px; cursor:pointer"></i></th>\
                            <th>\
                                <button style="margin:2px;" type="button" class="btn btn-primary btn-sm edit_product"><i class="fa fa-pencil"></i></button>\
                                <button address_id="'+item.id+'" click="bazar_names" style="margin:2px;" type="button" class="btn btn-danger btn-sm delete-address-admin"><i  class="fas fa-trash-alt"></i></button>\
                            </th>\
                        </tr>')
                });
            },
            error:function(response){
                console.log(response);
            }
        });
    });
    $(document).on('change','#nim-elaka_name',function(e){
        $('#address_view_format tr').remove();
    });
        // Category Hide Show
    $(document).on('click','.address_hide_show',function(e){
        $address_id = $(this).attr('address_id');
        $table_name = $(this).attr('address_table');
        $click = $(this).attr('click');
        $selector = $(this);
        $.ajax({
            type:'get',
            url:'/admin/address-table-hide-show/'+$address_id+'/'+$table_name+'/'+$click,
            dataType:'json',
            success: function(response){
                console.log(response);
                if(response.icon == 'fa-toggle-on'){
                    $selector.removeClass('fa-toggle-off');
                    $selector.addClass('fa-toggle-on');
                    $selector.css('color',response.color);
                    swal({
                        title: 'Address '+$table_name+' Activate',
                        text: "Your address has been updated successfully!",
                        icon: "success",
                        buttons: true,
                        dangerMode: true,
                    });
                }else{
                    $selector.removeClass('fa-toggle-on');
                    $selector.addClass('fa-toggle-off');
                    $selector.css('color',response.color);
                    swal({
                        title: 'Address '+$table_name+' Deactivate',
                        text: "Your address has been updated successfully!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    });
                }
                
            },
            error:function(response){
                console.log(response);
            }
        });
    });
    $(document).on('click','.delete-address-admin',function(e){
        $address_id = $(this).attr('address_id');
        $click = $(this).attr('click');
        $select = $(this);
        // alert($click)
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type:'get',
                    url:'/admin/address-delete/'+$address_id+'/'+$click,
                    dataType:'json',
                    success: function(response){
                        $('#address_view_format tr').remove();
                    },
                    error:function(response){
                        console.log(response);
                    }
                });
            }else {
              swal("Your Address is safe!");
            }
          });
    });
    $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat: 'D, dd-mm-yy',
        });
    } );
    $('.order-confirm-popup-open').click(function(){
        $order_id = $(this).attr('order_id');
        $('.order-confirm-popup').css({
            'visibility':'visible',
            'opacity': 1,
        });
        $('#order_confirm_submit_button').attr('order_id',$order_id);
    });
    $('#order_confirm_cancel_button').click(function(){
        $('.order-confirm-popup').css({
            'visibility':'hidden',
            'opacity': 0,
        });
    });
    $('#order_confirm_submit_button').click(function(){
        $order_id = $(this).attr('order_id');
        $code = $('#order_confirm_code').val();
        $name = $('#order_confirm_name').val();
        if($code > 0){
            if($name){
                $.ajax({
                    type:'get',
                    url:'/delivery-confirm/'+$order_id+'/'+$code+'/'+$name,
                    dataType:'json',
                    success: function(response){
                        console.log(response);
                        if(response.message == 'Completed'){
                            $('.order-confirm-popup').css({
                                'visibility':'hidden',
                                'opacity': 0,
                            });
                            swal({
                                title: "Success",
                                text: "Your Order has been "+response.message,
                                icon: "success",
                                button: "Ok",
                            });
                        }else{
                            swal({
                                title: "Error",
                                text: "Not Found Code",
                                icon: "warning",
                                button: "Ok",
                            });
                        }
                        
                    },
                    error:function(response){
                        console.log(response);
                    }
                });
            }
        }
    });
    $('.coupon_hide_show').click(function(){
        $coupon_id = $(this).attr('coupon_id');
        $selector = $(this);
        // alert('hlw');
        $.ajax({
            type:'get',
            url:'/coupon-status-change/'+$coupon_id,
            dataType:'json',
            success: function(response){
                $selector.removeClass(response.remove_class);
                $selector.addClass(response.status);
                $selector.css('color',response.color);
            },
            error:function(response){
                console.log(response);
            }
        });
    });
    $('#all-check-msg').click(function(){
        if($(this).text() == 'All Check'){
            $(this).text('Uncheck all');
            $('.send-msg-check-uncheck').prop('checked', true);
        }else{
            $(this).text('All Check');
            $('.send-msg-check-uncheck').prop('checked', false);
        }
    });
    $('.product-edit-price').click(function(){
        if($(this).text() == 'Edit'){
            $(this).text('Update')
            $product_id = $(this).attr('product_id');
            $product_price = $('#product-price-edit-'+$product_id).val();
            $('#product-price-edit-'+$product_id).removeAttr('disabled');
            $('#product-price-edit-'+$product_id).focus().val("").val($product_price);
        }else{
            $product_price = $('#product-price-edit-'+$product_id).val();
            $product_id = $(this).attr('product_id');
            $.ajax({
            type:'get',
            url:'/product-price-update-support/'+$product_price+'/'+$product_id,
            dataType:'json',
            success: function(response){
                $('#product-item-'+response.product_id).remove();
            },
            error:function(response){
                console.log(response);
            }
        });
        }

    });
        $('#custom_no_add').submit(function(e){
        e.preventDefault();
        let addForm = new FormData($('#custom_no_add')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/admin/custom-no-add-post',
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                    if(response.success == 'success'){
                        $('.custom-no-add-tr').append(
                        '<tr>\
                           <td><input type="checkbox" name="mobile[]" value="88'+response.phone_no+'" class="send-msg-check-uncheck"></td>\
                            <td>'+response.id+'</td>\
                            <td>'+response.phone_no+'</td>\
                            <td>'+response.division+'</td>\
                            <td>'+response.district_name+'</td>\
                            <td>'+response.upazila_name+'</td>\
                            <td>'+response.details+'</td>\
                        </tr>');
                        swal({
                            title: response.msg,
                            icon: 'success',
                            button: "Ok",
                        });
                    }else{
                        swal({
                            title: response.msg,
                            icon: 'warning',
                            button: "Ok",
                        });
                    }

            },
            error:function (response){
                console.log(response);
            }
        });
    });
    // Restaurant system add
    $('#add-restaurants-form').submit(function(e){
        e.preventDefault();
        // alert('hlw');die();
        let addForm = new FormData($('#add-restaurants-form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/add-restaurants-post',
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                $('#add-restaurants-form input').val('');
                swal({
                    title: 'Success',
                    icon: 'success',
                    button: "Ok",
                });
            },
            error:function (response){
                console.log(response);
            }
        });
    });
    $('#edit-restaurants-form').submit(function(e){
        $restaurant_id = $('#restaurant_id_post').val();
        e.preventDefault();
        // alert($restaurant_id);die();
        let addForm = new FormData($('#edit-restaurants-form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url: '/edit-restaurants-post/'+$restaurant_id,
            data: addForm,
            contentType:false,
            processData:false,
            success: function(response){
                location="/add-restaurants";
            },
            error:function (response){
                console.log(response);
            }
        });
    });
    $('.restaurant-product-click').click(function(){
        id = $(this).attr('prod_id');
        product_name = $('.product-name.'+id).text();
        $('#product_name').val(product_name);
        $('#main_product_id').val(id);
    });
})