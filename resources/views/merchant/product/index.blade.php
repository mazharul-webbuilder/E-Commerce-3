@extends('merchant.layout.app')
@section('extra_css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Products</span>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="flex justify-end">
                <a href="{{route('merchant.product.create')}}"  class="text-white bg-blue-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                    <i class="fas fa-plus mr-2"></i>
                    Add New
                </a>
            </div>


            <!-- end menu -->
            <div class="border border-[#8e0789] rounded-md mt-5 mb-8">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Product List</h2>
                </div>
                <div class="py-2 px-1 mt-3 flex" style="overflow-x: auto;">
                    <div class="p-2">
                        <span id="published">
                            <a href="javascript:void(0)" class="bg-blue-700 active:bg-blue-500 p-2 text-white rounded active:red">
                                Published
                            </a>
                        </span>

                        <span class="ml-5" id="unpublished">
                            <a href="javascript:void(0)" class="bg-cyan-600 active:bg-blue-500 p-2 text-white rounded active:red">
                                Unpublished
                            </a>
                        </span>
                    </div>
                </div>

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
                                    Thumbnail
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Name
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Current Price
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Previous Price
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Current Coin
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Status
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Flash Deal
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Control Panel
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Stock Manger
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Gallery
                                </div>
                            </th>

                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Action
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="text-black">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection
@include('merchant.product._flash_deal_modal')

@section('extra_js')
    <script>
        $(function() {
            // Initialize the datepickers with appropriate date formats
            $("#startDatePicker").datepicker({
                minDate: 0,
                dateFormat: "dd-mm-yy" // Date format (day-month-year)
            });

            $("#endDatePicker").datepicker({
                minDate: 1,
                dateFormat: "dd-mm-yy" // Date format (day-month-year)
            });
        });
    </script>
    <script>
        $(document).ready(function (){
            /*Page On Load*/
            getProductDatatable('all')
            /*End Page On load*/
            /*Published*/
            $('#published').on('click', function (){
                getProductDatatable('published')
            })
            /*Unpublished*/
            $('#unpublished').on('click', function (){
                getProductDatatable('unpublished')
            })
        })

        /*Datatable GET*/
        function getProductDatatable(filter = 'all'){
            $('#dataTable').DataTable().destroy()
            $("#dataTable").DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                ordering: true,
                pagingType: "full_numbers",
                ajax: {
                    url: '{{route('merchant.product.load')}}',
                    method: 'get',
                    data: {
                        filter: filter
                    }
                },
                columns: [
                    { data: 'DT_RowIndex',name:'DT_RowIndex' },
                    { data: 'thumbnail',name:'thumbnail', orderable: false},
                    { data: 'title',name:'title'},
                    { data: 'current_price',name:'current_price'},
                    { data: 'previous_price',name:'previous_price'},
                    { data: 'current_coin',name:'current_coin'},
                    { data: 'status',name:'status', orderable: false},
                    { data: 'flash_deal',name:'flash_deal', orderable: false},
                    { data: 'control_panel',name:'control_panel', orderable: false},
                    { data: 'stock_manager',name:'stock_manager', orderable: false},
                    { data: 'gallery',name:'gallery', orderable: false},
                    { data: 'action',name:'action', orderable: false},
                ],

                language : {
                    processing: 'Processing'
                },

            });
        }
    </script>


    @include('merchant.product.product-script')
    @include('merchant.product._control_panel_modal')
@endsection
