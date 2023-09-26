@extends('webend.share_owner.layouts.master')
@section('content')
    <div class="mt-4 mx-6">
        <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-3 pb-3">
            <div class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Share</span>
                        <span class="text-lg font-medium">{{count(Auth::guard('share')->user()->share_holders)}}</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{route('share_owner.my_share')}}">
                        <div class="flex justify-end">
                            <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                            <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="py-3 px-5 transition-shadow bg-gradient-to-b from-blue-200 to-blue-100 border-b-4 border-blue-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between  border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Share Wallet</span>
                        <span class="font-bold text-xl">{{Auth::guard('share')->user()->balance}}</span>
                    </div>
                    <div class="p-2 bg-blue-600 text-white rounded-md text-5xl">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{route('share_owner.share_balance_withdraw')}}">
                        <div class="flex justify-end">
                            <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">Withdraw</div>
                            <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="py-3 px-5 transition-shadow bg-gradient-to-b from-blue-200 to-blue-100 border-b-4 border-blue-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between  border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Share Transfer</span>
                        <span class="font-bold text-xl">{{count(Auth::guard('share')->user()->share_transfers)}}</span>
                    </div>
                    <div class="p-2 bg-blue-600 text-white rounded-md text-5xl">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="{{route('share_owner.share_transfer_history')}}">
                        <div class="flex justify-end">
                            <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                            <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="py-3 px-5 transition-shadow bg-gradient-to-b from-blue-200 to-blue-100 border-b-4 border-blue-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between  border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Last Month Share Commission</span>
                        <span class="font-bold text-xl">{{share_holder_setting()->live_share_commission}}</span>
                    </div>
                    <div class="p-2 bg-blue-600 text-white rounded-md text-5xl">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>

            </div>

            <div class="py-3 px-5 transition-shadow bg-gradient-to-b from-blue-200 to-blue-100 border-b-4 border-blue-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between  border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">1 Coin= 0.002 USD</span>
                    </div>
                    <div class="p-2 bg-blue-600 text-white rounded-md text-5xl">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
