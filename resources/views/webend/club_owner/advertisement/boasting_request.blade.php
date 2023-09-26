@extends('webend.club_owner.layouts.master')

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
                        <a href="{{ route('dashboard') }}" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Boasting Money</span>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="flex justify-end">
                <a style="text-decoration: none;" href="{{URL::previous() }}"  class="text-white bg-blue-700 hover:bg-blue-800  transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back
                </a>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Boasting Money Request</h2>
                </div>
                <!-- Category form start -->
                <form id="submit_form" data-action="{{ route('club_owner.send_boasting_request') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">


                            <div class="w-full">

                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Boasting Amount (Dollar)</h4>
                                    <input name="boasting_amount" class="boasting_amount w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="number" data-action="" required>
                                    <span class="boasting_amount_calculation hidden font-bold"></span>
{{--                                    <input type="hidden" name="boasting_dollar" class="boasting_dollar" value="">--}}
                                </div>
                            </div>

                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Transaction Numbers</h4>
                                <input name="transaction_number" class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                       type="text" data-action="" required>

                            </div>

                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Payment method</h4>
                                    <select required name="payment_id"  image_path="{{asset('uploads/payment/resize/')}}" data-action="{{route('share_owner.get_payment_detail')}}" class="get_payment_detail w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                        <option value="" selected disabled>--Select Type--</option>
                                        @foreach($payments as $payment)
                                            <option value="{{$payment->id}}" >{{$payment->payment_name}}</option>
                                        @endforeach

                                    </select>
                                    <span class="payment_id_error text-red-400"></span>
                                    <div class="bank_detail_area hidden bg-gray-100 p-4 " style="width: 500px;">
                                        <h1 class="justify-center mb-2"><strong>Payment Details</strong></h1>
                                        <img src="" class="set_payment_image" alt="logo" style="width: 70px;height: 70px">
                                        <p>Account Number: <span class="set_account_number"></span></p>
                                        <p>Account Type: <span class="set_account_type"></span></p>
                                    </div>
                                </div>

                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Image </h4>
                                <input name="image" class="dropify w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="file">
                                <span class="image_error text-red-400"></span>
                            </div>

                        </div>

                        <div class="w-full flex justify-start">
                            <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Send Boasting Request
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
                    success:function (response){

                        swal({
                            title: 'Good job!',
                            text: response.message,
                            icon: response.type,
                            timer: 5000,
                        })

                        $("#submit_form")[0].reset();

                    },
                    error:function(response){
                        if (response.status === 422) {
                            console.log(response)
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

            $("body").on('keyup','.boasting_amount',function (){
                let boasting_amount=$(this).val();
                if (boasting_amount !=""){
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        method:"post",
                        url:"{{route('club_owner.dollar_convert')}}",
                        data:{boasting_amount:boasting_amount},
                        success:function (response){

                            $('.boasting_amount_calculation').text(response.total_bdt+" "+response.total_inr).show()

                        }
                    })
                }else{
                    $('.boasting_amount_calculation').hide()
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


