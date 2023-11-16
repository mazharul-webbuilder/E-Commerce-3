@extends('webend.layouts.master')
@section('extra_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
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
    <style>
        #dataTable tbody > tr {
            height: 60px;
        }
        #dataTable tbody > tr > td {
            color: black;
            text-align: center;
        }
    </style>
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">All User Withdraw List</span>
                        </a>
                    </li>
                </ol>
            </div>
            <!-- end menu -->
            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 py-3 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">All Type Of User Withdraw List</h2>
                </div>
                <br>
                <div class="py-2 px-1" style="overflow-x: auto;">
                    <div class="p-2">
                        <span><a href="javascript:void(0)"
                                 class="bg-purple-600 active:bg-blue-500 p-2 text-white rounded filter-btn" filter="all">All</a></span>
                        <span><a href="javascript:void(0)"
                                 class="bg-purple-600 p-2 text-white rounded filter-btn" filter="merchant">Merchant</a></span>
                        <span><a href="javascript:void(0)"
                                 class="bg-purple-600 p-2 text-white rounded filter-btn" filter="seller">Seller</a></span>
                        <span><a href="javascript:void(0)"
                                 class="bg-purple-600 p-2 text-white rounded filter-btn" filter="affiliator">Affiliator</a></span>
                        <span><a href="javascript:void(0)"
                                 class="bg-purple-600 p-2 text-white rounded filter-btn" filter="shareOwner">Share Owner</a></span>
                        <span><a href="javascript:void(0)"
                                 class="bg-purple-600 p-2 text-white rounded filter-btn" filter="normalUser">Normal User</a></span>
                        <span>
                            <input type="text" name="daterange" value="" class="date-range" />
                        </span>
                        {{--Show Date Span--}}
                        <span class="dark:text-blue-500 hidden">Searching Date: {{ $date_range }}</span>
                        {{--End Show Date--}}

                        {{--Take Date Input--}}
                        <input type="text" id="startDate" name="start_date" value="" class="start_date">
                        <input type="text" id="endDate" name="end_date" value="" class="end_date">
                        {{--End Take Date Input--}}

                        <br><br>
                        <h2 class="text-2xl"><strong>Total Withdraw: {{\App\Models\WithdrawHistory::count()}}</strong></h2>


                    </div>

                    <table class="text-sm text-left text-white border-l border-r dataTable2" id="dataTable"
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
                                    User Name
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    User Type
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Withdraw Amount
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Charge
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Payment Method
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Banking / Mobile Banking Detail
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Payable Amount
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
    <script>
        $(document).ready(function (){

            /*Default Load*/
            var filter="all"
            getDatatable(filter)
            /*On click filter button*/
            $('body').on('click','.filter-btn', function (){
                filter = $(this).attr('filter')
                getDatatable(filter )
            })
            /*Filter by Date*/
            $('body').on('click', '.applyBtn', function (){
                startDate = $('#startDate').val()
                endDate = $('#endDate').val()
                getDatatable('all', startDate, endDate)
            })
            /*Get withdraw Datatable function*/
            function getDatatable(filter, startDate=null, endDate=null){
                var table = $('#dataTable').DataTable();
                table.destroy()
                var table=$("#dataTable").DataTable({

                    processing: true,
                    responsive: true,
                    serverSide: true,
                    ordering: false,
                    pagingType: "full_numbers",
                    ajax: {
                        url: '{{route('admin.all.withdraw.datatable')}}',
                        method: 'get',
                        data: {
                            filter: filter,
                            startDate: startDate,
                            endDate: endDate
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex',name:'DT_RowIndex' },
                        { data: 'user_name',name:'user_name' },
                        { data: 'user_type',name:'user_type' },
                        { data: 'withdraw_balance',name:'withdraw_balance'},
                        { data: 'charge',name:'charge'},
                        { data: 'balance_send_type',name:'balance_send_type'},
                        { data: 'bank_detail',name:'bank_detail'},
                        { data: 'user_received_balance',name:'user_received_balance'},
                        { data: 'status',name:'status'},
                    ],
                    language : {
                        processing: 'Processing'
                    },
                });

            }
            /*Change Withdraw Status*/
            $('body').on('change','.status-select', function (){
                let status = $(this).val()
                let id = $(this).data('id');
                if ((status == 3) || (status == 4) ) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Change Status!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{route('ecommerce.withdraw.status.change.seller')}}',
                                method: 'POST',
                                data: {status: status, id: id},
                                success: function (data) {
                                    if (data.response === 200) {
                                        Toast.fire({
                                            icon: data.type,
                                            title: data.message
                                        })
                                    }
                                }
                            })
                        }
                    })
                } else {
                    $.ajax({
                        url: '{{route('ecommerce.withdraw.status.change.seller')}}',
                        method: 'POST',
                        data: {status: status, id: id},
                        success: function (data) {
                            if (data.response === 200) {
                                Toast.fire({
                                    icon: data.type,
                                    title: data.message
                                })
                            }
                        }
                    })
                }

            })
        })
    </script>
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

            $("body").on('change', '#manage_order', function(e) {
                //e.preventDefault()
                let order_id = $(this).attr('order_id');
                let status = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "post",
                    url: $(this).attr('data-action'),
                    data: {
                        order_id: order_id,
                        status: status
                    },
                    success: function(response) {
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
