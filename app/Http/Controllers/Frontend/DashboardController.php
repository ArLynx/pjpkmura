<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Instansi;
use App\Models\Pilar;
use App\Models\Realisasi;
use App\Models\Tahun;
use App\Models\Target;

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

                'pilarsMonitoring',
            ),
        );
    }
}