<?php

namespace Tests\Unit;

use App\Models\Indikator;
use App\Models\Realisasi;
use App\Models\Tahun;
use App\Models\Target;
use App\Services\DataTren;
use App\Services\DataTrenBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataTrenBuilderTest extends TestCase
{
    use RefreshDatabase;

    private DataTrenBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = app(DataTrenBuilder::class);
    }

    private function indikator(): Indikator
    {
        return Indikator::factory()->create();
    }

    public function test_menghasilkan_daftar_tahun_terurut_naik_dengan_target_dan_realisasi_yang_selaras(): void
    {
        $indikator = $this->indikator();

        $tahun2020 = Tahun::factory()->create(['tahun' => 2020]);
        $tahun2021 = Tahun::factory()->create(['tahun' => 2021]);
        $tahun2022 = Tahun::factory()->create(['tahun' => 2022]);

        Target::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahun2022->id,
            'nilai_target' => 30,
        ]);
        Target::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahun2020->id,
            'nilai_target' => 10,
        ]);
        Realisasi::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahun2021->id,
            'nilai_realisasi' => 50,
        ]);

        $data = $this->builder->build($indikator, DataTrenBuilder::SCOPE_SEMUA);

        $this->assertInstanceOf(DataTren::class, $data);
        $this->assertSame([2020, 2021, 2022], $data->tahun);
        $this->assertSame([10.0, null, 30.0], $data->target);
        $this->assertSame([null, 50.0, null], $data->realisasi);
        $this->assertFalse($data->kosong());
    }

    public function test_tahun_tanpa_target_dan_realisasi_dilewati_tidak_diinterpolasi(): void
    {
        $indikator = $this->indikator();

        $tahun2019 = Tahun::factory()->create(['tahun' => 2019]);
        $tahun2020 = Tahun::factory()->create(['tahun' => 2020]);
        $tahun2021 = Tahun::factory()->create(['tahun' => 2021]);

        // Tahun 2020 tidak memiliki target maupun realisasi.
        Target::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahun2019->id,
            'nilai_target' => 10,
        ]);
        Realisasi::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahun2021->id,
            'nilai_realisasi' => 20,
        ]);

        $data = $this->builder->build($indikator, DataTrenBuilder::SCOPE_SEMUA);

        $this->assertSame([2019, 2021], $data->tahun);
        $this->assertSame([10.0, null], $data->target);
        $this->assertSame([null, 20.0], $data->realisasi);
    }

    public function test_tahun_dengan_nilai_null_dianggap_tidak_ada_data(): void
    {
        $indikator = $this->indikator();

        $tahun2020 = Tahun::factory()->create(['tahun' => 2020]);
        $tahun2021 = Tahun::factory()->create(['tahun' => 2021]);

        Target::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahun2020->id,
            'nilai_target' => 15,
        ]);
        // Baris target ada tetapi nilainya null.
        Target::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahun2021->id,
            'nilai_target' => null,
        ]);

        $data = $this->builder->build($indikator, DataTrenBuilder::SCOPE_SEMUA);

        $this->assertSame([2020], $data->tahun);
    }

    public function test_baseline_ikut_disertakan_sesuai_indikator(): void
    {
        $indikator = Indikator::factory()->baseline('75', 2018)->create();

        $tahun2020 = Tahun::factory()->create(['tahun' => 2020]);
        Target::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahun2020->id,
            'nilai_target' => 80,
        ]);

        $data = $this->builder->build($indikator, DataTrenBuilder::SCOPE_SEMUA);

        $this->assertSame(['nilai' => '75', 'tahun' => 2018], $data->baseline);
    }

    public function test_baseline_null_ketika_indikator_tidak_memiliki_nilai_baseline(): void
    {
        $indikator = $this->indikator();

        $tahun2020 = Tahun::factory()->create(['tahun' => 2020]);
        Target::factory()->create([
            'indikator_id' => $indikator->id,
            'tahun_id' => $tahun2020->id,
            'nilai_target' => 80,
        ]);

        $data = $this->builder->build($indikator, DataTrenBuilder::SCOPE_SEMUA);

        $this->assertNull($data->baseline);
    }

    public function test_scope_aktif_hanya_menghasilkan_tahun_berstatus_aktif(): void
    {
        $indikator = $this->indikator();

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

        $dataAktif = $this->builder->build($indikator, DataTrenBuilder::SCOPE_AKTIF);

        $this->assertSame([2020], $dataAktif->tahun);
        $this->assertSame([10.0], $dataAktif->target);
    }

    public function test_scope_semua_menghasilkan_seluruh_tahun_termasuk_nonaktif(): void
    {
        $indikator = $this->indikator();

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

        $dataSemua = $this->builder->build($indikator, DataTrenBuilder::SCOPE_SEMUA);

        $this->assertSame([2020, 2021], $dataSemua->tahun);
        $this->assertSame([10.0, 20.0], $dataSemua->target);
    }

    public function test_kosong_ketika_tidak_ada_data(): void
    {
        $indikator = $this->indikator();

        Tahun::factory()->create(['tahun' => 2020]);

        $data = $this->builder->build($indikator, DataTrenBuilder::SCOPE_SEMUA);

        $this->assertTrue($data->kosong());
        $this->assertSame([], $data->tahun);
        $this->assertSame([], $data->target);
        $this->assertSame([], $data->realisasi);
    }
}
