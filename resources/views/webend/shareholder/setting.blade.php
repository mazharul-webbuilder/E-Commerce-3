@extends('webend.layouts.master')
@section('extra_css')

@endsection
@section('content')
    <section class="w-full bg-white p-3 mt-5">
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Update Share Holder Setting</span>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="border border-[#8e0789] rounded-md mt-10 mb-8">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Share Holder Setting</h2>
                </div>
                <!-- Category form start -->
                <form id="submit_form" data-action="{{route('shareholder.update_setting')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="" value="{{$setting->id}}">
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Share Price
                                    </h4>
                                    <input name="share_price" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->share_price}}">
                                    <span class="share_price_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Share Holder Commission (%)
                                    </h4>
                                    <input  name="share_commission"  class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->share_commission}}" >
                                    <span class="share_commission_error text-red-400"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Referral Commission (%)
                                    </h4>
                                    <input name="referral_commission" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->referral_commission}}">
                                    <span class="referral_commission_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Withdraw charge (%)

                                    </h4>
                                    <input  name="withdraw_charge" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->withdraw_charge}}" >
                                    <span class="withdraw_charge_error text-red-400"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Max withdraw amount
                                    </h4>
                                    <input name="max_withdraw_amount" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->max_withdraw_amount}}">
                                    <span class="max_withdraw_amount_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Share transfer charge (fixed)
                                    </h4>
                                    <input  name="share_transfer_charge" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->share_transfer_charge}}">
                                    <span class="share_transfer_charge_error text-red-400"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">

                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Min withdraw amount
                                    </h4>
                                    <input name="min_withdraw_amount" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->min_withdraw_amount}}">
                                    <span class="min_withdraw_amount_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Live share commission
                                    </h4>
                                    <input name="live_share_commission" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->live_share_commission}}">
                                    <span class="live_share_commission_error text-red-400"></span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full flex">
                            <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Save Changes
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

    <script>


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
                    if (data.status==200)
                    {
                        swal("Good job!", data.message,data.type);
                        $(".submit_button").text("Save Changes").prop('disabled', false)
                    }
                },
                error:function(response){

                    if (response.status === 422) {
                        if (response.responseJSON.errors.hasOwnProperty('share_price')) {
                            $('.share_price_error').html(response.responseJSON.errors.share_price)
                        }else{
                            $('.share_price_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('share_commission')) {
                            $('.share_commission_error').html(response.responseJSON.errors.share_commission)
                        }else{
                            $('.share_commission_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('min_withdraw_amount')) {
                            $('.min_withdraw_amount_error').html(response.responseJSON.errors.min_withdraw_amount)
                        }else{
                            $('.min_withdraw_amount_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('max_withdraw_amount')) {
                            $('.max_withdraw_amount_error').html(response.responseJSON.errors.max_withdraw_amount)
                        }else{
                            $('.max_withdraw_amount_error').html('')
                        }
                        if (response.responseJSON.errors.hasOwnProperty('share_transfer_charge')) {
                            $('.share_transfer_charge_error').html(response.responseJSON.errors.share_transfer_charge)
                        }else{
                            $('.share_transfer_charge_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('withdraw_charge')) {
                            $('.withdraw_charge_error').html(response.responseJSON.errors.withdraw_charge)
                        }else{
                            $('.withdraw_charge_error').html('')
                        }
                        if (response.responseJSON.errors.hasOwnProperty('referral_commission')) {
                            $('.referral_commission_error').html(response.responseJSON.errors.referral_commission)
                        }else{
                            $('.referral_commission_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('live_share_commission')) {
                            $('.live_share_commission_error').html(response.responseJSON.errors.live_share_commission)
                        }else{
                            $('.live_share_commission_error').html('')
                        }
                    }
                    $(".submit_button").text("Update Product").prop('disabled', false)
                }
            });
        });
    </script>

@endsection


