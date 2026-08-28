<?php

namespace App\Services;

/**
 * Data tren multi-tahun sebuah indikator.
 *
 * `tahun`, `target`, dan `realisasi` adalah larik paralel yang selaras:
 * elemen pada indeks yang sama merepresentasikan tahun dan nilainya.
 * Tahun tanpa data (tidak ada target maupun realisasi) tidak ikut serta,
 * sehingga seluruh larik memiliki panjang yang sama dan urutan naik.
 */
class DataTren
{
    /**
     * @param  array<int, int>  $tahun  Tahun terurut naik.
     * @param  array<int, float|string|null>  $target  Nilai target per tahun, selaras dengan $tahun.
     * @param  array<int, float|string|null>  $realisasi  Nilai realisasi per tahun, selaras dengan $tahun.
     * @param  array{nilai: string|null, tahun: int|null}|null  $baseline  Nilai dan tahun baseline indikator.
     */
    public function __construct(
        public readonly array $tahun,
        public readonly array $target,
        public readonly array $realisasi,
        public readonly ?array $baseline,
    ) {}

    public function kosong(): bool
    {
        return count($this->tahun) === 0;
    }

    /**
     * @return array{tahun: array<int, int>, target: array<int, float|string|null>, realisasi: array<int, float|string|null>, baseline: array{nilai: string|null, tahun: int|null}|null}
     */
    public function toArray(): array
    {
        return [
            'tahun' => $this->tahun,
            'target' => $this->target,
            'realisasi' => $this->realisasi,
            'baseline' => $this->baseline,
        ];
    }
}
