@extends('webend.layouts.master')
@section('extra_css')

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .date-range{
            width: 240px;
            padding: 4px 20px;
            border: 2px solid purple;
            border-radius: 9px;
            font-weight: 700;
        }
    </style>
@endsection
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- table start -->
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
                        <a href="{{ route('dashboard') }}" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Dashboard</span>
                        </a>
                    </li>

                </ol>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10 mb-6">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Rank Update History</h2>
                </div>
                <div class="px-2 py-4">
                    <span><a href="{{route('rank_update_history',['type'=>'all'])}}" class="bg-purple-600 active:bg-blue-500 p-2 text-white rounded active:red">All History</a></span>
                    <span><a href="{{route('rank_update_history',['type'=>'auto_update'])}}" class="bg-purple-600 active:bg-blue-500 p-2 text-white rounded active:red">Auto Rank Update</a></span>
                    <span><a href="{{route('rank_update_history',['type'=>'coin_update'])}}" class="bg-purple-600 active:bg-blue-500 p-2 text-white rounded active:red">Coin Rank Update</a></span>
                    <span>
                            <input type="text" name="daterange" value="" class="date-range"/>
                    </span><br><br>


                </div>
                <form id="search_order_by_date" action="{{route('rank.search_by_date')}}" method="POST" style="display: none">
                    @csrf
                    <input type="text" name="start_date" value="" class="start_date">
                    <input type="text" name="end_date" value="" class="end_date">
                </form>
                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <table class="text-sm text-left text-white border-l border-r" id="dataTableAuthor" style=" width: 100%;">
                        <thead class="text-xs text-white uppercase bg-amber-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    SI NO.
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Username
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Player Account Number
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Previous Rank
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Current Rank
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Update Type
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Rank updated date
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($histories as $history)
                            <tr class="bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $history->user->name ?? '' }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $history->user->playerid ?? '' }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    <span class="p-1">{{ $history->previous_rank->rank_name ?? '' }}</span>
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                <span class="p-1">
                                    {{ $history->current_rank->rank_name ?? '' }}
                                </span>
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                <span class="p-1">
                                    {{ string_replace($history->type)  }}
                                </span>
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                <span class="p-1">
                                    {{ $history->created_at }}
                                </span>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script !src="">
        $(function(){

            $('input[name="daterange"]').daterangepicker({
                opens: 'right',
                maxDate:new Date()
            }, function(start, end, label) {

                $('.start_date').val( start.format('YYYY-MM-DD'))
                $('.end_date').val( end.format('YYYY-MM-DD'))
                setInterval(()=>{
                    $('#search_order_by_date').submit()
                },1000)

            });

            $("body").on('change','#manage_order',function (e){
                //e.preventDefault()
                let order_id=$(this).attr('order_id');
                let status=$(this).val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method:"post",
                    url:$(this).attr('data-action'),
                    data:{order_id:order_id,status:status},
                    success:function (response){
                        swal({
                            title: response.type,
                            text: response.message,
                            icon: response.type,
                            timer: 5000,
                            // buttons: true,
                        })
                    }
                })
            })
        })

    </script>
@endsection


