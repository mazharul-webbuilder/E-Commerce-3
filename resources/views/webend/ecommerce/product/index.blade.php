@extends('webend.layouts.master')
@section('extra_css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('webend/style/css/checkbox.css')}}">
@endsection
@section('content')
    <style>
        #productDatatable tbody > tr {
            height: 60px;
        }
        #productDatatable tbody > tr > td {
            color: black;
        }
    </style>
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Products</span>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="flex justify-end">
                <a href="{{route('product.create')}}"  class="text-white bg-blue-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                    <i class="fas fa-plus mr-2"></i>
                    Add New
                </a>
            </div>


            <!-- end menu -->
            <div class="border border-[#8e0789] rounded-md mt-5 mb-8">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Product List</h2>

                </div>
                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <table class="text-sm text-left text-white border-l border-r" id="productDatatable" style=" width: 100%;">
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
                                    Current Coin
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3" width="90px">
                                <div class="text-center" style="width: 70px">
                                    Available Stock
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3" width="90px">
                                <div class="text-center" style="width: 70px">
                                    Status
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3">
                                <div class="text-center">
                                    Flash Deal
                                </div>
                            </th>

                            <th scope="col" class="px-2 py-3">
                                <div class="text-center">
                                    Control Panel
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3">
                                <div class="text-center">
                                    Stock Manage
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

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- table end -->
            <!-- Modal -->
            @include('webend.ecommerce.product.modal.control')
            @include('webend.ecommerce.product.modal.deal')
            <!-- Modal toggle -->
        </div>
    </section>
@endsection
@section('extra_js')
    <script>
        $(document).ready(function (){
            $("#productDatatable").DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                ordering: false,
                pagingType: "full_numbers",
                ajax: '{{ route('product.datatable') }}',
                columns: [
                    { data: 'DT_RowIndex',name:'DT_RowIndex' },
                    { data: 'thumbnail',name:'thumbnail' },
                    { data: 'title',name:'title' },
                    { data: 'current_price',name:'current_price' },
                    { data: 'current_coin',name:'current_coin' },
                    { data: 'stock',name:'stock' },
                    { data: 'status',name:'status' },
                    { data: 'flash_deal',name:'flash_deal' },
                    { data: 'control_panel',name:'control_panel' },
                    { data: 'stock_management',name:'stock_management' },
                    { data: 'action',name:'action' },
                ],
                language : {
                    processing: 'Processing'
                },
            });
        })
    </script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('webend/style/js/product.js')}}"></script>


@endsection




