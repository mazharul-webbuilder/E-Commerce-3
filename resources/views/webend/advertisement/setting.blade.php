@extends('webend.layouts.master')
@section('extra_css')
    <style>
        .input-field_border{
            border: 2px solid #000;
        }
    </style>
@endsection
@section('content')
    <section class="w-full bg-white p-3 mt-5" >
        <div class="container px-2 mx-auto xl:px-5"  >
            <!-- table start -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        <a href="{{route('dashboard')}}" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>

                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Advertisement Setting</span>
                        </div>
                    </li>

                </ol>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Advertisement Setting</h2>
                </div>

                <div class="py-2 px-1 mt-3" style="overflow-x: auto;" >
                    <form id="submit_form" data-action="{{ route('advertisement.setting_update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$data->id}}">
                        <div class="flex flex-col gap-4 p-4 mt-3">

                            <div class="flex flex-col md:flex-row justify-between gap-3" id="date_count">
                                <div class="w-1/3">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Visitor Stay Time <span>(As second)</span></h4>
                                        <input  name="visitor_stay_time" required  class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                                type="number" value="{{$data->visitor_stay_time}}">
                                    </div>
                                </div>
                                <div class="w-1/3">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Ad Stay Time

                                        </h4>
                                        <input name="ad_stay_time" required  class="start_date w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                               type="text" value="{{$data->ad_stay_time}}">

                                    </div>
                                </div>

                                <div class="w-1/3">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Minimum Ad limit</h4>
                                        <input name="minimum_ad_limit" value="{{$data->minimum_ad_limit}}" required class="end_date w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">

                                    </div>
                                </div>
                                <div class="w-1/4">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Maximum Ad Limit
                                        </h4>
                                        <input name="maximum_ad_limit" value="{{$data->maximum_ad_limit}}" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" >

                                    </div>
                                </div>
                                <div class="w-1/4">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Ad Show per day
                                        </h4>
                                        <input name="ad_show_per_day" value="{{$data->ad_show_per_day}}" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" >

                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row justify-between gap-3" id="date_count">
                                <div class="w-1/3">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Add Continue day</h4>
                                        <input  name="ad_continue_day" required  class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                                type="number" value="{{$data->ad_continue_day}}">
                                    </div>
                                </div>
                                <div class="w-1/3">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Advertiser referral Commission

                                        </h4>
                                        <input name="advertiser_referral_commission" required  class="start_date w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                               type="text" value="{{$data->advertiser_referral_commission}}">

                                    </div>
                                </div>

                                <div class="w-1/3">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Share holder fund commission</h4>
                                        <input name="share_holder_fund_commission" value="{{$data->share_holder_fund_commission}}" required class="end_date w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">

                                    </div>
                                </div>
                                <div class="w-1/4">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Asset fund commission
                                        </h4>
                                        <input name="asset_fund_commission" value="{{$data->asset_fund_commission}}" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" >

                                    </div>
                                </div>
                                <div class="w-1/4">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">visitor commission
                                        </h4>
                                        <input name="visitor_commission" value="{{$data->visitor_commission}}" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" >

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
                </div>
            </div>

        </div>
    </section>
@endsection

@section('extra_js')


    <script !src="">
        $(function (){

            $('body').on('submit','#submit_form',function(e){
                e.preventDefault();
                let formDta = new FormData(this);
                $(".submit_button").text("Processing").attr('disabled',true)
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

                        $(".submit_button").text("Save Changes").attr('disabled',false)


                    },
                    error:function(response){
                        if (response.status === 422) {
                            console.log(response)
                        }

                        $(".submit_button").text("Save Change").attr('disabled',false)

                    }
                })

            })

        })
    </script>
@endsection

