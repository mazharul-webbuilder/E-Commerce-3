@extends('affiliate.layout.app')
@section('content')
    <style>
        #dataTable tbody > tr {
            height: 60px;
        }
        #dataTable tbody > tr > td {
            color: black;
            text-align: center;
        }
    </style>
    <section class="w-full bg-white p-3 mt-5">
        <div class="bg-white rounded-lg p-4 shadow-md">
            <h1 class="text-2xl font-semibold mb-4">User Details</h1>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="text-gray-600">Name:</label>
                    <p class="text-black">{{$connectedUser?->name}}</p>
                </div>
                <div class="mb-4">
                    <label class="text-gray-600">Email:</label>
                    <p class="text-black">{{$connectedUser?->email}}</p>
                </div>
                <div class="mb-4">
                    <label class="text-gray-600">Player ID:</label>
                    <p class="text-black">{{$connectedUser?->playerid}}</p>
                </div>
                <div class="mb-4">
                    <label class="text-gray-600">Country:</label>
                    <p class="text-black">{{$connectedUser?->country}}</p>
                </div>
                <div class="mb-4">
                    <label class="text-gray-600">Mobile:</label>
                    <p class="text-black">{{$connectedUser?->mobile}}</p>
                </div>
                <div class="mb-4">
                    <label class="text-gray-600">Address:</label>
                    <p class="text-black">{{$connectedUser?->address}}</p>
                </div>
                <div class="mb-4">
                    <label class="text-gray-600">Status:</label>
                    <p class="text-black">{{$connectedUser?->status == 1 ? 'Active' : 'Deactive'}}</p>
                </div>
            </div>
            <button id="DisconnectWithUser" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300">
                Disconnect Account
            </button>
        </div>
        @include('includes._ecommerce_balance_transfer_history_datatable')
    </section>


@endsection
@section('extra_js')
    <script>
        $(document).ready(function (){
            $('#DisconnectWithUser').on('click', function (e){
                e.preventDefault()
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Disconnect!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: '{{route('affiliate.account.discount')}}',
                            method: 'POST',
                            success:function(data){
                                if (data.response === 200) {
                                    Toast.fire({
                                        icon: data.type,
                                        title: data.message
                                    })
                                    window.location.href = '{{route('affiliate.dashboard')}}'
                                }
                            }
                        });
                    }
                })
            })
        })
    </script>
    {{--Show Seller Transfer Hisotory--}}
    <script>
        $(document).ready(function (){
            $("#dataTable").DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                ordering: false,
                pagingType: "full_numbers",
                ajax: '{{ route('affiliate.balance.transfer.history', [get_auth_affiliator()->user_id]) }}',
                columns: [
                    { data: 'DT_RowIndex',name:'DT_RowIndex' },
                    { data: 'amount',name:'amount' },
                    {
                        data: 'type',
                        name: 'type',
                        render: function (data) {
                            return data.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                        }
                    },
                    {
                        data: 'destination',
                        name:'destination',
                        render: function (data) {
                            return data.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                        }
                    },
                ],
                language : {
                    processing: 'Processing'
                },

            });
        })
    </script>
@endsection
