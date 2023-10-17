<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    /**
     * Get all users data.
     */
    public function all(int $limit = 50): Collection
    {
        return User::query()->take($limit)->latest()->get();
    }

    /**
     * Paginate all users data.
     */
    public function paginate(int $perPage = 10, bool $simple = true): Paginator
    {
        $pagination = User::query()
            ->when(request()->status !== null, function ($query) { // Filter status
                return $query->where('status', request()->status);
            })
            ->latest();

        $result = match ($simple) {
            true => $pagination->simplePaginate($perPage),
            false => $pagination->paginate($perPage),
        };

        return $result;
    }

    /**
     * Get user by id.
     */
    public function find(string $id): User
    {
        return User::query()->find($id);
    }

    /**
     * Get user by username.
     */
    public function findByUsername(string $username): User
    {
        return User::query()->where('username', $username)->first();
    }

    /**
     * Get user by email.
     */
    public function findByEmail(string $email): User
    {
        return User::query()->where('email', $email)->first();
    }

    /**
     * Get user by phone.
     */
    public function findByPhone(string|int $phone): User
    {
        return User::query()->where('phone', $phone)->first();
    }

    /**
     * Store new user data.
     */
    public function create(array $data): User
    {
        return User::query()->create($data);
    }

    /**
     * Update user data.
     */
    public function update(string $id, array $data): int
    {
        return User::query()->find($id)->update($data);
    }

    /**
     * Delete user data.
     */
    public function delete(string $id): int
    {
        return User::query()->find($id)->delete();
    }

    /**
     * Toggle user status.
     */
    public function toggleStatus(string $id): int
    {
        $user = User::query()->find($id);
        $result = $user->update(['status' => !$user->status]);

        return $result;
    }

    /**
     * Get users by role.
     */
    public function getByRoleCode(int $code): Collection
    {
        $users = User::query()
            ->whereHas('role', function (Builder $query) use ($code) {
                return $query->where('code', $code);
            })
            ->get();

        return $users;
    }
}
