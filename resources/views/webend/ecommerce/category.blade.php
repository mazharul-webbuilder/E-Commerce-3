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
                        <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Category</span>
                    </div>
                </li>
            </ol>
        </div>
        <!-- end menu -->

    @if(Request::routeIs('category.edit'))
        <!-- Category form start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Category Update</h2>
                </div>
                <!-- Category form start -->
                <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-2/12 pl-5">
                                <h4 class="mb-2 font-medium text-zinc-700">Digital Asset</h4>
                                <div class="flex gap-x-6 items-center">
                                    <label for="yes" class="inline-flex items-center mt-3">
                                        <input  id="yes" value="1" {{$category->digital_asset == 1 ? 'checked' : ''}} name="digital_asset" type="radio" class="form-radio h-6 w-6 text-gray-600 cursor-pointer" ><span class="ml-2 text-gray-700">Yes</span>
                                    </label>
                                    <label for="no" class="inline-flex items-center mt-3">
                                        <input id="no" value="0" {{$category->digital_asset == 0 ? 'checked' : ''}} name="digital_asset" type="radio" class="form-radio h-5 w-5 text-gray-600 cursor-pointer" checked><span class="ml-2 text-gray-700">No</span>
                                    </label>
                                </div>
                            </div>
                            <div class="w-5/12">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Category Title</h4>
                                    <input id="myDIV" placeholder="Enter Category Title" name="name" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" value="{{ $category->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-1/2">
                                <h4 class="mb-2 font-medium text-gray">Status</h4>
                                <div class="relative inline-flex w-full">
                                    <svg class="absolute w-6 h-6 fill-gray-600 -translate-y-1/2 pointer-events-none right-4 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                    <select name="status" class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }} >Active</option>
                                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }} >InActive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <h4 class="mb-2 font-medium text-gray">Image <span>(90x90)</span> </h4>
                                <div class="relative inline-flex w-full">
                                    <input accept="image/*" type='file' id="imgInp" name="image"  class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"/>

                                </div>
                                <img id="blah" style="display: {{$category->image == null ? 'none' : 'block'}} " src="{{ asset($category->image) }}" alt="your image" width="90px" height="90px" />
                            </div>
                        </div>
                        <div class="w-full flex justify-end">
                            <button type="submit" class="inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Category form end -->
            </div>
            <!-- Category form end -->

    @else
        <!-- Category form start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Category Create</h2>
                </div>
                <!-- Category form start -->
                <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-2/12 pl-5">
                                <h4 class="mb-2 font-medium text-zinc-700">Digital Asset</h4>
                                <div class="flex gap-x-6 items-center">
                                    <label for="yes" class="inline-flex items-center mt-3">
                                        <input  id="yes" value="1" name="digital_asset" type="radio" class="form-radio h-6 w-6 text-gray-600 cursor-pointer" ><span class="ml-2 text-gray-700">Yes</span>
                                    </label>
                                    <label for="no" class="inline-flex items-center mt-3">
                                        <input id="no" value="0" name="digital_asset" type="radio" class="form-radio h-5 w-5 text-gray-600 cursor-pointer" checked><span class="ml-2 text-gray-700">No</span>
                                    </label>
                                </div>
                            </div>
                            <div class="w-5/12">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Category Title</h4>
                                    <input id="myDIV" placeholder="Enter Category Title" name="name" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" >
                                </div>
                            </div>

                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">

                            <div class="w-1/2">
                                <h4 class="mb-2 font-medium text-gray">Image <span>(90x90)</span> </h4>
                                <div class="relative inline-flex w-full">
                                    <input accept="image/*" type='file' id="imgInp" name="image"  class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"/>
                                    <img id="blah" style="display: none" src="#" alt="your image" width="90px" height="90px" class="p-2" />
                                </div>

                            </div>
                        </div>
                        <div class="w-full flex justify-end">
                            <button type="submit" class="inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Category form end -->
            </div>
            <!-- Category form end -->
            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Category List</h2>
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
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Image
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Category Title
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Digital Asset
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3">
                                <div class="text-center">
                                    Status
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
                        @foreach($categories as $item)
                            <tr class=" bg-white   dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    @if($item->image != null)
                                        <img  src=" {{asset($item->image) }}">
                                    @else
                                        No Image Found
                                    @endif
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $item->name }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $item->digital_asset == 1 ? 'Yes' : 'No' }}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{ $item->status == 1 ? 'Active' : 'Inactive' }}
                                </td>
                                <td class="whitespace-nowrap space-x-1 text-center px-2 flex items-center justify-center">
                                    <a href="{{ route('category.edit', ['id' => $item->id, 'slug' => $item->slug]) }}" class="text-white bg-sky-400 hover:bg-sky-500 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-5 py-2 text-center">
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('category.destroy',$item->id) }}" type="button" class="text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
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

    @endif

    </div>
</section>
@endsection
