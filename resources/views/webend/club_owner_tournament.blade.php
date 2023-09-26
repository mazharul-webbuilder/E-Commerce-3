@extends('webend.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Club Owner Tournament</span>
                        </div>
                    </li>

                </ol>
            </div>

            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Club owner's Tournament List</h2>
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
                                    Club Owner
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    Game Type
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Tournament Name
                                </div>
                            </th>
                            <th scope="col" class="px-6 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Team Type
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="text-center">
                                    Registration Fee
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="text-center">
                                    Player Limit
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="text-center">
                                    Winning Prize
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="text-center">
                                    Winning Prize Detail
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="text-center">
                                    Winner Price
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3">
                                <div class="text-center">
                                    status
                                </div>
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tournaments as $tournament)
                            <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $tournament->club_owner->name }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ game_type($tournament->game_type)}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$tournament->tournament_name }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$tournament->player_type }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$tournament->registration_fee }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$tournament->player_limit }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$tournament->winning_prize }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$tournament->winner_price_detail }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    <a href="{{route('club_owner_tournament_round_price',$tournament->id)}}" class=" text-white bg-purple-600 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center
                                         px-5 py-2 text-center">View Detail</a>
                                </td>
                                <td class="px-2 py-4 text-black border-r whitespace-nowrap text-center">

{{--                                    @if($tournament->status==1)--}}
{{--                                        <a href="javascript:;" class="approve_reject_tournament bg-red-600 p-2 text-white rounded" action-type="Approve" data-action="{{route('approve_club_owner_tournament')}}"  tournament_id="{{$tournament->id}}"> Reject</a>--}}

{{--                                    @else--}}
{{--                                        <a href="javascript:;" class="approve_reject_tournament bg-purple-600 p-2 text-white rounded"  action-type="Reject" data-action="{{route('approve_club_owner_tournament')}}" tournament_id="{{$tournament->id}}"> Approve</a>--}}
{{--                                    @endif--}}

                                    <a  data-action="javascript:;" data-te-toggle="modal"
                                        data-te-target="#exampleModal"
                                        data-te-ripple-init
                                        data-te-ripple-color="light"
                                        href="javascript:void(0)" tournament_id="{{$tournament->id}}"
                                        tournament_note="{{$tournament->note}}" tournament_status="{{$tournament->status}}"
                                        class="show_tournament_approval_status text-white bg-{{$tournament->status==1 ? 'blue' : 'red'}}-600 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center
                                         px-5 py-2 text-center">
                                        {{$tournament->status==1 ? 'Accepted' : 'Rejected'}}
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
                            Club tournament approve or rejecte
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
                        <form id="submit_form" data-action="{{ route('approve_club_owner_tournament') }}" method="post">
                            @csrf
                            <input type="hidden" class="set_tournament_id" name="tournament_id" value="">
                            <div class="flex flex-col gap-2 p-1">
                                <span>Status</span>
                                <select name="status" class="add_option w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">

                                </select>
                            </div>
                            <div class="flex flex-col gap-2 p-1">
                                <span>Note</span>
                                <textarea name="note" class="set_tournament_note w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"></textarea>
                            </div>
                            <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg
                           focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out">Save Changes</button>
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

            $('body').on('click','.show_tournament_approval_status',function (){

                $('.set_tournament_id').val($(this).attr('tournament_id'))
                $('.set_tournament_note').val($(this).attr('tournament_note'))
                let options='';
                let status=$(this).attr('tournament_status')

                options+='<option value="1" '+(status==1 ? 'selected' : '' )+'>Approve</option>'
                options+='<option value="2" '+(status==2 ? 'selected' : '' )+' >Reject</option>'
                $('.add_option').html(options)


            })

            $('body').on('submit','#submit_form',function (e){
                e.preventDefault();
                let formDta = $(this).serialize();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:$(this).attr('data-action'),
                    method:$(this).attr('method'),
                    data:formDta,
                    success:function(data){
                        $("#dataTableAuthor").load(" #dataTableAuthor");
                        $('.close_modal').trigger('click');
                        swal({
                            title: 'success',
                            text: data.message,
                            icon: data.type,
                            timer: 5000,
                        })
                    }
                });
            })

        })
    </script>
@endsection
