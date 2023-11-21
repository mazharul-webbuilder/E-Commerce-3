<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * This Helper file will help to get Application all type of users information and
 * frequently users related task
*/

const USER = [
    'admin' => 'admin',
    'merchant' => 'merchant',
    'seller' => 'seller',
    'affiliator' => 'affiliator',
    'shareOwner' => 'shareOwner',
    'clubOwner' => 'clubOwner',
    'normalUser' => 'normalUser',
    'all' => 'all'
];

/**
 * Get Admin User
*/
if (!function_exists('get_auth_admin')) {
    function get_auth_admin()
    {
        return Auth::guard('admin')->user();
    }
}

/**
 * Get Auth Merchant User
*/
if (!function_exists('get_auth_merchant')) {
    function get_auth_merchant()
    {
        return Auth::guard('merchant')->user();
    }
}

/**
 * Get Auth Seller User
*/
if (!function_exists('get_auth_seller')) {
    function get_auth_seller()
    {
        return Auth::guard('seller')->user();
    }
}

/**
 * Get Auth Affiliator User
*/

if (!function_exists('get_auth_affiliator')) {
    function get_auth_affiliator()
    {
        return Auth::guard('affiliate')->user();
    }
}

/**
 * Get Total End Users
*/
if (!function_exists('getNumberOfEndUsers')) {
    function getNumberOfEndUsers(): int
    {
        return DB::table('users')->count();
    }
}






















