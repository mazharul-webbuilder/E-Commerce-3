@extends('webend.layouts.master')
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
                        <a href="{{route('dashboard')}}"
                           class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 hover:scale-105">
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
                        <a href="javascript:void(0)" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Merchant Shop Detail</span>
                        </a>
                    </li>
                </ol>
            </div>
            <!-- end menu -->
            {{--Start Shop Detail--}}
            <section class="py-3">
                <div class="">
                    <h2 class="py-3 bg-purple-600 text-white text-2xl pl-2">Merchant Shop Detail</h2>
                    <div class="">
                        <div class="flex py-1">
                            <div class="text-lg p-1">Shop Logo : </div>
                            <div class="ml-5 text-lg bg-fuchsia-50	p-1 px-2 rounded">
                                <img src="{{$shop->logo ? asset("uploads/shop/resize/$shop->logo") : default_image()}}" alt="" height="80" width="80">
                            </div>
                        </div>
                    </div>
                    <div class="flex py-1">
                        <div class="text-lg p-1">Shop Name : </div>
                        <div class="ml-5 text-lg bg-fuchsia-50	p-1 px-2 rounded">{{$shop->shop_name}}</div>
                    </div>
                </div>
                <div class="">
                    <div class="flex py-1">
                        <div class="text-lg p-1">Shop Legal Name : </div>
                        <div class="ml-5 text-lg bg-fuchsia-50	p-1 px-2 rounded">{{$shop->legal_name}}</div>
                    </div>
                </div>
                <div class="">
                    <div class="flex py-1">
                        <div class="text-lg p-1">Shop Owner Name : </div>
                        <div class="ml-5 text-lg bg-fuchsia-50	p-1 px-2 rounded">{{$shop->merchant->name}}</div>
                    </div>
                </div>
                <div class="">
                    <div class="flex py-1">
                        <div class="text-lg p-1">Shop Owner Email : </div>
                        <div class="ml-5 text-lg bg-fuchsia-50	p-1 px-2 rounded">{{$shop->merchant->email}}</div>
                    </div>
                </div>
                <div class="">
                    <div class="flex py-1">
                        <div class="text-lg p-1">Shop Owner Phone : </div>
                        <div class="ml-5 text-lg bg-fuchsia-50	p-1 px-2 rounded">{{$shop->merchant->phone ? : 'Not Set'}}</div>
                    </div>
                </div>
                <div class="">
                    <div class="flex py-1">
                        <div class="text-lg p-1">Shop Address : </div>
                        <div class="ml-5 text-lg bg-fuchsia-50	p-1 px-2 rounded">{{$shop->address ? : "Not Set Yet"}}</div>
                    </div>
                </div>
                <div class="">
                    <div class="flex py-1">
                        <div class="text-lg p-1">Shop Helpline : </div>
                        <div class="ml-5 text-lg bg-fuchsia-50	p-1 px-2 rounded">{{$shop->help_line ? : "Not Set Yet"}}</div>
                    </div>
                </div>
                <div class="">
                    <div class="flex py-1">
                        <div class="text-lg p-1">Shop Available Time : </div>
                        <div class="ml-5 text-lg bg-fuchsia-50	p-1 px-2 rounded">{{$shop->available_time ? : "Not Set Yet"}}</div>
                    </div>
                </div>
                <div class="">
                    <div class="flex py-1">
                        <div class="text-lg p-1">Trade License Issued : </div>
                        <div class="ml-5 text-lg bg-fuchsia-50	p-1 px-2 rounded">{{$shop->trade_licence_issued ? : "Not Set Yet"}}</div>
                    </div>
                </div>
                <div class="">
                    <div class="flex py-1">
                        <div class="text-lg p-1">Trade License Expired : </div>
                        <div class="ml-5 text-lg bg-fuchsia-50	p-1 px-2 rounded">{{$shop->trade_licence_expired ? : "Not Set Yet"}}</div>
                    </div>
                </div>
            </section>
            {{--End Shop Detail--}}
            {{-- Start Shop Product List --}}
            <div class="">
                <h2 class="py-3 bg-purple-600 text-white text-2xl pl-2">Merchant All Products</h2>
            </div>
            <div class="flex flex-wrap -mx-4">
                <!-- Product 1 -->
                @foreach($products as $product)
                    <div class="w-full md:w-1/2 lg:w-1/4 px-4 mb-8 mt-4">
                    <div class="max-w-sm mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                        <!-- Product Image -->
                        <img class="h-48 w-full object-cover" src="{{asset("uploads/product/small/$product->thumbnail")}}" alt="Product Image">

                        <!-- Product Title -->
                        <div class="p-4">
                            <a href="#" class="block text-lg leading-tight font-medium text-black hover:underline">{{$product->title}}</a>
                            <p class="mt-2 text-gray-500">
                                @php
                                $substring = substr($product->short_description, 0, 25);
                                 @endphp
                                {{str_pad($substring, 40, '.', STR_PAD_RIGHT )}}
                            </p>
                        </div>

                        <!-- Details Button -->
                        <div class="px-4 py-2 bg-indigo-500">
                            <a href="{{route('admin.users.product.detail', $product->id)}}" class="block text-white font-semibold text-center hover:underline">Details</a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            {{-- End Shop Product List --}}
        </div>
    </section>
@endsection

@section('extra_js')

@endsection
