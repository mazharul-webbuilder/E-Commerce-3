@extends('webend.club_owner.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <!-- table start -->
        <div class="border border-[#8e0789] rounded-md mt-10">
            <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                <h2 class="text-2xl font-bold py-2 text-white pl-3">Club Member List</h2>
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
                                Member Name
                            </div>
                        </th>
                        <th scope="col" class="px-2 whitespace-nowrap py-3">
                            <div class="text-center">
                                Rank
                            </div>
                        </th>
                        <th scope="col" class="px-2 whitespace-nowrap py-3">
                            <div class="text-center">
                                Diamond Partner
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($club_members as $club_member)
                        <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{ $club_member->name}}
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                {{ $club_member->rank->rank_name}}
                            </td>

                            <td class="px-2 py-4 text-black border-r text-center">
                                {{ $club_member->diamond_partner==1 ? "Diamond User" : "Not Diamond User"}}
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
