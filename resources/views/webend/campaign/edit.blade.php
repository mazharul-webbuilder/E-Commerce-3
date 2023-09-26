@extends('webend.layouts.master')
@section('extra_css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Update General Setting</span>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="border border-[#8e0789] rounded-md mt-10 mb-8">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Offer Tournament Settings</h2>
                </div>
                <!-- Category form start -->
                <form id="submit_form" action="{{route('campaign.update',$campaign->id)}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">


                            <div class="w-1/2">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Total Needed Position
                                    </h4>
                                    <input  name="total_needed_position" required  class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$campaign->total_needed_position}}" >
                                    <span class="free_login_diamond_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Total Needed Referral</h4>
                                    <input  name="total_needed_referral" required  class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                            type="number" value="{{$campaign->total_needed_referral}}" min="1">
                                    <span class="free_login_diamond_error text-red-400"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3" id="date_count">
                            <div class="w-1/4">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Start Date

                                    </h4>
                                    <input name="start_date" required  class="start_date w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$campaign->start_date}}">
                                    <span class="free_login_coin_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-1/4">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">End Date

                                    </h4>
                                    <input name="end_date" required class="end_date w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$campaign->end_date}}">

                                </div>
                            </div>
                            <div class="w-1/4">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Duration
                                    </h4>
                                    <input name="duration" readonly required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$campaign->duration}}">
                                    <span class="free_login_coin_error duration_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-1/4">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Status
                                    </h4>
                                  <select name="status"  class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none">
                                      <option {{ $campaign->status == 1 ? "selected" : '' }}  value="1">Active</option>
                                      <option {{ $campaign->status == 0 ? "selected" : '' }} value="0">Inactive</option>
                                  </select>
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
@section('extra_js')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $( ".start_date" ).datepicker({
            minDate: 0,
            dateFormat: 'yy-mm-dd'
        });
        $( ".end_date" ).datepicker({
            minDate: 0+1,
            dateFormat: 'yy-mm-dd'
        });
    </script>
@endsection

<script>

        $("#date_count").change(function(){
            var date_one =  $("input[name='start_date']").val();
            var date_two =  $("input[name='end_date']").val();
            var date1 = new Date(date_one);
            var date2 = new Date(date_two);
            days_between(date1,date2);
        });
        function days_between(date1, date2) {
            var Difference_In_Time = date2.getTime() - date1.getTime();
            var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
            if(Difference_In_Days > 0){
                $(".duration_error").css("display",'none');
                $(".submit_button").attr("disabled",false);
                $("input[name='duration']").val(Difference_In_Days);
            }else{
                $(".duration_error").css("display",'block');
                $(".submit_button").attr("disabled",true);
                $(".duration_error").html("Please Input valid start and end date");
            }
        }
    </script>
@endsection


