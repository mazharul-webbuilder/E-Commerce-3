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
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="#" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Rank gift Token
                            <!-- Button trigger modal -->

                        </a>
                    </li>
                </ol>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Rank Gift Token List</h2>
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
                                    Rank Name
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Title
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Gift Token
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Action
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody >
                        @foreach($rank_tokens as $rank_token)
                            @if($rank_token->constant_title != 'member_to_vip')
                                <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $rank_token->rank->rank_name }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $rank_token->title }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        {{ $rank_token->gift_token }}
                                    </td>
                                    <td class="px-2 py-4 text-black border-r text-center">
                                        <a  data-action="javascript:;" token_title="{{$rank_token->title}}" token="{{$rank_token->gift_token}}" rank_token_id="{{$rank_token->id}}" data-te-toggle="modal"
                                            data-te-target="#exampleModal"
                                            data-te-ripple-init
                                            data-te-ripple-color="light"
                                            href="javascript:void(0)" class="show_rank_gift_token text-white bg-purple-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center
                                         px-5 py-2 text-center">
                                            <i class="fas fa-solid fa-tag px-2"></i>
                                            Edit
                                        </a>
                                    </td>

                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>


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
                            Provide gift token for each particular token
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
                        <form class="submit_form" data-action="{{ route('rank.gift_token.update') }}" method="post">
                            @csrf
                            <input type="hidden" class="set_token_id" name="token_id" value="">
                            <div class="flex flex-col gap-2 p-1">
                                <span>Title</span>
                                <input type="text" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none set_token_title" value="" name="title">
                                <span class="title_error text-red-400"></span>
                            </div>
                            <div class="flex flex-col gap-2 p-1">
                                <span>Gift Token</span>
                                <input type="text" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none set_token" value="" name="gift_token" required >
                            </div>
                            <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg
                           focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out">Update</button>
                        </form>
                    </div>
                    <div
                        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('extra_js')


    <script !src="">
        $(function (){
            $('body').on('submit','.submit_form',function(e){
                e.preventDefault();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method:$(this).attr('method'),
                    url:$(this).attr('data-action'),
                    data:$(this).serialize(),
                    success:function (response){

                        swal({
                            title: 'Good job!',
                            text: response.message,
                            icon: response.type,
                            timer: 5000,
                        })
                        $('.close_modal').trigger('click')
                        $("#dataTableAuthor").load(" #dataTableAuthor");
                    },
                    error:function(response){
                        if (response.status === 422) {
                            if (response.responseJSON.errors.hasOwnProperty('title')) {
                                $('.title_error').html(response.responseJSON.errors.title)
                            }else{
                                $('.title_error').html('')
                            }
                        }

                    }
                })

            })

            $("body").on('click','.show_rank_gift_token',function (){

                $('.set_token_title').val($(this).attr('token_title'))
                $('.set_token').val($(this).attr('token'))
                $('.set_token_id').val($(this).attr('rank_token_id'))
            })

            $("body").on('click','.close_modal',function (){
                $('.title_error').text("");
            })
        })
    </script>
@endsection
