@extends('merchant.layout.app')
@section('extra_css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        #dataTable tbody > tr {
            height: 60px;
        }
    </style>
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
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- start menu -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        <a href="{{ route('merchant.dashboard') }}" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Orders</span>
                        </div>
                    </li>
                </ol>
            </div>

            <!-- end menu -->
            <div class="border border-[#8e0789] rounded-md mt-5 mb-8">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Order List</h2>
                </div>
                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <div class="p-2">
                        <span><a href="javascript:void(0)" filter="all" class="OrderFilterBtn bg-purple-600 p-2 text-white rounded">AllOrder</a></span>
                        <span><a href="javascript:void(0)" filter="pending" class="OrderFilterBtn bg-purple-600 p-2 text-white rounded">Pending</a></span>
                        <span><a href="javascript:void(0)" filter="processing" class="OrderFilterBtn bg-purple-600 p-2 text-white rounded">Processing</a></span>
                        <span><a href="javascript:void(0)" filter="shipping" class="OrderFilterBtn bg-purple-600 p-2 text-white rounded">Shipping</a></span>
                        <span><a href="javascript:void(0)" filter="delivered" class="OrderFilterBtn bg-purple-600 p-2 text-white rounded">Delivered</a></span>
                        <span><a href="javascript:void(0)" filter="declined" class="OrderFilterBtn bg-purple-600 p-2 text-white rounded">Declined</a></span>
                        <span>
                            <input type="text" name="daterange" value="" class="date-range" />

                        </span>
                        @if ($date_range != null)
                            <span class="dark:text-blue-500">Searching Date: {{ $date_range }}</span>
                        @endif
                    </div>
                </div>
                {{--Date Input--}}
                <input type="text" name="startDate" id="startDate" value="" class="start_date">
                <input type="text" name="endDate" id="endDate" value="" class="end_date">
                {{--Date Input--}}


                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <table class="text-sm text-left text-white border-l border-r" id="dataTable" style=" width: 100%;">
                        <thead class="text-xs text-white uppercase bg-amber-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    S/N
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Order Number
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Grand Total
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Quantity
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Status
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Created at
                                </div>
                            </th>


                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Action
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="text-black py-2">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection
@include('merchant.product._flash_deal_modal')

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

    {{--Datatable of Merchant Order--}}
    <script>
        function getMerchantOrderDatatable(filter='all', startDate=null, endDate=null){
            $('#dataTable').DataTable().destroy()
            $("#dataTable").DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                ordering: true,
                pagingType: "full_numbers",
                ajax: {
                    url: '{{ route('merchant.order.load') }}',
                    method: 'GET',
                    data: {
                        filter: filter,
                        startDate: startDate,
                        endDate: endDate
                    }
                },
                columns: [
                    { data: 'DT_RowIndex',name:'DT_RowIndex' },
                    { data: 'order_number',name:'order_number'},
                    { data: 'grand_total',name:'grand_total'},
                    { data: 'order_quantity',name:'order_quantity'},
                    { data: 'status',name:'status'},
                    { data: 'created_at',name:'created_at'},
                    { data: 'action',name:'action' },
                ],
                language : {
                    processing: 'Processing'
                },
            });
        }
    </script>
    {{--Filter Datatable--}}
    <script>
        /*On Load*/
        getMerchantOrderDatatable();
        /*Filter*/
        $(document).ready(function (){
            $('.OrderFilterBtn').on('click', function (){
                const filter = $(this).attr('filter')
                getMerchantOrderDatatable(filter)
            })
            /*Filter by Date*/
            $('body').on('click', '.applyBtn', function (){
                let startDate = $('#startDate').val()
                let endDate = $('#endDate').val()
                getMerchantOrderDatatable('all', startDate, endDate)
            })
        })
    </script>
@endsection
