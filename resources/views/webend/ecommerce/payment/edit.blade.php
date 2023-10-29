@extends('webend.layouts.master')
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Product Payment</span>
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
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Product Payment Edit</h2>
                </div>
                <!-- Category form start -->
                <form id="submit_form" data-action="{{ route('payment.update',$payment->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">

                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Payment Name</h4>
                                    <input value="{{$payment->payment_name}}" placeholder="Enter Payment Name" name="payment_name" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" >
                                    <span class="payment_name text-red-400"></span>
                                </div>
                            </div>


                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Priority</h4>
                                    <input value="{{$payment->priority}}" min="1" placeholder="Enter Priority" name="priority"  id="priority" class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                    <span class="priority text-red-400"></span>
                                </div>
                            </div>

                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Image (300x250)px</h4>
                                    <input  name="image" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="file" accept="image/*" >
                                    <span class="image text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Status</h4>
                                    <select name="status" class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                        <option value="" selected disabled>Select Type</option>
                                        <option value="1" {{$payment->status==1 ? "selected" : ""}}>Active</option>
                                        <option value="0" {{$payment->status==0 ? "selected" : ""}}>Inactive</option>
                                    </select>
                                    <span class="status text-red-400"></span>
                                </div>
                            </div>

                        </div>

                        <div class="w-full">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Payment Method</h4>
                                <select name="payment_method_id" class="account_type w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                    <option value="" selected disabled>--Select Type--</option>
                                    @foreach($payment_methods as $payment_method)
                                        <option value="{{$payment_method->id}}" {{$payment_method->id == $payment->paymentMethod->id ? 'selected' : ''}}>{{ $payment_method->payment_method_name }}</option>
                                    @endforeach
                                </select>
                                <span class="type text-red-400"></span>
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Type</h4>
                                <select name="type" class="account_type w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                    <option value="" selected disabled>--Select Type--</option>
                                    @foreach(PAYMENT_TYPE as $data)
                                        <option value="{{$data}}" {{$payment->type==$data ? 'selected' : ''}}>{{$data}}</option>
                                    @endforeach
                                </select>
                                <span class="type text-red-400"></span>
                            </div>
                        </div>


                        @php
                            $info=json_decode($payment->account_detail)
                        @endphp

                        <div class="mobile_baking_area {{$payment->type==PAYMENT_TYPE[1] ? 'block' : 'hidden'}}">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Mobile Account Number</h4>
                                        <input value="{{$info->account_number ?? '' }}" placeholder="Enter account number" name="account_number"
                                               class="account_number w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">

                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Reference Number</h4>
                                        <input value="{{$info->ref_number ?? ''}}" placeholder="Enter reference number " name="ref_number"
                                               class="ref_number w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="baking_area {{$payment->type==PAYMENT_TYPE[2] ? 'block' : 'hidden'}}">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Bank Holder Name</h4>
                                        <input value="{{$info->bank_holder_name ?? '' }}" placeholder="Enter bank_holder_name" name="bank_holder_name"
                                               class="bank_holder_name w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Account Number</h4>
                                        <input value="{{$info->bank_account_number ?? ''}}" placeholder="Enter bank account number" name="bank_account_number"
                                               class="bank_account_number w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Bank Name</h4>
                                        <input value="{{$info->bank_name ?? '' }}" placeholder="Enter bank name" name="bank_name"
                                               class="bank_name w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Branch Name</h4>
                                        <input value="{{$info->bank_branch_name ?? '' }}" placeholder="Enter bank branch name" name="bank_branch_name"
                                               class="bank_branch_name w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Route Number</h4>
                                        <input value="{{$info->bank_route_number ?? ''}}" placeholder="Enter route number" name="bank_route_number"
                                               class="bank_route_number w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Swift Code</h4>
                                        <input value="{{$info->bank_swift_code ?? '' }}" placeholder="Enter bank swift code" name="bank_swift_code"
                                               class="bank_swift_code w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="paytm_area {{$payment->type==PAYMENT_TYPE[3] ? 'block' : 'hidden'}}">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Paytm number or code</h4>
                                        <input value="{{$info->code_or_number ?? ''}}" placeholder="Enter code or Number" name="code_or_number"
                                               class="code_or_number w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="payment_gateway_area {{$payment->type==PAYMENT_TYPE[4] ? 'block' : 'hidden'}} ">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">E-mail</h4>
                                        <input value="{{$info->online_email ?? ''}}" placeholder="Enter email" name="online_email"
                                               class="online_email w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="w-full flex justify-start">
                            <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Update
                            </button>
                        </div>
                </form>
                <!-- Category form end -->
            </div>
        </div>
    </section>
@endsection
@section('extra_js')

    <script>
        $(document).ready(function (){

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
                let formDta = new FormData(this);
                $(".submit_button").html("Processing...").prop('disabled', true)

                $.ajax({
                    url: $(this).attr('data-action'),
                    method: $(this).attr('method'),
                    data: formDta,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(data){

                            swal({
                                title: 'Good job!',
                                text: data.message,
                                icon: data.type,
                                timer: 5000,
                                // buttons: true,
                            })
                            $(".submit_button").text("Update").prop('disabled', false)

                    },
                    error:function(response){

                        if (response.status === 422) {
                            if (response.responseJSON.errors.hasOwnProperty('payment_name')) {
                                $('.payment_name').html(response.responseJSON.errors.payment_name)
                            }else{
                                $('.payment_name').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty('type')) {
                                $('.type').html(response.responseJSON.errors.type)
                            }else{
                                $('.type').html('')
                            }
                            if (response.responseJSON.errors.hasOwnProperty('image')) {
                                $('.image').html(response.responseJSON.errors.image)
                            }else{
                                $('.image').html('')
                            }
                            if (response.responseJSON.errors.hasOwnProperty('account_number')) {
                                $('.account_number').html(response.responseJSON.errors.account_number)
                            }else{
                                $('.account_number').html('')
                            }
                            if (response.responseJSON.errors.hasOwnProperty('priority')) {
                                $('.priority').html(response.responseJSON.errors.priority)
                            }else{
                                $('.priority').html('')
                            }
                        }
                        $(".submit_button").text("Update").prop('disabled', false)
                    }
                });
            });
        })
    </script>

@endsection


