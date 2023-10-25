@extends('merchant.layout.app')
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Withdraw</span>
                        </div>
                    </li>
                </ol>
            </div>


            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Withdraw</h2>
                </div>

                <!-- Category form start -->
                <form id="submit_form">
                    @csrf
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Withdraw Amount</h4>
                                    <input placeholder="Enter withdraw amount"
                                           name="withdraw_balance" class="withdraw_amount w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="number"
                                           min="{{setting()->min_withdraw_limit}}"
                                           required>
                                </div>
                            </div>

                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">

                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Payment Type</h4>
                                    <select required name="payment_id" class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                        <option value="" selected disabled>--Select Type--</option>
                                        @foreach($payments as $payment)
                                            <option value="{{$payment->id}}" >{{$payment->name}}</option>
                                        @endforeach

                                    </select>
                                    <span class="type text-red-400"></span>
                                </div>
                            </div>

                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Account Type</h4>
                                    <select required name="balance_send_type" class="account_type w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                        <option value="" selected disabled>--Select Type--</option>
                                        @foreach(PAYMENT_TYPE as $data)
                                            <option value="{{$data}}" >{{$data}}</option>
                                        @endforeach

                                    </select>
                                    <span class="type text-red-400"></span>
                                </div>
                            </div>

                        </div>

                        <div class="mobile_baking_area hidden">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Mobile Account Number</h4>
                                        <input placeholder="Enter account number" name="account_number"
                                               class="account_number w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">

                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Reference Number</h4>
                                        <input placeholder="Enter reference number " name="ref_number"
                                               class="ref_number w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="baking_area hidden">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Bank Holder Name</h4>
                                        <input placeholder="Enter bank holder name" name="bank_holder_name"
                                               class="bank_holder_name w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Account Number</h4>
                                        <input placeholder="Enter bank account number" name="bank_account_number"
                                               class="bank_account_number w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Bank Name</h4>
                                        <input placeholder="Enter bank name" name="bank_name"
                                               class="bank_name w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Branch Name</h4>
                                        <input placeholder="Enter bank branch name" name="bank_branch_name"
                                               class="bank_branch_name w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Route Number</h4>
                                        <input placeholder="Enter route number" name="bank_route_number"
                                               class="bank_route_number w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Swift Code</h4>
                                        <input placeholder="Enter bank swift code" name="bank_swift_code"
                                               class="bank_swift_code w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="payment_gateway_area hidden ">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">E-mail</h4>
                                        <input placeholder="Enter email" name="online_email"
                                               class="online_email w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="paytm_area hidden">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Paytm number or code</h4>
                                        <input placeholder="Enter code or Number" name="code_or_number"
                                               class="code_or_number w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="w-full flex justify-start">
                            <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Withdraw
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
    <script !src="">
        $(function (){

            $('body').on('change','.account_type',function (){
                let type=$(this).val()

                if(type=='Mobile Banking'){

                    $('.mobile_baking_area').removeClass('hidden')
                    $('.baking_area').addClass('hidden')
                    $('.paytm_area').addClass('hidden')
                    $('.payment_gateway_area').addClass('hidden')

                    //mobile banking detail
                    $('.account_number').prop('required',true)
                    $('.ref_number').prop('required',true)

                    //bank detail
                    $('.bank_holder_name').prop('required',false)
                    $('.bank_name').prop('required',false)
                    $('.bank_account_number').prop('required',false)
                    $('.bank_branch_name').prop('required',false)
                    $('.bank_route_number').prop('required',false)
                    $('.bank_swift_code').prop('required',false)

                    // gateway detail
                    $('.online_email').prop('required',false)

                    // paytm detail
                    $('.code_or_number').prop('required',false)


                }else if(type=='Banking'){

                    $('.baking_area').removeClass('hidden')
                    $('.mobile_baking_area').addClass('hidden')
                    $('.paytm_area').addClass('hidden')
                    $('.payment_gateway_area').addClass('hidden')

                    //mobile banking detail
                    $('.account_number').prop('required',false)
                    $('.ref_number').prop('required',false)

                    //bank detail
                    $('.bank_holder_name').prop('required',true)
                    $('.bank_name').prop('required',true)
                    $('.bank_account_number').prop('required',true)
                    $('.bank_branch_name').prop('required',true)
                    $('.bank_route_number').prop('required',true)
                    $('.bank_swift_code').prop('required',true)

                    // gateway detail
                    $('.online_email').prop('required',false)

                    // paytm detail
                    $('.code_or_number').prop('required',false)

                }else if(type=='Paytm'){

                    $('.paytm_area').removeClass('hidden')
                    $('.mobile_baking_area').addClass('hidden')
                    $('.baking_area').addClass('hidden')
                    $('.payment_gateway_area').addClass('hidden')

                    //mobile banking detail
                    $('.account_number').prop('required',false)
                    $('.ref_number').prop('required',false)

                    //bank detail
                    $('.bank_holder_name').prop('required',false)
                    $('.bank_name').prop('required',false)
                    $('.bank_account_number').prop('required',false)
                    $('.bank_branch_name').prop('required',false)
                    $('.bank_route_number').prop('required',false)
                    $('.bank_swift_code').prop('required',false)

                    // gateway detail
                    $('.online_email').prop('required',false)

                    // paytm detail
                    $('.code_or_number').prop('required',true)

                }else if(type=='Payment Gateway'){

                    $('.payment_gateway_area').removeClass('hidden')
                    $('.mobile_baking_area').addClass('hidden')
                    $('.baking_area').addClass('hidden')
                    $('.paytm_area').addClass('hidden')

                    //mobile banking detail
                    $('.account_number').prop('required',false)
                    $('.ref_number').prop('required',false)

                    //bank detail
                    $('.bank_holder_name').prop('required',false)
                    $('.bank_name').prop('required',false)
                    $('.bank_account_number').prop('required',false)
                    $('.bank_branch_name').prop('required',false)
                    $('.bank_route_number').prop('required',false)
                    $('.bank_swift_code').prop('required',false)

                    // gateway detail
                    $('.online_email').prop('required',true)

                    // paytm detail
                    $('.code_or_number').prop('required',false)

                }
            })

            $('body').on('submit','#submit_form',function(e){
                e.preventDefault();
                $('.error-message').hide()
                $.ajax({
                    url: '{{ route('merchant.withdraw.request.post') }}',
                    method: 'POST',
                    data:$(this).serialize(),
                    success:function (response){
                        Toast.fire({
                            icon: response.type,
                            title: response.message
                        })
                        $("#submit_form")[0].reset();

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
        })
    </script>
@endsection
