@extends('affiliate.layout.app')
@section('extra_css')
    <link href="{{ asset('webend/style/css/dropify.css') }}" rel="stylesheet">
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 25px;
        }
        .dropify-wrapper .dropify-preview .dropify-render img{
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <section class="w-full bg-white p-3 mt-5" >
        <div class="container px-2 mx-auto xl:px-5">
            <!-- start menu -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        <a href="{{ route('affiliate.dashboard') }}" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Profile</span>
                        </div>
                    </li>
                </ol>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Profile Update</h2>
                </div>
                <!-- Category form start -->
                <form id="submit_form" data-action="{{ route('affiliate.update_profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Name</h4>
                                    <input name="name" class="deposit_amount w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="text" value="{{$data->name}}">
                                    <span class="deposit_amount_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">E-mail</h4>
                                <input name="email" class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                       type="text" value="{{$data->email}}" readonly>
                                <span class="transaction_number_error text-red-400"></span>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Password</h4>
                                    <input name="password"
                                           class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="text" >
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Phone</h4>
                                    <input name="phone" class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="text" value="{{$data->phone}}">
                                </div>
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Profile Image </h4>
                                <input name="image" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="file">
                                <span class="avatar_error text-red-400"></span>
                            </div>
                        </div>

                        <div class="w-full flex justify-start">
                            <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Category form end -->
            </div>
        </div>
    </section>
@endsection

@section('extra_js')
    <script src="{{ asset('/webend/style/js/dropify.js') }}"></script>

    <script !src="">
        $(function (){
            $('body').on('submit','#submit_form',function(e){
                $('.error-message').hide()
                e.preventDefault();
                let formDta = new FormData(this);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method:$(this).attr('method'),
                    url:$(this).attr('data-action'),
                    cache: false,
                    contentType: false,
                    processData: false,
                    data:formDta,
                    success:function (data){
                        Toast.fire({
                            icon: data.type,
                            title: data.message
                        })

                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 422) {
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
                })

            })

            $("body").on('change','.get_payment_detail',function (){
                let payment_id=$(this).val();
                let image_path=($(this).attr('image_path'))

                if (payment_id !==""){
                    $(".bank_detail_area").removeClass('hidden')
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        method:"post",
                        url:$(this).attr('data-action'),
                        data:{payment_id:payment_id},
                        success:function (response){

                            $('.set_account_number').text(response.data.account_number)
                            $('.set_account_type').text(response.data.type)
                            $('.set_payment_image').attr('src',image_path+"/"+response.data.image)
                        }
                    })
                }else{
                    $(".bank_detail_area").addClass('hidden')
                }
            })

            $("body").on('click','.transfer_share',function (){

                $('.set_share_id').val($(this).attr('share_id'))
            })

            $("body").on('click','.close_modal',function (){
                $('.title_error').text("");
            })

            $('.dropify').dropify();
        })
    </script>
@endsection

