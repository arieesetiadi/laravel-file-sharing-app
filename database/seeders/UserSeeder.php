<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (UserRole::all() as $userRole) {
            User::query()->create([
                'user_role_id' => $userRole->id,
                'username' => str($userRole->name)->lower(),
                'name' => $userRole->name,
                'email' => str($userRole->name)->lower().'@gmail.com',
                'password' => Hash::make(str($userRole->name)->lower()),
                'status' => true,
            ]);
        }

        User::factory(10)->create();
    }
}
