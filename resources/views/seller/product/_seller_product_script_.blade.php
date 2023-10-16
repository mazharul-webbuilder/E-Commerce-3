
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
                    $('#seller_price').attr('min',data.seller_price)
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
                            window.location.reload()
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

        /*Delete a Product*/
        $('body').on('click','.delete_item',function(){
            const sellerProductId = $(this).attr('data-id');
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
                        url: '{{route('seller.product.delete')}}',
                        method:'get',
                        data:{sellerProductId: sellerProductId},
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
    });


</script>
