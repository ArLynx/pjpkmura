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
                        $q->where('tahun_id', $tahun)->with('dataPendukungs');
                    },
                ])
                ->orderBy('urutan')
                ->get();
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
        $request->validate([
            'target.*' => 'nullable|numeric',
            'realisasi.*' => 'nullable|numeric',
            'pendukung.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,xls,xlsx|max:5120',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->target ?? [] as $indikatorId => $nilaiTarget) {
                $nilaiRealisasi = $request->realisasi[$indikatorId] ?? null;

                $adaTarget = $nilaiTarget !== null && $nilaiTarget !== '';

                $adaRealisasi = $nilaiRealisasi !== null && $nilaiRealisasi !== '';

                $adaFile = $request->hasFile("pendukung.$indikatorId");

                /*
            |--------------------------------------------------------------------------
            | Tidak ada data sama sekali
            |--------------------------------------------------------------------------
            */

                if (!$adaTarget && !$adaRealisasi && !$adaFile) {
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
                        ],
                    );
                }

                /*
            |--------------------------------------------------------------------------
            | REALISASI
            |--------------------------------------------------------------------------
            */

                $realisasi = null;

                if ($adaRealisasi) {
                    $status = $request->status[$indikatorId] ?? null;

                    $realisasi = Realisasi::updateOrCreate(
                        [
                            'indikator_id' => $indikatorId,
                            'tahun_id' => $request->tahun_id,
                        ],
                        [
                            'nilai_realisasi' => $nilaiRealisasi,
                            'status_pencapaian' => $status,
                            'created_by' => auth()->id(),
                        ],
                    );
                }

                /*
            |--------------------------------------------------------------------------
            | DATA PENDUKUNG
            |--------------------------------------------------------------------------
            */

                if ($adaFile && $realisasi) {
                    $file = $request->file("pendukung.$indikatorId");

                    $namaFile = time() . '_' . $file->getClientOriginalName();

                    $path = $file->storeAs('data-pendukung', $namaFile, 'public');

                    $pendukung = DataPendukung::where('realisasi_id', $realisasi->id)->first();

                    if ($pendukung) {
                        if ($pendukung->file && Storage::disk('public')->exists($pendukung->file)) {
                            Storage::disk('public')->delete($pendukung->file);
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
                ->with('success', 'Target, realisasi, dan data pendukung berhasil disimpan.');
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
