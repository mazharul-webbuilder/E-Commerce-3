@extends('webend.layouts.master')
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Review Coin Update</span>
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
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Review Coin Update</h2>
                </div>
                <!-- Category form start -->
                <form id="submit_form" data-action="{{ route('review_coin.update') }}" method="POST">
                    @csrf
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <input type="hidden" name="id" value="{{$reviewCoin->id}}">
                            <div class="w-full flex flex-col lg:flex-row gap-4">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Ratings</h4>
                                    <select name="ratting" class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                        <option value="" disabled>--Select Ratings--</option>
                                        <option value="1" {{ $reviewCoin->ratting == 1 ? 'selected' : '' }} >Rating 1</option>
                                        <option value="2" {{ $reviewCoin->ratting == 2 ? 'selected' : '' }} >Rating 2</option>
                                        <option value="3" {{ $reviewCoin->ratting == 3 ? 'selected' : '' }} >Rating 3</option>
                                        <option value="4" {{ $reviewCoin->ratting == 4 ? 'selected' : '' }} >Rating 4</option>
                                        <option value="5" {{ $reviewCoin->ratting == 5 ? 'selected' : '' }} >Rating 5</option>
                                    </select>
                                    <span class="ratting text-red-400"></span>
                                </div>
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Reward Coins</h4>
                                    <input min="1" value="{{ $reviewCoin->reward_coin }}" placeholder="Enter Review Coins" name="reward_coin" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" >
                                    <span class="reward_coin text-red-400"></span>
                                </div>
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

    <script>
        $(document).ready(function (){
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
                        if (data.status_code==200)
                        {
                            swal({
                                title: 'Good job!',
                                text: data.message,
                                icon: data.type,
                                timer: 5000,
                                // buttons: true,
                            })
                            $(".submit_button").text("Update").prop('disabled', false)
                            $('.ratting').text('')
                            $('.reward_coin').text('')
                        }
                    },
                    error:function(response){
                        if (response.status === 422) {

                            if (response.responseJSON.errors.hasOwnProperty('ratting')) {
                                $('.ratting').html(response.responseJSON.errors.ratting)
                            }else{
                                $('.ratting').html('')
                            }
                            if (response.responseJSON.errors.hasOwnProperty('reward_coin')) {
                                $('.reward_coin').html(response.responseJSON.errors.reward_coin)
                            }else{
                                $('.reward_coin').html('')
                            }
                        }
                        if (response.status === 500) {
                            console.log(response.responseJSON)
                        }

                        $(".submit_button").text("Update").prop('disabled', false)
                    }
                });
            });
        })
    </script>

@endsection


