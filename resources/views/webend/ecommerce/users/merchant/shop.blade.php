@extends('webend.layouts.master')

@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- start menu -->
            <!-- ... (your menu code) ... -->

            {{-- Start Shop Detail --}}
            <section class="py-3">
                <!-- ... (your shop detail code) ... -->
            </section>
            {{-- End Shop Detail --}}

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
