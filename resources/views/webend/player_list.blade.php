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
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Rank List</span>
                        </a>
                    </li>

                </ol>
            </div>
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        <a href="./index.html" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="./tournament.html" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 hover:text-gray-900 md:ml-2 dark:text-gray-400">Tournament</span>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="./game.html" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 hover:text-gray-900 md:ml-2 dark:text-gray-400">Game</span>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="./game_round.html" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 hover:text-gray-900 md:ml-2 dark:text-gray-400">Game Round</span>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="./board_list.html" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 hover:text-gray-900 md:ml-2 dark:text-gray-400">Board</span>
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Player</span>
                        </div>
                    </li>
                </ol>
            </div>
            <!-- end menu -->

            <!-- back button start -->
            <section>
                <div class="flex items-center gap-4 pt-4">
                    <div class="flex-none inline-block">
                        <a href="./board_list.html" class="flex items-center cursor-pointer justify-center w-9 h-9 bg-white border border-gray-300 rounded-full hover:text-white hover:bg-blue-800 hover:scale-105">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </div>
                    <div class="inline-block">
                        <p class="text-xl">Back</p>
                    </div>
                </div>
            </section>
            <!-- back button end -->

            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Player List</h2>
                    <div class="text-center text-2xl font-bold text-white flex items-center justify-center w-10/12">
                        Board Name: {{ ucfirst($board->board) }}
                    </div>
                </div>
                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <table class="text-sm text-left text-white border-l border-r" id="dataTableAuthor" style=" width: 100%;">
                        <thead class="text-xs text-white uppercase bg-amber-600">
                        <tr>

                            <th scope="col" class="px-6 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Player ID
                                </div>
                            </th>
                            <th scope="col" class="px-6 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Player Name
                                </div>
                            </th>
                            <th scope="col" class="px-6 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Tournament Name
                                </div>
                            </th>
                            <th scope="col" class="px-6 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Game No.
                                </div>
                            </th>
                            <th scope="col" class="px-6 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Board
                                </div>
                            </th>
                            <th scope="col" class="px-6 whitespace-nowrap py-3">
                                <div class="text-center">
                                    1st Winner
                                </div>
                            </th>
                            <th scope="col" class="px-6 whitespace-nowrap py-3">
                                <div class="text-center">
                                    2nd Winner
                                </div>
                            </th>
                            <th scope="col" class="px-6 whitespace-nowrap py-3">
                                <div class="text-center">
                                    3rd Winner
                                </div>
                            </th>
                            <th scope="col" class="px-6 whitespace-nowrap py-3">
                                <div class="text-center">
                                    4th Winner
                                </div>
                            </th>


                        </tr>
                        </thead>
                        <tbody>
                      @if($player != null)
                          @if($player->player_one != null)
                        <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td class="px-2 py-4 text-black border-r text-center">
                              {{ player_id($player->player_one)  }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{ player_name($player->player_one)  }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{ tournament_name($player->tournament_id) }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                               {{ $player->game->game_no }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{ $player->board_name->board }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                @if($player->player_one == $player->first_winner)
                                    <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                @else
                                @endif
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                @if($player->player_one == $player->second_winner)
                                    <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                @else
                                @endif
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                @if($player->player_one == $player->third_winner)
                                    <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                @else
                                @endif
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                @if($player->player_one == $player->fourth_winner)
                                    <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                @else
                                @endif
                            </td>


                        </tr>
                          @endif
                          @if($player->player_two != null)
                              <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                  <td class="px-2 py-4 text-black border-r text-center">
                                      {{ player_id($player->player_two)  }}
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      {{ player_name($player->player_two)  }}
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      {{ tournament_name($player->tournament_id) }}
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      {{ $player->game->game_no }}
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      {{ $player->board_name->board }}
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      @if($player->player_two == $player->first_winner)
                                          <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                      @else
                                      @endif
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      @if($player->player_two == $player->second_winner)
                                          <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                      @else
                                      @endif
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      @if($player->player_two == $player->third_winner)
                                          <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                      @else
                                      @endif
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      @if($player->player_two == $player->fourth_winner)
                                          <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                      @else
                                      @endif
                                  </td>


                              </tr>
                          @endif
                          @if($player->player_three != null)
                              <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                  <td class="px-2 py-4 text-black border-r text-center">
                                      {{ player_id($player->player_three)  }}
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      {{ player_name($player->player_three)  }}
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      {{ tournament_name($player->tournament_id) }}
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      {{ $player->game->game_no }}
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      {{ $player->board_name->board }}
                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      @if($player->player_three == $player->first_winner)
                                          <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                      @else
                                      @endif

                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      @if($player->player_three == $player->second_winner)
                                          <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                      @else
                                      @endif

                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      @if($player->player_three == $player->third_winner)
                                          <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                      @else
                                      @endif

                                  </td>
                                  <td class="px-2 py-4 text-black border-r text-center">
                                      @if($player->player_three == $player->fourth_winner)
                                          <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                      @else
                                      @endif

                                  </td>



                              </tr>
                          @endif
                              @if($player->player_four != null)
                                  <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                      <td class="px-2 py-4 text-black border-r text-center">
                                          {{ player_id($player->player_four)  }}
                                      </td>
                                      <td class="px-2 py-4 text-black border-r text-center">
                                          {{ player_name($player->player_four)  }}
                                      </td>
                                      <td class="px-2 py-4 text-black border-r text-center">
                                          {{ tournament_name($player->tournament_id) }}
                                      </td>
                                      <td class="px-2 py-4 text-black border-r text-center">
                                          {{ $player->game->game_no }}
                                      </td>
                                      <td class="px-2 py-4 text-black border-r text-center">
                                          {{ $player->board_name->board }}
                                      </td>
                                      <td class="px-2 py-4 text-black border-r text-center">
                                          @if($player->player_four == $player->first_winner)
                                              <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                          @else
                                          @endif

                                      </td>
                                      <td class="px-2 py-4 text-black border-r text-center">
                                          @if($player->player_four == $player->second_winner)
                                              <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                          @else
                                          @endif

                                      </td>
                                      <td class="px-2 py-4 text-black border-r text-center">
                                          @if($player->player_four == $player->third_winner)
                                              <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                          @else
                                          @endif

                                      </td>
                                      <td class="px-2 py-4 text-black border-r text-center">
                                          @if($player->player_four == $player->fourth_winner)
                                              <img class="object-center h-8" src="{{ asset('webend/check.png') }}">
                                          @else
                                          @endif

                                      </td>


                                  </tr>
                          @endif
                      @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- table end -->
        </div>
    </section>
@endsection
