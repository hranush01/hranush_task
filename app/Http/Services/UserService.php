<?php

namespace App\Http\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService{

    /**
     * @param RegisterRequest $request
     * @param string $role
     * @return void
     */
    public function registerUser(RegisterRequest $request , string $role = 'user'):void
    {
        $requestData = $request->all();
        $requestData['role'] = $role;

        User::create($requestData);
    }

    /**
     * @param LoginRequest $request
     * @return array|string[]
     */
    public function login(LoginRequest $request):array
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('sadad')->accessToken;

            return ['access_token' => $token];
        }

        return ['error' => 'Unauthorized'];
    }
}
