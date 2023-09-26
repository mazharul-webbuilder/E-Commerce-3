@extends('webend.share_owner.layouts.master')
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
                        <a href="#"
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
                        <a href="#" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Voucher</span>
                        </a>
                    </li>
                </ol>
            </div>
            <!-- end menu -->
            @if(Auth::guard("share")->user()->voucher_eligible==1)
            <div class="grid grid-cols-1 gap-4 md:grid-cols-12 mt-4">
                <div class="border border-[#8e0789] rounded-lg col-span-full overflow-hidden">
                    <div class="bg-[#8e0789] text-white overflow-hidden w-full px-0">
                        <h2 class="text-2xl font-bold py-2 pl-3">Send Voucher Request</h2>
                    </div>

                    <form id="submit_form" data-action="{{ route('share_owner.voucher_request') }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-4 p-4 mt-3">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Voucher price</h4>
                                        <input placeholder="voucher price" name="voucher_price" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                    </div>
                                </div>

                            </div>
                            <div class="w-full flex justify-end">
                                <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-purple-700 hover:bg-blue-800 cursor-pointer">
                                    Send Voucher Request
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            @endif
            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 py-3 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Vouchers</h2>

                </div>
                <br>

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
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Voucher Number
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Voucher Price
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Getting Source
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                   Request Status
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Uses Status
                                </div>
                            </th>


                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Created At
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
                        @foreach ($datas as $data)
                            <tr
                                class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td
                                    class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    @if($data->voucher_id==null)
                                        <span class="bg-red-500 rounded p-2 text-white">Not Assigned</span>
                                    @else
                                      {{$data->voucher->voucher_number}}
                                    @endif
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->voucher_price }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->getting_source }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    @if($data->voucher_id==null)
                                        <span class="bg-red-500 rounded p-2 text-white">Pending</span>
                                    @else
                                        <span class="bg-green-500 rounded p-2 text-white">Accept</span>
                                    @endif
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    @if($data->voucher_id==null)
                                        <span class="bg-red-500 rounded p-2 text-white">Not Applicable</span>
                                    @else
                                        @if($data->status==0)
                                        <span class="bg-green-500 rounded p-2 text-white">Not Used</span>
                                        @else
                                            <span class="bg-red-500 rounded p-2 text-white"> Used</span>
                                        @endif
                                    @endif
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->created_at }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    @if($data->voucher_id !=null)
                                        @if($data->status==0)
                                        <a href="javascript:;" request_id="{{$data->id}}" data-action="{{route('share_owner.voucher_collect')}}"
                                           class="collect_voucher p-2 bg-blue-700 rounded text-white">Collect Coin</a>

                                            <a  data-action="javascript:;" data-te-toggle="modal" request_id="{{$data->id}}"
                                                data-te-target="#exampleModal"
                                                data-te-ripple-init
                                                data-te-ripple-color="light"
                                                href="javascript:void(0)" class="transfer_data text-white bg-purple-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center
                                         px-5 py-2 text-center">
                                                Transfer
                                            </a>
                                        @else
                                        <span class="bg-purple-500 rounded p-2 text-white">Invalid</span>
                                    @endif
                                    @else
                                        <span class="bg-red-500 rounded p-2 text-white">Not Applicable</span>
                                    @endif

                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- table end -->
        </div>

        <div
            data-te-modal-init class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div
                data-te-modal-dialog-ref
                class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                <div
                    class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                        <h5
                            class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                            id="exampleModalLabel">
                            Transfer Voucher
                        </h5>
                        <button
                            type="button"
                            class="close_modal box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                            data-te-modal-dismiss
                            aria-label="Close">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-6 w-6">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="relative flex-auto p-4" data-te-modal-body-ref>

                        <form id="voucher_transfer_from_submit" data-action="{{ route('share_owner.transfer_voucher') }}" method="post">
                            @csrf
                            <input type="hidden" class="set_request_id" name="request_id" value="">
                            <div class="flex flex-col gap-2 p-1">

                                <input type="text" placeholder="Share Owner ID" class="add_destination w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none set_token_title"
                                       value="" name="share_owner_number" data-action="{{route('share_owner.add_destination')}}">
                                <span class="set_message"></span>
                            </div>

                            <button type="submit" class="submit_button px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg
                           focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out">Transfer</button>
                        </form>
                    </div>

                    <div
                        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('extra_js')
    <script !src="">
        $(function (){

            $('body').on('submit','#submit_form',function(e){

                e.preventDefault();
                let formDta = new FormData(this);
                $(".submit_button").html("Processing...").prop('disabled', true)

                $.ajax({
                    url: $(this).attr('data-action'),
                    method: $(this).attr('method'),
                    data: formDta,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        if (data.status==200)
                        {
                            swal({
                                title: 'Good job!',
                                text: data.message,
                                icon: data.type,
                                timer: 5000,
                                // buttons: true,
                            })
                            $(".submit_button").text("Send voucher Request").prop('disabled', false)
                            $("#submit_form")[0].reset();
                            $("#dataTableAuthor").load(" #dataTableAuthor")

                        }
                    },
                    error:function(response){

                        $(".submit_button").text("Send voucher Request").prop('disabled', false)
                    }
                });
            });

            $('body').on('click','.collect_voucher',function (){
                let request_id=$(this).attr('request_id');
                swal({
                    title: "Do You want use this voucher?",
                    icon: "info",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                url:$(this).attr('data-action'),
                                method:'post',
                                data:{request_id:request_id},
                                success:function(response){

                                    if(response.status=="200"){
                                        $("#dataTableAuthor").load(" #dataTableAuthor");
                                        swal({
                                            title: 'Congratulation!',
                                            text: response.message,
                                            icon: response.type,
                                            timer: 5000,
                                        })
                                    }else{
                                        swal({
                                            title: 'Opps, Something went wrong!',
                                            text: response.message,
                                            icon: response.type,
                                            timer: 5000,
                                        })
                                    }
                                }
                            });

                        }
                    });
            })

            $('body').on('submit','#voucher_transfer_from_submit',function(e){

                e.preventDefault();
                let formDta = new FormData(this);
                $(".submit_button").html("Processing...").prop('disabled', true)

                $.ajax({
                    url: $(this).attr('data-action'),
                    method: $(this).attr('method'),
                    data: formDta,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        if (data.status==200)
                        {
                            swal({
                                title: 'Good job!',
                                text: data.message,
                                icon: data.type,
                                timer: 5000,
                                // buttons: true,
                            })
                            $(".submit_button").text("Transfer").prop('disabled', false)
                            $("#dataTableAuthor").load(" #dataTableAuthor")

                        }
                    },
                    error:function(response){

                        $(".submit_button").text("Transfer").prop('disabled', false)
                    }
                });
            });


            $("body").on('keyup','.add_destination',function (){
                let share_owner_number=$(this).val();
                let share_id=$(".set_share_id").val();
                if (share_owner_number !==""){
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        method:"post",
                        url:$(this).attr('data-action'),
                        data:{share_owner_number:share_owner_number,share_id:share_id},
                        success:function (response){
                            if (response.status==200){
                                $('.set_message').text(response.message).addClass('text-green-700').removeClass('text-red-700')
                            }else{
                                $('.set_message').text(response.message).addClass('text-red-700').removeClass('text-green-700')
                            }
                        }
                    })
                }else{
                    $(".add_message"+share_holder_id).removeClass('bg-red-100','bg-green-100')
                }
            })

            $("body").on('click','.transfer_data',function (){

                $('.set_request_id').val($(this).attr('request_id'))
            })

        })
    </script>
@endsection


