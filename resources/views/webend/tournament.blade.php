@extends('webend.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Tournament</span>
                        </div>
                    </li>

                </ol>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-12 mt-4">
                <div class="border border-[#8e0789] rounded-lg col-span-full overflow-hidden">
                    <div class="bg-[#8e0789] text-white overflow-hidden w-full px-0">
                        <h2 class="text-2xl font-bold py-2 pl-3">Create Tournament</h2>
                    </div>

                    <!-- Tournament form start -->
                    <form action="{{ route('create.tournament') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col gap-4 p-4 mt-3">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-gray">Game Type</h4>
                                    <div class="relative inline-flex w-full">
                                        <svg class="absolute w-6 h-6 fill-gray-600 -translate-y-1/2 pointer-events-none right-4 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                        <select name="game_type" required class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                            @foreach(config('app.game_type') as $name => $gametype_value)
                                            <option value="{{$gametype_value}}" >{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full game_sub_type">
                                    <h4 class="mb-2 font-medium text-gray">Game Sub Type</h4>
                                    <div class="relative inline-flex w-full">
                                        <svg class="absolute w-6 h-6 fill-gray-600 -translate-y-1/2 pointer-events-none right-4 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                        <select name="game_sub_type" required  class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                            @foreach(config('app.regular_sub_type') as $sub_name => $sub_gametype_value)
                                                <option value="{{$sub_gametype_value}}" >{{ $sub_name }}</option>
                                            @endforeach
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
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-gray">Status</h4>
                                    <div class="relative inline-flex w-full">
                                        <svg class="absolute w-6 h-6 fill-gray-600 -translate-y-1/2 pointer-events-none right-4 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                        <select name="status" class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                            <option value="1">Active</option>
                                            <option value="2">InActive</option>
                                        </select>
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
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Tournament List</h2>
                </div>
                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <table class="text-sm text-left text-white border-l border-r" id="dataTableAuthor" style=" width: 100%;">
                        <thead class="text-xs text-white uppercase bg-amber-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    S/N
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Game Type
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Tournament Name
                                </div>
                            </th>
                            <th scope="col" class="px-6 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Team Type
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="text-center">
                                    Registration Fee
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="text-center">
                                    Player Limit
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="text-center">
                                    Winning Prize
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="text-center">
                                    Winning Prize Detail
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3">
                                <div class="text-center">
                                    status
                                </div>
                            </th>
                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Action
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tournaments as $tournament)
                        <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                               {{ $loop->iteration }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{ game_type($tournament->game_type)}}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{$tournament->tournament_name }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{$tournament->player_type }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{$tournament->registration_fee }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{$tournament->player_limit }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{$tournament->winning_prize }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{$tournament->winner_price_detail }}
                            </td>
                            <td class="px-2 py-4 text-black border-r whitespace-nowrap text-center">
                                {{$tournament->status == 1? "Active" : "Inactive" }}
                            </td>
                            <td class="whitespace-nowrap space-x-1 text-center px-2 flex items-center">
                                <a href="{{ route('all.round_ofgame',$tournament->id) }}" class="text-white py-2 bg-emerald-400 hover:bg-emerald-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 text-center">
                                    Round
                                </a>
                                <a href="{{ route('all.game',$tournament->id) }}" type="button" class="text-white bg-fuchsia-500 hover:bg-fuchsia-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center ">
                                    Game
                                </a>
{{--                                <button type="button" data-modal-toggle="editAuthor" class="text-white bg-sky-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">--}}
{{--                                    <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>--}}
{{--                                    Edit--}}
{{--                                </button>--}}
                                @if($tournament->game_type==4)
                                    @if(!empty($tournament->campaign))
                                        @if(count($tournament->register_to_offer_tournaments)>=$tournament->player_limit)
                                            <a href="{{ route('offer_tournament_register',$tournament->id) }}" type="button" class="text-white bg-fuchsia-500 hover:bg-fuchsia-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center ">
                                                <span>House Full</span>
                                            </a>
                                        @else
                                            <a href="{{ route('offer_tournament_register',$tournament->id) }}" class="text-white bg-fuchsia-500 hover:bg-fuchsia-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center ">
                                                {{count($tournament->register_to_offer_tournaments)}} Registered
                                            </a>
                                    @endif
                                    @else
                                        <button type="button" class="text-white bg-fuchsia-500 hover:bg-fuchsia-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center ">
                                           No Campaign
                                        </button>
                                    @endif
                                @endif

                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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

            $('select[name="game_type"]').on('change', function () {
                var game_type = $(this).val();
                if (game_type) {
                    $.ajax({
                        url: 'sub-type-by-game-type/' + game_type,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            if(data == null){

                                $('.game_sub_type').css('display','none');
                                $('select[name="game_sub_type"]').removeAttr('required');
                            }else {
                                $('.game_sub_type').css('display','block');
                                $('select[name="game_sub_type"]').empty();
                                $('select[name="game_sub_type"]').attr('required',true);
                                $('select[name="game_sub_type"]').append('<option value="">Select Game Sub type</option>');
                                $.each(data, function (keys, value) {
                                    $('select[name="game_sub_type"]').append('<option value="' + value + '">' + keys + '</option>');
                                });
                            }
                        }
                    });
                } else {
                    $('select[name="unit_id"]').empty();
                }
            });
        })
    </script>

    <script>
        $(document).ready(function () {
            $('select[name="game_type"]').on('change', function () {
                var game_type = $(this).val();
                if (game_type) {
                    if((game_type == 2) || game_type == 3){
                        $('.regular_registration').css('display','none');
                        $('.regular_wining').css('display','none');
                        $('.league_registration').css('display','block');
                        $('.league_wining').css('display','block');
                        $('.game_start_delay').css('display','block');
                        $('#registration_fee').removeAttr('required');
                        $('#winning_prize').removeAttr('required');
                    }else if(game_type == 4){
                        $('.regular_registration').css('display','none');
                        $('.regular_wining').css('display','none');
                        $('.league_registration').css('display','none');
                        $('.league_wining').css('display','none');
                        $('.game_start_delay').css('display','none');
                        $('#registration_fee').removeAttr('required');
                        $('#winning_prize').removeAttr('required');
                        $('#registration_fee_token').removeAttr('required');
                        $('#registration_fee_token').removeAttr('required');
                    }else if(game_type == 1){
                        $('.regular_registration').css('display','block');
                        $('.regular_wining').css('display','block');
                        $('.league_registration').css('display','none');
                        $('.league_wining').css('display','none');
                        $('.game_start_delay').css('display','block');
                        $('#registration_fee').prop('required',true);
                        $('#winning_prize').prop('required',true);
                        $('#registration_fee_token').removeAttr('required');
                        $('#registration_fee_token').removeAttr('required');
                    }

                } else {
                    $('select[name="unit_id"]').empty();
                }
            });
        });
    </script>
@endsection
