@extends('webend.seller.layouts.master')
@section('content')
    <div class="mt-6 mx-6 p-4 bg-[#8e0789] flex items-center justify-center border-gray-200 rounded-md">
        <p class="typewriter inline-block text-white text-base sm:text-2xl font-bold text-center">Welcome to {{ config('app.name')}} Seller Dashboard</p>
    </div>
    <div class="mt-4 mx-6">
        <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-3 pb-3">
            <div class="py-3 px-5 transition-shadow bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-sm hover:shadow-lg">
                <div class="p-4 flex items-start justify-between border-b-2 border-gray-300">
                    <div class="flex flex-col space-y-2">
                        <span class="text-gray-600 font-bold text-2xl">Total Players </span>
                        <span class="text-lg font-medium">3</span>
                    </div>
                    <div class="p-2 bg-green-600 text-white rounded-md text-5xl">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="#">
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
                        <span class="text-gray-600 font-bold text-2xl">Total Tournament</span>
                        <span class="font-bold text-xl">5</span>
                    </div>
                    <div class="p-2 bg-blue-600 text-white rounded-md text-5xl">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>
                <div class="p-2">
                    <a href="#">
                        <div class="flex justify-end">
                            <div class="inline-block px-2 rounded text-black font-bold cursor-pointer">View all</div>
                            <div class="text-black font-bold cursor-pointer"><i class="fas fa-chevron-right"></i></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>

@endsection
