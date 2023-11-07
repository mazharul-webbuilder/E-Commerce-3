@extends('webend.layouts.master')
@section('extra_css')
    <style>
        .input-field_border{
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
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        <a href="{{ route('dashboard') }}" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="#" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Generation</span>
                        </a>
                    </li>

                </ol>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Generation Lists & commission</h2>
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
                                   Generation Name
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    User Commission (%)
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Seller Commission (%)
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($generations as $generation)
                            <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $generation->generation_name }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    <input type="number" update_type="user" value="{{ $generation->commission }}" class="w-[80px] text-center px-1 input-field_border commission_field" generation_id="{{$generation->id}}">
                                    <p><span class="saving{{$generation->id}}"></span></p>
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    <input type="number" update_type="seller" value="{{ $generation->seller_commission }}" class="w-[80px] text-center px-1 input-field_border commission_field_seller" generation_id="{{$generation->id}}">
                                    <p><span class="seller_saving{{$generation->id}}"></span></p>
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
    <script !src="">
        $(function (){
            $('body').on('keyup','.commission_field,.commission_field_seller',function(e){
                console.log(e)
               let id=$(this).attr('generation_id')
                let commission=$(this).val()
                let type=$(this).attr('update_type')

               if(commission !==""){
                   if (type=="user"){
                       $('.saving'+id).text('Saving...')
                   }else{
                       $('.seller_saving'+id).text('Saving...')
                   }

                   $.ajax({
                       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                       method:"post",
                       url:"{{route('admin.update_generation_commission')}}",
                       data:{id:id,commission:commission,type:type},
                       success:function (response){
                           if(response.status_code===200){
                               setTimeout(function () {
                                   if (type=="user"){
                                       $('.saving'+id).text('')
                                   }else{
                                       $('.seller_saving'+id).text('')
                                   }

                               },2000)
                           }
                       }
                   })
               }
            })
        })
    </script>
@endsection
