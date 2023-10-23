@extends('merchant.layout.app')
@section('extra_css')
    <link href="{{ asset('webend/style/css/dropify.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 25px;
        }
        .dropify-wrapper .dropify-preview .dropify-render img{
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <section class="w-full bg-white p-3 mt-5" >
        <div class="container px-2 mx-auto xl:px-5">
            <!-- start menu -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        <a href="{{ route('merchant.dashboard') }}" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Shop Setting</span>
                        </div>
                    </li>
                </ol>
            </div>
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Shop Setting</h2>
                </div>
                <!-- Category form start -->
                <form id="ShopSettingForm" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-4 p-4 mt-3">
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Shop Name*</h4>
                                    <input name="shop_name" placeholder="Enter shop name" class="deposit_amount w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="text" value="{{$data?->shop_name}}">
                                </div>
                            </div>
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Legal Name</h4>
                                <input name="legal_name" placeholder="Enter shop legal name" class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                       type="text" value="{{$data?->legal_name}}">
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Trade License</h4>
                                    <input name="trade_licence" class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="text"
                                           placeholder="Enter trade license"
                                           value="{{$data?->trade_licence}}">
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Trade License Issued Date</h4>
                                    <input name="trade_licence_issued"
                                           id="licenseIssuedDate"
                                           class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="text"
                                           value="{{$data?->trade_licence_issued}}"
                                    >
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Trade License Expired Date</h4>
                                    <input name="trade_licence_expired"
                                           class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="text"
                                           id="licenseExpiredDate"
                                           value="{{$data?->trade_licence_expired}}"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Shop Address</h4>
                                    <input name="address"
                                           class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           placeholder="Enter shop address"
                                           type="text"
                                           value="{{$data?->address}}"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Help Line</h4>
                                    <input name="help_line"
                                           class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           placeholder="Enter helpline number"
                                           type="text"
                                           value="{{$data?->help_line}}"
                                    >
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Available Time</h4>
                                    <input name="available_time"
                                           class=" w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none"
                                           type="text"
                                           value="{{$data?->available_time}}"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-3">
                            <div class="w-full">
                                <div class="w-full">
                                    <h4 class="mb-2 font-medium text-zinc-700">Shop Detail</h4>
                                    <textarea rows="8" cols="3" placeholder="Description" name="detail" class="summernote w-full px-4 py-2 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text">
                                        {{$data?->detail}}
                                    </textarea>
                                </div>
                            </div>
                            <div class="w-full">
                                <div class="w-full">
                                    <div class="upload__box mt-5">
                                        <div class="upload__btn-box">
                                            <label class="upload__btn">
                                                <p>Upload Shop Logo</p>
                                                <input type="file" name="image" class="upload__inputfile dropify"
                                                       @if($data) data-default-file="{{asset('uploads/shop/resize/'. $data->logo )}} @endif">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full flex justify-start">
                            <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Update
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

    <script !src="">
        $(function (){
            $('body').on('submit','#ShopSettingForm',function(e){
                $('.error-message').hide()
                e.preventDefault();
                let formDta = new FormData(this);
                $.ajax({
                    url: '{{route('merchant.shop.setting')}}',
                    method: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data:formDta,
                    success:function (data){
                        Toast.fire({
                            icon: data.type,
                            title: data.message
                        })

                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;

                            // Display error messages for each input field
                            $.each(errors, function (field, errorMessage) {
                                const inputField = $('[name="' + field + '"]');
                                inputField.after('<span class="error-message text-red-600">' + errorMessage[0] + '</span>');
                            });
                        } else {
                            console.log('An error occurred:', status, error);
                        }
                    }
                })

            })
            $('.dropify').dropify();
            $('.summernote').summernote();

        })
    </script>
    <script>
        $(function() {
            // Initialize the datepickers with appropriate date formats
            $("#licenseIssuedDate").datepicker({
                dateFormat: "dd-mm-yy" // Date format (day-month-year)
            });

            $("#licenseExpiredDate").datepicker({
                minDate: 1,
                dateFormat: "dd-mm-yy" // Date format (day-month-year)
            });
        });
    </script>
@endsection

