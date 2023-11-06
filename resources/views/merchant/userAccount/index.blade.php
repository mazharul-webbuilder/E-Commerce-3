@extends('merchant.layout.app')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            {{--Send Verification Code--}}
            <div class="max-w-lg mx-auto p-6 bg-white rounded-md shadow-md" id="VerificationCodeSentDiv">
                <h2 class="text-2xl font-semibold text-gray-800">Enter User Player Id</h2>
                <form id="UserConnectedForm" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-medium">Player Id</label>
                        <input type="text"
                               id="playerId"
                               name="playerId"
                               class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                               placeholder="Enter Player Id">
                    </div>
                    <button id="submitBtn"
                            type="submit"
                            class="w-full py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                        Get Verification Code
                    </button>
                </form>
            </div>
            {{--Verify Code--}}
            <div class="max-w-lg mx-auto p-6 bg-white rounded-md shadow-md hidden" id="VerifyCodeDiv">
                <h2 class="text-2xl font-semibold text-gray-800">Enter Verification Code</h2>
                <form id="UserConnectionVerifyForm" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-medium">Verification code</label>
                        <input type="hidden" name="playerId" id="setPlayerId" value="">
                        <input type="text"
                               id="verifyCode"
                               name="verifyCode"
                               class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                               placeholder="Enter verification code">
                    </div>
                    <button id="submitBtn"
                            type="submit"
                            class="w-full py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                        Connect Account
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('extra_js')
    {{--Send Code to Connect Account with merchant--}}
    <script>
        $(document).ready(function (){
            $('#UserConnectedForm').on('submit', function (e){
                e.preventDefault();
                $('#submitBtn').text('Processing')
                const UserConnectedForm = $(this);

                // Clear previous error messages
                $('.error-message').remove();
                // Serialize the form data
                const formData = UserConnectedForm.serialize();
                $.ajax({
                    url: '{{ route('merchant.connect.with.user.account') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json', // Expect JSON response from the server
                    success: function (data) {
                        if (data.response === 200) {

                            Toast.fire({
                                icon: data.type,
                                title: data.message
                            });
                            $('#submitBtn').text('Get Verification Code')
                            $('#setPlayerId').val(data.playerId)
                            $('#VerificationCodeSentDiv').hide()
                            $('#VerifyCodeDiv').removeClass('hidden')

                        }
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 422) {
                            $('#submitBtn').text('Get Verification Code')

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

            })
        })
    </script>
    {{--Verify Code to Connect Account with merchant--}}
    <script>
        $(document).ready(function (){
            $('#UserConnectionVerifyForm').on('submit', function (e){
                e.preventDefault();
                $('#submitBtn').text('Processing')
                const UserConnectionVerifyForm = $(this);

                // Clear previous error messages
                $('.error-message').remove();
                // Serialize the form data
                const formData = UserConnectionVerifyForm.serialize();
                $.ajax({
                    url: '{{ route('merchant.connect.with.user.account.verify') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json', // Expect JSON response from the server
                    success: function (data) {
                        if (data.response === 200) {
                            window.location.href = '{{route('merchant.connected.user.account')}}'
                            Toast.fire({
                                icon: data.type,
                                title: data.message
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 422) {
                            $('#submitBtn').text('Connect Account')
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

            })
        })
    </script>

@endsection
