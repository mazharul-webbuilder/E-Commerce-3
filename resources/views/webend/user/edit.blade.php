@extends('webend.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5" style="height: 1100px">
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
                    <li class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('all.user') }}" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Player</span>
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Friend</span>
                        </div>
                    </li>
                </ol>
            </div>
            <!-- end menu -->

            <!-- back button start -->
            <section>
                <div class="flex items-center gap-4 pt-4">
                    <div class="flex-none inline-block">
                        <a href="{{ route('all.user') }}" class="flex items-center cursor-pointer justify-center w-9 h-9 bg-white border border-gray-300 rounded-full hover:text-white hover:bg-blue-800 hover:scale-105">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </div>
                    <div class="inline-block">
                        <p class="text-xl">Back</p>
                    </div>
                </div>
            </section>
            <!-- back button end -->

            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Update User detail</h2>
                </div>
                <!-- Tournament form start -->
                <form action="{{route('update_user')}}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Name</h4>
                                <input placeholder="Enter Name" name="name" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{ $user->name }}">
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Email</h4>
                                <input readonly placeholder="Enter Email" name="email" type="email" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" value="{{ $user->email }}">
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Phone Number</h4>
                                <input readonly placeholder="Enter Phone Number" name="mobile" type="number" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" value="{{ $user->mobile }}">
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Gender</h4>
                                <div class="relative inline-flex w-full">
                                    <svg class="absolute w-6 h-6 fill-gray-600 -translate-y-1/2 pointer-events-none right-4 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                    <select name="gender" class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                        <option {{ strtolower($user->gender) == 'male' ? "selected" : '' }} value="male">Male</option>
                                        <option {{ strtolower($user->gender) == 'female' ? "selected" : '' }} value="female">Female</option>
                                        <option {{ strtolower($user->gender) == 'others' ? "selected" : '' }}  value="others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Date of Birth</h4>
                                <input placeholder="Enter Date of Birth" name="dob" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="date" value="{{ $user->dob }}" >
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Refer Code</h4>
                                <input readonly placeholder="Enter Refer Code" name="refer_code" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" readonly value="{{ $user->refer_code }}"  type="number" >
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Free Coin</h4>
                                <input placeholder="Enter Free Coin" name="free_coin" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$user->free_coin}}" >
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Gift Coin</h4>
                                <input placeholder="Enter gift Coin" name="paid_coin" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$user->paid_coin}}">
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Free Diamond</h4>
                                <input placeholder="Enter Free Diamond" name="free_diamond" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$user->free_diamond}}">
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Paid Diamond</h4>
                                <input placeholder="Enter Paid Diamond" name="paid_diamond" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$user->paid_diamond}}">
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Max Loss</h4>
                                <input placeholder="Enter Max Loss" name="max_loos" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$user->max_loos}}">
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Max Win</h4>
                                <input placeholder="Enter Max Win" name="max_win" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$user->max_win}}">
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Win Balance</h4>
                                <input placeholder="Enter Win Balance" name="win_balance" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$user->win_balance}}">
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Crypto Asset</h4>
                                <input placeholder="Enter Crypto Asset" name="crypto_asset" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$user->crypto_asset}}">
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Max Hit</h4>
                                <input placeholder="Enter Max Hit" name="max_hit" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{$user->max_hit}}">
                            </div>
                        </div>

                        <div class="w-full flex justify-end">
                            <button type="submit" class="inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Tournament form end -->
            </div>
            <!-- table end -->
        </div>
    </section>
@endsection
