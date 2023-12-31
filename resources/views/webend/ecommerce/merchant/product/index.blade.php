@extends('webend.layouts.master')
@section('extra_css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('webend/style/css/checkbox.css')}}">
@endsection
@section('content')
    <style>
        tbody > tr {
            height: 60px;
        }

        tbody > tr > td{
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
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        <a href="{{ route('dashboard') }}" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Merchants Products</span>
                        </div>
                    </li>
                </ol>
            </div>
            <!-- end menu -->
            <div class="border border-[#8e0789] rounded-md mt-5 mb-8">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Product List</h2>

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
                                    Title
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Merchant
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Shop Name
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
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Status
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3" width="90px">
                                <div class="text-center" style="width: 70px">
                                    Available Size
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3" width="90px">
                                <div class="text-center" style="width: 70px">
                                    Available Stock
                                </div>
                            </th>
                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Action
                                </div>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('extra_js')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('webend/style/js/product.js')}}"></script>
    <script>
        var table = $("#dataTable").DataTable({
            processing: true,
            responsive: true,
            serverSide: true,
            ordering: false,
            pagingType: "full_numbers",
            ajax: '{{ route('product.merchant.datatable') }}',
            columns: [
                { data: 'DT_RowIndex',name:'DT_RowIndex' },
                { data: 'thumbnail',name:'thumbnail'},
                { data: 'title',name:'title'},
                { data: 'merchant',name:'merchant'},
                { data: 'shop',name:'shop'},
                { data: 'current_price',name:'current_price'},
                { data: 'current_coin',name:'current_coin'},
                { data: 'status',name:'status'},
                { data: 'available_size',name:'available_size'},
                { data: 'available_stock',name:'available_stock'},
                { data: 'action',name:'action' },
            ],

            language : {
                processing: 'Processing'
            },

        });
    </script>
    <script>
        $('document').ready(function (){
            $('body').on('change', '.status-update', function (){
                const productId = $(this).data('id')
                let newStatus = $(this).val()
                $.ajax({
                    url: '{{route('product.merchant.status.update')}}',
                    method: 'get',
                    data: {
                        productId: productId,
                        newStatus: newStatus
                    },
                    success: function (data) {
                      if (data.response === 200) {
                          Toast.fire({
                              icon: data.type,
                              title: data.message
                          });
                      }
                    }
                })
            })
        })
    </script>
@endsection





