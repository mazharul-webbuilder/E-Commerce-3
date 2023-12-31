<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('webend/asset/css/app.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" sizes="180*180" href="{{ asset('frontend/images/logo/nidch_logo.png') }}" >
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link href="{{ asset('webend/asset/css/style.css') }}" rel="stylesheet">
    <title>Admin Login|{{ config('app.name')}}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>

<body class="bg-gray-50">
<div class="mx-auto md:h-screen flex flex-col justify-center items-center px-6 pt-8 pt:mt-0">
    <a href="" class="text-2xl font-semibold flex justify-center items-center mb-8 lg:mb-10">

        <span class="self-center text-2xl font-bold whitespace-nowrap uppercase">{{ config('app.name')}} Club Owner LOGIN</span>
    </a>

    <!-- Card -->
    <div class="bg-white shadow rounded-lg md:mt-0 w-full sm:max-w-screen-sm xl:p-0">
        <div class="p-6 sm:p-8 lg:p-16 space-y-8">
            <div class="justify-between items-center text-center">
                <a  class="flex flex-none d-flex justify-center">
                    <img class="h-14 w-14 md:h-28 md:w-32" alt="LUDO"  src="{{ asset('webend/logo.png') }}"
                    >
                </a>
            </div>


            <form id="submit_form" class="mt-8 space-y-6" data-action="{{ route('club_owner.login.submit') }}" method="post">
                @csrf
                <div>
                    <label for="email" class="text-sm font-medium text-gray-900 block mb-2">Your email</label>
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5  " value="{{ old('email') }}" placeholder="name@company.com" required>
                </div>

                <div>
                    <label for="password" class="text-sm font-medium text-gray-900 block mb-2">Your password</label>
                    <div class="relative flex items-center">
                                    <span class="absolute inset-y-0 right-0 flex items-center p-4 cursor-pointer" onclick="passwordToggle('#passwordVisibiltyIcon', '#password', '#adminShowEyeIcon');" id="passwordVisibiltyIcon">
                                        <ion-icon class="text-gray-600 bg-gray-100" name="eye-off" id="adminShowEyeIcon"></ion-icon>
                                    </span>
                        <input type="password" name="password" id="password" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 " required>
                    </div>
                </div>


                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-cyan-200 h-4 w-4 rounded" >
                    </div>
                    <div class="text-sm ml-3">
                        <label for="remember" class="font-medium text-gray-900">Remember me</label>
                    </div>
                    <div class="w-full">
                        <div class="text-sm w-full ">
                            <p style="text-align: right">
                                <a href="{{route('forget.password', FORGET_PASSWORD_BY['clubOwner'])}}" class="text-blue-600">Forget Password ?</a>
                            </p>
                        </div>
                    </div>

                </div>
                <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">Login to your account</button>

            </form>
        </div>
    </div>
</div>
</body>


<script src="{{ asset('webend/asset/js/app.bundle.js') }}" ></script>
<script src="{{ asset('webend/asset/js/main.js') }}" ></script>
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
<script !src="">
    $(document).ready(function (){

        $('body').on('submit','#submit_form',function (e){
            e.preventDefault();
            let formData=$(this).serialize()
            $.ajax({
                type:$(this).attr('method'),
                url: $(this).attr('data-action'),
                data: formData,
                cache: false,
                success: function (response) {
                    if(response.status===200){
                        window.location=response.route
                    }
                }
            });
        })
    })
</script>
</html>
