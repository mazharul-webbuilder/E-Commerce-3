@extends('webend.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- start menu -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        <a href="#" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="#" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Income Source</span>
                        </a>
                    </li>

                </ol>
            </div>
            <!-- end menu -->

            <!-- back button start -->
            <section>
                <div class="flex items-center gap-4 pt-4">
                    <div class="flex-none inline-block">
                        <a href=".././user/user.html" class="flex items-center cursor-pointer justify-center w-9 h-9 bg-white border border-gray-300 rounded-full hover:text-white hover:bg-blue-800 hover:scale-105">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </div>
                    <div class="inline-block">
                        <p class="text-xl">Back</p>
                    </div>
                </div>
            </section>
            <!-- back button end -->

            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 py-3 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Share Holder Income Source</h2>

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
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Income source Name
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Commission
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Commission Type
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
                        @foreach($income_sources as $data)
                            <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $data->income_source_name }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->commission }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->commission_type ==1 ? 'Percent' : 'Flat' }}
                                </td>

                                <td class="whitespace-nowrap space-x-1 text-center px-2 flex items-center justify-center">
                                    <a  data-action="javascript:void(0)" commission="{{$data->commission}}" commission_type="{{$data->commission_type}}" share_holder_income_source_id="{{$data->id}}" data-te-toggle="modal"
                                        data-te-target="#exampleModal"
                                        data-te-ripple-init
                                        data-te-ripple-color="light"
                                        href="javascript:void(0)" class="show_income_source text-white bg-purple-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center
                                         px-5 py-2 text-center">
                                        <i class="fas fa-solid fa-tag px-2"></i>
                                        Edit
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
                    <div class="relative flex-auto p-4" data-te-modal-body-ref>

                        <form id="submit_form" data-action="{{route('shareholder.update_income_source')}}" method="POST" >
                            @csrf
                            <input type="hidden" class="share_holder_income_id" name="id" value="">
                            <div class="flex flex-col md:flex-row justify-between gap-3 p-2">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Commission</h4>
                                        <input placeholder="Commission" name="commission" class="set_commission w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" required>
                                    </div>
                                </div>
                            </div>
                            <div class="deal_detail">
                                <div class="flex flex-col gap-4  mt-3 p-2">
                                    <div class="flex flex-col md:flex-row justify-between gap-3">
                                        <div class="w-full">
                                            <div class="w-full">
                                                <h4 class="mb-2 font-medium text-zinc-700">Commission Type</h4>
                                                <input placeholder="Commission Type" name="commission_type" class="set_commission_type w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" required min="1" max="2">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full flex justify-end">
                                    <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out p-4 text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
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
        $(document).ready(function (){
            $('body').on('click','.show_income_source',function (){
               let commission=$(this).attr('commission')
                let commission_type=$(this).attr('commission_type')
                let id=$(this).attr('share_holder_income_source_id')
                $('.share_holder_income_id').val(id)
                $('.set_commission').val(commission)
                $('.set_commission_type').val(commission_type)

                $('body').on('submit','#submit_form',function (e){
                    e.preventDefault();
                    var data = $("").val();
                    $.ajax({
                        type: $(this).attr('method'),
                        url: $(this).attr('data-action'),
                        data: $(this).serializeArray(),
                        cache: false,
                        success: function (response) {
                            $(".close_modal").trigger('click')
                            $('#dataTableAuthor').load(" #dataTableAuthor")
                            swal("Good job!", response.message,response.type);
                        }
                    });

                })

            })
        })
    </script>
@endsection
