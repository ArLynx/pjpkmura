<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BeritaController extends Controller
{
    public function index(Request $request): View
    {
        $beritas = Berita::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = '%'.$request->string('q')->trim().'%';
                $query->where('judul', 'like', $keyword)->orWhere('penulis', 'like', $keyword);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('backend.beritas.index', compact('beritas'));
    }

    public function create(): View
    {
        return view('backend.beritas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['penulis'] = $validated['penulis'] ?: $request->user()->name;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('berita', 'public');
        }

        Berita::create($validated);

        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita): View
    {
        return view('backend.beritas.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita): RedirectResponse
    {
        $validated = $this->validated($request, true);
        $validated['penulis'] = $validated['penulis'] ?: $request->user()->name;

        if ($request->hasFile('foto')) {
            if ($berita->foto) {
                Storage::disk('public')->delete($berita->foto);
            }
            $validated['foto'] = $request->file('foto')->store('berita', 'public');
        } else {
            unset($validated['foto']);
        }

        $berita->update($validated);

        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita): RedirectResponse
    {
        if ($berita->foto) {
            Storage::disk('public')->delete($berita->foto);
        }
        $berita->delete();

        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil dihapus.');
    }

    private function validated(Request $request, bool $updating = false): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'foto' => [$updating ? 'nullable' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'isi' => ['required', 'string'],
            'penulis' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
