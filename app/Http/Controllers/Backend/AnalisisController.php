<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Pilar;
use App\Models\Tahun;
use App\Services\DataTrenBuilder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalisisController extends Controller
{
    public function index(Request $request, DataTrenBuilder $builder): View
    {
        $pilars = Pilar::with(['indikators' => fn ($query) => $query->orderBy('urutan')])
            ->orderBy('urutan')
            ->get();

        $pilarId = $request->integer('pilar') ?: $pilars->first()?->id;
        $pilar = $pilars->firstWhere('id', $pilarId);
        $indikatorId = $request->integer('indikator');

        $indikator = $pilar?->indikators->firstWhere('id', $indikatorId);

        if (! $indikator) {
            $indikator = $pilar?->indikators->first();
        }

        $tren = $indikator
            ? $builder->build($indikator, DataTrenBuilder::SCOPE_SEMUA)
            : null;

        $tahunByValue = Tahun::query()->pluck('id', 'tahun');
        $statusByYear = [];

        if ($indikator && $tren) {
            $statusByYear = $indikator->realisasis()
                ->whereIn('tahun_id', collect($tren->tahun)->map(fn ($tahun) => $tahunByValue[$tahun] ?? null)->filter())
                ->get()
                ->mapWithKeys(fn ($realisasi) => [$realisasi->tahun_id => $realisasi->status_pencapaian])
                ->all();
        }

        $detail = collect($tren?->tahun ?? [])->values()->map(function (int $tahun, int $index) use ($tren, $statusByYear, $tahunByValue) {
            return [
                'tahun' => $tahun,
                'target' => $tren->target[$index] ?? null,
                'realisasi' => $tren->realisasi[$index] ?? null,
                'status' => $statusByYear[$tahunByValue[$tahun] ?? 0] ?? null,
            ];
        });

        return view('backend.analisis.index', [
            'pilars' => $pilars,
            'pilar' => $pilar,
            'pilarId' => $pilarId,
            'indikator' => $indikator,
            'tren' => $tren?->toArray(),
            'detail' => $detail,
        ]);
    }
}
