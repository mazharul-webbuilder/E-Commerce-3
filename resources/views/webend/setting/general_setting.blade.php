@extends('webend.layouts.master')
@section('extra_css')

@endsection
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
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Update General Setting</span>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="border border-[#8e0789] rounded-md mt-10 mb-8">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">General Setting</h2>
                </div>
                <!-- Category form start -->
                <form id="submit_form" data-action="{{route('admin.update_general_setting')}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="id" id="" value="{{$setting->id}}">
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Free Coin Login
                                        <span data-toggle="tooltip" title="This coin will get when any user free login. Every 24
                                    hours interval the user will this amount.This amount will be added into free coin account">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="free_login_coin" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->free_login_coin}}">
                                    <span class="free_login_coin_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Free Login Diamond
                                        <span data-toggle="tooltip" title="This diamond will get when any user complete free login. Every 24
                                    hours interval the user will this diamond amount.This amount will be added into free diamond account">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="free_login_diamond"  class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->free_login_diamond}}" >
                                    <span class="free_login_diamond_error text-red-400"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Min Purchase Diamond
                                        <span data-toggle="tooltip" title="When any user will purchase diamond he/she needs to purchase this minimum amount of diamond">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="min_purchase_diamond" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->min_purchase_diamond}}">
                                    <span class="min_purchase_diamond_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Max withdraw Limit
                                        <span data-toggle="tooltip" title="When any user will withdraw balance he/she can not withdraw grater than this amount">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="max_withdraw_limit" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->max_withdraw_limit}}" >
                                    <span class="max_withdraw_limit_error text-red-400"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Referral Bonus
                                        <span data-toggle="tooltip" title="If any user refer other user he/she will get a referral bomus">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="referal_bonus" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->referal_bonus}}">
                                    <span class="referal_bonus_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Min Withdraw Limit
                                        <span data-toggle="tooltip" title="When any user will Withdraw amount he/she can not less than this this amount">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="min_withdraw_limit" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->min_withdraw_limit}}">
                                    <span class="min_withdraw_limit_error text-red-400"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Diamond Partner Coin
                                        <span data-toggle="tooltip" title="When any user will be diamond partner this amount diamond will be reduced from user's diamond amount">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="diamond_partner_coin" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->diamond_partner_coin}}">
                                    <span class="diamond_partner_coin_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Admin Store
                                        <span data-toggle="tooltip" title="When any user will update his/her rank using coin this amount of percent coin will be stored in history">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="admin_store" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->admin_store}}" step="any">
                                    <span class="admin_store_error text-red-400"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Sub controller Commission
                                        <span data-toggle="tooltip" title="Every Eligible Sub Controller will get this percent amount every month. This amount will be stored in recovery fund.">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="sub_controller_commission" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->sub_controller_commission}}">
                                    <span class="sub_controller_commission_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700"> Controller Commission
                                        <span data-toggle="tooltip" title="Every Eligible Controller will get this percent amount every month. This amount will be stored in recovery fund.">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="controller_commission" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->controller_commission}}" >
                                    <span class="controller_commission_error text-red-400"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700"> Use Diamond
                                        <span data-toggle="tooltip" title="When any user will diamond this amount of diamond will be cut from his/her diamond amount">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="use_diamond" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->use_diamond}}">
                                    <span class="use_diamond_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Gift To Win Charge
                                        <span data-toggle="tooltip" title="When any user will transfer balance from Gift to win this percent of amount will be deduction ">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="gift_to_win_charge" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->gift_to_win_charge}}" >
                                    <span class="gift_to_win_charge_error text-red-400"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Win To Gift Charge
                                        <span data-toggle="tooltip" title="When any user will transfer balance from Win to Gift this percent of amount will be deduction">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="win_to_gift_charge" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->win_to_gift_charge}}">
                                    <span class="win_to_gift_charge_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Marketing To Win charge
                                        <span data-toggle="tooltip" title="When any user will transfer balance from Marketing to Win this percent of amount will be deduction">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="marketing_to_win_charge" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->marketing_to_win_charge}}" >
                                    <span class="marketing_to_win_charge_error text-red-400"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700"> Marketing to Gift Charge
                                        <span data-toggle="tooltip" title="When any user will transfer balance from Marketing to Gift this percent of amount will be deduction">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="marketing_to_gift_charge" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->marketing_to_gift_charge}}">
                                    <span class="marketing_to_gift_charge_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Balance Withdraw Charge
                                        <span data-toggle="tooltip" title="When any user withdraw this amount be charged. This amount flat commission for withdraw balance">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="balance_withdraw_charge" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->balance_withdraw_charge}}" >
                                    <span class="balance_withdraw_charge_error text-red-400"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700"> Played Tournament
                                        <span data-toggle="tooltip" title="When any user will transfer balance from Marketing to Gift this percent of amount will be deduction">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="played_tournament" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->played_tournament}}">
                                    <span class="played_tournament_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Win Game Percentage
                                        <span data-toggle="tooltip" title="When any user withdraw this amount be charged. This amount flat commission for withdraw balance">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="win_game_percentage" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->win_game_percentage}}" >
                                    <span class="win_game_percentage_error text-red-400"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700"> Bidder Commission
                                        <span data-toggle="tooltip" title="When any user will transfer balance from Marketing to Gift this percent of amount will be deduction">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="bidder_commission" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->bidder_commission}}">
                                    <span class="played_tournament_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700"> Admin Commission from Bidder section
                                        <span data-toggle="tooltip" title="When any user withdraw this amount be charged. This amount flat commission for withdraw balance">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="admin_commission_from_bid" readonly class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->admin_commission_from_bid}}" >
                                    <span class="win_game_percentage_error text-red-400"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Minimum Bidding Coin
                                        <span data-toggle="tooltip" title="When any user will transfer balance from Marketing to Gift this percent of amount will be deduction">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="min_bidding_amount" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->min_bidding_amount}}">
                                    <span class="played_tournament_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700"> Maximum Bidding Coin
                                        <span data-toggle="tooltip" title="When any user withdraw this amount be charged. This amount flat commission for withdraw balance">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="max_bidding_amount" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->max_bidding_amount}}" >
                                    <span class="win_game_percentage_error text-red-400"></span>
                                </div>
                            </div>
                        </div>


                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Coin Convert to USD
                                        <span data-toggle="tooltip" title="When user convert coin he/she will 0.0094 USD against this amount of coin">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="coin_convert_to_bdt" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->coin_convert_to_bdt}}">
                                    <span class="played_tournament_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700"> Data apply
                                        <span data-toggle="tooltip" title="When any user withdraw this amount be charged. This amount flat commission for withdraw balance">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="data_apply_row" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->data_apply_row}}" >
                                    <span class="win_game_percentage_error text-red-400"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Data Apply Day
                                        <span data-toggle="tooltip" title="When any user will transfer balance from Marketing to Gift this percent of amount will be deduction">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="data_apply_day" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$setting->data_apply_day}}">
                                    <span class="played_tournament_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700"> Data Apply coin
                                        <span data-toggle="tooltip" title="When any user withdraw this amount be charged. This amount flat commission for withdraw balance">
                                            <i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input  name="data_apply_coin" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->data_apply_coin}}" >
                                    <span class="win_game_percentage_error text-red-400"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Unregistration Commission
                                        <span data-toggle="tooltip" ><i class="fas fa-solid fa-info" title="When any user will unregister from tournament this kind of amount will be detuched as %"></i></span>
                                    </h4>
                                    <input  name="tournament_unregistation_commission" required class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->tournament_unregistation_commission}}" >
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Withdraw Saving
                                    </h4>
                                    <input name="withdraw_saving" required
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->withdraw_saving}}" >
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Withdraw Saving Controller
                                    </h4>
                                    <input name="withdraw_saving_controller" required
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->withdraw_saving_controller}}" >
                                </div>
                            </div>

                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Withdraw Saving Sub Controller
                                    </h4>
                                    <input name="withdraw_saving_sub_controller" required
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{$setting->withdraw_saving_sub_controller}}" >
                                </div>
                            </div>

                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">

                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Game Logo
                                        <span data-toggle="tooltip" ><i class="fas fa-solid fa-info"></i></span>
                                    </h4>
                                    <input name="game_logo" id="imgInp"  class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="file" >
                                    <span class="played_tournament_error text-red-400"></span>
                                    <img src="{{ asset($setting->game_logo) }}" id="blah" width="100px" height="50px">
                                </div>
                            </div>

                        </div>


                        <div class="w-full flex">
                            <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Category form end -->
            </div>
        </div>

    </section>
@endsection
@section('extra_js')

    <script>
        $( function() {
            $('[data-toggle="tooltip"]').tooltip();
        } );

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
                        swal("Good job!", data.message,data.type);
                        $(".submit_button").text("Save Changes").prop('disabled', false)
                    }
                },
                error:function(response){

                    if (response.status === 422) {
                        if (response.responseJSON.errors.hasOwnProperty('free_login_coin')) {
                            $('.free_login_coin_error').html(response.responseJSON.errors.free_login_coin)
                        }else{
                            $('.free_login_coin_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('free_login_diamond')) {
                            $('.free_login_diamond_error').html(response.responseJSON.errors.free_login_diamond)
                        }else{
                            $('.free_login_diamond_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('min_purchase_diamond')) {
                            $('.min_purchase_diamond_error').html(response.responseJSON.errors.min_purchase_diamond)
                        }else{
                            $('.min_purchase_diamond_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('max_withdraw_limit')) {
                            $('.max_withdraw_limit_error').html(response.responseJSON.errors.max_withdraw_limit)
                        }else{
                            $('.max_withdraw_limit_error').html('')
                        }
                        if (response.responseJSON.errors.hasOwnProperty('min_withdraw_limit')) {
                            $('.min_withdraw_limit_error').html(response.responseJSON.errors.min_withdraw_limit)
                        }else{
                            $('.min_withdraw_limit_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('diamond_partner_coin')) {
                            $('.diamond_partner_coin_error').html(response.responseJSON.errors.diamond_partner_coin)
                        }else{
                            $('.diamond_partner_coin_error').html('')
                        }
                        if (response.responseJSON.errors.hasOwnProperty('admin_store')) {
                            $('.admin_store_error').html(response.responseJSON.errors.admin_store)
                        }else{
                            $('.admin_store_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('sub_controller_commission')) {
                            $('.sub_controller_commission_error').html(response.responseJSON.errors.sub_controller_commission)
                        }else{
                            $('.sub_controller_commission_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('controller_commission')) {
                            $('.controller_commission_error').html(response.responseJSON.errors.controller_commission)
                        }else{
                            $('.controller_commission_error').html('')
                        }
                        if (response.responseJSON.errors.hasOwnProperty('use_diamond')) {
                            $('.use_diamond_error').html(response.responseJSON.errors.use_diamond)
                        }else{
                            $('.use_diamond_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('referal_bonus')) {
                            $('.referal_bonus_error').html(response.responseJSON.errors.referal_bonus)
                        }else{
                            $('.referal_bonus_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('gift_to_win_charge')) {
                            $('.gift_to_win_charge_error').html(response.responseJSON.errors.gift_to_win_charge)
                        }else{
                            $('.gift_to_win_charge_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('win_to_gift_charge')) {
                            $('.win_to_gift_charge_error').html(response.responseJSON.errors.win_to_gift_charge)
                        }else{
                            $('.win_to_gift_charge_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('marketing_to_win_charge')) {
                            $('.marketing_to_win_charge_error').html(response.responseJSON.errors.marketing_to_win_charge)
                        }else{
                            $('.marketing_to_win_charge_error').html('')
                        }


                        if (response.responseJSON.errors.hasOwnProperty('marketing_to_gift_charge')) {
                            $('.marketing_to_gift_charge_error').html(response.responseJSON.errors.marketing_to_gift_charge)
                        }else{
                            $('.marketing_to_gift_charge_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('balance_withdraw_charge')) {
                            $('.balance_withdraw_charge_error').html(response.responseJSON.errors.balance_withdraw_charge)
                        }else{
                            $('.balance_withdraw_charge_error').html('')
                        }
                        if (response.responseJSON.errors.hasOwnProperty('played_tournament')) {
                            $('.played_tournament_error').html(response.responseJSON.errors.played_tournament)
                        }else{
                            $('.played_tournament_error').html('')
                        }

                        if (response.responseJSON.errors.hasOwnProperty('win_game_percentage')) {
                            $('.win_game_percentage_error').html(response.responseJSON.errors.win_game_percentage)
                        }else{
                            $('.win_game_percentage_error').html('')
                        }
                    }
                    $(".submit_button").text("Update Product").prop('disabled', false)
                }
            });
        });
    </script>
    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>

@endsection


