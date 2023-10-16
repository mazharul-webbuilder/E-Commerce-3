<script>
    $(document).ready(function (){
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        /*Merchant Product Status Update*/
        $('body').on('change', '.status-select', function (){
            const productId = $(this).data('id')
            $.ajax({
                url: '{{route('merchant.product.status.change')}}',
                method: 'post',
                data: {id: productId, _token: csrfToken},
                success: function (data) {
                    if (data.response === 200) {
                        Toast.fire({
                            icon: data.type,
                            title: data.message
                        })
                    }
                }
            })
        })

        /*Flash Deal Control*/
        /* Flash Deal Control */
        $('body').on('click', '.FlashDealBtn', function () {
            const productId = $(this).data('id');
            $.ajax({
                url: '{{ route('merchant.product.flash-deal') }}',
                method: 'get',
                data: { id: productId, _token: csrfToken },
                success: function (data) {
                    $('#getFlashDealStatus').text(data.flash_deal === 1 ? "Yes" : "No")
                    $('#flashDealStatus').val(data.flash_deal === 1 ? 1 : '')
                    $('#dealType').val(data.deal_type)
                    $('#amount').val(data.deal_amount)
                    $('#FlashDealProductId').val(productId)
                    $('#flashDealModal').removeClass('hidden');
                    $('#flashDealModalClose').click(function() {
                        $('#flashDealModal').addClass('hidden');
                    });
                }
            });
        });

        /**
         * Update Status of Flash Deals
         * */
        $('#flashDealControlForm').on('submit', function (e) {
            e.preventDefault();

            const flashDealControlForm = $(this);

            // Clear previous error messages
            $('.error-message').remove();

            // Serialize the form data
            const formData = flashDealControlForm.serialize();

            $.ajax({
                url: '{{ route('merchant.product.flash-deal.store') }}',
                type: 'POST',
                data: formData,
                dataType: 'json', // Expect JSON response from the server
                // JavaScript to hide the modal after a successful operation
                success: function (data) {
                    if (data.response === 200) {
                        // Reset the form fields
                        $('#flashDealControlForm')[0].reset();

                        // Hide the modal
                        $('#flashDealModal').addClass('hidden');

                        // Reload the DataTable if needed
                        $('#dataTable').DataTable().ajax.reload();

                        Toast.fire({
                            icon: data.type,
                            title: data.message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;

                        // Display error messages for each input field
                        $.each(errors, function (field, errorMessage) {
                            const inputField = $('[name="' + field + '"]');
                            inputField.after('<span class="error-message text-red-600">' + errorMessage[0] + '</span>');
                        });
                    } else {
                        console.log('An error occurred:', status, error);
                    }
                }
            });
        });


        /*Control Panel*/
        $('body').on('click', '.ControlPanelBtn', function (){
            const productId = $(this).data('id')
            let recentProduct = $('.recentProduct')
            let bestSaleProduct = $('.bestSaleProduct')
            let mostSaleProduct = $('.mostSaleProduct')
            $('.set_product_id').val(productId)

            recentProduct.attr('data-id', productId);
            bestSaleProduct.attr('data-id', productId);
            mostSaleProduct.attr('data-id', productId);

            recentProduct.prop('checked', false)
            bestSaleProduct.prop('checked', false)
            mostSaleProduct.prop('checked', false)

            $.ajax({
                url: '{{ route('merchant.product') }}',
                method: 'GET',
                data: { id: productId },
                success: function (data) {
                    if (data.recent === 1) {
                        recentProduct.prop('checked', true);
                    }
                    if (data.best_sale === 1) {
                        bestSaleProduct.prop('checked', true);
                    }
                    if (data.most_sale === 1) {
                        mostSaleProduct.prop('checked', true);
                    }
                    //
                    // // Reload the DataTable if needed
                    // $('#dataTable').DataTable().ajax.reload();

                    $('#ControlPanelModal').removeClass('hidden');

                    $('#ControlPanelModalClose').click(function () {
                        $('#ControlPanelModal').addClass('hidden');
                    });
                }
            });

        })

        /* Change Status Of Product */
        $('body').on('click', '.recentProduct', function () {
            const productId = $('.set_product_id').val();
            controlProduct(productId, 'recent')
        });

        $('.bestSaleProduct').on('click', function (){
            const productId = $('.set_product_id').val();
            controlProduct(productId, 'best-sale')
        })
        $('.mostSaleProduct').on('click', function (){
            const productId = $('.set_product_id').val();
            controlProduct(productId, 'most-sale')
        })
    })

    function controlProduct(productId, action) {
        $.ajax({
            url: '{{route('merchant.product.control.panel')}}',
            method: 'GET',
            data: {
                productId: productId,
                action: action
            },
            success: function (data) {
                if (data.response === 200) {
                    Toast.fire({
                        icon: data.type,
                        title: data.message
                    });
                }
            }
        })
    }

    /*Delete a Product*/
    $('body').on('click','.delete_item',function(){
        let item_id=$(this).attr('data-id');
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
                    url: '{{route('merchant.product.delete')}}',
                    method:'get',
                    data:{item_id:item_id},
                    success:function(data){
                        Toast.fire({
                            icon: data.type,
                            title: data.message
                        })
                        $('#dataTable').DataTable().ajax.reload();
                    }
                });
            }
        })
    })
    /*Convert Date Format*/
    // function convertDateFormat(inputDate) {
    //     var parts = inputDate.split('-');
    //     if (parts.length === 3) {
    //         var day = parts[0];
    //         var month = parts[1];
    //         var year = parts[2];
    //         return month + '/' + day + '/' + year;
    //     }
    //     return '';
    // }
</script>
