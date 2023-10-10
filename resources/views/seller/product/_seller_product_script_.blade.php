
<script>
    $(document).ready(function (){
        /*Appear Config Modal*/
        $('body').on('click', '.ConfigBtn', function (){
            const SellerProductId = $(this).data('id');
            $.ajax({
                url: '{{ route('seller.product.details') }}',
                method: 'GET',
                data: { sellerProductId: SellerProductId },
                success: function (data) {
                    /*Set Existing Values*/
                    $('#sellerProductId').val(data.id)
                    $('#seller_price').val(data.seller_price)
                    $('#seller_company_commission').val(data.seller_company_commission)

                    /*show Modal*/
                    $('#ConfigModal').removeClass('hidden')
                    /*Close Modal*/
                    $('#ConfigModalClose').on('click', function (){
                        $('#ConfigModal').addClass('hidden')
                    })
                }
            });
        });

        /*Submit Config Form*/
        $('#SellerConfigForm').on('submit', function (e){
                e.preventDefault()
                $('.submit-btn').html('Processing....')

                const formData = new FormData(this);

                $.ajax({
                    url: '{{route('seller.product.config.store')}}',
                    method: 'post',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.response === 200) {
                            Toast.fire({
                                icon: data.type,
                                title: data.message
                            })
                            $('.submit-btn').text('Submit')
                            /*Close Modal*/
                            $('#ConfigModal').addClass('hidden')
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error')
                        if (xhr.status === 422) {
                            $('.submit-btn').text('Submit').prop('disabled', false)
                            const errors = xhr.responseJSON.errors;

                            // Clear previous error messages
                            $('.error-message').remove();

                            // Display error messages for each input field
                            Object.keys(errors).forEach(function(field) {
                                const errorMessage = errors[field][0];
                                const inputField = $('[name="' + field + '"]');
                                inputField.after('<span class="error-message text-red-500">' + errorMessage + '</span>');
                            });

                        } else {
                            console.log('An error occurred:', status, error);
                        }
                    }
                })

            })
    });

</script>
