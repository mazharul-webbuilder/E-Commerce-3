@extends('webend.layouts.master')
@section('extra_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
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
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('all.user') }}" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">User List</span>
                        </a>
                    </li>

                </ol>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10 mb-6">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">User List</h2>
                </div>
                <br>
                <div class="px-2 py-4">
                    <span>
                        <a href="{{ route('all.user') }}"
                            class="bg-purple-600 active:bg-blue-500 p-2 text-white rounded active:red">
                            All History</a></span>
                    <span>
                        <input type="text" name="daterange" value="" class="date-range" />
                    </span><br><br>
                </div>
                <form id="search_order_by_date" action="{{ route('users_by_date') }}" method="POST" style="display: none">
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
                                        SI NO.
                                    </div>
                                </th>
                                <th scope="col" class="px-2 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Avatar
                                    </div>
                                </th>
                                <th scope="col" class="px-2 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Current Rank
                                    </div>
                                </th>
                                <th scope="col" class="px-2 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Member of Club
                                    </div>
                                </th>
                                <th scope="col" class="px-2 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        My Club
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                    <div class="text-center">
                                        Name
                                    </div>
                                </th>
                                <th scope="col" class="px-2 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        PlayerId
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Email
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Phone
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Date of Birth
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Country
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Gender
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Free Coin
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Gift Coin
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Marketing Balance
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Recovery Fund
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Diamond
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Win Balance
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Refer Code
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Max Win
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Max Loss
                                    </div>
                                </th>
                                <th scope="col" class="px-2 py-3">
                                    <div class="text-center">
                                        status
                                    </div>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <div class="text-center">
                                        Applied Data
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

                            @foreach ($users as $user)
                                <tr
                                    class="bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->avator }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        <span class="p-1">{{ $user->rank->rank_name }}</span>
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        <span class="p-1">
                                            {{ $user->club_join->club_name ?? 'Not Member' }}
                                        </span>
                                    </td>

                                    <td class="px-2 py-4 text-black border-r text-center">
                                        <span class="p-1">
                                            {{ $user->club->club_name ?? 'Not Owner' }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->playerid }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->mobile }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->dob }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->country }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->gender }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->free_coin }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->paid_coin }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->marketing_balance }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->recovery_fund }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->paid_diamond }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->win_balance }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->refer_code }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->max_win }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $user->max_loos }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r whitespace-nowrap text-center">
                                        {{ $user->otp_verified_at != null ? 'Active' : '' }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r whitespace-nowrap text-center">
                                        @if ($user->apply_data == 1)
                                            <a href="{{ route('user.data_applied_list', $user->id) }}"
                                                class="text-white py-2 bg-blue-700 hover:bg-emerald-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 text-center">
                                                Applied List
                                            </a>
                                        @else
                                            <span>Not Applied</span>
                                        @endif
                                    </td>
                                    <td
                                        class="whitespace-nowrap space-x-1 text-center px-2 flex items-center justify-center">
                                        <a href="{{ route('user.daily_order', $user->id) }}"
                                            class="text-white py-2 bg-pink-700 hover:bg-pink-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 text-center">
                                            Daily Order
                                        </a>

                                        <a href="{{ route('user.friendlist', $user->id) }}"
                                            class="text-white py-2 bg-emerald-400 hover:bg-emerald-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 text-center">
                                            Friend List
                                        </a>
                                        <a href="{{ route('user.token_history', $user->id) }}"
                                            class="text-white py-2 bg-fuchsia-500 hover:bg-fuchsia-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 text-center">
                                            Token
                                        </a>
                                        <a href="{{ route('user_referral_list.user', $user->id) }}"
                                            class="text-white bg-sky-400 cursor-pointer hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                                            Referral
                                        </a>
                                        <a href="{{ route('token_transfer_history.user', $user->id) }}"
                                            class="text-white py-2 bg-amber-500 hover:bg-amber-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 text-center">
                                            Token Transfer
                                        </a>
                                        <a href="{{ route('user_balance_transfer_history', $user->id) }}"
                                            class="text-white py-2 bg-fuchsia-500 hover:bg-fuchsia-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 text-center">
                                            Balance Transfer
                                        </a>
                                        <a href="#"
                                            class="text-white py-2 bg-pink-500 hover:bg-pink-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 text-center">
                                            Static Report
                                        </a>
                                        <a href="{{ route('edit.user', $user->id) }}"
                                            class="text-white bg-sky-400 cursor-pointer hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        {{--                                <a href="#" data-modal-toggle="editAuthor" class="text-white bg-amber-500 hover:bg-amber-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center"> --}}
                                        {{--                                    <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg> --}}
                                        {{--                                    Details --}}
                                        {{--                                </a> --}}
                                        {{--                                <a href="{{ route('user.destroy',$user->id) }}" type="button" class="text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor"> --}}
                                        {{--                                    <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> --}}
                                        {{--                                    Delete --}}
                                        {{--                                </a> --}}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- table end -->
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
    <script !src="">
        $(document).ready(function() {
            $('body').on('click', '.share_holder_confirmation', function() {

                swal({
                        title: "Provide Share Holder",
                        text: "Are sure to provide a shareholder to this user?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            let user_id = $(this).attr('user_id')
                            $.ajax({
                                type: "post",
                                url: $(this).attr('data-action'),
                                data: {
                                    user_id: user_id
                                },
                                success: function(response) {
                                    swal({
                                        title: response.title,
                                        text: response.data,
                                        icon: response.type,
                                        button: "Okay",
                                    });
                                }
                            });
                        }
                    });
            })
        })
    </script>
@endsection
