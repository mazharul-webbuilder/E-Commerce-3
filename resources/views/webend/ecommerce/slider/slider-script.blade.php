<script>
    $(document).ready(function (){
        $('#SliderForm').on('submit', function (e){
            e.preventDefault()

            $('.submit-btn').html('Processing....').prop('disabled', true)

            const formData = new FormData(this);

            $.ajax({
                url: '{{route('slider.store')}}',
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
                        $('#SliderForm')[0].reset();
                        $('.submit-btn').text('Submit').prop('disabled', false)

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
