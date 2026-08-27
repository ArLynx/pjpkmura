<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Pilar;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DataPendukung;
use App\Models\Realisasi;
use App\Models\Tahun;
use Illuminate\Support\Facades\Storage;

class CapaianController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Tahun
        |--------------------------------------------------------------------------
        */

        $tahuns = Tahun::where('status', 'aktif')->orderBy('tahun')->get();

        $tahun = $request->tahun_id;

        if (!$tahun) {
            $tahun = $tahuns->first()?->id;
        }

        /*
        |--------------------------------------------------------------------------
        | Pilar
        |--------------------------------------------------------------------------
        */

        $pilars = Pilar::orderBy('urutan')->get();

        $pilar = $request->pilar ?? $pilars->first()?->id;

        /*
        |--------------------------------------------------------------------------
        | Data Pilar Dipilih
        |--------------------------------------------------------------------------
        */

        $pilarAktif = Pilar::find($pilar);

        $indikators = collect();

        if ($pilarAktif) {
            $indikators = Indikator::where('pilar_id', $pilar)
            ->with([
                'targets' => function ($q) use ($tahun) {
                    $q->where('tahun_id', $tahun);
                },
                'realisasis' => function ($q) use ($tahun) {
                    $q->where('tahun_id', $tahun)
                        ->with('dataPendukungs');
                },
            ])
            ->orderBy('urutan')
            ->paginate(3)
            ->withQueryString();
        }

        /*
|--------------------------------------------------------------------------
| Statistik Tahun
|--------------------------------------------------------------------------
*/

        $statistikTahun = [];

        foreach ($tahuns as $item) {
            $jumlahTarget = Target::where('tahun_id', $item->id)->count();

            $jumlahRealisasi = Realisasi::where('tahun_id', $item->id)->count();

            $jumlahPendukung = DataPendukung::whereHas('realisasi', function ($q) use ($item) {
                $q->where('tahun_id', $item->id);
            })->count();

            $statistikTahun[$item->id] = [
                'target' => $jumlahTarget,

                'realisasi' => $jumlahRealisasi,

                'pendukung' => $jumlahPendukung,

                'boleh_hapus' => $jumlahTarget == 0 && $jumlahRealisasi == 0 && $jumlahPendukung == 0,
            ];
        }

        return view(
            'backend.capaian.index',
            compact(
                'pilars',
                'tahuns',
                'tahun',
                'pilar',

                'indikators',
                'pilarAktif',

                'statistikTahun',
            ),
        );
    }

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK TAHUN AKTIF
        |--------------------------------------------------------------------------
        */

        if (!Tahun::where('status', 'aktif')->exists()) {

            return back()->with(
                'error',
                'Penginputan capaian tidak dapat dilakukan karena belum ada tahun aktif. Silakan tambahkan tahun terlebih dahulu.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'tahun_id' => ['required', 'exists:tahuns,id'],
            'pilar' => ['required', 'exists:pilars,id'],

            'target' => ['nullable', 'array'],
            'target.*' => ['nullable', 'numeric'],

            'realisasi' => ['nullable', 'array'],
            'realisasi.*' => ['nullable', 'numeric'],

            'status' => ['nullable', 'array'],
            'status.*' => ['nullable', 'in:tercapai,belum_tercapai'],

            'rencana_aksi' => ['nullable', 'array'],
            'rencana_aksi.*' => ['nullable', 'string'],

            'hambatan' => ['nullable', 'array'],
            'hambatan.*' => ['nullable', 'string'],

            'evaluasi' => ['nullable', 'array'],
            'evaluasi.*' => ['nullable', 'string'],

            'pendukung' => ['nullable', 'array'],
            'pendukung.*' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,xls,xlsx',
                'max:5120',
            ],
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Gabungkan semua indikator yang memiliki input
            |--------------------------------------------------------------------------
            */

            $indikatorIds = collect()
                ->merge(array_keys($request->input('target', [])))
                ->merge(array_keys($request->input('realisasi', [])))
                ->merge(array_keys($request->input('status', [])))
                ->merge(array_keys($request->input('rencana_aksi', [])))
                ->merge(array_keys($request->input('hambatan', [])))
                ->merge(array_keys($request->input('evaluasi', [])))
                ->merge(array_keys($request->file('pendukung', [])))
                ->unique()
                ->values();


            /*
            |--------------------------------------------------------------------------
            | Proses setiap indikator
            |--------------------------------------------------------------------------
            */

            foreach ($indikatorIds as $indikatorId) {

                $indikator = Indikator::find($indikatorId);

                if (!$indikator) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Hak akses indikator
                |--------------------------------------------------------------------------
                */

                $isSuperadmin = auth()->user()->role === 'superadmin';

                $isAdminPenanggungJawab =
                    auth()->user()->role === 'admin' &&
                    auth()->user()->instansi_id !== null &&
                    (int) $indikator->instansi_id === (int) auth()->user()->instansi_id;

                $isPenanggungJawab =
                    $isSuperadmin || $isAdminPenanggungJawab;

                if (!$isPenanggungJawab) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Admin/OPD hanya boleh mengisi indikator tanggung jawabnya
                |--------------------------------------------------------------------------
                */

                if (!$isPenanggungJawab) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Ambil data input
                |--------------------------------------------------------------------------
                */

                $nilaiTarget = $request->input("target.$indikatorId");
                $nilaiRealisasi = $request->input("realisasi.$indikatorId");
                $status = $request->input("status.$indikatorId");

                $rencanaAksi = $request->input("rencana_aksi.$indikatorId");
                $hambatan = $request->input("hambatan.$indikatorId");


                /*
                |--------------------------------------------------------------------------
                | Evaluasi hanya boleh diisi Superadmin
                |--------------------------------------------------------------------------
                */

                $evaluasi = $isSuperadmin
                    ? $request->input("evaluasi.$indikatorId")
                    : null;


                /*
                |--------------------------------------------------------------------------
                | Cek apakah ada data
                |--------------------------------------------------------------------------
                */

                $adaTarget =
                    $nilaiTarget !== null &&
                    $nilaiTarget !== '';

                $adaRealisasi =
                    $nilaiRealisasi !== null &&
                    $nilaiRealisasi !== '';

                $adaRencanaAksi =
                    $rencanaAksi !== null &&
                    trim($rencanaAksi) !== '';

                $adaHambatan =
                    $hambatan !== null &&
                    trim($hambatan) !== '';

                $adaEvaluasi =
                    $evaluasi !== null &&
                    trim($evaluasi) !== '';

                $adaFile = $request->hasFile("pendukung.$indikatorId");


                /*
                |--------------------------------------------------------------------------
                | Kalau benar-benar tidak ada data
                |--------------------------------------------------------------------------
                */

                if (
                    !$adaTarget &&
                    !$adaRealisasi &&
                    !$adaRencanaAksi &&
                    !$adaHambatan &&
                    !$adaEvaluasi &&
                    !$adaFile
                ) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | TARGET
                |--------------------------------------------------------------------------
                */

                if ($adaTarget) {

                    Target::updateOrCreate(
                        [
                            'indikator_id' => $indikatorId,
                            'tahun_id' => $request->tahun_id,
                        ],
                        [
                            'nilai_target' => $nilaiTarget,
                            'created_by' => auth()->id(),
                        ]
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | REALISASI + NARASI + HAMBATAN + EVALUASI
                |--------------------------------------------------------------------------
                |
                | Semua informasi ini disimpan pada tabel realisasis.
                |
                */

                $realisasi = Realisasi::firstOrNew([
                    'indikator_id' => $indikatorId,
                    'tahun_id' => $request->tahun_id,
                ]);


                if ($adaRealisasi) {
                    $realisasi->nilai_realisasi = $nilaiRealisasi;
                }


                if ($status !== null) {
                    $realisasi->status_pencapaian = $status;
                }


                /*
                |--------------------------------------------------------------------------
                | Admin / OPD
                |--------------------------------------------------------------------------
                */

                if (!$isSuperadmin) {

                    if ($request->has('rencana_aksi')) {
                        $realisasi->rencana_aksi = $rencanaAksi;
                    }

                    if ($request->has('hambatan')) {
                        $realisasi->hambatan = $hambatan;
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Superadmin
                |--------------------------------------------------------------------------
                */

                if ($isSuperadmin) {

                    if ($request->has('evaluasi')) {
                        $realisasi->evaluasi = $evaluasi;
                    }
                }


                $realisasi->created_by ??= auth()->id();

                $realisasi->save();


                /*
                |--------------------------------------------------------------------------
                | DATA PENDUKUNG
                |--------------------------------------------------------------------------
                */

                if ($adaFile) {

                    $file = $request->file("pendukung.$indikatorId");

                    $namaFile = time() . '_' . $file->getClientOriginalName();

                    $path = $file->storeAs(
                        'data-pendukung',
                        $namaFile,
                        'public'
                    );


                    $pendukung = DataPendukung::where(
                        'realisasi_id',
                        $realisasi->id
                    )->first();


                    if ($pendukung) {

                        if (
                            $pendukung->file &&
                            Storage::disk('public')->exists($pendukung->file)
                        ) {
                            Storage::disk('public')->delete(
                                $pendukung->file
                            );
                        }


                        $pendukung->update([
                            'judul' => $file->getClientOriginalName(),
                            'file' => $path,
                        ]);

                    } else {

                        DataPendukung::create([
                            'realisasi_id' => $realisasi->id,
                            'judul' => $file->getClientOriginalName(),
                            'file' => $path,
                        ]);
                    }
                }
            }


            DB::commit();


            return redirect()
                ->route('admin.capaian.index', [
                    'tahun_id' => $request->tahun_id,
                    'pilar' => $request->pilar,
                ])
                ->with(
                    'success',
                    'Target, realisasi, rencana aksi, hambatan, evaluasi, dan data pendukung berhasil disimpan.'
                );


        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function destroyTahun($id)
    {
        $tahun = Tahun::findOrFail($id);

        $jumlahTarget = Target::where('tahun_id', $id)->count();

        $jumlahRealisasi = Realisasi::where('tahun_id', $id)->count();

        $jumlahPendukung = DataPendukung::whereHas('realisasi', function ($q) use ($id) {
            $q->where('tahun_id', $id);
        })->count();

        if ($jumlahTarget > 0 || $jumlahRealisasi > 0 || $jumlahPendukung > 0) {
            return back()->with('error', 'Tahun tidak dapat dihapus karena sudah memiliki data.');
        }

        $tahun->delete();

        return back()->with('success', 'Tahun berhasil dihapus.');
    }
}
