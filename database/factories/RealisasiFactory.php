<?php

namespace Database\Factories;

use App\Models\Indikator;
use App\Models\Realisasi;
use App\Models\Tahun;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Realisasi>
 */
class RealisasiFactory extends Factory
{
    protected $model = Realisasi::class;

    public function definition(): array
    {
        return [
            'indikator_id' => Indikator::factory(),
            'tahun_id' => Tahun::factory(),
            'nilai_realisasi' => fake()->numberBetween(0, 1000),
            'status_pencapaian' => fake()->randomElement(['tercapai', 'belum_tercapai']),
            'created_by' => User::factory(),
        ];
    }
}
