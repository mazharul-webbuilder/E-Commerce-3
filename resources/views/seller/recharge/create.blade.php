@extends('seller.layout.app')

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
                        <a href="{{ route('seller.dashboard') }}" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Recharge</span>
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
            <div class="border border-[#8e0789] rounded-md mt-10 mb-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Deposit Request</h2>
                </div>
                <!-- Category form start -->
                <form id="RechargeForm" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Deposit Amount</h4>
                                    <input name="deposit_amount" class="deposit_amount w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="number" data-action="">
                                </div>
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Transaction Numbers</h4>
                                <input name="transaction_number" class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                       type="text" data-action="">
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Note</h4>
                                <input name="note" class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                       type="text" data-action="">
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Payment method</h4>
                                    <select  name="payment_id"  image_path="{{asset('uploads/payment/resize/')}}" data-action="{{route('share_owner.get_payment_detail')}}" class="get_payment_detail w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                        <option value="" selected disabled>--Select Type--</option>
                                        @foreach($payments as $payment)
                                            <option value="{{$payment->id}}" >{{$payment->payment_name}}</option>
                                        @endforeach
                                    </select>
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
                            </div>
                        </div>
                        <div class="w-full flex justify-start">
                            <input type="submit" value="Send Recharge Request" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800" />
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
    <script>
       $(document).ready(function (){
           $('#RechargeForm').on('submit', function (e) {
               e.preventDefault();
               const RechargeForm = $('#RechargeForm')[0];
               // Clear previous error messages
               $('.error-message').remove();

               // Serialize the form data
               const formData = new FormData(RechargeForm);

               $.ajax({
                   url: '{{ route('seller.recharge.post') }}',
                   type: 'POST',
                   data: formData,
                   processData: false,
                   contentType: false,
                   success: function (data) {
                       if (data.response === 200) {
                           Toast.fire({
                               icon: data.type,
                               title: data.message
                           });
                           $('#RechargeForm')[0].reset();
                       }
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
               });
           });
           /**
            * Get Payment details
            * */
           $('.get_payment_detail').on('change', function (){
               const paymentId = $(this).val()
               $.ajax({
                   url: '{{route('seller.payment.details')}}',
                   method: "GET",
                   data: {id: paymentId},
                   success: function (data) {
                    // Parse the "account_detail" JSON string to an object
                       const accountDetail = JSON.parse(data.account_detail);

                       let imagePath = '{{asset('/')}}' + 'uploads/payment/resize/' + data.image
                       $('.set_payment_image').attr('src', imagePath)
                       $('.set_account_number').text(accountDetail.bank_account_number)
                       $('.set_account_type').text(data.type)
                       $('.bank_detail_area').removeClass('hidden')
                   }
               })
           })

           $('.dropify').dropify();
       })
    </script>
@endsection

