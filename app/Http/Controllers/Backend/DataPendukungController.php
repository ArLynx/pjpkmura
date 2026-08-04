<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DataPendukung;
use App\Models\Realisasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DataPendukungController extends Controller
{
    public function index(Request $request): View
    {
        $dataPendukungs = DataPendukung::query()
            ->with('realisasi.indikator.pilar')
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = '%'.$request->string('q')->trim().'%';
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('judul', 'like', $keyword)
                        ->orWhereHas('realisasi.indikator', fn ($indikatorQuery) => $indikatorQuery->where('nama_indikator', 'like', $keyword));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('backend.data-pendukungs.index', compact('dataPendukungs'));
    }

    public function create(): View
    {
        return view('backend.data-pendukungs.create', ['realisasis' => $this->realisasis()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'realisasi_id' => ['required', 'exists:realisasis,id'],
            'judul' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,csv,jpg,jpeg,png', 'max:10240'],
        ]);

        $validated['file'] = $request->file('file')->store('data-pendukung', 'public');
        DataPendukung::create($validated);

        return redirect()->route('admin.data-pendukungs.index')->with('success', 'Data pendukung berhasil ditambahkan.');
    }

    public function edit(DataPendukung $dataPendukung): View
    {
        return view('backend.data-pendukungs.edit', [
            'dataPendukung' => $dataPendukung,
            'realisasis' => $this->realisasis(),
        ]);
    }

    public function update(Request $request, DataPendukung $dataPendukung): RedirectResponse
    {
        $validated = $request->validate([
            'realisasi_id' => ['required', 'exists:realisasis,id'],
            'judul' => ['required', 'string', 'max:255'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,csv,jpg,jpeg,png', 'max:10240'],
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($dataPendukung->file);
            $validated['file'] = $request->file('file')->store('data-pendukung', 'public');
        } else {
            unset($validated['file']);
        }

        $dataPendukung->update($validated);

        return redirect()->route('admin.data-pendukungs.index')->with('success', 'Data pendukung berhasil diperbarui.');
    }

    public function destroy(DataPendukung $dataPendukung): RedirectResponse
    {
        Storage::disk('public')->delete($dataPendukung->file);
        $dataPendukung->delete();

        return redirect()->route('admin.data-pendukungs.index')->with('success', 'Data pendukung berhasil dihapus.');
    }

    private function realisasis()
    {
        return Realisasi::with('indikator.pilar')->latest('tahun')->get();
    }
}
