<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    use HasApiResponses;

    /**
     * Default service class.
     */
    protected UserService $userService;

    /**
     * Initiate controller properties value.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Attempt the login credentials.
     */
    public function process(LoginRequest $request): JsonResponse
    {
        $user = $request->validatedUser();

        // Delete previous auth token
        $user->tokens()->where('name', 'auth')->delete();

        // Generate new auth token
        $token = $user->createToken('auth')->plainTextToken;

        $data = [
            'token' => $token,
            'user' => UserResource::make($user),
        ];

        return $this->success(
            code: Response::HTTP_OK,
            message: 'Auth token generated successfully.',
            data: $data,
        );
    }
}
