@extends('webend.layouts.master')
@section('extra_css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('webend/style/css/checkbox.css')}}">
@endsection
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
                @if($count_deal>0)
                <div class="flex justify-end p-1">
                    <a href="{{route('product.all_flash_deal')}}"  class="text-white bg-blue-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                        <i class="fas fa-eye mr-2"></i>
                        All Flash Deal Product
                    </a>
                </div>
                @endif
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
                        @foreach($products as $product)
                            <tr class="hide_row{{$product->id}} bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    <img style="width: 150px;height: 60px" src="{{asset('uploads/product/small/'.$product->thumbnail) }}">
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$product->title}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{price_format($product->current_price)}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$product->current_coin}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$product->stocks->sum('quantity')}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    <select data-action="{{route('product_status_update')}}" product_id="{{$product->id}}" name="status"
                                            class="change_product_status w-full h-6 h-10 pl-2 pr-2 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                        <option value="1" {{$product->status==1 ? 'selected' : ''}}> Publish</option>
                                        <option value="0" {{$product->status==0 ? 'selected' : ''}}> Unpublish</option>
                                    </select>
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    <a  data-te-toggle="modal"
                                        data-te-target="#exampleModalDeal"
                                        data-te-ripple-init
                                        data-te-ripple-color="light" data-action="{{route('get_product_deal')}}" product_id="{{$product->id}}" href="javascript:void(0)" class="flash_deal_product_status flash_deal_status{{ $product->id }}  text-white bg-red-500 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                                        {{$product->flash_deal==1 ? 'Yes' : 'No' }}
                                    </a>

                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    <a  data-te-toggle="modal"
                                        data-te-target="#exampleModalControl"
                                        data-te-ripple-init
                                        data-te-ripple-color="light" data-action="{{route('show_product_status')}}" product_id="{{$product->id}}" href="javascript:void(0)" class="show_product_status text-white bg-purple-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                                        <i class="fas fa-solid fa-tag px-2"></i>
                                        Control
                                    </a>
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    <a href="{{route('stock.index',$product->id)}}" class="text-white bg-pink-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                                        <i class="fas fa-solid fa-warehouse px-2"></i>
                                        Stock
                                    </a>
                                </td>
                                <td class="whitespace-nowrap px-2 py-4 text-black border-r text-center">
                                    <a href="{{route('gallery.index',$product->id)}}" class="text-white bg-blue-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                                        <i class="fas fa-solid fa-images px-2"></i>
                                        Gallery
                                    </a>
                                    <a href="{{route('product.product_detail',$product->slug)}}" class="text-white bg-indigo-400  hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        View
                                    </a>
                                    <a href="{{ route('product.edit',$product->id)  }}" class="text-white bg-sky-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        Edit
                                    </a>

                                    <a href="javascriptL:;" data-action="{{route('product.delete')}}"  item_id="{{$product->id}}" type="button" class="delete_item text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
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

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('webend/style/js/product.js')}}"></script>

@endsection




