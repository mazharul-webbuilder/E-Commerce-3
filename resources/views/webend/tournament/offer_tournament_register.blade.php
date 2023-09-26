@extends('webend.layouts.master')

@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">All Offer Tournament Register List</h2>
                </div>
                @if(count($tournament_game_board)<1)
                @if($valid_register>=$tournament->player_limit)
                    <div class="flex justify-end p-1">
                        <a href="javascript:;"  tournament_id="{{$tournament->id}}" data-action= "{{route('offer_tournament_manage_game')}}" class="confirmation_button text-white bg-blue-700 hover:bg-blue-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                            Manage Game
                        </a>
                    </div>
                @endif

                @if($player_enrolls>=$tournament->player_limit)
                    <div class="flex justify-end p-1">
                        <a href="javascript:;"  tournament_id="{{$tournament->id}}" data-action= "{{route('offer_tournament_start_game')}}" class="start_game text-white bg-purple-700 hover:bg-purple-800 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                            Start Game
                        </a>
                    </div>
                @endif
                @endif

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
                                    User Name
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                  Registered At
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Status
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Campaign Name
                                </div>
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($offer_tournament_registers as $offer_tournament_register)
                            <tr class=" bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$offer_tournament_register->user->name }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$offer_tournament_register->created_at }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$offer_tournament_register->status==1 ? "Valid" : "Invalid" }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$offer_tournament_register->campaign->campaign_title }}
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
        $(function(){
            $("body").on('click','.confirmation_button',function (){
                swal({
                    title: "Are You sure assign user into game?",
                    text: "Once you click, Tournament will be started right now !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                type: "post",
                                url: $(this).attr('data-action'),
                                data: {tournament_id:$(this).attr('tournament_id')},
                                cache: false,
                                success: function (response) {
                                    $("#dataTableAuthor").load(" #dataTableAuthor")
                                    $(".confirmation_button").hide();
                                    swal({
                                        title: "Good job!",
                                        text: response.message,
                                        icon: response.type,
                                        button: "Okay",
                                    });
                                }
                            });
                        }
                    });
            })


            $("body").on('click','.start_game',function (){
                swal({
                    title: "Are You sure to start game?",
                    text: "Once you click, Tournament will be started right now !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                type: "post",
                                url: $(this).attr('data-action'),
                                data: {tournament_id:$(this).attr('tournament_id')},
                                cache: false,
                                success: function (response) {
                                    $("#dataTableAuthor").load(" #dataTableAuthor")
                                    $(".confirmation_button").hide();
                                    swal({
                                        title: "Good job!",
                                        text: response.message,
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
@endsection
