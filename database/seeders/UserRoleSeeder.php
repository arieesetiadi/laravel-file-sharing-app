<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRoles = [
            [
                'code' => 1,
                'name' => 'Admin',
            ],
            [
                'code' => 2,
                'name' => 'General',
            ],
        ];

        foreach ($userRoles as $userRole) {
            UserRole::query()->create($userRole);
        }
    }
}
