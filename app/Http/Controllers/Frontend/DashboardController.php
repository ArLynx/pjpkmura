<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Pilar;
use App\Models\Realisasi;
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

        $tahuns = Target::select('tahun')->distinct()->orderBy('tahun')->pluck('tahun');

        $tahun = request('tahun', $tahuns->first());

        $pilar = request()->filled('pilar') ? (int) request('pilar') : null;

        $mode = request('mode', 'tahunan');

        $tahunAwal = $tahuns->first();

        $tahunAkhir = $tahuns->last();

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

        $jumlahTarget = Target::where('tahun', $tahun)
            ->when($pilar, function ($query) use ($pilar) {
                $query->whereHas('indikator', function ($q) use ($pilar) {
                    $q->where('pilar_id', $pilar);
                });
            })
            ->count();

        $jumlahTercapai = Realisasi::where('tahun', $tahun)
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
                            $q->where('tahun', $tahun);
                        } else {
                            $q->orderBy('tahun');
                        }
                    },

                    'realisasis' => function ($q) use ($mode, $tahun) {
                        if ($mode == 'tahunan') {
                            $q->where('tahun', $tahun);
                        } else {
                            $q->orderBy('tahun');
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
