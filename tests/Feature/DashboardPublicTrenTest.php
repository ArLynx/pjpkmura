<?php

namespace Tests\Feature;

use App\Models\Indikator;
use App\Models\Pilar;
use App\Models\Realisasi;
use App\Models\Tahun;
use App\Models\Target;
use App\Services\DataTren;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardPublicTrenTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_publik_memuat_blok_tren_indikator(): void
    {
        $pilar = Pilar::factory()->create(['urutan' => 1]);
        $indikator = Indikator::factory()->create(['pilar_id' => $pilar->id]);

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Tren Indikator')
            ->assertSee('Pilih Pilar');
    }

    public function test_dashboard_publik_memuat_data_tren_dengan_hanya_tahun_aktif(): void
    {
        $pilar = Pilar::factory()->create(['urutan' => 1]);
        $indikator = Indikator::factory()->create(['pilar_id' => $pilar->id]);

        $tahunAktif = Tahun::factory()->create(['tahun' => 2020, 'status' => 'aktif']);
        $tahunNonaktif = Tahun::factory()->create(['tahun' => 2021, 'status' => 'nonaktif']);

        Target::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahunAktif->id,
            'nilai_target' => 10,
        ]);
        Target::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahunNonaktif->id,
            'nilai_target' => 20,
        ]);

        $response = $this->get(route('dashboard', [
            'pilar_tren' => $pilar->id,
            'indikator_tren' => $indikator->id,
        ]))
            ->assertOk();

        $response->assertViewHas('indikatorDipilih', fn ($value) => $value?->id === $indikator->id);

        /** @var DataTren $dataTren */
        $dataTren = $response->viewData('dataTren');

        $this->assertInstanceOf(DataTren::class, $dataTren);
        $this->assertSame([2020], $dataTren->tahun);
        $this->assertSame([10.0], $dataTren->target);
    }

    public function test_dashboard_publik_memuat_data_tren_dengan_baseline(): void
    {
        $pilar = Pilar::factory()->create(['urutan' => 1]);
        $indikator = Indikator::factory()->baseline('75', 2018)->create(['pilar_id' => $pilar->id]);

        $tahunAktif = Tahun::factory()->create(['tahun' => 2020, 'status' => 'aktif']);

        Target::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahunAktif->id,
            'nilai_target' => 80,
        ]);

        $response = $this->get(route('dashboard', [
            'pilar_tren' => $pilar->id,
            'indikator_tren' => $indikator->id,
        ]))
            ->assertOk();

        /** @var DataTren $dataTren */
        $dataTren = $response->viewData('dataTren');

        $this->assertSame(['nilai' => '75', 'tahun' => 2018], $dataTren->baseline);
    }

    public function test_dashboard_publik_menampilkan_indikator_hanya_untuk_pilar_terpilih(): void
    {
        $pilarSatu = Pilar::factory()->create(['urutan' => 1]);
        $pilarDua = Pilar::factory()->create(['urutan' => 2]);
        $indikatorSatu = Indikator::factory()->create(['pilar_id' => $pilarSatu->id]);

        Indikator::factory()->create(['pilar_id' => $pilarDua->id]);

        $response = $this->get(route('dashboard', ['pilar_tren' => $pilarSatu->id]))
            ->assertOk();

        $indikatorsTren = $response->viewData('indikatorsTren');

        $this->assertCount(1, $indikatorsTren);
        $this->assertSame($indikatorSatu->id, $indikatorsTren->first()->id);
    }

    public function test_tren_data_mengembalikan_indikator_per_pilar(): void
    {
        $pilarSatu = Pilar::factory()->create(['urutan' => 1]);
        $pilarDua = Pilar::factory()->create(['urutan' => 2]);
        $indikatorSatu = Indikator::factory()->create(['pilar_id' => $pilarSatu->id]);

        Indikator::factory()->create(['pilar_id' => $pilarDua->id]);

        $response = $this->getJson(route('dashboard.trenData', ['pilar_tren' => $pilarSatu->id]))
            ->assertOk()
            ->assertJsonPath('indikators.0.id', $indikatorSatu->id);

        $this->assertCount(1, $response->json('indikators'));
    }

    public function test_tren_data_mengembalikan_data_tren_dan_indikator_terpilih(): void
    {
        $pilar = Pilar::factory()->create(['urutan' => 1]);
        $indikator = Indikator::factory()->create(['pilar_id' => $pilar->id]);

        $tahunAktif = Tahun::factory()->create(['tahun' => 2020, 'status' => 'aktif']);

        Target::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahunAktif->id,
            'nilai_target' => 15,
        ]);

        $this->getJson(route('dashboard.trenData', [
            'pilar_tren' => $pilar->id,
            'indikator_tren' => $indikator->id,
        ]))
            ->assertOk()
            ->assertJsonPath('indikator.nama_indikator', $indikator->nama_indikator)
            ->assertJsonPath('data_tren.tahun.0', 2020)
            ->assertJsonPath('data_tren.target.0', 15);
    }
}
