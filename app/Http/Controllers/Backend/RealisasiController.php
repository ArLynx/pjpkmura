<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Realisasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RealisasiController extends Controller
{
    public function index(Request $request): View
    {
        $realisasis = Realisasi::query()
            ->with(['indikator.pilar', 'user'])
            ->withCount('dataPendukungs')
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = '%'.$request->string('q')->trim().'%';
                $query->whereHas('indikator', fn ($subQuery) => $subQuery->where('nama_indikator', 'like', $keyword));
            })
            ->when($request->filled('tahun'), fn ($query) => $query->where('tahun', $request->integer('tahun')))
            ->when($request->filled('status'), fn ($query) => $query->where('status_pencapaian', (string) $request->string('status')))
            ->latest('tahun')
            ->paginate(15)
            ->withQueryString();

        $tahuns = Realisasi::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('backend.realisasis.index', compact('realisasis', 'tahuns'));
    }

    public function create(): View
    {
        return view('backend.realisasis.create', ['indikators' => $this->indikators()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['created_by'] = $request->user()->id;
        Realisasi::create($validated);

        return redirect()->route('admin.realisasis.index')->with('success', 'Realisasi berhasil ditambahkan.');
    }

    public function edit(Realisasi $realisasi): View
    {
        return view('backend.realisasis.edit', [
            'realisasi' => $realisasi,
            'indikators' => $this->indikators(),
        ]);
    }

    public function update(Request $request, Realisasi $realisasi): RedirectResponse
    {
        $realisasi->update($this->validated($request, $realisasi));

        return redirect()->route('admin.realisasis.index')->with('success', 'Realisasi berhasil diperbarui.');
    }

    public function destroy(Realisasi $realisasi): RedirectResponse
    {
        foreach ($realisasi->dataPendukungs as $dataPendukung) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($dataPendukung->file);
        }

        $realisasi->delete();

        return redirect()->route('admin.realisasis.index')->with('success', 'Realisasi dan data pendukungnya berhasil dihapus.');
    }

    private function validated(Request $request, ?Realisasi $realisasi = null): array
    {
        return $request->validate([
            'indikator_id' => ['required', 'exists:indikators,id'],
            'tahun' => [
                'required',
                'integer',
                'between:2000,2100',
                Rule::unique('realisasis', 'tahun')
                    ->where(fn ($query) => $query->where('indikator_id', $request->integer('indikator_id')))
                    ->ignore($realisasi?->id),
            ],
            'nilai_realisasi' => ['nullable', 'numeric', 'between:-9999999999999.99,9999999999999.99'],
            'status_pencapaian' => ['nullable', Rule::in(['tercapai', 'belum_tercapai'])],
            'keterangan' => ['nullable', 'string'],
        ], [
            'tahun.unique' => 'Realisasi untuk indikator dan tahun tersebut sudah tersedia.',
        ]);
    }

    private function indikators()
    {
        return Indikator::with('pilar')->orderBy('pilar_id')->orderBy('urutan')->get();
    }
}
