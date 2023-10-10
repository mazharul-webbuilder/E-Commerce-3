
<script>
    $(document).ready(function (){
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
                        url: '{{route('affiliate.product.delete')}}',
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
