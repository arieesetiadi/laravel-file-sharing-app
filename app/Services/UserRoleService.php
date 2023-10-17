<?php

namespace App\Services;

use App\Models\UserRole;
use Illuminate\Database\Eloquent\Collection;

class UserRoleService
{
    /**
     * Get all user roles data.
     */
    public function all(): Collection
    {
        return UserRole::query()->orderBy('code')->get();
    }

    /**
     * Get user role by id.
     */
    public function find(string $id): UserRole
    {
        return UserRole::query()->find($id);
    }
}
