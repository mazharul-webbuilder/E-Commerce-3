@extends('webend.club_owner.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="flex justify-end">
            <a href="{{route('club_owner.tournament_create')}}"  class="text-white bg-blue-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-2 py-2 text-center">
                <i class="fas fa-plus mr-2"></i>
                Add New Tournament
            </a>
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
                            <th scope="col" class="px-2 py-3">
                                <div class="text-center">
                                    status
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3">
                                <div class="text-center">
                                    Admin Opinion
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
                                <td class="px-2 py-4 text-black border-r whitespace-nowrap text-center">
                                    {{$tournament->status == 1? "Active" : "Inactive" }}
                                </td>
                                <td class="px-2 py-4 text-black border-r whitespace-nowrap text-center">
                                    {{$tournament->note }}
                                </td>
                                <td class="whitespace-nowrap space-x-1 text-center px-2 flex items-center">
                                    <a href="{{ route('club_owner.tournament_round',$tournament->id) }}" class="text-white py-2 bg-emerald-400 hover:bg-emerald-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 text-center">
                                        Round
                                    </a>
                                    <a href="{{ route('club_owner.tournament_game',$tournament->id) }}" type="button" class="text-white bg-fuchsia-500 hover:bg-fuchsia-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center ">
                                        Game
                                    </a>
                                    <button type="button" data-modal-toggle="editAuthor" class="text-white bg-sky-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        Edit
                                    </button>
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
