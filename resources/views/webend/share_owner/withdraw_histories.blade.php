@extends('webend.share_owner.layouts.master')
@section('content')

    <section class="w-full bg-white p-3 mt-5" >
        <div class="container px-2 mx-auto xl:px-5"  >
            <!-- table start -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        <a href="{{route('dashboard')}}" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>

                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Withdraw History</span>
                        </div>
                    </li>

                </ol>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Withdraw History</h2>
                </div>
                <div class="px-2 py-6 hidden">
                    <span><a href="{{route('withdraw.index',['type'=>'all'])}}" class="bg-purple-600 active:bg-blue-500 p-2 text-white rounded active:red">All Withdraw</a></span>
                    @foreach(withdraw_payments() as $withdraw_payment)
                        <span><a href="{{route('withdraw.index',['type'=>$withdraw_payment->id])}}" class="bg-purple-600 active:bg-blue-500 p-2 text-white rounded active:red">{{$withdraw_payment->name}}</a></span>
                    @endforeach

                    <br><br>
                    <h2 class="text-2xl"><strong>Total Amount: {{$withdraws->sum('user_received_balance')}}</strong></h2>
                </div>

                <div class="py-2 px-1 mt-3" style="overflow-x: auto;" >
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
                                    Withdraw Balance
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Charge Deduction
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Received Amount
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Payment Name
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Balance Send Type
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Banking Detail
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Request At
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Processing Time
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Action
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody >
                        @php
                            $data=null;
                        @endphp
                        @foreach($withdraws as $withdraw)

                            <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $withdraw->withdraw_balance }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $withdraw->charge }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $withdraw->user_received_balance }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $withdraw->withdraw_payment->name ?? '' }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $withdraw->balance_send_type }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-left">
                                    @php
                                        $data=json_decode($withdraw->bank_detail,true);
                                    @endphp
                                    @if(array_key_exists('mobile_account_number',$data))
                                        <p><strong>Mobile Account Number: </strong>{{$data['mobile_account_number']}}</p>
                                    @endif

                                    @if(array_key_exists('ref_number',$data))
                                        <p><strong>Reference Number: </strong>{{$data['ref_number']}}</p>
                                    @endif

                                    @if(array_key_exists('bank_holder_name',$data))
                                        <p><strong>Bank Holder Name: </strong>{{$data['bank_holder_name']}}</p>
                                    @endif
                                    @if(array_key_exists('bank_account_number',$data))
                                        <p><strong>Bank Account Name: </strong>{{$data['bank_account_number']}}</p>
                                    @endif

                                    @if(array_key_exists('bank_name',$data))
                                        <p><strong>Bank Name: </strong>{{$data['bank_name']}}</p>
                                    @endif
                                    @if(array_key_exists('bank_branch_name',$data))
                                        <p><strong>Bank Branch Name: </strong>{{$data['bank_branch_name']}}</p>
                                    @endif

                                    @if(array_key_exists('bank_route_number',$data))
                                        <p><strong>Bank Route number: </strong>{{$data['bank_route_number']}}</p>
                                    @endif

                                    @if(array_key_exists('bank_swift_code',$data))
                                        <p><strong>Bank swift code: </strong>{{$data['bank_swift_code']}}</p>
                                    @endif

                                    @if(array_key_exists('code_or_number',$data))
                                        <p><strong>Paytm Coed or Number: </strong>{{$data['code_or_number']}}</p>
                                    @endif

                                    @if(array_key_exists('online_gateway_email',$data))
                                        <p><strong>Online Payment E-mail: </strong>{{$data['online_gateway_email']}}</p>
                                    @endif
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ date('d-m-Y h:i:s a', strtotime($withdraw->created_at)) }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">

                                        <span>{{$withdraw->processing_time}}</span>

                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">

                                    @if($withdraw->status==1)
                                        <span>Pending</span>
                                        @elseif($withdraw->status==2)
                                        <span>Processing</span>
                                    @elseif($withdraw->status==3)
                                        <span>Accepted</span>
                                        @else
                                        <span>Rejected</span>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('extra_js')



@endsection

