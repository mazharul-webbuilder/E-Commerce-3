<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('webend/asset/css/app.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" sizes="180*180" href="{{ asset('frontend/images/logo/nidch_logo.png') }}">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link href="{{ asset('webend/asset/css/style.css') }}" rel="stylesheet">
    <title>Admin Login|{{ config('app.name') }}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <style>
        .error-message{
            color: red;
        }
    </style>
</head>

<body class="bg-gray-50">
<div class="mx-auto md:h-screen flex flex-col justify-center items-center px-6 pt-8 pt:mt-0">
    <a href="" class="text-2xl font-semibold flex justify-center items-center mb-8 lg:mb-10">

        <span class="self-center text-2xl font-bold whitespace-nowrap uppercase">{{ config('app.name') }} Reset Password</span>
    </a>
    <!-- Card -->
    <div class="bg-white shadow rounded-lg md:mt-0 w-full sm:max-w-screen-sm xl:p-0">
        <div class="p-6 sm:p-8 lg:p-16 space-y-8">
            <div class="justify-between items-center text-center">
                <a class="flex flex-none d-flex justify-center">
                    <img class="h-14 w-14 md:h-28 md:w-32" alt="LUDO" src="{{ asset('webend/logo.png') }}">
                </a>
            </div>
            <form class="mt-8 space-y-6" id="ResetPasswordForm">
                @csrf
                <div>
                    <label for="email" class="text-sm font-medium text-gray-900 block mb-2">Verification Code</label>
                    <input type="number"
                           name="verification_code"
                           class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 @error('email') border-red-500 @enderror"
                          >
                    <div>
                        <label for="password" class="text-sm font-medium text-gray-900 block mb-2">Enter new password</label>
                        <div class="relative flex items-center">
                            <span class="absolute inset-y-0 right-0 flex items-center p-4 cursor-pointer"
                                  onclick="passwordToggle('#passwordVisibiltyIcon', '#password', '#adminShowEyeIcon');"
                                  id="passwordVisibiltyIcon">
                                <ion-icon class="text-gray-600 bg-gray-100" name="eye-off" id="adminShowEyeIcon">
                                </ion-icon>
                            </span>
                            <input type="password" name="password" id="password" placeholder=""
                                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 @error('password') border-red-500 @enderror"
                                   >
                        </div>
                    </div>
                    <div>
                        <label for="password" class="text-sm font-medium text-gray-900 block mb-2">Retype password</label>
                        <div class="relative flex items-center">
                            <span class="absolute inset-y-0 right-0 flex items-center p-4 cursor-pointer"
                                  onclick="passwordToggle('#passwordVisibiltyIcon', '#passwordConfirm', '#adminShowEyeIcon');"
                                  id="passwordVisibiltyIcon">
                                <ion-icon class="text-gray-600 bg-gray-100" name="eye-off" id="adminShowEyeIcon">
                                </ion-icon>
                            </span>
                            <input type="password" name="password_confirmation" id="passwordConfirm" placeholder=""
                                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 @error('password') border-red-500 @enderror"
                                   >
                        </div>
                    </div>
                    <input type="hidden" name="userType" value="{{$userType}}">
                </div>
                <button type="submit" id="SubmitBtn" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
</body>

<script src="{{ asset('webend/asset/js/app.bundle.js') }}"></script>
<script src="{{ asset('webend/asset/js/main.js') }}"></script>
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
<script>
    $(document).ready(function (){
        $('#ResetPasswordForm').on('submit', function (e){
            e.preventDefault()
            $('#SubmitBtn').text('Processing.....')
            $('.error-message').hide()
            const form = $(this)
            const formData = form.serialize();

            $.ajax({
                url: '{{route('password.reset.post')}}',
                method: 'POST',
                data: formData,
                success: function (data) {
                    if (data.response === 200) {
                        Toast.fire({
                            icon: data.type,
                            title: data.message
                        });
                        $('#SubmitBtn').text('Reset Password')

                        switch ('{{$userType}}'){
                            case 'admin':
                                window.location.href = '{{route('show.login')}}'
                                break;
                            case 'merchant':
                                window.location.href = '{{route('merchant.login.show')}}'
                                break;
                            case 'seller':
                                window.location.href = '{{route('seller.login.show')}}'
                                break;
                            case 'affiliate':
                                window.location.href = '{{route('affiliate.login.show')}}'
                        }

                    }
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 422) {
                        $('#SubmitBtn').text('Reset Password')
                        const errors = xhr.responseJSON.errors;

                        // Display error messages for each input field
                        $.each(errors, function (field, errorMessage) {
                            const inputField = $('[name="' + field + '"]');
                            inputField.after('<span class="error-message">' + errorMessage[0] + '</span>');
                        });
                    } else {
                        console.log('An error occurred:', status, error);
                    }
                }
            })
        })
    })
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
</script>

</html>
