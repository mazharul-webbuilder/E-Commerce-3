@extends('webend.layouts.master')
@section('extra_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .input-field_border {
            border: 2px solid #000;
        }
         #dataTable tbody > tr {
             height: 60px;
         }
        #dataTable tbody > tr > td{
             color: black;
            text-align: center;
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
                        <a href="javascript:void(0)"
                           class="bg-purple-600 active:bg-blue-500 p-2 text-white rounded active:red filterBtn">
                            All History</a></span>
                    <span class="filterBtn">
                        <input type="text" name="daterange" value="" class="date-range" />
                    </span><br><br>
                </div>
                {{--Filter By date--}}
                <input type="text" name="start_date" id="startDate" value="" class="start_date">
                <input type="text" name="end_date" id="endDate" class="end_date">

                <div class="pl-2">
                    <button class="p-2 rounded border-2" style="cursor: text">Total Users: {{getNumberOfEndUsers()}}</button>
                </div>
                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <table class="text-sm text-left text-white border-l border-r" id="dataTable"
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
                                    Refer Code
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
    {{--Datatable--}}
    <script>
        /*On Load*/
        getDatatable();

        /*Filter*/
        $(document).ready(function (){
            //
            $('.filterBtn').on('click', function (){
                getDatatable()
            })
            /*Filter by Date*/
            $('body').on('click', '.applyBtn', function (){
                let startDate = $('#startDate').val()
                let endDate = $('#endDate').val()
                getDatatable('all', startDate, endDate)
            })
        })
        /*function to get data*/
        function getDatatable(filter='all', startDate=null, endDate=null){
            $('#dataTable').DataTable().destroy()
            $("#dataTable").DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                ordering: true,
                pagingType: "full_numbers",
                ajax: {
                    url: '{{ route('all.user.datatable') }}',
                    method: 'GET',
                    data: {
                        filter: filter,
                        startDate: startDate,
                        endDate: endDate
                    }
                },
                columns: [
                    { data: 'DT_RowIndex',name:'DT_RowIndex' },
                    { data: 'avatar',name:'avatar' },
                    { data: 'userRank',name:'userRank' },
                    { data: 'club',name:'club' },
                    { data: 'name',name:'name' },
                    { data: 'playerid',name:'playerid' },
                    { data: 'email',name:'email' },
                    { data: 'mobile',name:'mobile', render: function (data) {return data !== '' ? data : 'no data'} },
                    { data: 'refer_code',name:'refer_code', render: function (data) {return data !== 0 ? data : 'no data'} },
                    { data: 'action',name:'action' },

                ],
                language : {
                    processing: 'Processing'
                },
            });
        }
    </script>
    {{--End Datatable--}}
@endsection
