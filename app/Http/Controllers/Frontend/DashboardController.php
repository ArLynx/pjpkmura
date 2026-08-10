<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
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

        $tahuns = Tahun::where('status', 'aktif')->orderBy('tahun')->get();

        $tahun = request('tahun_id');

        if (!$tahun) {
            $tahun = $tahuns->first()?->id;
        }

        $pilar = request()->filled('pilar') ? (int) request('pilar') : null;

        $mode = request('mode', 'tahunan');

        $tahunAwal = $tahuns->first()?->tahun;

        $tahunAkhir = $tahuns->last()?->tahun;

        $labelGabungan = "Gabungan {$tahunAwal}-{$tahunAkhir}";

        // Pilar yang dipilih
        $pilarDipilih = null;

        if ($pilar) {
            $pilarDipilih = Pilar::find($pilar);
        }

        /*
        |--------------------------------------------------------------------------
        | Card Dashboard
        |--------------------------------------------------------------------------
        */

        $jumlahPilar = Pilar::count();

        $jumlahIndikator = Indikator::when($pilar, function ($query) use ($pilar) {
            $query->where('pilar_id', $pilar);
        })->count();

        $jumlahTarget = Target::where('tahun_id', $tahun)
            ->when($pilar, function ($query) use ($pilar) {
                $query->whereHas('indikator', function ($q) use ($pilar) {
                    $q->where('pilar_id', $pilar);
                });
            })
            ->count();

        $jumlahTercapai = Realisasi::where('tahun_id', $tahun)
            ->where('status_pencapaian', 'tercapai')
            ->when($pilar, function ($query) use ($pilar) {
                $query->whereHas('indikator', function ($q) use ($pilar) {
                    $q->where('pilar_id', $pilar);
                });
            })
            ->count();

        /*
|--------------------------------------------------------------------------
| Data Monitoring
|--------------------------------------------------------------------------
*/

        $pilarsMonitoring = Pilar::with([
            'indikators' => function ($query) use ($mode, $tahun) {
                $query->orderBy('urutan')->with([
                    'targets' => function ($q) use ($mode, $tahun) {
                        if ($mode == 'tahunan') {
                            $q->where('tahun_id', $tahun);
                        } else {
                            $q->orderBy('tahun_id');
                        }
                    },

                    'realisasis' => function ($q) use ($mode, $tahun) {
                        if ($mode == 'tahunan') {
                            $q->where('tahun_id', $tahun);
                        } else {
                            $q->orderBy('tahun_id');
                        }

                        $q->with('dataPendukungs');
                    },
                ]);
            },
        ])

            ->when($pilar, function ($query) use ($pilar) {
                $query->where('id', $pilar);
            })

            ->orderBy('urutan')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | View
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
