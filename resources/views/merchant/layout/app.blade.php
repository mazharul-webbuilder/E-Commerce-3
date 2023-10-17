<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title> Dashboard | {{ config('app.name')}} </title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- <link href="{{ asset('webend') }}asset/css/app.css" rel="stylesheet"> -->

    <link href="{{ asset('webend') }}/asset/css/DataTables/dataTable.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
          integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet" type="text/css" />
    <link href="{{ asset('webend') }}/asset/css/style.css" rel="stylesheet">
    @yield('extra_css')

    <style>
        /* DEMO-SPECIFIC STYLES */
        .typewriter{
            color: #fff;
            font-family: monospace;
            overflow: hidden; /* Ensures the content is not revealed until the animation */
            border-right: .15em solid transparent; /* The typwriter cursor */
            white-space: nowrap; /* Keeps the content on a single line */
            margin: 0 auto; /* Gives that scrolling effect as the typing happens */
            letter-spacing: .15em; /* Adjust as needed */
            animation:
                typing 3.5s steps(30, end),
                blink-caret .5s step-end;
        }

        /* The typing effect */
        @keyframes typing {
            from { width: 0 }
            to { width: 33% }
        }

        /* The typewriter cursor effect */
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: transparent }
        }



        /** BEGIN CSS NEEDED FOR SWITCH **/
        .on-off-toggle {
            width: 66px;
            height: 34px;
            position: relative;
            display: inline-block;
        }

        .on-off-toggle__slider {
            width: 76px;
            height: 34px;
            display: block;
            border-radius: 40px;
            background-color: #6fc2f8;
            transition: background-color 0.4s;
            cursor: pointer;
        }

        .on-off-toggle__slider:before {
            content: '';
            display: block;
            background-color: #fff;
            box-shadow: 0 0 0 1px #949494;
            bottom: 5px;
            height: 24px;
            left: 7px;
            position: absolute;
            transition: .4s;
            width: 28px;
            z-index: 5;
            border-radius: 100%;
        }

        .on-off-toggle__slider:after {
            display: block;
            line-height: 36px;
            text-transform: uppercase;
            font-size: 15px;
            font-weight: bold;
            content: 'BN';
            color: white;
            padding-left: 40px;
            transition: all 0.4s;
        }

        .on-off-toggle__input {
            /*
                This way of hiding the default input is better
                for accessibility than using display: none;
            */

            /* display: none; */
            position: absolute;
            opacity: 0;
        }

        .on-off-toggle__input:checked +
        .on-off-toggle__slider {
            background-color: #6fc2f8
        }

        .on-off-toggle__input:checked +
        .on-off-toggle__slider:before {
            transform: translateX(34px);
        }

        .on-off-toggle__input:checked +
        .on-off-toggle__slider:after {
            content: 'EN';
            color: #FFFFFF;
            padding-left: 10px;
            font-weight: bold;
            font-size: 15px;
        }

        .select2-container .select2-selection--single {
            height: 48px;
            /* line-height: 44px; */
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 10px;
            right: 1px;
            width: 20px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: rgb(134, 134, 134);
            line-height: 39px;
        }
        /*table tr td{*/
        /*    color: black;*/
        /*}*/

        /*** END CSS NEEDED FOR SWITCH **/
    </style>
</head>
<body>
<script>
    window.addEventListener( "pageshow", function ( event ) {
        var historyTraversal = event.persisted ||
            ( typeof window.performance != "undefined" &&
                window.performance.navigation.type === 2 );
        if ( historyTraversal ) {
            // Handle page restore.
            window.location.reload();
        }
    });
</script>

@if(Session::has('alert.config'))
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    @php
        session()->forget('alert.config');
    @endphp
@endif
<nav class="bg-[#1b1b9b] border-b border-gray-200 fixed z-30 w-full">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <!-- mobile menu button start -->
                <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                    <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    <svg id="toggleSidebarMobileClose" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <!-- mobile menu button end -->
                <!-- logo start -->
                <div class="text-xl font-bold ml-1 md:ml-16 flex items-center">
                    <a href="{{ route('merchant.dashboard') }}" class="cursor-pointer">
                        <img class="h-8 sm:h-20 w-10 sm:w-full" alt="LUDO" @if(setting()->game_logo != null)  src="{{ asset(setting()->game_logo) }}" @else src="{{ asset('webend/logo.png') }}" @endif>
                    </a>
                    <h1 class="hidden lg:block lg:ml-32 font-semibold text-white">Merchant</h1>
                </div>
                <!-- logo end -->
            </div>
            <!-- Right elements -->
            <div class="flex items-center">
                <div class="flex items-center relative">
                    <div class="dropdown relative">



                        <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName" class="flex text-white items-center text-sm font-medium text-gray-900 rounded-full hover:text-blue-600 dark:hover:text-blue-500 md:mr-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white" type="button">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 mr-2 rounded-full" src="https://static.toiimg.com/thumb/msid-94864313,imgsize-37446,width-400,resizemode-4/94864313.jpg" alt="user photo">
                            {{auth()->guard('merchant')->user()->name}}
                            <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownAvatarName" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                <div class="font-medium ">{{auth()->guard('merchant')->user()->name}}</div>
                                <div class="truncate">{{auth()->guard('merchant')->user()->email}}</div>
                            </div>
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                                <li>
                                    <a href="{{route('merchant.dashboard')}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                </li>
                                <li>
                                    <a href="{{route('merchant.profile')}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                                </li>
                            </ul>
                            <div class="py-2">
                                <a href="{{ route('merchant.logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>

                                <form id="frm-logout" action="{{ route('merchant.logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            <!-- Right elements -->
        </div>
    </div>
</nav>

<div class="flex overflow-hidden bg-white pt-24">
    <!-- Sidebar Start -->
    <aside id="sidebar" class="fixed hidden mt-5 z-20 h-full border-r-2 border-gray-200 top-0 left-0 pt-12 sm:pt-20 lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75" aria-label="Sidebar">
        <div class="relative flex-1 flex flex-col h-full  bg-[#1b1b9b] pt-0 overflow-y-auto">
            <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                <div class="flex-1 px-3 bg-[#1b1b9b] divide-y space-y-1">
                    <ul class="space-y-2 pb-6" id="sidenavExample">
                        <li>
                            <a href="{{ route('merchant.dashboard') }}" class="text-lg text-white font-normal rounded-lg {{ Request::routeIs('merchant.dashboard') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                <svg class="w-6 h-6 text-white group-hover:text-white transition duration-75 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                                <span class="ml-3 group-hover:text-white transition duration-150">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('merchant.product.index')}}" class="{{ Request::routeIs(['merchant.product.index']) ? 'bg-blue-500' : '' }} text-lg text-white font-normal rounded-lg  flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                <i class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                <span class="ml-3 group-hover:text-white transition duration-150">Products</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('merchant.order.index')}}" class="{{ Request::routeIs(['merchant.order.index']) ? 'bg-blue-500' : '' }} text-lg text-white font-normal rounded-lg  flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                <i class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                <span class="ml-3 group-hover:text-white transition duration-150">Orders</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </aside>

    <!-- Sidebar End -->

    <!-- sidebar Backdrop Start -->
    <div class="bg-[#1b1b9b] opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
    <!-- sidebar Backdrop End -->

    <div id="main-content" class="h-full w-full  relative overflow-y-auto lg:ml-64" >
        <main>
            @yield('content')

        </main>

    </div>
    <div class="bg-[#1b1b9b] text-center lg:text-left fixed bottom-0  w-full">
        <div class="text-center text-white p-0 text-sm flex flex-col">
            Copyright © 2022
            <div class="text-white">
                Developed by <a class="text-white font-medium" target="_blank" href="https://www.banglapuzzle.com/">Bangla Puzzle Limited</a>
            </div>
        </div>
    </div>
</div>


@php
    Session::forget(['alert.config', 'sweet_alert.alert']);
@endphp

    <!-- for data table -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('webend') }}/asset/ckeditor/ckeditor.js"></script>
<script src="{{ asset('webend') }}/asset/js/app.bundle.js" ></script>
<script src="{{ asset('webend') }}/asset/js/main.js" ></script>
<script src="{{ asset('webend') }}/asset/js/dataTable.js" ></script>
<script src="{{ asset('webend') }}/asset/js/select2.js" ></script>
<script src="{{ asset('webend') }}/asset/js/ckeditor.js" ></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
    $(document).on('click', '.diamond_active', function() {

        $('.diamond_limit').prop('disabled', false);
    });
    $(document).on('click', '.diamond_inactive', function() {

        $('.diamond_limit').prop('disabled', true);
    });
</script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single1').select2();
    });
    $(document).ready(function() {
        $('.js-example-basic-single2').select2();
    });
</script>

<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            $("#blah").css("display", "block");
            blah.src = URL.createObjectURL(file)
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
  </script>
@yield('extra_js')


</body>
</html>
