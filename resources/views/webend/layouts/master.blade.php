<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title> Dashboard | {{ config('app.name') }} </title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- <link href="{{ asset('webend') }}asset/css/app.css" rel="stylesheet"> -->
    <link rel="icon" type="image/x-icon" href="{{ asset(setting()->game_logo) }}">
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
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet"
        type="text/css" />
    <link href="{{ asset('webend') }}/asset/css/style.css" rel="stylesheet">
    @yield('extra_css')

    <style>
        /* DEMO-SPECIFIC STYLES */
        html {
            height: 100%;
            box-sizing: border-box;
        }

        body {
            position: relative;
            margin: 0;
            min-height: 100%;
            padding-bottom: 6.74rem;
            box-sizing: inherit;
        }

        .typewriter {
            color: #fff;
            font-family: monospace;
            overflow: hidden;
            /* Ensures the content is not revealed until the animation */
            border-right: .15em solid transparent;
            /* The typwriter cursor */
            white-space: nowrap;
            /* Keeps the content on a single line */
            margin: 0 auto;
            /* Gives that scrolling effect as the typing happens */
            letter-spacing: .15em;
            /* Adjust as needed */
            animation:
                typing 3.5s steps(30, end),
                blink-caret .5s step-end;
        }

        /* The typing effect */
        @keyframes typing {
            from {
                width: 0
            }

            to {
                width: 33%
            }
        }

        /* The typewriter cursor effect */
        @keyframes blink-caret {

            from,
            to {
                border-color: transparent
            }

            50% {
                border-color: transparent
            }
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

        .on-off-toggle__input:checked+.on-off-toggle__slider {
            background-color: #6fc2f8
        }

        .on-off-toggle__input:checked+.on-off-toggle__slider:before {
            transform: translateX(34px);
        }

        .on-off-toggle__input:checked+.on-off-toggle__slider:after {
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

        /*** END CSS NEEDED FOR SWITCH **/
    </style>
</head>

<body>
    <script>
        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });
    </script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            @php
                Alert::toast($error, 'error');
            @endphp
        @endforeach
    @endif
    @if (Session::has('alert.config'))
        @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
        @php
            session()->forget('alert.config');
        @endphp
    @endif
    <nav class="bg-[#1b1b9b] border-b border-gray-200 fixed z-30 w-full">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <!-- mobile menu button start -->
                    <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
                        class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                        <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <svg id="toggleSidebarMobileClose" class="w-6 h-6 hidden" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <!-- mobile menu button end -->
                    <!-- logo start -->
                    <div class="text-xl font-bold ml-1 md:ml-16 flex items-center">
                        <a href="{{ route('dashboard') }}" class="cursor-pointer">
                            <img class="h-8 sm:h-20 w-10 sm:w-full" alt="LUDO"
                                @if (setting()->game_logo != null) src="{{ asset(setting()->game_logo) }}" @else src="{{ asset('webend/logo.png') }}" @endif>
                        </a>
                        <h1 class="hidden lg:block lg:ml-32 font-semibold text-white">Admin </h1>
                    </div>
                    <!-- logo end -->
                </div>

                <!-- Right elements -->
                <div class="flex items-center">
                    <div class="flex items-center relative">
                        <div class="dropdown relative">
                            <a href="{{ route('auth.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                                class="dropdown-toggle flex items-center hidden-arrow" href="#"
                                id="dropdownMenuButton2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://mdbootstrap.com/img/new/avatars/2.jpg" class="rounded-full"
                                    style="height: 44px; width: 44px" alt="" loading="lazy" />
                            </a>

                            {{--                        <div class="relative" data-te-dropdown-ref> --}}
                            {{--                            <a --}}
                            {{--                                class="flex items-center whitespace-nowrap rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase --}}
                            {{--                                leading-normal text-white transition duration-150 ease-in-out --}}
                            {{--                                focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] --}}
                            {{--                                focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] --}}
                            {{--                                motion-reduce:transition-none" --}}
                            {{--                                href="#" --}}
                            {{--                                type="button" --}}
                            {{--                                id="dropdownMenuButton2" --}}
                            {{--                                data-te-dropdown-toggle-ref --}}
                            {{--                                aria-expanded="false" --}}
                            {{--                                data-te-ripple-init --}}
                            {{--                                data-te-ripple-color="light"> --}}
                            {{--                                <img src="https://mdbootstrap.com/img/new/avatars/2.jpg" class="rounded-full" --}}
                            {{--                                     style="height: 44px; width: 44px" alt="" loading="lazy" /> --}}

                            {{--                            </a> --}}
                            {{--                            <ul aria-labelledby="dropdownMenuButton2" --}}
                            {{--                                data-te-dropdown-menu-ref --}}
                            {{--                                class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block" aria-labelledby="dropdownMenuButton2"> --}}
                            {{--                                <li> --}}
                            {{--                                    <a class="w-32 dropdown-item font-semibold py-2 px-4 block whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-200" href="#">Profile</a> --}}
                            {{--                                </li> --}}
                            {{--                                <li> --}}
                            {{--                                    <a href="{{ route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"  class="dropdown-item w-32 py-2 px-4 font-semibold block whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-200"> --}}
                            {{--                                        Logout --}}
                            {{--                                    </a> --}}
                            {{--                                    <form id="frm-logout" action="{{ route('auth.logout') }}" method="POST" style="display: none;"> --}}
                            {{--                                        {{ csrf_field() }} --}}
                            {{--                                    </form> --}}
                            {{--                                </li> --}}
                            {{--                            </ul> --}}
                            {{--                        </div> --}}
                            <ul class="divide-y-2 dropdown-menu min-w-max absolute overflow-hidden bg-[#2f2fcc] text-base z-50 float-left py-0 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none left-auto right-0"
                                aria-labelledby="dropdownMenuButton2">
                                <li>
                                    <a class="w-32 dropdown-item font-semibold py-2 px-4 block whitespace-nowrap bg-transparent text-white hover:bg-blue-500"
                                        href="./profile.html">Profile</a>
                                </li>
                                <li>
                                    <a href="{{ route('auth.logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                                        class="dropdown-item w-32 py-2 px-4 font-semibold block whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-200">
                                        Logout
                                    </a>
                                    <form id="frm-logout" action="{{ route('auth.logout') }}" method="POST"
                                        style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Right elements -->
            </div>
        </div>
    </nav>

    <div class="flex overflow-hidden bg-white pt-24">
        <!-- Sidebar Start -->
        <aside id="sidebar" style="width: 280px;"
            class="fixed hidden mt-5 z-20 h-full border-r-2 border-gray-200 top-0 left-0 pt-12 sm:pt-20 lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75"
            aria-label="Sidebar">
            <div class="relative flex-1 flex flex-col h-full  bg-[#1b1b9b] pt-0 overflow-y-auto">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex-1 px-3 bg-[#1b1b9b] divide-y space-y-1">
                        <ul class="space-y-2 pb-6" id="sidenavExample">
                            <li>
                                <a href="{{ route('dashboard') }}"
                                    class="text-lg text-white font-normal rounded-lg {{ Request::routeIs('dashboard') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <svg class="w-6 h-6 text-white group-hover:text-white transition duration-75 "
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                    </svg>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Dashboard</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('system_version') }}"
                                   class="text-lg text-white font-normal rounded-lg {{ Request::routeIs('system_version') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <svg class="w-6 h-6 text-white group-hover:text-white transition duration-75 "
                                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                    </svg>
                                    <span class="ml-3 group-hover:text-white transition duration-150">System Version</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('all.user') }}"
                                    class="text-lg text-white font-normal rounded-lg  {{ Request::routeIs('all.user') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i
                                        class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">User</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('coin_earning_history') }}"
                                    class="text-lg text-white font-normal rounded-lg  {{ Request::routeIs('coin_earning_history') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i
                                        class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Coin Earning
                                        History</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.generation_commission') }}"
                                    class="text-lg text-white font-normal {{ Request::routeIs('admin.generation_commission') ? 'bg-blue-500' : '' }} rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-link"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Generation</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('rank.member') }}"
                                    class="text-lg text-white font-normal {{ Request::routeIs('rank.member') ? 'bg-blue-500' : '' }} rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i
                                        class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Rank List</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('rank.commission') }}"
                                    class="text-lg text-white font-normal {{ Request::routeIs('rank.commission') ? 'bg-blue-500' : '' }} rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i
                                        class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Rank
                                        Commission</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('rank.duration.index') }}"
                                    class="text-lg text-white font-normal {{ Request::routeIs('rank.duration.index') ? 'bg-blue-500' : '' }} rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Rank update
                                        duration</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('rank.coins_auto_update') }}"
                                    class="text-lg text-white font-normal  {{ Request::routeIs('rank.coins_auto_update') ? 'bg-blue-500' : '' }} rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Rank Update by
                                        auto </span>
                                </a>
                            </li>


                            <li>
                                <a href="{{ route('rank.coins') }}"
                                    class="text-lg text-white font-normal  {{ Request::routeIs('rank.coins') ? 'bg-blue-500' : '' }} rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i
                                        class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Rank update by
                                        Coin</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('rank_update_history') }}"
                                    class="text-lg text-white font-normal  {{ Request::routeIs('rank_update_history') ? 'bg-blue-500' : '' }} rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i
                                        class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Rank Update
                                        History</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('rank.gift_token.index') }}"
                                    class="text-lg text-white font-normal rounded-lg {{ Request::routeIs('rank.gift_token.index') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i
                                        class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Rank League
                                        Token</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('all.diamond') }}"
                                    class="text-lg text-white font-normal rounded-lg {{ Request::routeIs('all.diamond') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i
                                        class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Diamond</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('diamond_package.index') }}"
                                    class="text-lg text-white font-normal {{ Request::routeIs('diamond_package.index') ? 'bg-blue-500' : '' }} rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Diamond
                                        Package</span>
                                </a>
                            </li>


                            <li>
                                <a href="{{ route('admin.used_coin_history') }}"
                                    class="text-lg text-white font-normal rounded-lg {{ Request::routeIs('admin.used_coin_history') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Uses Coin
                                        History</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.home.used_coin_history') }}"
                                    class="text-lg text-white font-normal rounded-lg {{ Request::routeIs('admin.home.used_coin_history') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Home Game Coin
                                        History</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.home.used_diamond_history') }}"
                                    class="text-lg text-white font-normal rounded-lg {{ Request::routeIs('admin.home.used_diamond_history') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Home Game Diamond
                                        History</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('all_balance_transfer_history') }}"
                                    class="text-lg text-white font-normal rounded-lg  {{ Request::routeIs('all_balance_transfer_history') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Balance Transfer
                                        History </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('diamond_used_history') }}"
                                    class="text-lg text-white font-normal {{ Request::routeIs('diamond_used_history') ? 'bg-blue-500' : '' }}  rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Diamond Used
                                        History</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('user.token_transfer_history') }}"
                                    class="text-lg text-white font-normal {{ Request::routeIs('user.token_transfer_history') ? 'bg-blue-500' : '' }} rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Token Transfer
                                        History</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('all_referral_history.user') }}"
                                    class="text-lg text-white font-normal rounded-lg {{ Request::routeIs('all_referral_history.user') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">All Referral
                                        History</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('rank_update_history.member') }}"
                                    class="text-lg text-white font-normal rounded-lg flex {{ Request::routeIs('rank_update_history.member') ? 'bg-blue-500' : '' }} items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Rank Update
                                        History</span>
                                </a>
                            </li>



                            <li>
                                <button type="button"
                                    class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500 w-full transition duration-75 group"
                                    aria-controls="dropdown-example-tournament"
                                    data-collapse-toggle="dropdown-example-tournament">
                                    <button type="button"
                                        class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group {{ Route::is(['get_campaign_position', 'shareholder.income_source', 'shareholder.share_holder']) ? 'bg-blue-500' : '' }} active:bg-blue-500  w-full transition duration-75 group"
                                        aria-controls="dropdown-example-tournament"
                                        data-collapse-toggle="dropdown-example-tournament">
                                        <i
                                            class="fas fa-dice-six text-white group-hover:text-white transition duration-75"></i>
                                        <span
                                            class="ml-3 group-hover:text-white transition duration-150">Tournament</span>
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                            class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 448 512">
                                            <path fill="currentColor"
                                                d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                            </path>
                                        </svg>
                                    </button>
                                    <ul id="dropdown-example-tournament"
                                        class="@if (Request::routeIs('get_campaign_position')) @else hidden @endif py-2 bg-blue-900 rounded p-1">
                                        <li>
                                            <a href="{{ route('all.tournament') }}"
                                                class="text-lg text-white font-normal {{ Request::routeIs('all.tournament') ? 'bg-blue-500' : '' }} rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                                <i
                                                    class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="ml-3 group-hover:text-white transition duration-150">Tournament</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('club_owner_tournaments') }}"
                                                class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                                <i
                                                    class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                                <span class="ml-3 group-hover:text-white transition duration-150">Club
                                                    owner Tournament</span>
                                            </a>
                                        </li>
                                    </ul>
                            </li>

                            <li>
                                <a href="{{ route('withdraw.index') }}"
                                    class="text-lg text-white font-normal rounded-lg flex items-center {{ Request::routeIs('withdraw.index') ? 'bg-blue-500' : '' }} p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i
                                        class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Withdrawal
                                        History</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('withdraw.saving') }}"
                                   class="text-lg text-white font-normal rounded-lg flex items-center {{ Request::routeIs('withdraw.saving') ? 'bg-blue-500' : '' }} p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i
                                        class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Withdrawal
                                        Saving</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('withdraw_payment.index') }}"
                                    class="text-lg text-white font-normal rounded-lg {{ Request::routeIs('withdraw_payment.index') ? 'bg-blue-500' : '' }} flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-solid fa-gem"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Withdraw
                                        Payment</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.general_setting') }}"
                                    class="text-lg text-white font-normal {{ Request::routeIs('admin.general_setting') ? 'bg-blue-500' : '' }}  rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i
                                        class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">General
                                        Setting</span>
                                </a>
                            </li>

                            <li>
                                <button type="button"
                                    class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500 w-full transition duration-75 group"
                                    aria-controls="dropdown-example-campaign"
                                    data-collapse-toggle="dropdown-example-campaign">
                                    <button type="button"
                                        class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group {{ Route::is(['get_campaign_position', 'shareholder.income_source', 'shareholder.share_holder']) ? 'bg-blue-500' : '' }} active:bg-blue-500  w-full transition duration-75 group"
                                        aria-controls="dropdown-example-campaign"
                                        data-collapse-toggle="dropdown-example-campaign">
                                        <i
                                            class="fas fa-dice-six text-white group-hover:text-white transition duration-75"></i>
                                        <span
                                            class="ml-3 group-hover:text-white transition duration-150">Campaign</span>
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                            class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 448 512">
                                            <path fill="currentColor"
                                                d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                            </path>
                                        </svg>
                                    </button>
                                    <ul id="dropdown-example-campaign"
                                        class="@if (Request::routeIs('get_campaign_position')) @else hidden @endif py-2 bg-blue-900 rounded p-1">
                                        <li>
                                            <a href="{{ route('campaign.index') }}"
                                                class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                                <i
                                                    class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="ml-3 group-hover:text-white transition duration-150">Campaign</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('get_campaign_position') }}"
                                                class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                                <i
                                                    class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="ml-3 group-hover:text-white transition duration-150">Campaign
                                                    Position</span>
                                            </a>
                                        </li>
                                    </ul>
                            </li>

                            <li>
                                <button type="button"
                                    class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500 w-full transition duration-75 group"
                                    aria-controls="dropdown-example-clubManage"
                                    data-collapse-toggle="dropdown-example-clubManage">
                                    <button type="button"
                                        class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group {{ Route::is(['admin_club.index', 'admin_club.club_owner', 'admin_club.setting','admin_club.boasting_request']) ? 'bg-blue-500' : '' }} active:bg-blue-500  w-full transition duration-75 group"
                                        aria-controls="dropdown-example-clubManage"
                                        data-collapse-toggle="dropdown-example-clubManage">
                                        <i
                                            class="fas fa-dice-six text-white group-hover:text-white transition duration-75"></i>
                                        <span class="ml-3 group-hover:text-white transition duration-150">Manage
                                            Club</span>
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                            class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 448 512">
                                            <path fill="currentColor"
                                                d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                            </path>
                                        </svg>
                                    </button>
                                    <ul id="dropdown-example-clubManage"
                                        class="@if (Request::routeIs('admin_club.index')) @else hidden @endif py-2 bg-blue-900 rounded p-1">
                                        <li>
                                            <a href="{{ route('admin_club.index') }}"
                                                class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                                <i
                                                    class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="ml-3 group-hover:text-white transition duration-150">Club</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin_club.club_owner') }}"
                                                class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                                <i
                                                    class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                                <span class="ml-3 group-hover:text-white transition duration-150">Club
                                                    Owners</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin_club.setting') }}"
                                                class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                                <i
                                                    class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                                <span class="ml-3 group-hover:text-white transition duration-150">Club
                                                    Setting</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('admin_club.boasting_request') }}"
                                               class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                                <i
                                                    class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                                <span class="ml-3 group-hover:text-white transition duration-150">Boasting Request</span>
                                            </a>
                                        </li>

                                    </ul>
                            </li>

                            <li>
                                <button type="button"
                                        class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500 w-full transition duration-75 group"
                                        aria-controls="dropdown-example-advertisementManage"
                                        data-collapse-toggle="dropdown-example-advertisementManage">
                                    <button type="button"
                                            class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group {{ Route::is(['advertisement.setting','advertisement.ad_duration','advertisement.ad_list']) ? 'bg-blue-500' : '' }} active:bg-blue-500  w-full transition duration-75 group"
                                            aria-controls="dropdown-example-advertisementManage"
                                            data-collapse-toggle="dropdown-example-advertisementManage">
                                        <i
                                            class="fas fa-dice-six text-white group-hover:text-white transition duration-75"></i>
                                        <span class="ml-3 group-hover:text-white transition duration-150">Advertisement</span>
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                             class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 448 512">
                                            <path fill="currentColor"
                                                  d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                            </path>
                                        </svg>
                                    </button>
                                    <ul id="dropdown-example-advertisementManage"
                                        class="@if (Request::routeIs('advertisement.setting')) @else hidden @endif py-2 bg-blue-900 rounded p-1">
                                        <li>
                                            <a href="{{ route('advertisement.setting') }}"
                                               class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                                <i
                                                    class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="ml-3 group-hover:text-white transition duration-150">Setting</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('advertisement.ad_duration') }}"
                                               class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                                <i
                                                    class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="ml-3 group-hover:text-white transition duration-150">Ad Duration</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('advertisement.ad_list') }}"
                                               class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                                <i
                                                    class="fas fa-trophy text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="ml-3 group-hover:text-white transition duration-150">Ad List</span>
                                            </a>
                                        </li>


                                    </ul>
                            </li>

                            <li>
                                <button type="button"
                                    class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500 w-full transition duration-75 group"
                                    aria-controls="dropdown-example-share"
                                    data-collapse-toggle="dropdown-example-share">
                                    <button type="button"
                                        class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group {{ Route::is(['shareholder.setting', 'shareholder.income_source', 'shareholder.share_holder', 'shareholder.share_transfer_history']) ? 'bg-blue-500' : '' }} active:bg-blue-500  w-full transition duration-75 group"
                                        aria-controls="dropdown-example-share"
                                        data-collapse-toggle="dropdown-example-share">
                                        <i
                                            class="fas fa-dice-six text-white group-hover:text-white transition duration-75"></i>
                                        <span class="ml-3 group-hover:text-white transition duration-150">Share
                                            Holders</span>
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                            class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 448 512">
                                            <path fill="currentColor"
                                                d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                            </path>
                                        </svg>
                                    </button>
                                    <ul id="dropdown-example-share"
                                        class="@if (Request::routeIs(
                                                'shareholder.setting',
                                                'shareholder.income_source',
                                                'shareholder.share_owner',
                                                'shareholder.share_holder_fund_history',
                                                'shareholder.share_transfer_history',
                                                'shareholder.voucher','shareholder.create_voucher',
                                                'shareholder.voucher_request','shareholder.deposit_history',
                                                'shareholder.coin_earning_history')) @else hidden @endif py-2 bg-blue-900 rounded p-1">
                                        <li>
                                            <a href="{{ route('shareholder.share_owner') }}"
                                                class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('shareholder.share_owner') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">Share
                                                    Owner</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('shareholder.voucher') }}"
                                               class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('shareholder.share_owner') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">Vouchers</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('shareholder.voucher_request') }}"
                                               class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('shareholder.share_owner') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">Vouchers Request</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('shareholder.setting') }}"
                                                class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('shareholder.setting') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">Setting</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('shareholder.income_source') }}"
                                                class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('shareholder.income_source') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">Income
                                                    Source</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('shareholder.share_holder_fund_history') }}"
                                                class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('shareholder.share_holder_fund_history') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">Fund
                                                    History</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('shareholder.deposit_history') }}"
                                               class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('shareholder.deposit_history') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">Deposit
                                                    History</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('shareholder.share_transfer_history') }}"
                                                class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('shareholder.share_transfer_history') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">Transfer
                                                    History</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('shareholder.coin_earning_history') }}"
                                               class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('shareholder.share_transfer_history') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">Coin Earning History</span>
                                            </a>
                                        </li>
                                    </ul>
                            </li>

                            <li>
                                <button type="button"
                                    class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500 w-full transition duration-75 group"
                                    aria-controls="dropdown-example-5" data-collapse-toggle="dropdown-example-5">
                                    <button type="button"
                                        class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group @if (Request::routeIs('all.free.two_player') ||
                                                Request::routeIs('all.free.three_player') ||
                                                Request::routeIs('all.free.four_player')) bg-blue-500 @else @endif active:bg-blue-500 w-full transition duration-75 group"
                                        aria-controls="dropdown-example-5" data-collapse-toggle="dropdown-example-5">
                                        <i
                                            class="fas fa-dice-six text-white group-hover:text-white transition duration-75"></i>
                                        <span class="ml-3 group-hover:text-white transition duration-150">Home
                                            Game</span>
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                            class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 448 512">
                                            <path fill="currentColor"
                                                d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                            </path>
                                        </svg>
                                    </button>
                                    <ul id="dropdown-example-5"
                                        class="@if (Request::routeIs('all.free.two_player') ||
                                                Request::routeIs('all.free.three_player') ||
                                                Request::routeIs('all.free.four_player')) @else hidden @endif py-2 bg-blue-900 rounded p-1">
                                        <li>
                                            <a href="{{ route('all.free.two_player') }}"
                                                class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('all.free.two_player') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">2
                                                    Player</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('all.free.three_player') }}"
                                                class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('all.free.three_player') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-users text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">3
                                                    Player</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('all.free.four_player') }}"
                                                class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group  {{ Request::routeIs('all.free.four_player') ? 'bg-blue-500' : '' }}  active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                                <i
                                                    class="fas fa-users text-white group-hover:text-white transition duration-75"></i>
                                                <span
                                                    class="group-hover:text-white font-normal transition duration-150">4
                                                    Player</span>
                                            </a>
                                        </li>
                                    </ul>
                            </li>


                            <li>
                                <button type="button"
                                    class="text-lg text-white font-normal rounded-lg flex items-center  {{ Request::routeIs('admin.view_commission_history') ? 'bg-blue-500' : '' }}  p-2 hover:bg-blue-500 group active:bg-blue-500 w-full transition duration-75 group"
                                    aria-controls="dropdown-example-6" data-collapse-toggle="dropdown-example-6">
                                    <i
                                        class="fas fa-dice-six text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Recovery
                                        Fund</span>
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                        class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 448 512">
                                        <path fill="currentColor"
                                            d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                        </path>
                                    </svg>
                                </button>
                                <ul id="dropdown-example-6"
                                    class=" {{ Request::routeIs('admin.view_commission_history') ? '' : 'hidden' }}  py-2 bg-blue-900 rounded p-1">
                                    <li>
                                        <a href="{{ route('admin.view_commission_history') }}"
                                            class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900                hover:bg-blue-500 group active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                            <span class="group-hover:text-white font-normal transition duration-150">D.
                                                Recovery Fund</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>


                            <li>
                                <button type="button"
                                    class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group @if (Request::routeIs('settings.free.two_player') ||
                                            Request::routeIs('settings.free.three_player') ||
                                            Request::routeIs('settings.free.four_player')) bg-blue-500 @else @endif  w-full transition duration-75 group"
                                    aria-controls="dropdown-example-7" data-collapse-toggle="dropdown-example-7">
                                    <i
                                        class="fas fa-dice-six text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Home Game
                                        Settings</span>
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                        class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 448 512">
                                        <path fill="currentColor"
                                            d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                        </path>
                                    </svg>
                                </button>
                                <ul id="dropdown-example-7"
                                    class="@if (Request::routeIs('settings.free.two_player') ||
                                            Request::routeIs('settings.free.three_player') ||
                                            Request::routeIs('settings.free.four_player')) @else hidden @endif  py-2 bg-blue-900 rounded p-1">
                                    <li>
                                        <a href="{{ route('settings.free.two_player') }}"
                                            class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('settings.free.two_player') ? 'bg-blue-500' : '' }}  active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-user-friends text-white group-hover:text-white transition duration-75"></i>
                                            <span class="group-hover:text-white font-normal transition duration-150">2
                                                Player</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('settings.free.three_player') }}"
                                            class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('settings.free.three_player') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-users text-white group-hover:text-white transition duration-75"></i>
                                            <span class="group-hover:text-white font-normal transition duration-150">3
                                                Player</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('settings.free.four_player') }}"
                                            class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Request::routeIs('settings.free.four_player') ? 'bg-blue-500' : '' }}  active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-users text-white group-hover:text-white transition duration-75"></i>
                                            <span class="group-hover:text-white font-normal transition duration-150">4
                                                Player</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <hr>
                            <!-- e-commerce section -->

                            {{--Start Ecommerce Users--}}
                            <li>
                                <button type="button"
                                        class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group @if (Request::routeIs('admin.all') ||
                                            Request::routeIs('merchant.all') ||
                                            Request::routeIs('seller.all') ||
                                            Request::routeIs('affiliator.all')) bg-blue-500 @endif  w-full transition duration-75 group"
                                        aria-controls="dropdown-example-15" data-collapse-toggle="dropdown-example-15">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span
                                        class="ml-3 group-hover:text-white  font-normal transition duration-150">Ecommerce Users</span>
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                         class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 448 512">
                                        <path fill="currentColor"
                                              d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                        </path>
                                    </svg>
                                </button>
                                <ul id="dropdown-example-15"
                                    class=" @if (Request::routeIs('admin.all') ||
                                            Request::routeIs('merchant.all') ||
                                            Request::routeIs('seller.all') ||
                                            Request::routeIs('affiliator.all')) @else hidden @endif  py-2 bg-blue-900 rounded p-1">
                                    <li>
                                        <a href="{{ route('admin.all') }}"
                                           class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group @if (Request::routeIs('admin.all')) bg-blue-500 @else @endif focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Admins</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('merchant.all') }}"
                                           class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group @if (Request::routeIs('merchant.all')) bg-blue-500 @else @endif active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Merchants</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('seller.all') }}"
                                           class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group @if (Request::routeIs('seller.all')) bg-blue-500 @else @endif active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Sellers</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('affiliator.all') }}"
                                           class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group @if (Request::routeIs('affiliator.all')) bg-blue-500 @else @endif active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Affiliators</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{--End Ecommerce Users--}}

                            <li>
                                <a href="{{ route('admin.seller.balance.history') }}"
                                   class="{{ Route::is('admin.seller.balance.history') ? 'bg-blue-500' : '' }} text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Seller Recharge Req</span>
                                </a>
                            </li>
                            <li>
                                <button type="button"
                                    class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group @if (Request::routeIs('category.all') ||
                                            Request::routeIs('sub-category.all') ||
                                            Request::routeIs('sub-category.edit') ||
                                            Request::routeIs('category.edit')) bg-blue-500 @endif  w-full transition duration-75 group"
                                    aria-controls="dropdown-example-9" data-collapse-toggle="dropdown-example-9">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span
                                        class="ml-3 group-hover:text-white  font-normal transition duration-150">Category</span>
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                        class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 448 512">
                                        <path fill="currentColor"
                                            d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                        </path>
                                    </svg>
                                </button>
                                <ul id="dropdown-example-9"
                                    class=" @if (Request::routeIs('category.all') ||
                                            Request::routeIs('sub-category.all') ||
                                            Request::routeIs('sub-category.edit') ||
                                            Request::routeIs('category.edit')) @else hidden @endif  py-2 bg-blue-900 rounded p-1">
                                    <li>
                                        <a href="{{ route('category.all') }}"
                                            class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group @if (Request::routeIs('category.all') || Request::routeIs('category.edit')) bg-blue-500 @else @endif focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Category</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('sub-category.all') }}"
                                            class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group @if (Request::routeIs('sub-category.all') || Request::routeIs('sub-category.edit')) bg-blue-500 @else @endif active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Sub-Category</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('brand.index') }}"
                                    class="{{ Route::is('brand.index') ? 'bg-blue-500' : '' }} text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Brand</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('banner.all') }}"
                                    class="{{ Route::is('banner.all') ? 'bg-blue-500' : '' }} text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Banner</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('slider.index') }}"
                                    class="{{ Route::is('slider.index') ? 'bg-blue-500' : '' }} block px-1.5 py-2 mt-2 font-normal rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span class="group-hover:text-white font-normal transition duration-150">Slider
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('unit.index') }}"
                                    class="{{ Route::is('unit.index') ? 'bg-blue-500' : '' }} block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span class="group-hover:text-white font-normal transition duration-150">Unit
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('size.index') }}"
                                    class="{{ Route::is('size.index') ? 'bg-blue-500' : '' }} block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span class="group-hover:text-white font-normal transition duration-150">Size
                                    </span>
                                </a>
                            </li>
                            {{--Product Start--}}
                            <li>
                                <button type="button"
                                        class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group
                                        @if (
                                            Request::routeIs('product.index') ||
                                            Request::routeIs('product.merchant') ||
                                            Request::routeIs('product.product_detail')) bg-blue-500 @endif  w-full transition duration-75 group"
                                        aria-controls="dropdown-example-10"
                                        data-collapse-toggle="dropdown-example-10">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span
                                        class="ml-3 group-hover:text-white  font-normal transition duration-150">Product</span>
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                         class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 448 512">
                                        <path fill="currentColor"
                                              d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                        </path>
                                    </svg>
                                </button>
                                <ul id="dropdown-example-10"
                                    class=" @if (
                                                Request::routeIs('product.index') ||
                                                Request::routeIs('product.product_detail') ||
                                                Request::routeIs('product.merchant'))
                                            @else hidden @endif  py-2 bg-blue-900 rounded p-1">
                                    <li>
                                        <a href="{{ route('product.index') }}"
                                           class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group
                                            @if (Request::routeIs('product.index') || Request::routeIs('product.product_detail')) bg-blue-500 @else @endif focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Admin Products</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product.merchant') }}"
                                           class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group
                                            @if (Request::routeIs('product.merchant') || Request::routeIs('product.product_detail')) bg-blue-500
                                             @else @endif active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Merchant Products</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{--Product End--}}

                            <li>
                                <a href="{{ route('product.sale_history') }}"
                                    class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Route::is('product.sale_history') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span
                                        class="group-hover:text-white font-normal transition duration-150 padding-left pl-1">Products
                                        Sale History</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('review_coin.index') }}"
                                    class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Route::is('review_coin.index') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span
                                        class="group-hover:text-white font-normal transition duration-150 padding-left pl-1">
                                        Review Coins</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('payment.index') }}"
                                    class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group {{ Route::is('payment.index') ? 'bg-blue-500' : '' }} active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span
                                        class="group-hover:text-white font-normal transition duration-150 padding-left pl-1">
                                        Payment</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('review.index') }}"
                                    class="{{ Route::is('review.index') ? 'bg-blue-500' : '' }} text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Review</span>
                                </a>
                            </li>
                            {{--Order Start--}}
                            <li>
                                <button type="button"
                                        class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group
                                        @if (
                                            Request::routeIs('order.index') ||
                                            Request::routeIs('admin.order')) bg-blue-500 @endif  w-full transition duration-75 group"
                                        aria-controls="dropdown-example-11"
                                        data-collapse-toggle="dropdown-example-11">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span
                                        class="ml-3 group-hover:text-white  font-normal transition duration-150">Order</span>
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                         class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 448 512">
                                        <path fill="currentColor"
                                              d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                        </path>
                                    </svg>
                                </button>
                                <ul id="dropdown-example-11"
                                    class=" @if (
                                                Request::routeIs('order.index') ||
                                                Request::routeIs('admin.order'))
                                            @else
                                             hidden
                                             @endif  py-2 bg-blue-900 rounded p-1">
                                    <li>
                                        <a href="{{ route('order.index', ORDER_TYPE[0]) }}"{{--Order type 0 = all order--}}
                                           class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group
                                            @if(Request::routeIs('order.index') || Request::routeIs('admin.order')) bg-blue-500
                                            @else
                                            @endif focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">All Orders</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.order') }}"
                                           class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group
                                            @if (Request::routeIs('admin.order') || Request::routeIs('admin.order')) bg-blue-500
                                             @else @endif active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Admin Orders</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{--Order End--}}

                            {{--Withdraw Start--}}
                            <li>
                                <button type="button"
                                        class="text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group
                                        @if (
                                            Request::routeIs('ecommerce.withdraw.list.merchant') ||
                                            Request::routeIs('ecommerce.withdraw.list.seller') ||
                                            Request::routeIs('ecommerce.withdraw.list.affiliator')) bg-blue-500 @endif  w-full transition duration-75 group"
                                        aria-controls="dropdown-example-12"
                                        data-collapse-toggle="dropdown-example-12">
                                    <i class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                    <span
                                        class="ml-3 group-hover:text-white  font-normal transition duration-150">Withdraw</span>
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                         class="w-4 h-4 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 448 512">
                                        <path fill="currentColor"
                                              d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                                        </path>
                                    </svg>
                                </button>
                                <ul id="dropdown-example-12"
                                    class=" @if (
                                                Request::routeIs('ecommerce.withdraw.list.merchant') ||
                                            Request::routeIs('ecommerce.withdraw.list.seller') ||
                                            Request::routeIs('ecommerce.withdraw.list.affiliator'))
                                            @else
                                             hidden
                                             @endif  py-2 bg-blue-900 rounded p-1">
                                    <li>
                                        <a href="{{ route('ecommerce.withdraw.list.merchant')}}"
                                        class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group
                                            @if(Request::routeIs('ecommerce.withdraw.list.merchant')) bg-blue-500
                                            @else
                                            @endif focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Merchant</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('ecommerce.withdraw.list.seller') }}"
                                           class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group
                                            @if (Request::routeIs('ecommerce.withdraw.list.seller')) bg-blue-500
                                             @else @endif active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Seller</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('ecommerce.withdraw.list.affiliator') }}"
                                           class="block px-1.5 py-2 mt-2 font-semibold rounded-lg text-white md:mt-0 focus:text-gray-900 hover:bg-blue-500 group
                                            @if (Request::routeIs('ecommerce.withdraw.list.affiliator')) bg-blue-500
                                             @else @endif active:bg-blue-500 focus:outline-none focus:shadow-outline">
                                            <i
                                                class="fas fa-th text-white group-hover:text-white transition duration-75"></i>
                                            <span
                                                class="group-hover:text-white font-normal transition duration-150">Affiliate</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{--Withdraw End--}}


                            <li>
                                <a href="{{ route('currency.index') }}"
                                   class="{{ Route::is('currency.index') ? 'bg-blue-500' : '' }}
                                   text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                <i
                                        class="fas fa-list text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Currency</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ecommerce.users.balance.transfer.history') }}"
                                   class="{{ Route::is('ecommerce.users.balance.transfer.history') ? 'bg-blue-500' : '' }}
                                   text-lg text-white font-normal rounded-lg flex items-center p-2 hover:bg-blue-500 group active:bg-blue-500">
                                <i
                                        class="fas fa-list text-white group-hover:text-white transition duration-75"></i>
                                    <span class="ml-3 group-hover:text-white transition duration-150">Balance Transfer History</span>
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

        <div id="main-content" class="h-full w-full  relative overflow-y-auto lg:ml-64">
            <main>
                @yield('content')

            </main>

        </div>
        <div class="bg-[#1b1b9b] text-center lg:text-left fixed bottom-0  w-full">
            <div class="text-center text-white p-0 text-sm flex flex-col">
                Copyright © 2023
                <div class="text-white mb-2">
                    Developed by IROZEN LLC
                </div>
            </div>
        </div>
    </div>


    @php
        Session::forget(['alert.config', 'sweet_alert.alert']);
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
    <!-- for data table -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('webend') }}/asset/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('webend') }}/asset/js/app.bundle.js"></script>
    <script src="{{ asset('webend') }}/asset/js/main.js"></script>
    <script src="{{ asset('webend') }}/asset/js/dataTable.js"></script>
    {{-- <script src="{{ asset('webend') }}/asset/js/select2.js" ></script> --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


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
        // imgInp.onchange = evt => {
        //     const [file] = imgInp.files
        //     if (file) {
        //         $("#blah").css("display", "block");
        //         blah.src = URL.createObjectURL(file)
        //     }
        // }
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
