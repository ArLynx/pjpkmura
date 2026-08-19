<?php

namespace Tests\Feature;

use App\Models\Indikator;
use App\Models\Pilar;
use App\Models\Realisasi;
use App\Models\Target;
use App\Models\Tahun;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalisisTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_open_analysis_with_selected_trend_data(): void
    {
        [$pilar, $indikator, $tahunAktif, $tahunNonaktif] = $this->createTrendData();
        $user = User::factory()->superadmin()->create();

        $response = $this->actingAs($user)->get(route('admin.analisis.index', [
            'pilar' => $pilar->id,
            'indikator' => $indikator->id,
        ]));

        $response->assertOk()
            ->assertViewHas('indikator', fn ($selected) => $selected->is($indikator))
            ->assertViewHas('tren', fn ($tren) => $tren['tahun'] === [$tahunAktif->tahun, $tahunNonaktif->tahun]);
    }

    public function test_admin_opd_can_open_analysis(): void
    {
        [$pilar, $indikator] = $this->createTrendData();
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->get(route('admin.analisis.index', ['pilar' => $pilar->id, 'indikator' => $indikator->id]))
            ->assertOk();
    }

    private function createTrendData(): array
    {
        $pilar = Pilar::factory()->create();
        $indikator = Indikator::factory()->for($pilar)->baseline('10', 2019)->create();
        $tahunAktif = Tahun::factory()->create(['tahun' => 2022, 'status' => 'aktif']);
        $tahunKosong = Tahun::factory()->create(['tahun' => 2021, 'status' => 'aktif']);
        $tahunNonaktif = Tahun::factory()->create(['tahun' => 2023, 'status' => 'nonaktif']);

        Target::factory()->for($indikator)->for($tahunAktif)->create(['nilai_target' => 20]);
        Realisasi::factory()->for($indikator)->for($tahunAktif)->create(['nilai_realisasi' => 18, 'status_pencapaian' => 'tercapai']);
        Target::factory()->for($indikator)->for($tahunNonaktif)->create(['nilai_target' => 25]);

        return [$pilar, $indikator, $tahunAktif, $tahunNonaktif, $tahunKosong];
    }
}
