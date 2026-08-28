<?php

namespace Database\Factories;

use App\Models\Indikator;
use App\Models\Pilar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Indikator>
 */
class IndikatorFactory extends Factory
{
    protected $model = Indikator::class;

    public function definition(): array
    {
        return [
            'pilar_id' => Pilar::factory(),
            'tujuan_strategis' => fake()->sentence(4),
            'nama_indikator' => fake()->unique()->sentence(3),
            'instansi_id' => null,
            'nilai_baseline' => null,
            'tahun_baseline' => null,
            'satuan' => fake()->randomElement(['%', 'orang', 'unit', 'kali']),
            'sumber_data' => fake()->sentence(3),
            'urutan' => fake()->unique()->numberBetween(1, 100),
        ];
    }

    public function baseline(string $nilai, int $tahun): static
    {
        return $this->state(fn () => [
            'nilai_baseline' => $nilai,
            'tahun_baseline' => $tahun,
        ]);
    }
}
