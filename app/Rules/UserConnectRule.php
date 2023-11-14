<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserConnectRule implements Rule
{
    protected string $userType;



    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $userType)
    {
        $this->userType = $userType;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $flag = false;
        $userId = DB::table('users')->where('playerid', $value)->value('id');

        switch ($this->userType) {
            case 'merchant':
                $flag =  DB::table('merchants')->where('user_id', $userId)->exists();
                break;
            case 'seller':
                $flag = DB::table('sellers')->where('user_id', $userId)->exists();
                break;
            case 'affiliate':
                $flag = DB::table('affiliators')->where('user_id', $userId)->exists();
                break;

        }
        return !$flag;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User is already connected with someone else account.';
    }
}
