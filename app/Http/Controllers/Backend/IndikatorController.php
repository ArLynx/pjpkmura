<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Pilar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Models\Instansi;

class IndikatorController extends Controller
{
    public function index(Request $request): View
    {
        $indikators = Indikator::query()
            ->with(['pilar', 'instansi'])
            ->withCount(['targets', 'realisasis'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = '%' . $request->string('q')->trim() . '%';

                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery
                        ->where('nama_indikator', 'like', $keyword)
                        ->orWhere('tujuan_strategis', 'like', $keyword)
                        ->orWhereHas('instansi', function ($query) use ($keyword) {
                            $query->where('nama', 'like', $keyword);
                        });
                });
            })
            ->when($request->filled('pilar_id'), fn($query) => $query->where('pilar_id', $request->integer('pilar_id')))
            ->orderBy('pilar_id')
            ->orderBy('urutan')
            ->paginate(15)
            ->withQueryString();

        $pilars = Pilar::orderBy('urutan')->get();

        return view('backend.indikators.index', compact('indikators', 'pilars'));
    }

    public function create(): View
    {
        return view('backend.indikators.create', [
            'pilars' => Pilar::orderBy('urutan')->get(),
            'instansis' => Instansi::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Indikator::create($this->validated($request));

        return redirect()->route('admin.indikators.index')->with('success', 'Indikator berhasil ditambahkan.');
    }

    public function edit(Indikator $indikator): View
    {
        return view('backend.indikators.edit', [
            'indikator' => $indikator,
            'pilars' => Pilar::orderBy('urutan')->get(),
            'instansis' => Instansi::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Indikator $indikator): RedirectResponse
    {
        $indikator->update($this->validated($request));

        return redirect()->route('admin.indikators.index')->with('success', 'Indikator berhasil diperbarui.');
    }

    public function destroy(Indikator $indikator): RedirectResponse
    {
        $files = \App\Models\DataPendukung::whereHas('realisasi', fn($query) => $query->where('indikator_id', $indikator->id))->pluck('file')->all();
        if ($files) {
            Storage::disk('public')->delete($files);
        }

        $indikator->delete();

        return redirect()->route('admin.indikators.index')->with('success', 'Indikator dan seluruh data turunannya berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate(
            [
                'pilar_id' => ['required', 'exists:pilars,id'],
                'tujuan_strategis' => ['required', 'string', 'max:255'],
                'nama_indikator' => ['required', 'string', 'max:255'],
                'instansi_id' => ['required', 'exists:instansis,id'],
                'instansi_pendukung' => ['nullable', 'string'],
                'nilai_baseline' => ['nullable', 'string', 'max:100'],
                'tahun_baseline' => ['nullable', 'integer', 'between:1900,2100'],
                'satuan' => ['nullable', 'string', 'max:100'],
                'sumber_data' => ['nullable', 'string', 'max:255'],
                'urutan' => [
                    'required',
                    'integer',
                    'min:1',

                    Rule::unique('indikators')
                        ->where(function ($query) use ($request) {
                            return $query->where('pilar_id', $request->pilar_id);
                        })
                        ->ignore(optional($request->route('indikator'))->id),
                ],
            ],

            [
                'urutan.unique' => 'Nomor urutan sudah digunakan pada pilar yang dipilih.',
            ],
        );
    }
}
