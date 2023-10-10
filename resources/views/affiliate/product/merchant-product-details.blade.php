@extends('affiliate.layout.app')
@section('extra_css')
    <link href="{{ asset('webend/style/css/dropify.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 25px;
        }

        .dropify-wrapper .dropify-preview .dropify-render img {
            width: 100%;
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
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        <a href="{{ route('seller.dashboard') }}"
                           class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex items-center">
                            <span
                                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Product Detail</span>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="flex justify-end">
                <a style="text-decoration: none;" href="{{URL::previous() }}"
                   class="text-white bg-blue-700 hover:bg-blue-800  transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back
                </a>
            </div>


            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Product Details</h2>
                    <div
                        class="text-center text-2xl font-bold text-white flex flex-col items-center justify-center w-10/12">
                        <p>Product Code: {{ $product->product_code ? $product->product_code : ''  }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full rounded-lg mt-2 bg-gray-light p-2">
                        <div class="w-full">
                            <div class="flex gap-2">

                                @foreach($product->galleries as $gallery)
                                    <div class="border border-gray-100 object-cover overflow-hidden">
                                        @if($gallery->image != null)
                                            <img class="h-24" src="{{asset('uploads/gallery/small/'.$gallery->image)}}"
                                                 alt="Gallery Images">
                                        @endif
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <!-- table start -->
                        <div class="border border-[#8e0789] rounded-md mt-10">

                            <div class="mt-4">
                                <div class="w-full rounded-lg mt-2 bg-gray-light p-2">
                                    <table class="w-full border-collapse">
                                        <tbody class="text-left">
                                        <tr>
                                            <th class="w-1/2 py-2 px-4 border border-gray-300">Title</th>
                                            <td class="py-2 px-4 border border-gray-300">{{$product->title}}</td>
                                        </tr>
                                        <tr>
                                            <th class="py-2 px-4 border border-gray-300">Category</th>
                                            <td class="py-2 px-4 border border-gray-300">{{$product->category->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="py-2 px-4 border border-gray-300">Sub-Category</th>
                                            <td class="py-2 px-4 border border-gray-300">{{$product->sub_category ? $product->sub_category->name : ""}}</td>
                                        </tr>
                                        <tr>
                                            <th class="py-2 px-4 border border-gray-300">Discount Price (Product Owner)</th>
                                            <td class="py-2 px-4 border border-gray-300">{{ $product->purchase_price ? price_format($product->purchase_price) : ''}}</td>
                                        </tr>
                                        <tr>
                                            <th class="py-2 px-4 border border-gray-300">Purchase Price (Product Owner)</th>
                                            <td class="py-2 px-4 border border-gray-300">{{ $product->purchase_price ? price_format($product->purchase_price) : ''}}</td>
                                        </tr>
                                        <tr>
                                            <th class="py-2 px-4 border border-gray-300">Previous Price (Product Owner)</th>
                                            <td class="py-2 px-4 border border-gray-300">{{ $product->previous_price ? price_format($product->previous_price) : ''}}</td>
                                        </tr>

                                        <tr class="bg-gray-200">
                                            <th class="py-2 px-4  border border-gray-300">Current Price (Product Owner)</th>
                                            <td class="py-2 px-4 border border-gray-300">{{ $product->current_price ? price_format($product->current_price) : ''}}</td>
                                        </tr>
                                        <tr>
                                            <th class="py-2 border border-gray-300 px-4">Review</th>
                                            <td class="py-2 border border-gray-300 px-4">80</td>
                                        </tr>
                                        <tr>
                                            <th class="py-2 border border-gray-300 px-4">Rating</th>
                                            <td class="py-2 border border-gray-300 px-4">4.5</td>
                                        </tr>
                                        <tr>
                                            <th class="py-2 border border-gray-300 px-4">Delivery Charge in Dhaka</th>
                                            <td class="py-2 border border-gray-300 px-4">{{ $product->delivery_charge_in_dhaka }}</td>
                                        </tr>
                                        <tr>
                                            <th class="py-2 border border-gray-300 px-4">Delivery Charge out Dhaka:</th>
                                            <td class="py-2 border border-gray-300 px-4">{{ $product->delivery_charge_out_dhaka }}</td>
                                        </tr>
                                        <tr>
                                            <th class="py-2 border border-gray-300 px-4">Short Description</th>
                                            <td class="py-2 border border-gray-300 px-4">{{ $product->short_description }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!-- table end -->

                        <div class="flex flex-col divide-y border mt-3 rounded-md overflow-hidden">

                            <div class="flex divide-x bg-white">

                                <div class="w-full p-4">
                                    <div class="flex items-center">
                                        <div class="font-semibold">Stocks Detail</div>
                                    </div>
                                </div>
                                <div class="w-full p-4">
                                    <div class="flex items-center">
                                        <div class="font-semibold">Other Detail</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex divide-x bg-white">
                                <div class="w-full p-4">
                                    <div class="flex divide-x bg-white">

                                        <div class="w-full p-4">
                                            <div class="flex items-center">
                                                <div class="font-semibold">Size</div>
                                            </div>
                                        </div>
                                        <div class="w-full p-4">
                                            <div class="flex items-center">
                                                <div class="font-semibold">Quantity</div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($product->stocks as $stock)
                                        <div class="flex divide-x bg-white">
                                            <div class="w-full p-4">

                                                <div class="flex items-center">
                                                    <div class="font-medium">{{ $stock->size->name }}</div>
                                                </div>

                                            </div>
                                            <div class="w-full p-4">

                                                <div class="flex items-center">
                                                    <div>{{ $stock->quantity }}</div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                                <div class="w-full p-4">

                                    <div class="flex items-center">

                                    </div>

                                </div>
                            </div>

                            <!-- Size Name and Quantity end -->
                            <div class="flex divide-x bg-white">
                                <div class="w-full p-4">
                                    <div class="flex items-center gap-x-8">
                                        <div class="font-medium">Type:</div>
                                        <div>234</div>
                                    </div>
                                </div>
                                <div class="w-full p-4">
                                    <div class="flex items-center gap-x-8">
                                        <div class="font-medium">Flash Deal Amount: {{ $product->deal_amount }}</div>
                                        <div>{{ $product->deal_type }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex divide-x bg-white">
                                <div class="w-full p-4">
                                    <div class="flex items-center gap-x-8">
                                        <div class="font-medium">Status:</div>
                                        <div>{{ $product->status == 1 ? 'Active' : 'Inactive' }}</div>
                                    </div>
                                </div>
                                <div class="w-full p-4">
                                    <div class="flex items-center gap-x-8">
                                        <div class="font-medium">Most Sell:</div>
                                        <div>{{ $product->most_sale == 1 ? 'Yes' : 'No' }}</div>
                                    </div>
                                </div>
                                <div class="w-full p-4">
                                    <div class="flex items-center gap-x-8">
                                        <div class="font-medium">Best Sell:</div>
                                        <div>{{ $product->best_sale == 1 ? 'Yes' : 'No' }}</div>
                                    </div>
                                </div>
                                <div class="w-full p-4">
                                    <div class="flex items-center gap-x-8">
                                        <div class="font-medium">Recent:</div>
                                        <div>{{ $product->recent == 1 ? 'Yes' : 'No' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex divide-x bg-white">
                                <div class="w-6/12 p-4">
                                    <div class="flex items-start gap-x-4">
                                        <div class="font-medium">Flash Deal:</div>
                                        <div class="flex gap-x-2">
                                            <div><span
                                                    class="font-semibold">Start Date: </span> {{ date('d-m-Y', strtotime($product->deal_start_date)) }}
                                            </div>
                                            <div><span
                                                    class="font-semibold">End Date: </span> {{ date('d-m-Y', strtotime($product->deal_end_date)) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-3/12 p-4">
                                    <div class="flex items-center gap-x-8">
                                        <div class="font-medium">View:</div>
                                        <div>{{ $product->view }}</div>
                                    </div>
                                </div>
                                <div class="w-3/12 p-4">
                                    <div class="flex items-center gap-x-8">
                                        <div class="font-medium">Last Ordered At:</div>
                                        <div>{{ $product->last_ordered_at != null ? date('d-m-Y', strtotime($product->last_ordered_at)) : 'Null' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full p-4">
                                    <div class="flex items-start gap-x-8">
                                        <div class="font-medium">Details:</div>
                                        <div>{!! $product->description !!}</div>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="w-full" style="display:none;">--}}
{{--                                <div class="w-full p-4">--}}
{{--                                    <div class="flex items-start gap-x-8">--}}
{{--                                        <div class="font-medium">Review</div>--}}
{{--                                        <div>--}}
{{--                                            <div class="flex flex-grow gap-2 items-start justify-between">--}}
{{--                                                <div class="flex gap-x-2 items-center">--}}
{{--                                                    <div--}}
{{--                                                        class="h-12 w-12 bg-slate-300 rounded-full overflow-hidden border border-gray-200">--}}
{{--                                                        <img src="./asset/images/1.jpg" alt="">--}}
{{--                                                    </div>--}}
{{--                                                    <div class="font-medium">--}}
{{--                                                        <div>Russel Arnold</div>--}}
{{--                                                        <div class="flex gap-2 items-center">--}}
{{--                                                            <div class="flex gap-2">--}}
{{--                                                                <i class="text-amber-600 fas fa-star"></i>--}}
{{--                                                                <i class="text-amber-600 fas fa-star"></i>--}}
{{--                                                                <i class="text-amber-600 fas fa-star"></i>--}}
{{--                                                                <i class="text-amber-600 fas fa-star"></i>--}}
{{--                                                                <i class="text-zinc-600 fas fa-star"></i>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="font-medium">4.3 out of 5</div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div>2022, 2 hours ago</div>--}}
{{--                                            </div>--}}
{{--                                            <div class="mt-2">Lorem, ipsum dolor sit amet consectetur adipisicing elit.--}}
{{--                                                Veniam tempore numquam nobis? Nostrum minus dolorem quas rem--}}
{{--                                                consequuntur laboriosam quidem eos, accusamus, repudiandae aliquid--}}
{{--                                                magni. Sequi voluptate dicta veritatis tempore?--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- table end -->

        </div>

    </section>
@endsection


