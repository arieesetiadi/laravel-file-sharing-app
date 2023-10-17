<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LogoutRequest;
use App\Services\UserService;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LogoutController extends Controller
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
     * Attempt the logout process.
     */
    public function process(LogoutRequest $request): JsonResponse
    {
        // Find token id by the given bearer token
        $activeToken = str_replace('Bearer ', '', $request->header('Authorization'));
        $tokenId = explode('|', $activeToken)[0];

        // Delete user's token base on token id
        $user = $request->validatedUser();
        $user->tokens()->where('id', $tokenId)->delete();

        return $this->success(
            code: Response::HTTP_OK,
            message: 'Auth token deleted successfully.'
        );
    }
}
