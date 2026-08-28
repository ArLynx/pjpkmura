<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Instansi;
use App\Models\Pilar;
use App\Models\Realisasi;
use App\Models\Tahun;
use App\Models\Target;
use App\Services\DataTrenBuilder;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        $pilars = Pilar::orderBy('urutan')->get();

        $tahuns = Tahun::where('status', 'aktif')
            ->orderBy('tahun')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Tahun
        |--------------------------------------------------------------------------
        */

        $tahun = request('tahun_id');

        if (!$tahun) {
            $tahun = $tahuns->first()?->id;
        }

        /*
        |--------------------------------------------------------------------------
        | Pilar
        |--------------------------------------------------------------------------
        */

        $pilar = request()->filled('pilar')
            ? (int) request('pilar')
            : null;

        /*
        |--------------------------------------------------------------------------
        | INSTANSI
        |--------------------------------------------------------------------------
        |
        | Indikator menggunakan:
        | indikators.instansi_id
        |
        */

        $instansiId = request()->filled('instansi_id')
            ? (int) request('instansi_id')
            : null;

        /*
        |--------------------------------------------------------------------------
        | Daftar Instansi
        |--------------------------------------------------------------------------
        */

        $instansis = Instansi::orderBy('nama')->get();

        /*
        |--------------------------------------------------------------------------
        | Mode
        |--------------------------------------------------------------------------
        */

        $mode = request('mode', 'tahunan');

        /*
        |--------------------------------------------------------------------------
        | Tahun Gabungan
        |--------------------------------------------------------------------------
        */

        $tahunAwal = $tahuns->first()?->tahun;

        $tahunAkhir = $tahuns->last()?->tahun;

        $labelGabungan = "Gabungan {$tahunAwal}-{$tahunAkhir}";

        /*
        |--------------------------------------------------------------------------
        | Pilar yang dipilih
        |--------------------------------------------------------------------------
        */

        $pilarDipilih = null;

        if ($pilar) {
            $pilarDipilih = Pilar::find($pilar);
        }

        /*
        |--------------------------------------------------------------------------
        | Instansi yang dipilih
        |--------------------------------------------------------------------------
        */

        $instansiDipilih = null;

        if ($instansiId) {
            $instansiDipilih = Instansi::find($instansiId);
        }

        /*
        |--------------------------------------------------------------------------
        | Card Dashboard
        |--------------------------------------------------------------------------
        */

        $jumlahPilar = Pilar::count();

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN 5 PILAR
        |--------------------------------------------------------------------------
        */

        $ringkasanPilar = Pilar::orderBy('urutan')
            ->get()
            ->map(function ($pilar) use ($tahun) {
                $totalIndikator = $pilar->indikators()->count();

                $totalTarget = Target::where('tahun_id', $tahun)
                    ->whereHas('indikator', function ($q) use ($pilar) {
                        $q->where('pilar_id', $pilar->id);
                    })
                    ->count();

                $tercapai = Realisasi::where('tahun_id', $tahun)
                    ->where('status_pencapaian', 'tercapai')
                    ->whereHas('indikator', function ($q) use ($pilar) {
                        $q->where('pilar_id', $pilar->id);
                    })
                    ->count();

                $persentase = $totalTarget > 0
                    ? round(($tercapai / $totalTarget) * 100, 1)
                    : 0;

                return [
                    'urutan' => $pilar->urutan,
                    'nama' => $pilar->nama,
                    'jumlah_indikator' => $totalIndikator,
                    'persentase' => $persentase,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | TOTAL INDIKATOR
        |--------------------------------------------------------------------------
        */

        $jumlahIndikator = Indikator::query()

            ->when($pilar, function ($query) use ($pilar) {
                $query->where('pilar_id', $pilar);
            })

            ->when($instansiId, function ($query) use ($instansiId) {
                $query->where('instansi_id', $instansiId);
            })

            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL TARGET
        |--------------------------------------------------------------------------
        */

        $jumlahTarget = Target::query()
            ->where('tahun_id', $tahun)

            ->when($pilar, function ($query) use ($pilar) {
                $query->whereHas('indikator', function ($q) use ($pilar) {
                    $q->where('pilar_id', $pilar);
                });
            })

            ->when($instansiId, function ($query) use ($instansiId) {
                $query->whereHas('indikator', function ($q) use ($instansiId) {
                    $q->where('instansi_id', $instansiId);
                });
            })

            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL TERCAPAI
        |--------------------------------------------------------------------------
        */

        $jumlahTercapai = Realisasi::query()
            ->where('tahun_id', $tahun)
            ->where('status_pencapaian', 'tercapai')

            ->when($pilar, function ($query) use ($pilar) {
                $query->whereHas('indikator', function ($q) use ($pilar) {
                    $q->where('pilar_id', $pilar);
                });
            })

            ->when($instansiId, function ($query) use ($instansiId) {
                $query->whereHas('indikator', function ($q) use ($instansiId) {
                    $q->where('instansi_id', $instansiId);
                });
            })

            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL BELUM TERCAPAI
        |--------------------------------------------------------------------------
        */

        $jumlahBelumTercapai = Realisasi::query()
            ->where('tahun_id', $tahun)
            ->where('status_pencapaian', 'belum_tercapai')

            ->when($pilar, function ($query) use ($pilar) {
                $query->whereHas('indikator', function ($q) use ($pilar) {
                    $q->where('pilar_id', $pilar);
                });
            })

            ->when($instansiId, function ($query) use ($instansiId) {
                $query->whereHas('indikator', function ($q) use ($instansiId) {
                    $q->where('instansi_id', $instansiId);
                });
            })

            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL VERIFIKASI (status_pencapaian = verifikasi)
        |--------------------------------------------------------------------------
        */

        $jumlahVerifikasi = Realisasi::query()
            ->where('tahun_id', $tahun)
            ->where('status_pencapaian', 'verifikasi')

            ->when($pilar, function ($query) use ($pilar) {
                $query->whereHas('indikator', function ($q) use ($pilar) {
                    $q->where('pilar_id', $pilar);
                });
            })

            ->when($instansiId, function ($query) use ($instansiId) {
                $query->whereHas('indikator', function ($q) use ($instansiId) {
                    $q->where('instansi_id', $instansiId);
                });
            })

            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL BELUM ISI (target ada tapi realisasi kosong)
        |--------------------------------------------------------------------------
        */

        $jumlahBelumIsi = Target::query()
            ->where('tahun_id', $tahun)
            ->whereDoesntHave('indikator.realisasis', function ($q) use ($tahun) {
                $q->where('tahun_id', $tahun);
            })

            ->when($pilar, function ($query) use ($pilar) {
                $query->whereHas('indikator', function ($q) use ($pilar) {
                    $q->where('pilar_id', $pilar);
                });
            })

            ->when($instansiId, function ($query) use ($instansiId) {
                $query->whereHas('indikator', function ($q) use ($instansiId) {
                    $q->where('instansi_id', $instansiId);
                });
            })

            ->count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL TARGET TAHUN INI (untuk denominador persentase)
        |--------------------------------------------------------------------------
        */

        $totalTargetTahunIni = Target::query()
            ->where('tahun_id', $tahun)

            ->when($pilar, function ($query) use ($pilar) {
                $query->whereHas('indikator', function ($q) use ($pilar) {
                    $q->where('pilar_id', $pilar);
                });
            })

            ->when($instansiId, function ($query) use ($instansiId) {
                $query->whereHas('indikator', function ($q) use ($instansiId) {
                    $q->where('instansi_id', $instansiId);
                });
            })

            ->count();

        $persentaseProgres = $totalTargetTahunIni > 0
            ? round(($jumlahTercapai / $totalTargetTahunIni) * 100, 1)
            : 0;

            /*
        |--------------------------------------------------------------------------
        | DATA MONITORING
        |--------------------------------------------------------------------------
        */

        $pilarsMonitoring = Pilar::with([
            'indikators' => function ($query) use (
                $mode,
                $tahun,
                $instansiId
            ) {

                /*
                |--------------------------------------------------------------------------
                | FILTER INSTANSI
                |--------------------------------------------------------------------------
                */

                $query->when($instansiId, function ($q) use ($instansiId) {
                    $q->where('instansi_id', $instansiId);
                });

                /*
                |--------------------------------------------------------------------------
                | URUTAN INDIKATOR
                |--------------------------------------------------------------------------
                */

                $query->orderBy('urutan');

                /*
                |--------------------------------------------------------------------------
                | TARGET DAN REALISASI
                |--------------------------------------------------------------------------
                */

                $query->with([

                    /*
                    |--------------------------------------------------------------------------
                    | TARGET
                    |--------------------------------------------------------------------------
                    */

                    'targets' => function ($q) use ($mode, $tahun) {

                        if ($mode === 'tahunan') {

                            $q->where('tahun_id', $tahun);

                        } else {

                            $q->orderBy('tahun_id');

                        }
                    },

                    /*
                    |--------------------------------------------------------------------------
                    | REALISASI
                    |--------------------------------------------------------------------------
                    */

                    'realisasis' => function ($q) use ($mode, $tahun) {

                        if ($mode === 'tahunan') {

                            $q->where('tahun_id', $tahun);

                        } else {

                            $q->orderBy('tahun_id');

                        }

                        /*
                        |--------------------------------------------------------------------------
                        | DATA PENDUKUNG
                        |--------------------------------------------------------------------------
                        */

                        $q->with('dataPendukungs');
                    },

                ]);
            },
        ])

        /*
        |--------------------------------------------------------------------------
        | HANYA TAMPILKAN PILAR YANG PUNYA INDIKATOR
        |--------------------------------------------------------------------------
        */

        ->when($instansiId, function ($query) use ($instansiId) {

            $query->whereHas('indikators', function ($q) use ($instansiId) {
                $q->where('instansi_id', $instansiId);
            });

        })

        /*
        |--------------------------------------------------------------------------
        | FILTER PILAR
        |--------------------------------------------------------------------------
        */

        ->when($pilar, function ($query) use ($pilar) {

            $query->where('id', $pilar);

        })

        ->orderBy('urutan')

        ->get();

        /*
        |--------------------------------------------------------------------------
        | BLOK TREN INDIKATOR
        |--------------------------------------------------------------------------
        */

        $pilarTren = request()->filled('pilar_tren')
            ? (int) request('pilar_tren')
            : null;

        $indikatorTren = request()->filled('indikator_tren')
            ? (int) request('indikator_tren')
            : null;

        $indikatorsTren = collect();

        if ($pilarTren) {
            $indikatorsTren = Indikator::where('pilar_id', $pilarTren)
                ->orderBy('urutan')
                ->get();
        }

        $indikatorDipilih = null;

        $dataTren = null;

        if ($indikatorTren) {
            $indikatorDipilih = Indikator::find($indikatorTren);

            if ($indikatorDipilih) {
                $dataTren = app(DataTrenBuilder::class)->build(
                    $indikatorDipilih,
                    DataTrenBuilder::SCOPE_AKTIF,
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN INDIKATOR
        |--------------------------------------------------------------------------
        */

        $ringkasanIndikator = Indikator::with(['pilar', 'targets', 'realisasis'])
            ->when($pilar, function ($query) use ($pilar) {
                $query->where('pilar_id', $pilar);
            })
            ->when($instansiId, function ($query) use ($instansiId) {
                $query->where('instansi_id', $instansiId);
            })
            ->orderBy('pilar_id')
            ->orderBy('urutan')
            ->paginate(5)
            ->through(function ($indikator) use ($tahun) {
                $target = $indikator->targets->firstWhere('tahun_id', $tahun);
                $realisasi = $indikator->realisasis->firstWhere('tahun_id', $tahun);

                return [
                    'nama' => $indikator->nama_indikator,
                    'pilar' => $indikator->pilar->nama ?? '-',
                    'pilar_urutan' => $indikator->pilar->urutan ?? 0,
                    'target' => $target?->nilai_target ?? '-',
                    'realisasi' => $realisasi?->nilai_realisasi ?? '-',
                    'status' => $realisasi?->status_pencapaian ?? null,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.dashboard',
            compact(
                'pilars',
                'tahuns',

                'tahun',
                'pilar',
                'pilarDipilih',

                'instansiId',
                'instansis',
                'instansiDipilih',

                'mode',

                'tahunAwal',
                'tahunAkhir',

                'labelGabungan',

                'jumlahPilar',
                'jumlahIndikator',
                'jumlahTarget',
                'jumlahTercapai',
                'jumlahBelumTercapai',
                'jumlahVerifikasi',
                'jumlahBelumIsi',
                'persentaseProgres',

                'pilarsMonitoring',

                'pilarTren',
                'indikatorTren',
                'indikatorsTren',
                'indikatorDipilih',
                'dataTren',

                'ringkasanIndikator',
                'ringkasanPilar',
            ),
        );
    }

    /**
     * Data JSON untuk blok Tren Indikator (dimuat via AJAX agar tidak
     * me-refresh halaman dan menggeser posisi scroll).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function trenData()
    {
        $pilarTren = request()->filled('pilar_tren')
            ? (int) request('pilar_tren')
            : null;

        $indikatorTren = request()->filled('indikator_tren')
            ? (int) request('indikator_tren')
            : null;

        $indikators = collect();

        if ($pilarTren) {
            $indikators = Indikator::where('pilar_id', $pilarTren)
                ->orderBy('urutan')
                ->get()
                ->map(fn (Indikator $indikator) => [
                    'id' => $indikator->id,
                    'nama_indikator' => $indikator->nama_indikator,
                ]);
        }

        $dataTren = null;

        $indikatorDipilih = null;

        if ($indikatorTren) {
            $indikatorDipilih = Indikator::find($indikatorTren);

            if ($indikatorDipilih) {
                $dataTren = app(DataTrenBuilder::class)->build(
                    $indikatorDipilih,
                    DataTrenBuilder::SCOPE_AKTIF,
                );
            }
        }

        return response()->json([
            'pilar_tren' => $pilarTren,
            'indikator_tren' => $indikatorTren,
            'indikators' => $indikators,
            'indikator' => $indikatorDipilih ? [
                'nama_indikator' => $indikatorDipilih->nama_indikator,
                'tujuan_strategis' => $indikatorDipilih->tujuan_strategis,
            ] : null,
            'data_tren' => $dataTren && ! $dataTren->kosong()
                ? $dataTren->toArray()
                : null,
        ]);
    }
}