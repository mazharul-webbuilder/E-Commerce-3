<script>
    $(document).ready(function (){
        /*Add Modal*/
        $('#AddModal').on('click', function (){
            /*Appear Add Modal*/
            $('#addModal').removeClass('hidden')

            /*Disappear Add Modal*/
            $('#addModalClose').on('click', function (){
                $('#addModal').addClass('hidden')
            })
        })
        /*Brand Create*/
        $('.addModal').on('submit', function (e){
            e.preventDefault()

            $('.submit-btn').html('Processing....').prop('disabled', true)

            const formData = new FormData(this);

            $.ajax({
                url: '{{route('brand.store')}}',
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
                        $('.addModal')[0].reset();
                        $('.submit-btn').text('Submit').prop('disabled', false)
                        $('#addModal').addClass('hidden')
                        /*Reload After Successfully Brand Creation*/
                        location.reload()

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
        /*Edit Modal*/
        $('body').on('click', '.edit-brand', function (e){
            e.preventDefault()
            const id = $(this).data('id')
            $.ajax({
                url: '{{route('brand.detail')}}',
                method: 'GET',
                data: {id: id},
                success: function (data) {
                    $('.brand-id').val(data.id)
                    $('.brandName').val(data.brand_name)
                    $('.existing-image').attr('src', '{{asset('uploads/brand/resize')}}' + '/' + data.image)
                }
            })
            /*Modal Control*/
            $('#editModal').removeClass('hidden')
            $('#editModalClose').on('click', function (){
                $('#editModal').addClass('hidden')
            })

        })
        /*Update Brand*/
        $('.updateForm').on('submit', function (e){
            e.preventDefault()
            const updateFormData = new FormData(this)
            $.ajax({
                url: '{{route('brand.update')}}',
                method: 'POST',
                data: updateFormData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.response === 200) {
                        Toast.fire({
                            icon: data.type,
                            title: data.message
                        })
                        $('.submit-btn').text('Update').prop('disabled', false)
                        $('#editModal').addClass('hidden')
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
        /*Delete Brand*/
        $('body').on('click', '.delete-brand', function (e){
            e.preventDefault();
            const id = $(this).data('id')
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
                        url: '{{ route('brand.delete') }}',
                        method: 'POST',
                        data: {id: id},
                        success: function (data) {
                            if (data.response === 200) {
                                Toast.fire({
                                    icon: data.type,
                                    title: data.message
                                })
                                window.location.reload()
                            }
                        }
                    });

                }
            })

        })
        /*Status Update*/
        $('body').on('click', '.brandStatusBtn', function (e){
            e.preventDefault();
            const brandId = $(this).data('id')
            $.ajax({
                url: '{{route('brand.status.update')}}',
                method: 'POST',
                data: {id: brandId},
                success: function (data) {
                    if (data.response === 200) {
                        Toast.fire({
                            icon: data.type,
                            title: data.message
                        })
                        window.location.reload()
                    }
                }
            })
        })

    })
</script>
