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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Rank Commission History</span>
                        </div>
                    </li>
                </ol>
            </div>
            @if($datas->sum('commission_amount')>0)
            <div class="flex justify-start p-1">
                <a disabled href="javascript:;"  class="distribution_button text-white bg-blue-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                    Distribution Commission
                </a>
            </div>
            @endif

            <!-- end menu -->
            <div class="border border-[#8e0789] rounded-md mt-5">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Last Month commission History against rank update</h2>
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
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Username
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Updated From (Rank)
                                </div>
                            </th>

                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Updated To (Rank)
                                </div>
                            </th>

                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                   Commission
                                </div>
                            </th>

                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Date Tome
                                </div>
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($datas as $data)
                            <tr class="bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->rank_update_admin_store->user->name}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->rank_update_admin_store->previous_rank->rank_name}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->rank_update_admin_store->current_rank->rank_name}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$data->commission_amount}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{date("d-m-Y h:i:s A",strtotime($data->created_at))}}
                                </td>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td colspan="5" class="px-2 py-4 text-black border-r text-right">
                                <strong>Total Commission</strong>
                            </td>
                            <td class="px-2 py-4 text-black border-r text-center">
                                <strong> {{$datas->sum('commission_amount')}}</strong>
                            </td>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('extra_js')
    <script !src="">
        $(function(){
            $("body").on('click','.distribution_button',function (){
                swal({
                    title: "Are you sure to distributes?",
                    text: "If you click on ok button commission will be distributed all the controller and sub-controller!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location='{{route('admin.distribute_recovery_fund')}}'
                        }
                    });
            })
        })

    </script>
@endsection





