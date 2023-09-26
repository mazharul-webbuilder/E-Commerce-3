@extends('webend.layouts.master')
@section('extra_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .input-field_border {
            border: 2px solid #000;
        }

        .date-range {
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Share Holder</span>
                        </a>
                    </li>
                </ol>
            </div>
            <!-- end menu -->


            <div class="flex justify-end">
                <a href="{{ route('shareholder.create_share_owner') }}"
                   class="text-white bg-blue-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                    <i class="fas fa-plus mr-2"></i>
                    Add Dashboard owner
                </a>
            </div>

            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 py-3 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Share Holder List</h2>

                </div>
                <br>
                <div class="px-2 py-4 hidden">
                    <span>
                        <a href="{{ route('shareholder.share_holder') }}"
                           class="bg-purple-600 active:bg-blue-500 p-2 text-white rounded active:red">
                            All History</a></span>
                    <span>
                        <input type="text" name="daterange" value="" class="date-range" />
                    </span><br><br>
                </div>
                <form id="search_order_by_date" action="{{ route('share_holder_by_date') }}" method="POST"
                      style="display: none">
                    @csrf
                    <input type="text" name="start_date" value="" class="start_date">
                    <input type="text" name="end_date" value="" class="end_date">
                </form>
                <div class="p-2">
                    <p><strong>Total Share Sale: {{$shares->sum('share_purchase_price')}} </strong></p>
                    <p><strong>Total Share Owner: {{$datas->count()}} </strong></p>
                    <p><strong>Total Share: {{$shares->count()}} </strong></p>
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
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Username
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Share Owner Number
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    E-mail
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Total Balance
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Total Share
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
                        @foreach ($datas as $data)
                            <tr
                                class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td
                                    class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td
                                    class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $data->name }}
                                </td>
                                <td
                                    class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $data->share_owner_number }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->email }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->balance }}
                                </td>

                                <td
                                    class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $data->share_holders->count() }}
                                </td>

                                <td class="whitespace-nowrap space-x-1 text-center px-2 flex items-center justify-center">

                                    <a href="{{route('shareholder.edit_share_owner',$data->id)}}" class=" text-white bg-green-500 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center ">
                                        Edit
                                    </a>

                                    <a href="javascript:;" data-action="{{route('shareholder.provide_share')}}" share_owner_id="{{$data->id}}" class="provide_share text-white bg-blue-500 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center ">
                                        Provide Share
                                    </a>

                                    <a href="{{route('shareholder.user_all_share',$data->id)}}" class=" text-white bg-red-500 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center ">
                                        View Share
                                    </a>


                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- table end -->
        </div>

        <div data-te-modal-init
             class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
             id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div data-te-modal-dialog-ref
                 class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                <div
                    class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                        <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                            id="exampleModalLabel">
                            Share Holder Detail
                        </h5>
                        <button type="button"
                                class="close_modal box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                                data-te-modal-dismiss aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="relative flex-auto p-4 detail_table" data-te-modal-body-ref>

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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script !src="">
        $(function() {

            $('input[name="daterange"]').daterangepicker({
                opens: 'right',
                maxDate: new Date()
            }, function(start, end, label) {

                $('.start_date').val(start.format('YYYY-MM-DD'))
                $('.end_date').val(end.format('YYYY-MM-DD'))
                setInterval(() => {
                    $('#search_order_by_date').submit()
                }, 1000)

            });

        })
    </script>
    <script !src="">
        $(document).ready(function() {
            $('body').on('click', '.show_modal_data', function() {
                let user_id = $(this).attr('share_holder_id')
                let path = "{{ route('shareholder.share_purchased_detail', ':user_id') }}";
                let url = path.replace(':user_id', user_id);
                $.ajax({
                    type: "get",
                    url: url,
                    data: {
                        user_id: user_id
                    },
                    cache: false,
                    success: function(response) {
                        $('.detail_table').html(response.data)
                    }
                });
            })


            $('body').on('click','.provide_share',function(){
                let share_owner_id=$(this).attr('share_owner_id');


                swal("Provide Share price", {
                    content: "input",
                }).then((value) => {
                    if (value) {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: $(this).attr('data-action'),
                        method: 'post',
                        data: {share_owner_id: share_owner_id, share_price: value},
                        success: function (data) {
                            swal({
                                title: 'Good job!',
                                text: data.message,
                                icon: data.type,
                                timer: 5000,
                            })
                        }
                    });
                  }else{
                        swal({
                            title: 'Something wrong',
                            text: "Please provide Share price",
                            icon: "error",
                            timer: 5000,
                        })
                    }
                });

            })

        })
    </script>
@endsection
