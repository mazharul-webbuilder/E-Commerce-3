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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Product Stock</span>
                        </div>
                    </li>
                </ol>
            </div>
            <div class="flex justify-end">
                <a style="text-decoration: none;" href="{{URL::previous() }}"  class="text-white bg-blue-700 hover:bg-blue-800  transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back
                </a>
            </div>
            <!-- end menu -->
                <div class="border border-[#8e0789] rounded-md mt-10">
                    <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                        <h2 class="text-2xl font-bold py-2 text-white pl-3">Add New Stock</h2>
                    </div>
                    <!-- Category form start -->
                    <form id="submit_form" data-action="{{ route('stock.store') }}" method="POST">
                        @csrf
                        <input value="{{$product->id}}" name="product_id" type="hidden" >
                        <div class="flex flex-col gap-4 p-4 mt-3">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                    <div class="w-5/12">
                                        <div class="w-full">
                                            <h4 class="mb-2 font-medium text-zinc-700">Product title</h4>
                                            <input value="{{$product->title}}" name="product_title" readonly class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" >
                                        </div>
                                    </div>

                                <div class="w-5/12">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Sizes</h4>
                                        <select class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none"
                                                name="size_id">
                                            <option value="">Select Size</option>
                                            @foreach($sizes as $size)
                                                <option value="{{$size->id}}">{{$size->name ? : 'no size'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="size_error text-red-400"></span>

                                </div>
                                <div class="w-5/12">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Quantity</h4>
                                        <input placeholder="Enter Quantity" name="quantity" min="1" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" >
                                        <span class="quantity_error text-red-400"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex justify-end">
                                <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                    Add New Stock
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- Category form end -->
                </div>
                <!-- Category form end -->
                <!-- table start -->
                <div class="border border-[#8e0789] rounded-md mt-10" >
                    <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                        <h2 class="text-2xl font-bold py-2 text-white pl-3">Stock List</h2>
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
                                        Product title
                                    </div>
                                </th>
                                <th scope="col" class="px-2 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Size Name
                                    </div>
                                </th>
                                <th scope="col" class="px-6 whitespace-nowrap py-3">
                                    <div class="text-center">
                                        Quantity
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
                            @foreach($stocks as $stock)
                                <tr class="hide_row{{$stock->id}} bg-white   dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $stock->product->title }}
                                    </td>

                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $stock->size_id ?  $stock->size->name ? : 'no size' : '' }}
                                    </td>

                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $stock->quantity  }}
                                    </td>
                                    <td class="whitespace-nowrap space-x-1 text-center px-2 flex items-center justify-center">
                                        <a href="{{route('stock.edit',$stock->id)}}" class="text-white bg-sky-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                                            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                            Edit
                                        </a>
                                        <a href="javascript:;" data-action="{{route('stock.delete')}}"  item_id="{{$stock->id}}" type="button" class="delete_item text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
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
@endsection

@section('extra_js')

    <script>
        $(document).ready(function (){
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
                        if (data.status_code==200)
                        {
                            swal({
                                title: 'Good job!',
                                text: data.message,
                                icon: data.type,
                                timer: 5000,
                            })
                            $(".submit_button").text("Add New Stock").prop('disabled', false)
                            $("#submit_form")[0].reset();
                            $("#dataTableAuthor").load(" #dataTableAuthor");
                        }
                    },
                    error:function(response){

                        if (response.status === 422) {
                            if (response.responseJSON.errors.hasOwnProperty('size_id')) {
                                $('.size_error').html(response.responseJSON.errors.size_id)
                            }else{
                                $('.size_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty('quantity')) {
                                $('.quantity_error').html(response.responseJSON.errors.quantity)
                            }else{
                                $('.quantity_error').html('')
                            }
                        }
                        $(".submit_button").text("Add New Stock").prop('disabled', false)
                    }
                });
            });

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
