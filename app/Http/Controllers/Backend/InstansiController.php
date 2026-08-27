<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstansiController extends Controller
{
    public function index(): View
    {
        $instansis = Instansi::withCount(['users', 'indikators'])
            ->orderBy('nama')
            ->paginate(15);

        return view('backend.instansis.index', compact('instansis'));
    }

    public function create(): View
    {
        return view('backend.instansis.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'nama' => ['required', 'string', 'max:255', 'unique:instansis,nama'],
            ],
            [
                'nama.required' => 'Nama instansi wajib diisi.',
                'nama.unique' => 'Nama instansi sudah terdaftar.',
            ],
        );

        Instansi::create($validated);

        return redirect()->route('admin.instansis.index')->with('success', 'Instansi berhasil ditambahkan.');
    }

    public function edit(Instansi $instansi): View
    {
        return view('backend.instansis.edit', compact('instansi'));
    }

    public function update(Request $request, Instansi $instansi): RedirectResponse
    {
        $validated = $request->validate(
            [
                'nama' => ['required', 'string', 'max:255', 'unique:instansis,nama,' . $instansi->id],
            ],
            [
                'nama.required' => 'Nama instansi wajib diisi.',
                'nama.unique' => 'Nama instansi sudah terdaftar.',
            ],
        );

        $instansi->update($validated);

        return redirect()->route('admin.instansis.index')->with('success', 'Instansi berhasil diperbarui.');
    }

    public function destroy(Instansi $instansi): RedirectResponse
    {
        // Jangan hapus instansi kalau masih digunakan user
        if ($instansi->users()->exists()) {
            return redirect()->route('admin.instansis.index')->with('error', 'Instansi tidak dapat dihapus karena masih digunakan oleh user.');
        }

        // Jangan hapus instansi kalau masih digunakan indikator
        if ($instansi->indikators()->exists()) {
            return redirect()->route('admin.instansis.index')->with('error', 'Instansi tidak dapat dihapus karena masih digunakan oleh indikator.');
        }

        $instansi->delete();

        return redirect()->route('admin.instansis.index')->with('success', 'Instansi berhasil dihapus.');
    }
}
