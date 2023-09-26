@extends('webend.layouts.master')
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Order</span>
                        </div>
                    </li>
                </ol>
            </div>

            <!-- end menu -->
            <section>
                <div class="flex items-center gap-4 pt-4">
                    <div class="flex-none inline-block">
                        <a href="{{route('order.index',ORDER_TYPE[0])}}" class="flex items-center cursor-pointer justify-center w-9 h-9 bg-white border border-gray-300 rounded-full hover:text-white hover:bg-blue-800 hover:scale-105">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </div>
                    <div class="inline-block">
                        <p class="text-xl">Back</p>
                    </div>
                </div>
            </section>
            <div class="flex divide-x bg-white">
                <div class="w-full p-4">
                    <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                        <h2 class="text-2xl font-bold py-2 text-white pl-3">Order Detail</h2>
                    </div>
                    <div class="flex items-start gap-x-8 p-1 text-justify">
                        <div class="font-medium">Order Number:</div>
                        <div>#{{$order->order_number}}</div>
                    </div>
                    <div class="flex items-start gap-x-8 p-1 text-justify">
                        <div class="font-medium">Order Date:</div>
                        <div>{{date('d-m-Y',strtotime($order->created_at))}}</div>
                    </div>
                    <div class="flex items-start gap-x-8 p-1 text-justify">
                        <div class="font-medium">Total Order Item:</div>
                        <div>{{$order->quantity}}</div>
                    </div>
                    <div class="flex items-start gap-x-8 p-1 text-justify">
                        <div class="font-medium">Tax/Vat:</div>
                        <div>{{price_format($order->tax)}}</div>
                    </div>
                    <div class="flex items-start gap-x-8 p-1 ">
                        <div class="font-medium">Shipping Charge:</div>
                        <div>{{price_format($order->shipping_charge)}}</div>
                    </div>
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">Order Note:</div>
                        <div>{{$order->order_note}}</div>
                    </div>

                </div>
                <div class="w-full p-4">
                    <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                        <h2 class="text-2xl font-bold py-2 text-white pl-3">Payment Detail</h2>
                    </div>
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">Payment Name:	</div>
                        <div>{{$order->payment->payment_name ?? ''}}</div>
                    </div>
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">Transaction Number:	</div>
                        <div>{{$order->transaction_number}}</div>
                    </div>
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">Account Type:	</div>
                        <div>{{$order->payment->type ?? ''}}</div>
                    </div>
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">Order Status:	</div>
                        <div>{{ucwords($order->status)}}</div>
                    </div>
                    @if($order->image != null)
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">Payment Proof:</div>
                        <div><a href="{{ asset($order->image) }}" target="_blank" ><img src="{{ asset($order->image) }}" height="50px" width="100px"></a></div>
                    </div>
                    @endif
                </div>
                <div class="w-full p-4">
                    <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                        <h2 class="text-2xl font-bold py-2 text-white pl-3">Shipping Detail</h2>
                    </div>
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">Name:	</div>
                        <div>{{$order->billing ? $order->billing->name : ""}}</div>
                    </div>
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">E-mail:	</div>
                        <div>{{$order->billing ? $order->billing->email : ""}}</div>
                    </div>
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">Phone:	</div>
                        <div>{{$order->billing ? $order->billing->phone : ""}}</div>
                    </div>
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">City:	</div>
                        <div>{{$order->billing ? $order->billing->city : ""}}</div>
                    </div>
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">Zip Code:	</div>
                        <div>{{$order->billing ? $order->billing->zip_code : ""}}</div>
                    </div>
                    <div class="flex items-center gap-x-8 p-1">
                        <div class="font-medium">Address:	</div>
                        <div>{{$order->billing ? $order->billing->address : ""}}</div>
                    </div>
                </div>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-5">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Ordered Items Detail</h2>
                </div>
                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <table class="text-sm text-left text-white border-l border-r" style=" width: 100%;">
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
                                    Product Name
                                </div>
                            </th>

                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Size
                                </div>
                            </th>

                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Unit Coin
                                </div>
                            </th>
                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Total Coin
                                </div>
                            </th>

                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Quantity
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Unit Price
                                </div>
                            </th>
                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Sub Total
                                </div>
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->order_detail as $item)
                            <tr class="bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    <img src="{{ asset('uploads/product/resize/'.$item->product->thumbnail) }}" alt="" style="width: 70px;height: 50px">
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$item->product->title}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$item->size ? $item->size->name : ""}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$item->product->current_coin}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$item->product->current_coin*$item->product_quantity}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$item->product_quantity}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{price_format($item->product->current_price)}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{price_format($item->product->current_price*$item->product_quantity)}}
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="flex justify-end ">
                        <div class="bg-gray-100 justify-end">
                            <p class="p-1">
                                <span><strong>Sub Total:</strong></span>
                                <span>{{price_format($order->sub_total)}}</span>
                            </p>
                            <p class="p-1">
                                <span><strong>Shipping Charge:</strong></span>
                                <span>{{price_format($order->shipping_charge)}}</span>
                            </p>
                            <p class="p-1">
                                <span><strong>VAT:</strong></span>
                                <span>{{price_format($order->tex)}}</span>
                            </p>
                            <p class="p-1">
                                <span><strong>Grand Total:</strong></span>
                                <span>{{price_format($order->grand_total)}}</span>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('extra_js')

@endsection




