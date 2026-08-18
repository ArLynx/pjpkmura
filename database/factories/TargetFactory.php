<?php

namespace Database\Factories;

use App\Models\Indikator;
use App\Models\Tahun;
use App\Models\Target;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Target>
 */
class TargetFactory extends Factory
{
    protected $model = Target::class;

    public function definition(): array
    {
        return [
            'indikator_id' => Indikator::factory(),
            'tahun_id' => Tahun::factory(),
            'nilai_target' => fake()->numberBetween(0, 1000),
            'created_by' => User::factory(),
        ];
    }
}
