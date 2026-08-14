<?php

namespace App\Http\Controllers\Backend;

use App\Exports\CapaianExport;
use App\Http\Controllers\Controller;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CapaianLaporanController extends Controller
{
    /**
     * ============================================================
     * DATA LAPORAN
     * ============================================================
     *
     * Superadmin:
     * - melihat semua indikator
     *
     * Admin:
     * - hanya melihat indikator sesuai instansi_id user
     *
     * Data yang diambil:
     * - indikator
     * - pilar
     * - instansi
     * - target
     * - realisasi
     * - data pendukung
     */
    private function getDataLaporan(int $tahunId)
    {
        $user = auth()->user();

        $query = DB::table('indikators')

            /*
            |--------------------------------------------------------------------------
            | PILAR
            |--------------------------------------------------------------------------
            */
            ->join(
                'pilars',
                'pilars.id',
                '=',
                'indikators.pilar_id'
            )

            /*
            |--------------------------------------------------------------------------
            | TARGET
            |--------------------------------------------------------------------------
            */
            ->leftJoin('targets', function ($join) use ($tahunId) {

                $join->on(
                    'targets.indikator_id',
                    '=',
                    'indikators.id'
                );

                $join->where(
                    'targets.tahun_id',
                    '=',
                    $tahunId
                );
            })

            /*
            |--------------------------------------------------------------------------
            | REALISASI
            |--------------------------------------------------------------------------
            */
            ->leftJoin('realisasis', function ($join) use ($tahunId) {

                $join->on(
                    'realisasis.indikator_id',
                    '=',
                    'indikators.id'
                );

                $join->where(
                    'realisasis.tahun_id',
                    '=',
                    $tahunId
                );
            })

            /*
            |--------------------------------------------------------------------------
            | DATA PENDUKUNG
            |--------------------------------------------------------------------------
            */
            ->leftJoin('data_pendukungs', function ($join) {

                $join->on(
                    'data_pendukungs.realisasi_id',
                    '=',
                    'realisasis.id'
                );
            })

            /*
            |--------------------------------------------------------------------------
            | INSTANSI
            |--------------------------------------------------------------------------
            */
            ->leftJoin(
                'instansis',
                'instansis.id',
                '=',
                'indikators.instansi_id'
            )

            /*
            |--------------------------------------------------------------------------
            | SELECT DATA
            |--------------------------------------------------------------------------
            */
            ->select([

                /*
                |--------------------------------------------------------------------------
                | INDIKATOR
                |--------------------------------------------------------------------------
                */
                'indikators.id',

                'indikators.pilar_id',

                'indikators.tujuan_strategis',

                'indikators.nama_indikator',

                'indikators.instansi_id',

                'indikators.instansi_pendukung',

                'indikators.nilai_baseline',

                'indikators.tahun_baseline',

                'indikators.sumber_data',

                'indikators.urutan as indikator_urutan',

                /*
                |--------------------------------------------------------------------------
                | PILAR
                |--------------------------------------------------------------------------
                */
                'pilars.nama as nama_pilar',

                'pilars.urutan as pilar_urutan',

                /*
                |--------------------------------------------------------------------------
                | INSTANSI
                |--------------------------------------------------------------------------
                */
                'instansis.nama as nama_instansi',

                /*
                |--------------------------------------------------------------------------
                | TARGET
                |--------------------------------------------------------------------------
                */
                'targets.nilai_target',

                /*
                |--------------------------------------------------------------------------
                | REALISASI
                |--------------------------------------------------------------------------
                */
                'realisasis.nilai_realisasi',

                'realisasis.status_pencapaian',

                'realisasis.rencana_aksi',

                'realisasis.hambatan',

                'realisasis.evaluasi',

                /*
                |--------------------------------------------------------------------------
                | DATA PENDUKUNG
                |--------------------------------------------------------------------------
                */
                'data_pendukungs.judul as judul_pendukung',

                'data_pendukungs.file as file_pendukung',
            ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER ADMIN
        |--------------------------------------------------------------------------
        |
        | Superadmin melihat semua.
        |
        | Admin hanya melihat indikator yang mempunyai
        | instansi_id sama dengan instansi user.
        |
        */

        if ($user->role !== 'superadmin') {

            $query->where(
                'indikators.instansi_id',
                $user->instansi_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | URUTKAN
        |--------------------------------------------------------------------------
        */

        return $query

            ->orderBy(
                'pilars.urutan'
            )

            ->orderBy(
                'indikators.urutan'
            )

            ->get()

            /*
            |--------------------------------------------------------------------------
            | GROUP BERDASARKAN PILAR
            |--------------------------------------------------------------------------
            */

            ->groupBy(
                'pilar_id'
            );
    }


    /**
     * ============================================================
     * HALAMAN LAPORAN
     * ============================================================
     */
    public function index()
    {
        $tahuns = Tahun::orderByDesc('tahun')->get();

        return view(
            'backend.capaian.laporan',
            compact('tahuns')
        );
    }


    /**
     * ============================================================
     * PDF
     * ============================================================
     */
    public function pdf(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI TAHUN
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'tahun_id' => [
                'required',
                'exists:tahuns,id',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | TAHUN
        |--------------------------------------------------------------------------
        */

        $tahun = Tahun::findOrFail(
            $request->tahun_id
        );


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $data = $this->getDataLaporan(
            $tahun->id
        );


        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | INSTANSI ADMIN
        |--------------------------------------------------------------------------
        */

        $instansi = null;

        if ($user->instansi_id) {
            $instansi = DB::table('instansis')
                ->where('id', $user->instansi_id)
                ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | PDF
        |--------------------------------------------------------------------------
        */

        $pdf = app(
            'dompdf.wrapper'
        );


        $pdf->loadView(
            'backend.capaian.pdf',
            [
                'data' => $data,

                'tahun' => $tahun,

                'instansi' => $instansi,

                'user' => $user,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | UKURAN KERTAS
        |--------------------------------------------------------------------------
        */

        $pdf->setPaper(
            'a4',
            'landscape'
        );


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD / STREAM
        |--------------------------------------------------------------------------
        */

        return $pdf->stream(
            'Laporan-Capaian-' .
            $tahun->tahun .
            '.pdf'
        );
    }


        /**
     * ============================================================
     * EXCEL
     * ============================================================
     */
    public function excel(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'tahun_id' => [
                'required',
                'exists:tahuns,id',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | TAHUN
        |--------------------------------------------------------------------------
        */

        $tahun = Tahun::findOrFail(
            $request->tahun_id
        );

        /*
        |--------------------------------------------------------------------------
        | EXPORT EXCEL
        |--------------------------------------------------------------------------
        |
        | CapaianExport akan mengambil sendiri:
        |
        | - data indikator
        | - filter instansi berdasarkan user
        | - target
        | - realisasi
        | - status capaian
        | - rencana aksi
        | - hambatan
        | - evaluasi
        | - data pendukung
        | - instansi untuk tanda tangan
        |
        */

        return Excel::download(
            new CapaianExport($tahun->id),
            'Laporan-Capaian-' .
            $tahun->tahun .
            '.xlsx'
        );
    }
}