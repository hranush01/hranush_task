<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\UserService;
use App\Mail\UserBlockedReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{



    public function __construct(private UserService $userService)
    {
    }


    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request):JsonResponse
    {
        return response()->json(($response = $this->userService->login($request)),
            isset($response['token']) ? 200 : 401 );
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request):JsonResponse
    {
       $this->userService->registerUser($request);

       return response()->json(['message' => 'User registered successfully'], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createModerator(Request $request):JsonResponse
    {
        $this->userService->registerUser($request,'moderator');
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function blockUser(Request $request)
    {
        $user = User::find($request->input('user_id'));


        if ($user->role !== 'admin') {

            $user->update([
                'is_blocked' => 1,
            ]);

            $reportText = 'This is the report text for the blocked user. Customize as needed.';

            Mail::to($user->email)->send(new UserBlockedReport($user, $reportText));

            return response()->json(['message' => 'User blocked'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
