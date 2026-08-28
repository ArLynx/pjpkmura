<?php

namespace Database\Factories;

use App\Models\Tahun;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tahun>
 */
class TahunFactory extends Factory
{
    protected $model = Tahun::class;

    public function definition(): array
    {
        return [
            'tahun' => fake()->unique()->numberBetween(2000, 2100),
            'status' => 'aktif',
        ];
    }

    public function nonaktif(): static
    {
        return $this->state(fn () => ['status' => 'nonaktif']);
    }

    public function aktif(): static
    {
        return $this->state(fn () => ['status' => 'aktif']);
    }
}
