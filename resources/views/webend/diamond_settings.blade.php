@extends('webend.layouts.master')

@section('content')
<section class="w-full bg-white p-3 mt-5">
    <div class="container px-2 mx-auto xl:px-5">
        <!-- start menu -->
        <div class="mt-4">
            <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                <li class="flex items-center">
                    <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    <a href="#" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                        Home
                    </a>
                </li>
                <li aria-current="page" class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <div class="flex items-center">
                        <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Diamond</span>
                    </div>
                </li>
            </ol>
        </div>
        <!-- end menu -->

        <!-- Diamond form start -->
        <div class="border border-[#8e0789] rounded-md mt-10">
            <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                <h2 class="text-2xl font-bold py-2 text-white pl-3">Diamond Price Setting </h2>
            </div>
            <!-- Diamond form start -->
            <form action="{{ route('diamond.update') }}" method="POST">
                @csrf
                <div class="flex flex-col gap-4 p-4 mt-3">
                    <div class="flex flex-col md:flex-row justify-between gap-3">
                        <div class="w-full">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Diamond Price(Previous)</h4>
                                <input placeholder="Enter Diamond Number" name="previous_price" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{ $diamond_view->previous_price }}"  step="0.01" >
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Diamond Price (Current)</h4>
                                <input placeholder="Enter Diamond Price" name="current_price" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{ $diamond_view->current_price }}" step="0.01"  >
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Diamond Price (Partner)</h4>
                                <input placeholder="Enter Diamond Price (Partner)" name="partner_price" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" value="{{ $diamond_view->partner_price }}" step="0.01" >
                            </div>
                        </div>
                    </div>

                    @if($diamond_view != null)
                    <div class="w-full flex justify-end">
                        <button type="submit" class="inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                            Submit
                        </button>
                    </div>
                    @endif
                </div>
            </form>
            <!-- Diamond form end -->
        </div>
        <!-- Diamond form end -->


    </div>
</section>
@endsection
