<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pilar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PilarController extends Controller
{
    public function index(Request $request): View
    {
        $pilars = Pilar::query()
            ->withCount('indikators')
            ->when($request->filled('q'), fn ($query) => $query->where('nama', 'like', '%'.$request->string('q')->trim().'%'))
            ->orderBy('urutan')
            ->paginate(15)
            ->withQueryString();

        return view('backend.pilars.index', compact('pilars'));
    }

    public function create(): View
    {
        return view('backend.pilars.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'urutan' => ['required', 'integer', 'min:1'],
        ]);

        Pilar::create($validated);

        return redirect()->route('admin.pilars.index')->with('success', 'Pilar berhasil ditambahkan.');
    }

    public function edit(Pilar $pilar): View
    {
        return view('backend.pilars.edit', compact('pilar'));
    }

    public function update(Request $request, Pilar $pilar): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'urutan' => ['required', 'integer', 'min:1'],
        ]);

        $pilar->update($validated);

        return redirect()->route('admin.pilars.index')->with('success', 'Pilar berhasil diperbarui.');
    }

    public function destroy(Pilar $pilar): RedirectResponse
    {
        $files = \App\Models\DataPendukung::whereHas('realisasi.indikator', fn ($query) => $query->where('pilar_id', $pilar->id))->pluck('file')->all();
        if ($files) {
            Storage::disk('public')->delete($files);
        }

        $pilar->delete();

        return redirect()->route('admin.pilars.index')->with('success', 'Pilar dan seluruh data turunannya berhasil dihapus.');
    }
}
