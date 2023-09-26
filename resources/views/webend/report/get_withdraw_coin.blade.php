@extends('webend.layouts.master')
@section('extra_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .input-field_border {
            border: 2px solid #000;
        }

        .input-field_border {
            border: 2px solid #000;
        }

        .input-field_border {
            border: 2px solid #000;
        }

        .date-range {
            width: 240px;
            padding: 4px 20px;
            border: 2px solid purple;
            border-radius: 9px;
            font-weight: 700;
        }

        .input-field_border {
            border: 2px solid #000;
        }
    </style>
@endsection
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- table start -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        <a href="{{ route('dashboard') }}"
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Withdraw History</span>
                        </div>
                    </li>

                </ol>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Withdraw History</h2>
                </div>
                <br>
                <div class="px-2 py-4">
                    <span>
                        <a href="{{ route('get_withdraw_coin', ['status' => 2]) }}"
                            class="bg-purple-600 active:bg-blue-500 p-2 text-white rounded active:red">
                            All History</a></span>
                    <span>
                        <input type="text" name="daterange" value="" class="date-range" />
                    </span><br><br>
                </div>
                <form id="search_order_by_date" action="{{ route('get_withdraw_coin_date', ['status' => 2]) }}"
                    method="POST" style="display: none">
                    @csrf
                    <input type="text" name="start_date" value="" class="start_date">
                    <input type="text" name="end_date" value="" class="end_date">
                </form>

                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <table class="text-sm text-left text-white border-l border-r" id="dataTableAuthor"
                        style=" width: 100%;">
                        <thead class="text-xs text-white uppercase bg-amber-600">
                            <tr>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    <div class="text-center">
                                        S/N
                                    </div>
                                </th>
                                <th scope="col" class="px-2 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        User Name
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
                                        Action
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $data = null;
                            @endphp
                            @foreach ($withdraws as $withdraw)
                                <tr
                                    class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td
                                        class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $withdraw->user->name }}
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
                                        {{ $withdraw->balance_send_type == 1 ? 'Mobile Banking' : 'Bank' }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-left">
                                        @php
                                            if ($withdraw->balance_send_type == 1) {
                                                $data = json_decode($withdraw->mobile_account_detail);
                                            } else {
                                                $data = json_decode($withdraw->bank_detail);
                                            }
                                        @endphp
                                        @if ($withdraw->balance_send_type == 1)
                                            <p><strong>Number:</strong> {{ $data->mobile_account_number }}</p>
                                            <p><strong>Type:</strong> {{ ucwords($data->mobile_account_type) }}</p>
                                        @else
                                            <p><strong>Account Holder Name:</strong> {{ $data->bank_account_holder_name }}
                                            </p>
                                            <p><strong>Account Number:</strong> {{ $data->bank_account_number }}</p>
                                            <p><strong>Bank Name:</strong> {{ $data->bank_name }}</p>
                                            <p><strong>Branch Name:</strong> {{ $data->branch_name }}</p>
                                            <p><strong>Route Number:</strong> {{ $data->bank_route_number }}</p>
                                        @endif
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ date('d-m-Y h:i:s a', strtotime($withdraw->created_at)) }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        @if ($withdraw->status == 1)
                                            <select name="status" id="manage_withdrawal" withdraw_id="{{ $withdraw->id }}"
                                                data-action="{{ route('withdraw.manage_withdraw') }}">
                                                <option value="1" {{ $withdraw->status == 1 ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="2" {{ $withdraw->status == 2 ? 'selected' : '' }}>
                                                    Accept
                                                </option>
                                                <option value="3" {{ $withdraw->status == 3 ? 'selected' : '' }}>
                                                    Reject
                                                </option>
                                            </select>
                                        @else
                                            @if ($withdraw->status == 2)
                                                <span class="bg-blue-700 p-2 text-white rounded">Accepted</span>
                                            @else
                                                <span class="bg-red-500 p-2 text-white rounded">Rejected</span>
                                            @endif
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

            $("body").on('change', '#manage_order', function(e) {
                //e.preventDefault()
                let order_id = $(this).attr('order_id');
                let status = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "post",
                    url: $(this).attr('data-action'),
                    data: {
                        order_id: order_id,
                        status: status
                    },
                    success: function(response) {
                        swal({
                            title: response.type,
                            text: response.message,
                            icon: response.type,
                            timer: 5000,
                            // buttons: true,
                        })
                    }
                })
            })
        })
    </script>
@endsection
