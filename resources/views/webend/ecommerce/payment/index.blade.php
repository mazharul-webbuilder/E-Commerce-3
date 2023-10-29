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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Product Payment</span>
                        </div>
                    </li>
                </ol>
            </div>
           <div class="flex flex-row-reverse">
               <div class="px-2">
                   <a href="{{route('payment.create')}}"  class="text-white bg-blue-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                       <i class="fas fa-plus mr-2"></i>
                       Add New Payment
                   </a>
               </div>
               <div class="">
                   <a href="{{route('payment.create')}}"  class="text-white bg-cyan-700 hover:bg-teal-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                       <i class="fas fa-plus mr-2"></i>
                       Add New Payment Method
                   </a>
               </div>
           </div>
            <!-- end menu -->
            <div class="border border-[#8e0789] rounded-md mt-5">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Product Payment List</h2>

                </div>
                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
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
                                    Image
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Name
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Type
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Priority
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3">
                                <div class="text-center">
                                    Status
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3">
                                <div class="text-center">
                                    Show Detail
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
                        @foreach($payments as $item)
                            <tr class="hide_row{{$item->id}} bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    <img src="{{ asset('uploads/payment/resize/'.$item->image) }}" alt="payment Image" class="h-12 w-12">
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $item->payment_name }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $item->type  }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $item->priority  }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $item->status  }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    <a data-te-toggle="modal"
                                        data-te-target="#exampleModal"
                                        data-te-ripple-init
                                        data-te-ripple-color="light"
                                        href="javascript:void(0)" account_detail="{{$item->account_detail}}" class="show_modal text-white bg-purple-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center
                                         px-5 py-2 text-center">
                                        View
                                    </a>
                                </td>


                                <td class="whitespace-nowrap space-x-1 text-center px-2 flex items-center justify-center">
                                    <a href="{{ route('payment.edit',$item->id)  }}" class="text-white bg-sky-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        Edit
                                    </a>
                                    <a href="javascript:;" data-action="{{route('payment.delete')}}"  item_id="{{$item->id}}" type="button" class="delete_item text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        Delete
                                    </a>
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
                        Update ShareHolder Income Source
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
                <div class="relative flex-auto p-4 modal_content" data-te-modal-body-ref>


                </div>
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_js')

    <script>
        $(document).ready(function(){

            $('body').on('click','.show_modal',function (){
                let account_detail=$(this).attr('account_detail')
                let data=JSON.parse(account_detail)
                let content='<div>'+
                    '<p>Bank holder name: '+data.bank_holder_name+'</p>'+
                    '<p>Bank account Number: '+data.bank_account_number+'</p>'+
                    '<p>Bank name: '+data.bank_name+'</p>'+
                    '<p>Bank branch name: '+data.bank_branch_name+'</p>'+
                    '<p>Bank route name: '+data.bank_route_number+'</p>'+
                    '<p>Bank swift code: '+data.bank_swift_code+'</p>'+
                    '<p>Paytm code or number: '+data.code_or_number+'</p>'+
                    '<p>Gateway E-mail: '+data.online_email+'</p>'+
                    '<p>Mobile Banking Number: '+data.account_number+'</p>'+
                    '<p>Mobile referance Number: '+data.ref_number+'</p>'
                    +'</div>'

                $('.modal_content').html(content)

            })

            $('body').on('click','.delete_item',function(){
                let item_id=$(this).attr('item_id');
                swal({
                    title: "Do you want to delete?",
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
                                data:{item_id:item_id},
                                success:function(data){
                                    swal({
                                        title: 'Good job!',
                                        text: data.message,
                                        icon: data.type,
                                        timer: 5000,
                                        // buttons: true,
                                    })
                                    $('.hide_row'+item_id).hide();
                                }
                            });

                        }
                    });
            })
        })
    </script>
@endsection


