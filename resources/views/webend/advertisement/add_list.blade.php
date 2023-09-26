


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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Ad List</span>
                        </div>
                    </li>
                </ol>
            </div>
            <!-- end menu -->
            <div class="border border-[#8e0789] rounded-md mt-5">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Ad List</h2>

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
                                    Club Owner
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Ad Duration
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Time Slot Section
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Time Slot
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Total Ad
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Total Day
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Total Cost
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Ad Show Per Day
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Add Start Day
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Add End Day
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Status
                                </div>
                            </th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($datas as $data)
                            <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{$loop->index+1}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->owner->name}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->ad_duration->title}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->time_slot_section->section_name ?? 'N\A'}}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    @if($data->time_slot !=null)
                                        {{  $data->time_slot->time_slot_from." to ".$data->time_slot->time_slot_to}}
                                    @else
                                        {{"N\A"}}
                                    @endif

                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->total_ad}}
                                </td>


                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->total_day}}
                                </td>


                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->total_cost}}
                                </td>



                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->ad_show_per_day}}
                                </td>


                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->ad_start_from}}
                                </td>


                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->ad_end_in}}
                                </td>


                                <td class="px-2 py-4 text-black border-r text-center">
                                    @if($data->status==0)
                                        <span class="p-1 rounded bg-green-500 text-white">Live</span>
                                    @else
                                        <span class="p-1 rounded bg-red-500 text-white">Expired</span>
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
    <script>
        $(document).ready(function(){

        })

    </script>
@endsection




