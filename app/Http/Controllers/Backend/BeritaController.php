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
    /**
     * Daftar berita.
     */
    public function index(Request $request): View
    {
        $beritas = Berita::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = '%' . $request->string('q')->trim() . '%';

                $query->where('judul', 'like', $keyword)->orWhere('penulis', 'like', $keyword);
            })
            ->oldest()
            ->paginate(15)
            ->withQueryString();

        return view('backend.beritas.index', compact('beritas'));
    }

    /**
     * Form tambah berita.
     */
    public function create(): View
    {
        return view('backend.beritas.create');
    }

    /**
     * Simpan berita baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        $validated['penulis'] = $validated['penulis'] ?: $request->user()->name;

        /*
        |--------------------------------------------------------------------------
        | FOTO UTAMA
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('berita', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN BERITA
        |--------------------------------------------------------------------------
        */

        Berita::create($validated);

        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Form edit berita.
     */
    public function edit(Berita $berita): View
    {
        return view('backend.beritas.edit', compact('berita'));
    }

    /**
     * Update berita.
     */
    public function update(Request $request, Berita $berita): RedirectResponse
    {
        $validated = $this->validated($request, true);

        $validated['penulis'] = $validated['penulis'] ?: $request->user()->name;

        /*
        |--------------------------------------------------------------------------
        | FOTO UTAMA
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {
            /*
            |--------------------------------------------------------------------------
            | Hapus foto lama
            |--------------------------------------------------------------------------
            */

            if ($berita->foto) {
                Storage::disk('public')->delete($berita->foto);
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan foto baru
            |--------------------------------------------------------------------------
            */

            $validated['foto'] = $request->file('foto')->store('berita', 'public');
        } else {
            unset($validated['foto']);
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $berita->update($validated);

        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Hapus berita.
     */
    public function destroy(Berita $berita): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Hapus foto utama
        |--------------------------------------------------------------------------
        */

        if ($berita->foto) {
            Storage::disk('public')->delete($berita->foto);
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus berita
        |--------------------------------------------------------------------------
        */

        $berita->delete();

        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Upload gambar dari CKEditor.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $path = $request->file('upload')->store('berita/content', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }

    /**
     * Validasi data berita.
     */
    private function validated(Request $request, bool $updating = false): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],

            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            'isi' => ['required', 'string'],

            'penulis' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
