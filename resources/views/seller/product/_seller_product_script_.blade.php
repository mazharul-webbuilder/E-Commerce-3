<script>
    $(document).ready(function (){
        $('body').on('click', '.ConfigBtn', function (){
            const SellerProductId = $(this).data('id')
            $.ajax({
                url: '{{route('seller.product.details')}}',
                method: 'GET',
                data: {sellerProductId: SellerProductId},
                success: function (data) {
                    console.log(data)
                }
            })
        })
    })
</script>
