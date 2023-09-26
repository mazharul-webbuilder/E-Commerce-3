@extends('webend.club_owner.layouts.master')
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Boasting Money History</span>
                        </a>
                    </li>
                </ol>
            </div>
            <!-- end menu -->


            <div class="flex justify-end">

                <a href="{{route('club_owner.boasting_money_request')}}"
                   class=" text-white bg-purple-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center mr-2">
                    <i class="fas fa-plus mr-2"></i>
                    Send Boasting Money Request
                </a>

            </div>


            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 py-3 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Boasting Money History</h2>

                </div>
                <br>

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
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Boasting Amount
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Boasting Dollar

                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Transaction Number
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Payment Method
                                </div>
                            </th>


                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Created At
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Image
                                </div>
                            </th>


                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Status
                                </div>
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($datas as $data)
                            <tr
                                class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td
                                    class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->boasting_amount }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->boasting_dollar }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->transaction_number }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    hgfh
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">

                                    {{$data->created_at}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">

                                    <img class="w-60 h-30 rounded-lg" src="{{asset('uploads/boasting/'.$data->image)}}" alt="image" >
                                </td>


                                <td class="px-2 py-4 text-black border-r text-center">
                                    <span>{{deposit_withdraw_status($data->status)}}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- table end -->
        </div>

        <div
            data-te-modal-init class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div
                data-te-modal-dialog-ref
                class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                <div
                    class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                        <h5
                            class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                            id="exampleModalLabel">
                            Transfer Share Holder
                        </h5>
                        <button
                            type="button"
                            class="close_modal box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                            data-te-modal-dismiss
                            aria-label="Close">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-6 w-6">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="relative flex-auto p-4" data-te-modal-body-ref>

                        <form class="submit_form" data-action="{{ route('share_owner.transfer_share') }}" method="post">
                            @csrf
                            <input type="hidden" class="set_share_id" name="share_id" value="">
                            <div class="flex flex-col gap-2 p-1">
                                <span>Share Owner Humber</span>
                                <input type="text" class="add_destination w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none set_token_title"
                                       value="" name="share_owner_number" data-action="{{route('share_owner.add_destination')}}">
                                <span class="set_message"></span>
                            </div>

                            <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg
                           focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out">Transfer</button>
                        </form>
                    </div>

                    <div
                        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('extra_js')

@endsection

