@extends('webend.club_owner.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        @if(is_null($check_current_ad))
        <div class="flex justify-end">
            <a href="{{route('club_owner.ad_request')}}"  class="text-white bg-blue-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-2 py-2 text-center">
                <i class="fas fa-plus mr-2"></i>
                Ad Request
            </a>
        </div>
        @endif

        <!-- table start -->
        <div class="border border-[#8e0789] rounded-md mt-10">
            <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                <h2 class="text-2xl font-bold py-2 text-white pl-3">Advertisement List</h2>
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
                                  <span>Live</span>
                                @else
                                    <span>Expired</span>
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
