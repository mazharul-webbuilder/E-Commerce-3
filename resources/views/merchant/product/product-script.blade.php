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
                    $('#getFlashDealStatus').text(data === 1 ? "Yes" : "No")
                    $('#flashDealStatus').val(data)
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
            let recentProduct = $('#recentProduct')
            let bestSaleProduct = $('#bestSaleProduct')
            let mostSaleProduct = $('#mostSaleProduct')

            recentProduct.attr('checked', false)
            bestSaleProduct.attr('checked', false)
            mostSaleProduct.attr('checked', false)

            $.ajax({
                url: '{{route('merchant.product')}}',
                method: 'GET',
                data: {id: productId},
                success: function (data){
                    if (data.recent === 1) {
                        recentProduct.attr('checked', true)
                        // Reload the DataTable if needed
                        $('#dataTable').DataTable().ajax.reload();
                    }
                    if (data.most_sale === 1) {
                        bestSaleProduct.attr('checked', true)
                        // Reload the DataTable if needed
                        $('#dataTable').DataTable().ajax.reload();
                    }
                    if (data.most_sale === 1) {
                        mostSaleProduct.attr('checked', true)
                        // Reload the DataTable if needed
                        $('#dataTable').DataTable().ajax.reload();
                    }

                    $('#ControlPanelModal').removeClass('hidden');

                    $('#ControlPanelModalClose').click(function() {
                        $('#ControlPanelModal').addClass('hidden');
                    });
                }
            })
        })
    })
</script>
