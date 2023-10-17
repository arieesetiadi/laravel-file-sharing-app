<?php

namespace Database\Factories;

use App\Constants\UserRoleCode;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_role_id' => UserRole::query()->where('code', UserRoleCode::CUSTOMER)->value('id'),
            'username' => fake()->unique()->userName,
            'name' => fake()->name,
            'email' => fake()->unique()->email,
            'phone' => fake()->unique()->phoneNumber,
            'password' => Hash::make('customer'),
            'status' => rand(0, 1),
        ];
    }
}
