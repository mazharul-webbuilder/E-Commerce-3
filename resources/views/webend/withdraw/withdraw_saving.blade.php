@extends('webend.layouts.master')
@section('extra_css')
    <style>
        .input-field_border{
            border: 2px solid #000;
        }
    </style>
@endsection
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Withdraw Saving</span>
                        </div>
                    </li>

                </ol>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Withdraw Saving</h2>
                </div>
                <div class="px-2 py-6">
                    <h2 class="text-2xl"><strong>Total Amount: {{$datas->sum('saving_amount')}}</strong></h2>
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
                                    Saving Amount
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Status
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Created At
                                </div>
                            </th>


                        </tr>
                        </thead>
                        <tbody >

                        @foreach($datas as $data)

                            <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->saving_amount  }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $data->status  }}
                                </td>

                                <th scope="col" class="px-2 whitespace-nowrap py-3">
                                    <div class="text-center text-black">
                                        {{ $data->created_at  }}
                                    </div>
                                </th>

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
    <script !src="">
        $(function (){
            $("body").on('change','#manage_withdrawal',function (){
                let withdraw_id=$(this).attr('withdraw_id');
                let status=$(this).val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method:"post",
                    url:$(this).attr('data-action'),
                    data:{withdraw_id:withdraw_id,status:status},
                    success:function (response){
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

            $("body").on('keyup','.processing_time',function (){
                let withdraw_id=$(this).attr('withdraw_id');
                let processing_time=$(this).val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method:"post",
                    url:$(this).attr('data-action'),
                    data:{withdraw_id:withdraw_id,processing_time:processing_time},
                    success:function (response){

                    }
                })
            })


        })
    </script>
@endsection


