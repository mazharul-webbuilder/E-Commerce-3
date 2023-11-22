@extends('webend.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
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
                        <a href="javascript:void(0)" class="flex items-center hover:scale-105">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">User</span>
                        </a>
                    </li>
                </ol>
            </div>
        </div>
        <div class="container mx-auto mt-5 p-5 bg-white rounded-lg shadow-lg">
            <img src="{{default_image()}}" height="100" width="100" />
            <table class="w-full border-collapse">
                <tbody>
                <!-- User Information Rows -->
                <tr class="border-b border-gray-300">
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Name</td>
                    <td class="py-3 px-6 text-left">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Email</td>
                    <td class="py-3 px-6 text-left">{{ $user->email }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Address</td>
                    <td class="py-3 px-6 text-left">{{ $user->address ?? 'No data'}}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Data of Birth</td>
                    <td class="py-3 px-6 text-left">{{ $user->dob ?? 'No data'}}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">PlayerId</td>
                    <td class="py-3 px-6 text-left">{{ $user->playerid ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Refer Code</td>
                    <td class="py-3 px-6 text-left">{{ $user->refer_code ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">User Refer Code</td>
                    <td class="py-3 px-6 text-left">{{ $user->used_reffer_code ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Country</td>
                    <td class="py-3 px-6 text-left">{{ $user->country ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Phone</td>
                    <td class="py-3 px-6 text-left">{{ $user->mobile ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Gender</td>
                    <td class="py-3 px-6 text-left">{{ $user->gender ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Play Coin</td>
                    <td class="py-3 px-6 text-left">{{ $user->playcoin ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Shareholder Fund</td>
                    <td class="py-3 px-6 text-left">{{ $user->shareholder_fund ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Marketing Balance</td>
                    <td class="py-3 px-6 text-left">{{ $user->marketing_balance ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Recovery Fund</td>
                    <td class="py-3 px-6 text-left">{{ $user->recovery_fund ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Crypto Asset</td>
                    <td class="py-3 px-6 text-left">{{ $user->crypto_asset ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Paid Diamond</td>
                    <td class="py-3 px-6 text-left">{{ $user->paid_diamond ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Paid Coin</td>
                    <td class="py-3 px-6 text-left">{{ $user->paid_coin ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Game asset</td>
                    <td class="py-3 px-6 text-left">{{ $user->game_asset ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Free Coin</td>
                    <td class="py-3 px-6 text-left">{{ $user->free_coin ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Free Diamond</td>
                    <td class="py-3 px-6 text-left">{{ $user->free_diamond ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Win Balance</td>
                    <td class="py-3 px-6 text-left">{{ $user->win_balance ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Earning Balance</td>
                    <td class="py-3 px-6 text-left">{{ $user->earning_balance ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Max Win</td>
                    <td class="py-3 px-6 text-left">{{ $user->max_win ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Max Lose</td>
                    <td class="py-3 px-6 text-left">{{ $user->max_loos ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Joining Date</td>
                    <td class="py-3 px-6 text-left">{{ $user->created_at ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Parent</td>
                    <td class="py-3 px-6 text-left">{{ $user->parent?->name ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Rank</td>
                    <td class="py-3 px-6 text-left">{{ $user->rank?->name ?? 'No data' }}</td>
                </tr>
                <tr>
                    <td class="py-3 px-6 text-left font-medium bg-gray-100">Club</td>
                    <td class="py-3 px-6 text-left">{{ $user->club?->club_name ?? 'No data' }}</td>
                </tr>

                <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>


    </section>
@endsection
