@extends('webend.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- table start -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        <a href="#"
                            class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="#" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">3 player</span>
                        </a>
                    </li>

                </ol>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">3 Player List</h2>
                </div>
                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <table class="text-sm text-left text-white border-l border-r" id="dataTableAuthor"
                        style=" width: 100%;">
                        <thead class="text-xs text-white uppercase bg-amber-600">
                            <tr>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    <div class="text-center">
                                        S/N
                                    </div>
                                </th>
                                <th scope="col" class="px-2 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Player 1
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Player 2
                                    </div>
                                </th>
                                <th scope="col" class="px-2 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Player 3
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Game No.
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Game id.
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        First Winner
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Second Winner
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Looser
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        First Winner coin
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Second Winner coin
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Looser coin
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Time
                                    </div>
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    <div class="text-center">
                                        Status
                                    </div>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($free_three_player as $player)
                                <tr
                                    class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td
                                        class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ \App\Models\User::find($player->player_one) ? \App\Models\User::find($player->player_one)->name : '' }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ \App\Models\User::find($player->player_two) ? \App\Models\User::find($player->player_two)->name : '' }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ \App\Models\User::find($player->player_three) ? \App\Models\User::find($player->player_three)->name : '' }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $player->game_no }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $player->game_id }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ \App\Models\User::find($player->first_winner) ? \App\Models\User::find($player->first_winner)->name : '' }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ \App\Models\User::find($player->second_winner) ? \App\Models\User::find($player->second_winner)->name : '' }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ \App\Models\User::find($player->third_winner) ? \App\Models\User::find($player->third_winner)->name : '' }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $player->first_winner_coin }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $player->second_winner_coin }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $player->third_winner_coin }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $player->created_at->format('d-m-Y h:i A') }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r whitespace-nowrap text-center">
                                        @if ($player->status == 0)
                                            <span class="bg-gray-600 text-white px-2 py-1 rounded"> Running</span>
                                        @else
                                            <span class="bg-green-600 text-white px-2 py-1 rounded"> Complete</span>
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
