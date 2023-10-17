<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\User\StoreRequest;
use App\Http\Requests\API\V1\User\UpdateRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use App\Traits\HasApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use HasApiResponses;

    /**
     * Default service class.
     */
    protected UserService $userService;

    /**
     * Initiate resource service class.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->all(limit: 50);
        $users = UserCollection::make($users);

        return $this->success(
            code: Response::HTTP_OK,
            message: 'Users data retrieved successfully.',
            data: $users
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $credentials = $request->credentials();
        $user = $this->userService->create($credentials);
        $user = UserResource::make($user);

        return $this->success(
            code: Response::HTTP_OK,
            message: 'User data created successfully.',
            data: $user
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->userService->find($id);

        // Check user existance
        if (!$user) {
            return $this->failed(message: 'User data is not found.', code: Response::HTTP_NOT_FOUND);
        }

        $user = UserResource::make($user);

        return $this->success(
            code: Response::HTTP_OK,
            message: 'User data retrieved successfully.',
            data: $user
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id): JsonResponse
    {
        $credentials = $request->credentials();
        $user = $this->userService->find($id);

        // Check user existance
        if (!$user) {
            return $this->failed(message: 'User data is not found.', code: Response::HTTP_NOT_FOUND);
        }

        $user->update($credentials);
        $user = UserResource::make($user);

        return $this->success(
            code: Response::HTTP_OK,
            message: 'User data updated successfully.',
            data: $user
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $user = $this->userService->find($id);

        if (!$user) {
            return $this->failed(message: 'User data is not found.', code: Response::HTTP_NOT_FOUND);
        }

        $user->delete();

        return $this->success(
            code: Response::HTTP_OK,
            message: 'User data deleted successfully.'
        );
    }
}
