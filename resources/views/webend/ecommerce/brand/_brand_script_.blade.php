<script>
    $(document).ready(function (){
        /*Modal*/
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
    })
</script>
