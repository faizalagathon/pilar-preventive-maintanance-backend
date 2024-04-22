<?php
// UserFactory.php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * The name of the factory's corresponding model.
     */
    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('123'), // You should hash your password
            'role' => $this->faker->randomElement(['admin', 'teknisi', 'kepala_bidang']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
