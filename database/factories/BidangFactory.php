<?php

namespace Database\Factories;

use App\Models\Bidang;
use Illuminate\Database\Eloquent\Factories\Factory;

class BidangFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bidang::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'id_kepala_bidang' => $this->faker->uuid,
            'nama' => $this->faker->name,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
