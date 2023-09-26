@extends('webend.layouts.master')


@section('content')
    <div class="mt-6 mx-6 p-4 bg-[#8e0789] flex items-center justify-center border-gray-200 rounded-md">
        <p class="typewriter inline-block text-white text-base sm:text-2xl font-bold text-center">Welcome to
            {{ config('app.name') }} Dashboard</p>
    </div>
    <div class="mt-4 mx-6">
        <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-3 pb-3">

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Players</span>
                        <span class="text-lg font-medium">{{ $user }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('all.user') }}">
                        <div class="flex justify-end">
                            <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                            <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                        </div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-blue-200 to-blue-100 border-b-4 border-blue-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between  border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Tournament</span>
                        <span class="font-bold text-xl">{{ $tournament }}</span>
                    </div>
                    <div class="p-2 bg-blue-600 text-white rounded-md text-5xl">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('all.tournament') }}">
                        <div class="flex justify-end">
                            <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                            <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                        </div>
                    </a>
                </div>
            </div>

            {{--            ecommerce part card here start --}}
            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-purple-200 to-purple-100 border-b-4 border-purple-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Banner</span>
                        <span class="font-bold text-xl">{{ $banner }}</span>
                    </div>
                    <div class="p-2 bg-purple-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('banner.all') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Slider</span>
                        <span class="font-bold text-xl">{{ $slider }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('slider.index') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Normal Member</span>
                        <span class="font-bold text-xl">{{ count(get_rank_wise_user(0, 'rank')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('rank_wise_user', ['rank_name' => 0, 'type' => 'rank']) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total VIP Member</span>
                        <span class="font-bold text-xl">{{ count(get_rank_wise_user(1, 'rank')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('rank_wise_user', ['rank_name' => 1, 'type' => 'rank']) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Partner</span>
                        <span class="font-bold text-xl">{{ count(get_rank_wise_user(2, 'rank')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('rank_wise_user', ['rank_name' => 2, 'type' => 'rank']) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Star</span>
                        <span class="font-bold text-xl">{{ count(get_rank_wise_user(3, 'rank')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('rank_wise_user', ['rank_name' => 3, 'type' => 'rank']) }}"
                        class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Sub Controller</span>
                        <span class="font-bold text-xl">{{ count(get_rank_wise_user(4, 'rank')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('rank_wise_user', ['rank_name' => 4, 'type' => 'rank']) }}"
                        class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Controller</span>
                        <span class="font-bold text-xl">{{ count(get_rank_wise_user(5, 'rank')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('rank_wise_user', ['rank_name' => 5, 'type' => 'rank']) }}"
                        class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Diamond Partner</span>
                        <span class="font-bold text-xl">{{ count(get_rank_wise_user(1, 'diamond_partner')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('rank_wise_user', ['rank_name' => 1, 'type' => 'diamond_partner']) }}"
                        class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Share Owners</span>
                        <span class="font-bold text-xl">{{ count(get_share_owners()) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('share_owner_list') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Purchased Share</span>
                        <span class="font-bold text-xl">{{ count(get_share_holders()) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('share_holder_list') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Diamond Balance</span>
                        <span class="font-bold text-xl">{{ get_total_diamond_balance()->sum('paid_diamond') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('diamond_holder_user') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Purchase Diamond</span>
                        <span class="font-bold text-xl">{{ get_total_purchase_diamond()->sum('total_diamond') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('diamond_purchase_history') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Diamond Used</span>
                        <span class="font-bold text-xl">{{ get_total_purchase_used()->sum('used_diamond') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('diamond_used_history') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Wining Balance</span>
                        <span class="font-bold text-xl">{{ get_users()->sum('win_balance') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('all.user') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Earn Wining Coin</span>
                        <span
                            class="font-bold text-xl">{{ get_earn_wining_coin(COIN_EARNING_SOURCE['tournament_winning'])->sum('earning_coin') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_earning_coin', COIN_EARNING_SOURCE['tournament_winning']) }}"
                        class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Withdraw Coin</span>
                        <span class="font-bold text-xl">{{ get_total_withdraw(2)->sum('withdraw_balance') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_withdraw_coin', ['status' => 2]) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total wining coin to gift</span>
                        <span
                            class="font-bold text-xl">{{ get_total_balance_transfer('win_to_gift')->sum('transfer_balance') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_transfer_balance', ['constant_title' => 'win_to_gift']) }}"
                        class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Marketing Coin</span>
                        <span class="font-bold text-xl">{{ get_users()->sum('marketing_balance') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('all.user') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Marketing Achieved</span>
                        <span
                            class="font-bold text-xl">{{ get_earn_wining_coin('share_fund_history')->sum('earning_coin') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_earning_coin', COIN_EARNING_SOURCE['share_fund_history']) }}"
                        class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Marketing to win</span>
                        <span
                            class="font-bold text-xl">{{ get_total_balance_transfer('marketing_to_win')->sum('transfer_balance') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_transfer_balance', ['constant_title' => 'marketing_to_win']) }}"
                        class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total gift coin</span>
                        <span class="font-bold text-xl">{{ get_users()->sum('paid_coin') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('all.user') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total gift coin spend in tournament</span>
                        <span
                            class="font-bold text-xl">{{ get_coin_uses_history('tournament_registration')->sum('user_coin') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_coin_uses_history', ['purpose' => 'tournament_registration']) }}"
                        class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Gift to win coin</span>
                        <span
                            class="font-bold text-xl">{{ get_total_balance_transfer('gift_to_win')->sum('transfer_balance') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_transfer_balance', ['constant_title' => 'gift_to_win']) }}"
                        class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Gift Token</span>
                        <span class="font-bold text-xl">{{ count(get_user_token('gift')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_user_token', ['type' => 'gift']) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Gift token used</span>
                        <span class="font-bold text-xl">{{ count(get_token_used_history('gift')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_token_used_history', ['type' => 'gift']) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Green Token from league tournament</span>
                        <span class="font-bold text-xl">{{ count(get_source_wise_token('league_tournament')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_source_wise_token', ['getting_source' => 'league_tournament']) }}"
                        class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Gift Token Transfer</span>
                        <span class="font-bold text-xl">{{ count(get_transfer_token_history('gift')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_token_transfer_history', ['type' => 'gift']) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Green Token</span>
                        <span class="font-bold text-xl">{{ count(get_user_token('green')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_user_token', ['type' => 'green']) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Green token used</span>
                        <span class="font-bold text-xl">{{ count(get_token_used_history('green')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_token_used_history', ['type' => 'green']) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Green Token Transfer</span>
                        <span class="font-bold text-xl">{{ count(get_transfer_token_history('green')) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_token_transfer_history', ['type' => 'green']) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Game Assets</span>
                        <span class="font-bold text-xl">{{ get_users()->sum('game_asset') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('all.user') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Share Holders</span>
                        <span class="font-bold text-xl">{{ count(get_share_holder_list()) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('shareholder.share_holder') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total purchased Share</span>
                        <span class="font-bold text-xl">{{ get_share_holder_list()->sum('total_share') }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('shareholder.share_holder') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Shareholder's income balance</span>
                        <span
                            class="font-bold text-xl">{{ get_income_balance_shareholder(get_share_holder_list()) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('shareholder.share_holder') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Share Transfer</span>
                        <span class="font-bold text-xl">{{ count(get_share_transfer_history()) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_share_transfer_history') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Data Applied User</span>
                        <span class="font-bold text-xl">{{ count(get_data_applied_users()) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_data_applied_users') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Regular Tournament</span>
                        <span class="font-bold text-xl">{{ count(get_admin_tournament(1)) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_admin_tournament', ['game_type' => 1]) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total League Tournament</span>
                        <span class="font-bold text-xl">{{ count(get_admin_tournament(2)) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_admin_tournament', ['game_type' => 2]) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Campaign Tournament</span>
                        <span class="font-bold text-xl">{{ count(get_admin_tournament(3)) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_admin_tournament', ['game_type' => 3]) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Offer Tournament</span>
                        <span class="font-bold text-xl">{{ count(get_admin_tournament(4)) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('get_admin_tournament', ['game_type' => 4]) }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>

            <div
                class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Club</span>
                        <span class="font-bold text-xl">{{ count(get_total_club()) }}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{ route('admin_club.index') }}" class="flex justify-end">
                        <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                        <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                    </a>
                </div>
            </div>


        </div>
    </div>
@endsection
