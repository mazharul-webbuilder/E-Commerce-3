@extends('merchant.layout.app')
@section('extra_css')
    <link href="{{ asset('webend/style/css/dropify.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 25px;
        }

        .dropify-wrapper .dropify-preview .dropify-render img {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- start menu -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Product create</span>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="flex justify-end">
                <a style="text-decoration: none;" href="{{ URL::previous() }}"
                   class="text-white bg-blue-700 hover:bg-blue-800  transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back
                </a>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Product Create</h2>
                </div>
                <!-- Category form start -->
                <form id="submit_form" data-action="{{ route('merchant.product.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Product Title</h4>
                                    <input placeholder="Product Title" name="title"
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="text">
                                    <span class="title_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Short Description</h4>
                                    <textarea placeholder="Product short description" name="short_description"
                                              class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"></textarea>
                                    <span class="short_description_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Weight</h4>
                                    <input placeholder="Weight" name="weight" min="0.01"
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="number" step=0.01>
                                    <span class="weight_error text-red-400"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-gray">Select Category</h4>
                                <div class="relative inline-flex w-full">

                                    <select
                                        class="find_sub_category w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none"
                                        name="category_id" id="category_id" data-action="{{ route('find_sub_category') }}">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="category_error text-red-400"></span>
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-gray">Select Sub Category</h4>
                                <div class="relative inline-flex w-full">
                                    <select
                                        class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none load_sub_cat"
                                        name="sub_category_id">
                                    </select>
                                </div>
                                <span class="sub_cat_error text-red-400"></span>
                            </div>

                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-gray">Product Unit</h4>
                                <div class="relative inline-flex w-full">
                                    <select
                                        class="w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none"
                                        name="unit_id">
                                        <option value="">Select Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="unit_error text-red-400"></span>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Purchase Price</h4>
                                    <input placeholder="Purchase Price" name="purchase_price" min="0" step="0.01"
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="number" required>
                                    <span class="purchase_price_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Previous Price</h4>
                                    <input min="1" placeholder="Previous Price" name="previous_price"
                                           step="0.01"
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="number">
                                    <span class="previous_price_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Current Price</h4>
                                    <input min="1" placeholder="Discount Price" name="current_price"
                                           step="0.01"
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="number">
                                    <span class="current_price_error text-red-400"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Previous Coin</h4>
                                    <input min="1" placeholder="Previous Coin" name="previous_coin"
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="number">
                                    <span class="previous_coin_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Purchase Coin</h4>
                                    <input min="1" placeholder="Purchase Coin" name="current_coin"
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="number">
                                    <span class="current_coin_error text-red-400"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Delivery Charge Dhaka (In)</h4>
                                    <input min="0" placeholder="Delivery Charge in dhaka" step="0.01"
                                           name="delivery_charge_in_dhaka"
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="number">
                                    <span class="delivery_charge_in_dhaka_error text-red-400"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Delivery Charge Dhaka (Out)</h4>
                                    <input min="0" placeholder="Delivery Charge out dhaka" step="0.01"
                                           name="delivery_charge_out_dhaka"
                                           class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="number">
                                    <span class="delivery_charge_out_dhaka_error text-red-400"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <div class="upload__box mt-5">
                                        <div class="upload__btn-box">
                                            <label class="upload__btn">
                                                <p>Upload images</p>
                                                <input type="file" name="thumbnail" class="upload__inputfile dropify">
                                            </label>
                                        </div>
                                        <span class="thumbnail_error text-red-400"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Description</h4>
                                <textarea rows="3" cols="3" placeholder="Description" name="description"
                                          class="summernote w-full px-4 py-2 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                          type="text"></textarea>
                                <span class="description_error text-red-400"></span>
                            </div>
                        </div>

                        <div class="w-full flex justify-end">
                            <button type="submit"
                                    class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Add Product
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
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('/webend/style/js/dropify.js') }}"></script>
    <script>
        $(document).ready(function() {
            // get all sub category
            $('body').on('change', '.find_sub_category', function() {
                let category_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(this).attr('data-action'),
                    method: "POST",
                    data: {
                        category_id: category_id
                    },
                    success: function(data) {
                        var setItem = '';
                        data.subcategoryes.forEach(function(item, index) {
                            console.log(item.name)
                            setItem += '<option value="' + item.id + '">' + item.name +
                                '</option>'
                        });
                        $('.load_sub_cat').html(setItem);
                    },
                    error: function(response) {}
                });
            });
            //end sub category
            $('body').on('submit', '#submit_form', function(e) {

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
                    success: function(data) {
                        if (data.status_code == 200) {
                            swal("Good job!", data.message, data.type);
                            $(".submit_button").text("Add").prop('disabled', false)
                            $("#submit_form")[0].reset();
                            $('.dropify-wrapper .dropify-preview .dropify-render img').hide();
                        }
                    },
                    error: function(response) {

                        if (response.status === 422) {
                            if (response.responseJSON.errors.hasOwnProperty('title')) {
                                $('.title_error').html(response.responseJSON.errors.title)
                            } else {
                                $('.title_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty(
                                'short_description')) {
                                $('.short_description_error').html(response.responseJSON.errors
                                    .short_description)
                            } else {
                                $('.short_description_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty('weight')) {
                                $('.weight_error').html(response.responseJSON.errors.weight)
                            } else {
                                $('.weight_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty('category_id')) {
                                $('.category_error').html(response.responseJSON.errors
                                    .category_id)
                            } else {
                                $('.category_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty(
                                'sub_category_id')) {
                                $('.sub_cat_error').html(response.responseJSON.errors
                                    .sub_category_id)
                            } else {
                                $('.sub_cat_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty('unit_id')) {
                                $('.unit_error').html(response.responseJSON.errors.unit_id)
                            } else {
                                $('.unit_error').html('')
                            }
                            if (response.responseJSON.errors.hasOwnProperty('purchase_price')) {
                                $('.purchase_price_error').html(response.responseJSON.errors
                                    .purchase_price)
                            } else {
                                $('.purchase_price_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty('previous_price')) {
                                $('.previous_price_error').html(response.responseJSON.errors
                                    .previous_price)
                            } else {
                                $('.previous_price_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty('current_price')) {
                                $('.current_price_error').html(response.responseJSON.errors
                                    .current_price)
                            } else {
                                $('.current_price_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty('previous_coin')) {
                                $('.previous_coin_error').html(response.responseJSON.errors
                                    .previous_coin)
                            } else {
                                $('.previous_coin_error').html('')
                            }
                            if (response.responseJSON.errors.hasOwnProperty('current_coin')) {
                                $('.current_coin_error').html(response.responseJSON.errors
                                    .current_coin)
                            } else {
                                $('.current_coin_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty(
                                'delivery_charge_in_dhaka')) {
                                $('.delivery_charge_in_dhaka_error').html(response.responseJSON
                                    .errors.delivery_charge_in_dhaka)
                            } else {
                                $('.delivery_charge_in_dhaka_error').html('')
                            }
                            if (response.responseJSON.errors.hasOwnProperty(
                                'delivery_charge_out_dhaka')) {
                                $('.delivery_charge_out_dhaka_error').html(response.responseJSON
                                    .errors.delivery_charge_out_dhaka)
                            } else {
                                $('.delivery_charge_out_dhaka_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty('description')) {
                                $('.description_error').html(response.responseJSON.errors
                                    .description)
                            } else {
                                $('.description_error').html('')
                            }

                            if (response.responseJSON.errors.hasOwnProperty('thumbnail')) {
                                $('.thumbnail_error').html(response.responseJSON.errors
                                    .thumbnail)
                            } else {
                                $('.thumbnail_error').html('')
                            }
                        }
                        $(".submit_button").text("Add Product").prop('disabled', false)
                    }
                });
            });
            $('.dropify').dropify();
            $('.summernote').summernote();

        })
    </script>
@endsection
