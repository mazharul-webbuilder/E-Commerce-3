$(document).ready(function(){
    // sweet alert
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    $('body').on('click','.delete_item',function(){
        let item_id=$(this).attr('item_id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:$(this).attr('data-action'),
                    method:'post',
                    data:{item_id:item_id},
                    success:function(data){
                        Toast.fire({
                            icon: data.type,
                            title: data.message
                        })
                        $('.hide_row'+item_id).hide();
                    }
                });
            }
        })
    })

    // control product status

    $('body').on('click','.show_product_status',function(e){
        e.preventDefault();
        let product_id=$(this).attr('product_id');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: $(this).attr('data-action'),
            method: "POST",
            data:{product_id:product_id},
            success:function(response){
                let data=response.product
                //console.log(data)
                $(".store_product_id").val(data.id)

                if (data.best_sale===1)
                {
                    $('#best_sale').prop('checked', true)


                }else
                {
                    $('#best_sale').prop('checked', false)

                }
                if (data.most_sale===1)
                {
                    $('#most_sale').prop('checked', true)


                }else
                {
                    $('#most_sale').prop('checked', false)


                }
                if (data.recent===1)
                {
                    $('#recent').prop('checked', true)


                }else
                {
                    $('#recent').prop('checked', false)


                }
            },
        })

    });

    //  FLASH DEAL
    $('body').on('click','.show_flash_deal',function(e){
        e.preventDefault();
        let product_id=$(this).attr('product_id');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: $(this).attr('data-action'),
            method: "POST",
            data:{product_id:product_id},
            success:function(response){
                let data=response.product;
                $(".keep_product_id").val(data.id)
                $(".current_discount").text("Current Discount: "+data.discount+" %")
                $("#end_date").val(data.end_date)
                if (data.flash_deal==0)
                {
                    $('#flash_deal').prop('checked', true)
                }else
                {
                    $('#flash_deal').prop('checked', false)
                }
            },
        })
    });


    // change product status

    $('body').on('change','.change_product_status',function(){

        let status=$(this).val();
        let product_id=$(this).attr('product_id');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: $(this).attr('data-action'),
            method: "POST",
            data:{product_id:product_id,status:status},
            success:function(data){
                Toast.fire({
                    icon: data.type,
                    title: data.message
                })
                // window.reload();
            },
        })
    })

    // control product status
    $('body').on('change','.control_product_status',function(){
        let type=$(this).attr('status_type');
        let product_id=$('.store_product_id').val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: $('.store_product_id').attr('data-action'),
            method: "POST",
            data:{product_id:product_id,type:type},
            success:function(data){
                Toast.fire({
                    icon: data.type,
                    title: data.message
                })
            },
        })
    })

    $('body').on('submit','#submit_form_deal',function(e){
        e.preventDefault();
        let formDta = new FormData(this);
        $.ajax({
            url: $(this).attr('data-action'),
            method: "POST",
            data: formDta,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                // location.reload();

                Toast.fire({
                    icon: data.type,
                    title: data.message
                })
                $("#submit_form_deal")[0].reset();
                $("#exampleModalDeal").hide();
                $('body').removeClass('modal-open');
                $('.close_modal').trigger('click')
                if(data.flash_deal === '1'){
                    $(".flash_deal_status"+$(".deal_product_id").val()).text('Yes');
                }else{
                    $(".flash_deal_status"+$(".deal_product_id").val()).text('No');
                }
            },
            error:function(response){
                var errors=response.responseJSON
            }

        });
    })

    // show flash deal status
    $('body').on('click','.flash_deal_product_status',function(){
        let product_id=$(this).attr('product_id');
        $('.deal_product_id').val(product_id)
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: $(this).attr('data-action'),
            method: "POST",
            data: {product_id:product_id},
            success:function(data){
                    $('.deal_amount').val(data.product.deal_amount)
                    $('.deal_start_date').val(data.product.deal_start_date)
                    $('.deal_end_date').val(data.product.deal_end_date)
                    $('.deal_amount').val(data.product.deal_amount)
                    $('.current_deal').text(current_deal(data.product.flash_deal))
                    $('.current_type').text(data.product.deal_type)

            },
            error:function(response){
               console.log(response)
            }
        });
    })

    function current_deal(status){
       return status==1 ?  "Yes" : 'No';
    }
    $('body').on('change','.deal_status',function(){
        let deal_status=$(this).val();
        if (deal_status==1) {
            $('.deal_detail_style').css('display','block');
            $('.deal_start_date').attr('required', 'true');
            $('.deal_end_date').attr('required', 'true');
            $('.deal_amount').attr('required', 'true');
            $('.deal_type').attr('required', 'true');

        }else{
            $('.deal_start_date').removeAttr('required').val('');
            $('.deal_end_date').removeAttr('required').val('');
            $('.deal_amount').removeAttr('required').val('');
            $('.deal_type').removeAttr('required').val('');
            $('.deal_detail_style').css('display','none');
        }
    });
    $( ".deal_start_date" ).datepicker({
        minDate: 0,
        dateFormat: 'dd-mm-yy'
    });
    $( ".deal_end_date" ).datepicker({
        minDate: 0+1,
        dateFormat: 'dd-mm-yy'
    });

})
