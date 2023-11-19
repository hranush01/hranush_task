<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class NotBlockedUser implements Rule
{
    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value):bool
    {
        return User::where('email', $value)->where('is_blocked', false)->exists();
    }

    /**
     * @return string
     */
    public function message():string
    {
        return 'The user is blocked or does not exist.';
    }
}
