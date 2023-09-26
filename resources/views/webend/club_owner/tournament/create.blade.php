@extends('webend.club_owner.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-12 mt-4">
                <div class="border border-[#8e0789] rounded-lg col-span-full overflow-hidden">
                    <div class="bg-[#8e0789] text-white overflow-hidden w-full px-0">
                        <h2 class="text-2xl font-bold py-2 pl-3">Advertisement Information</h2>
                    </div>

                    <!-- Tournament form start -->
                    <form action="{{ route('club_owner.tournament_store') }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-4 p-4 mt-3">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-gray">Game Type</h4>
                                    <div class="relative inline-flex w-full">
                                        <svg class="absolute w-6 h-6 fill-gray-600 -translate-y-1/2 pointer-events-none right-4 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                        <select name="game_type" required class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                                <option value="1" >Regular</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full game_sub_type">
                                    <h4 class="mb-2 font-medium text-gray">Game Sub Type</h4>
                                    <div class="relative inline-flex w-full">
                                        <svg class="absolute w-6 h-6 fill-gray-600 -translate-y-1/2 pointer-events-none right-4 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                        <select name="game_sub_type" required  class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                                <option value="1" >General</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Tournament Name</h4>
                                        <input placeholder="Enter Tournament Name" name="tournament_name" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-gray">Player Type</h4>
                                    <div class="relative inline-flex w-full">
                                        <svg class="absolute w-6 h-6 fill-gray-600 -translate-y-1/2 pointer-events-none right-4 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                        <select name="player_type" required class="select_player_type w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                            <option value="">Select Player Type</option>
                                            <option value="2p">2p</option>
                                            <option value="4p">4p</option>
                                            <option value="team">Team</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-gray">Player Limit</h4>
                                    <div class="relative inline-flex w-full">
                                        <svg class="absolute w-6 h-6 fill-gray-600 -translate-y-1/2 pointer-events-none right-4 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                        <select name="player_limit" required class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                            <option value="" class="player_limit_option0">Select Player Limit</option>
                                            @for($i = 2 ; $i < 2000 ; $i*=2 )
                                                @php
                                                    $output1 = 2 * $i;
                                                @endphp
                                                <option value="{{ $output1 }}" class="player_limit_option{{$output1}}">{{ $output1 }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                                <div class="w-full regular_registration">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Registration Fee</h4>
                                        <input required id="registration_fee" placeholder="Enter Registration Fee" name="registration_fee" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                    </div>
                                </div>
                                <div class="w-full regular_wining">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Winning Prize</h4>
                                        <input required id="winning_prize" placeholder="Enter Winning Prize" name="winning_prize" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                    </div>
                                </div>
                                <div class="w-full league_registration" style="display: none">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Registration Fee (Token)</h4>
                                        <input required id="registration_fee_token" value="1" readonly name="registration_fee_token" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                    </div>
                                </div>
                                <div class="w-full league_wining" style="display: none">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Winning Prize (Token)</h4>
                                        <input required id="winning_prize_token" value="1" readonly placeholder="Enter Winning Prize" name="winning_prize_token" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                    </div>
                                </div>
                                <div class="w-full league_wining_prize" >
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Winning Prize (details)</h4>
                                        <textarea required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" name="prize_details"></textarea>
                                    </div>
                                </div>
                                <div class="w-full pl-6">
                                    <h4 class="mb-2 font-medium text-zinc-700">Diamond use</h4>
                                    <div class="w-full flex gap-x-6">
                                        <label for="diamond_active" class="flex gap-x-3 items-center h-8">
                                            <input required value="1" name="diamond_use" id="diamond_active" class="diamond_active w-full h-8 px-4 border border-gray-300 rounded-md cursor-pointer text-zinc-700 focus:outline-none" checked type="radio">
                                            Active
                                        </label>
                                        <label for="diamond_inactive" class="flex gap-x-3 items-center h-8">
                                            <input required value="0" name="diamond_use" id="diamond_inactive" class="diamond_inactive w-full h-8 px-4 border border-gray-300 rounded-md cursor-pointer text-zinc-700 focus:outline-none" type="radio">
                                            InActive
                                        </label>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Diamond Use Limit in Tournament Game</h4>
                                        <input  placeholder="Enter tournament use limit" name="diamond_limit" id="diamond_limit" class="diamond_limit w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                    </div>
                                </div>

                            </div>
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full pl-6">
                                    <h4 class="mb-2 font-medium text-zinc-700">Un Registration</h4>
                                    <div class="w-full flex gap-x-6">
                                        <label for="registration_active" class="flex gap-x-3 items-center h-8">
                                            <input required value="1" name="registration_use" id="registration_active" class="w-full h-8 px-4 border border-gray-300 rounded-md cursor-pointer text-zinc-700 focus:outline-none" checked type="radio">
                                            Active
                                        </label>
                                        <label for="registration_inactive" class="flex gap-x-3 items-center h-8">
                                            <input required value="0" name="registration_use" id="registration_inactive" class="w-full h-8 px-4 border border-gray-300 rounded-md cursor-pointer text-zinc-700 focus:outline-none" type="radio">
                                            InActive
                                        </label>
                                    </div>
                                </div>
                                <div class="w-full game_start_delay">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700 text-center">Game Start Delay Time</h4>
                                        <div class="flex justify-between items-center gap-x-2">
                                            <div class="w-full">
                                                <select name="hour" class="js-example-basic-single1 flex items-center w-full pl-4 pr-10 h-12 focus:ring-0 bg-white border border-gray-200 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                                    <option value="">Hour</option>
                                                    @for($i = 0;$i<100 ; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="w-full">
                                                <select name="minute" class="js-example-basic-single2 flex items-center w-full pl-4 pr-10 h-12 focus:ring-0 bg-white border border-gray-200 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                                    <option value="">Minute</option>
                                                    @for($i = 1;$i<60 ; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Diamond Use Limit in Round</h4>
                                        <input  placeholder="Enter round use limit" name="diamond_limit_round" id="diamond_limit" class="diamond_limit w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                    </div>
                                </div>



                            </div>
                            <div class="w-full flex justify-end">
                                <button type="submit" class="inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- Tournament form end -->
                </div>
            </div>

            <!-- table start -->

            <!-- table end -->
        </div>
    </section>
@endsection
@section('extra_js')
    <script !src="">
        $(document).ready(function (){
            $('body').on('change','.select_player_type',function (){
                let player_type=$(this).val();
                if(player_type==="2p"){
                    $(".player_limit_option4").css("display","none")
                }else{
                    $(".player_limit_option4").css("display","block")
                }
            })
        })
    </script>
@endsection

