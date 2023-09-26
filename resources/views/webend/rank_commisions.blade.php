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
                        <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Rank List</span>
                    </div>
                </li>
            </ol>
        </div>
        <!-- end menu -->

        @if(Request::routeIs('rank_commission.edit'))
            <!-- Rank form start -->
                <div class="border border-[#8e0789] rounded-md mt-10">
                    <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                        <h2 class="text-2xl font-bold py-2 text-white pl-3">Settings Update of {{ $rank_commission->rank_name  }} Rank</h2>
                    </div>
                    <!-- rank form start -->
                    <form action="{{ route('rank_commission.update',$rank_commission->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col gap-4 p-4 mt-3">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Register Commission (%)</h4>
                                        <input  name="registration_commission" required value="{{ $rank_commission->registration_commission }}" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" step="0.01" >
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Diamond use commission(Per Diamond)</h4>
                                        <input  value="{{ $rank_commission->diamond_commission }}" required name="diamond_commission" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" step="0.01" >
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Bidding (%)</h4>
                                        <input value="{{ $rank_commission->betting_commission }}" required name="betting_commission" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" step="0.01" >
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Withdraw (%)</h4>
                                        <input value="{{ $rank_commission->withdraw_commission }}" required name="withdraw_commission" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" step="0.01" >
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Game Asset (Flat)</h4>
                                        <input value="{{ $rank_commission->game_asset_commission }}" required name="game_asset_commission" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" step="0.01" >
                                    </div>
                                </div>
                                <div class="w-full" style="display: none">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Updating</h4>
                                        <input value="{{ $rank_commission->updating_commission }}" required name="updating_commission" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" step="0.01" >
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
                    <!-- rank form end -->
                </div>
                <!-- Rank form end -->
        @else


        <!-- table start -->
        <div class="border border-[#8e0789] rounded-md mt-10">
            <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                <h2 class="text-2xl font-bold py-2 text-white pl-3">Rank Commission List</h2>
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
                        <th scope="col" class="px-6 whitespace-nowrap py-3">
                            <div class="text-center">
                               Rank Name
                            </div>
                        </th>
                        <th scope="col" class="px-2 whitespace-nowrap py-3">
                            <div class="text-center">
                               Regi. Commission (%)
                            </div>
                        </th>
                        <th scope="col" class="px-6 whitespace-nowrap py-3">
                            <div class="text-center">
                              Diamond use commission (Per diamond)
                            </div>
                        </th>
                        <th scope="col" class="px-6 whitespace-nowrap py-3">
                            <div class="text-center">
                               Bidding Commission (%)
                            </div>
                        </th>
                        <th scope="col" class="px-2 py-3">
                            <div class="text-center">
                               Withdraw Commission (%)
                            </div>
                        </th>
                        <th scope="col" class="px-2 py-3">
                            <div class="text-center">
                                G. Asset Commission (Flat)
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
                    @foreach($rank_commissions as $commission)
                    <tr style="display: @if($commission->rank->priority==0 || $commission->rank->priority==1) none @endif" class="bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                         {{ $loop->iteration }}
                        </td>
                        <td class="px-2 py-4 text-black border-r text-center">
                           {{ $commission->rank_name }}
                        </td>
                        <td class="px-2 py-4 text-black border-r text-center">
                            {{ $commission->registration_commission }}
                        </td>
                        <td class="px-2 py-4 text-black border-r text-center">
                            {{ $commission->diamond_commission }}
                        </td>
                        <td class="px-2 py-4 text-black border-r text-center">
                            {{ $commission->betting_commission }}
                        </td>
                        <td class="px-2 py-4 text-black border-r text-center">
                            {{ $commission->withdraw_commission }}
                        </td>
                        <td class="px-2 py-4 text-black border-r text-center">
                            {{ $commission->game_asset_commission }}
                        </td>
                        <td class="whitespace-nowrap space-x-1 text-center px-2 flex items-center justify-center">
                            <a href="{{ route('rank_commission.edit', $commission->id) }}" class="text-white bg-sky-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                                <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <!-- table end -->
            @endif
    </div>
</section>
@endsection
