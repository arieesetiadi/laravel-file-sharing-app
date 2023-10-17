<?php

namespace App\Http\Requests;

class BaseFormRequest
{
    /**
     * Global form request attributes.
     */
    public static function getAttributes(): array
    {
        return [
            'credential' => 'credential',
            'username' => 'username',
            'name' => 'name',
            'email' => 'email',
            'phone' => 'phone',
            'user_role_id' => 'user role',
            'avatar' => 'avatar',
            'password' => 'password',
            'password_confirmation' => 'password confirmation',
            'status' => 'status',
        ];
    }
}
