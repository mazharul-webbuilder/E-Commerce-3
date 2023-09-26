@extends('webend.layouts.master')

@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- start menu -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        <a href="{{ route('dashboard') }}"
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
                        <a href="{{ route('all.tournament') }}" class="flex items-center hover:scale-105">
                            <span
                                class="ml-1 font-medium text-gray-500 hover:text-gray-900 md:ml-2 dark:text-gray-400">Tournament</span>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a class="flex items-center hover:scale-105">
                            <span
                                class="ml-1 font-medium text-gray-500 hover:text-gray-900 md:ml-2 dark:text-gray-400">Game</span>
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Game Round</span>
                        </div>
                    </li>
                </ol>
            </div>
            <!-- end menu -->

            <!-- back button start -->
            <section>
                <div class="flex items-center gap-4 pt-4">
                    <div class="flex-none inline-block">
                        <a href="{{ route('all.game', $game->tournament_id) }}"
                            class="flex items-center cursor-pointer justify-center w-9 h-9 bg-white border border-gray-300 rounded-full hover:text-white hover:bg-blue-800 hover:scale-105">
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
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Game Round List</h2>
                    <div class="text-center text-2xl font-bold text-white flex items-center justify-center w-10/12">
                        Game No: {{ $game->game_no }}
                    </div>
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
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Round No.
                                    </div>
                                </th>
                                <th scope="col" class="px-2 whitespace-nowrap py-3">
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
                                        Round End Time
                                    </div>
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    <div class="text-center">
                                        Status
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
                            @foreach ($rounds as $round)
                                <tr
                                    class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td
                                        class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $round->round_no }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $round->tournament->tournament_name }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $round->game->game_no }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        @if ($round->round_end_time != null)
                                            {{ \Carbon\Carbon::parse($round->round_end_time)->format('d-m-Y, g:i:A') }}
                                        @else
                                        @endif
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        @if ($round->status == 0)
                                            Pending
                                        @elseif($round->status == 1)
                                            Running
                                        @elseif($round->status == 2)
                                            Complete
                                        @endif
                                    </td>
                                    <td
                                        class="whitespace-nowrap space-x-1 text-center px-2 flex items-center justify-center">
                                        <!-- <button type="button" data-modal-toggle="editAuthor" class="text-white bg-sky-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                            Edit
                                        </button> -->
                                        <a href="{{ route('all.board', $round->id) }}"
                                            class="text-white py-2 bg-emerald-400 hover:bg-emerald-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 text-center">
                                            Board
                                        </a>
                                        {{--                            <a href="#" type="button" class="text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor"> --}}
                                        {{--                                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> --}}
                                        {{--                                Delete --}}
                                        {{--                            </a> --}}
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
