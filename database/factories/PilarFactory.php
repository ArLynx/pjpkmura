<?php

namespace Database\Factories;

use App\Models\Pilar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pilar>
 */
class PilarFactory extends Factory
{
    protected $model = Pilar::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->words(3, true),
            'urutan' => fake()->unique()->numberBetween(1, 100),
        ];
    }
}
