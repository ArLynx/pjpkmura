<?php

namespace App\Services;

use App\Models\Indikator;
use App\Models\Tahun;

/**
 * Membangun data tren multi-tahun sebuah indikator.
 *
 * Mekanisme bersama yang dipakai dashboard publik (hanya tahun aktif) dan
 * halaman admin Analisis (semua tahun), agar perilaku pengurutan tahun,
 * pelewatan data kosong, dan penyertaan baseline konsisten di kedua tempat.
 */
class DataTrenBuilder
{
    public const SCOPE_AKTIF = 'aktif';

    public const SCOPE_SEMUA = 'semua';

    /**
     * Bangun data tren untuk sebuah indikator dengan cakupan tahun tertentu.
     *
     * @param  Indikator  $indikator  Indikator sumber data.
     * @param  string  $scope  self::SCOPE_AKTIF hanya tahun berstatus aktif,
     *                         self::SCOPE_SEMUA seluruh tahun.
     */
    public function build(Indikator $indikator, string $scope = self::SCOPE_AKTIF): DataTren
    {
        $tahunIdsAktif = $this->tahunDalamScope($scope);

        /*
        |--------------------------------------------------------------------------
        | Kumpulkan nilai target dan realisasi per tahun
        |--------------------------------------------------------------------------
        */

        $data = [];

        foreach ($indikator->targets as $target) {
            $tahunId = $target->tahun_id;

            if (! isset($tahunIdsAktif[$tahunId]) || $target->nilai_target === null) {
                continue;
            }

            $data[$tahunId]['target'] = (float) $target->nilai_target;
        }

        foreach ($indikator->realisasis as $realisasi) {
            $tahunId = $realisasi->tahun_id;

            if (! isset($tahunIdsAktif[$tahunId]) || $realisasi->nilai_realisasi === null) {
                continue;
            }

            $data[$tahunId]['realisasi'] = (float) $realisasi->nilai_realisasi;
        }

        /*
        |--------------------------------------------------------------------------
        | Buang tahun yang tidak punya target maupun realisasi
        |--------------------------------------------------------------------------
        */

        $data = array_filter($data, fn (array $nilai) => isset($nilai['target']) || isset($nilai['realisasi'])
        );

        /*
        |--------------------------------------------------------------------------
        | Urutkan tahun naik, bangun larik paralel
        |--------------------------------------------------------------------------
        */

        ksort($data, SORT_NUMERIC);

        $tahun = [];
        $target = [];
        $realisasi = [];

        foreach ($data as $tahunId => $nilai) {
            $tahun[] = $tahunIdsAktif[$tahunId];
            $target[] = $nilai['target'] ?? null;
            $realisasi[] = $nilai['realisasi'] ?? null;
        }

        /*
        |--------------------------------------------------------------------------
        | Baseline
        |--------------------------------------------------------------------------
        */

        $baseline = null;

        if ($indikator->nilai_baseline !== null && $indikator->nilai_baseline !== '') {
            $baseline = [
                'nilai' => $indikator->nilai_baseline,
                'tahun' => $indikator->tahun_baseline !== null ? (int) $indikator->tahun_baseline : null,
            ];
        }

        return new DataTren($tahun, $target, $realisasi, $baseline);
    }

    /**
     * Peta tahun_id => nilai tahun untuk cakupan yang dipilih.
     *
     * @return array<int, int>
     */
    private function tahunDalamScope(string $scope): array
    {
        $query = Tahun::query();

        if ($scope === self::SCOPE_AKTIF) {
            $query->where('status', 'aktif');
        }

        return $query
            ->orderBy('tahun')
            ->pluck('tahun', 'id')
            ->all();
    }
}
