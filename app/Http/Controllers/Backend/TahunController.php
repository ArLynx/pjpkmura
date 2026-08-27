<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tahun;
use App\Models\Target;
use App\Models\Realisasi;
use App\Models\DataPendukung;
use Illuminate\Http\Request;

class TahunController extends Controller
{
    public function index()
    {
        $tahuns = Tahun::orderBy('tahun')->get();

        return view('backend.tahun.index', compact('tahuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|digits:4|unique:tahuns,tahun',
        ]);

        Tahun::create([
            'tahun' => $request->tahun,
            'status' => 'aktif',
        ]);

        return back()->with(
            'success',
            'Tahun berhasil ditambahkan.'
        );
    }

    public function update(Request $request, Tahun $tahun)
    {
        $request->validate([
            'tahun' => 'required|digits:4|unique:tahuns,tahun,' . $tahun->id,
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $tahun->update([
            'tahun' => $request->tahun,
            'status' => $request->status,
        ]);

        return back()->with(
            'success',
            'Tahun berhasil diperbarui.'
        );
    }

    public function destroy(Tahun $tahun)
    {
        $dipakai =
            Target::where('tahun_id', $tahun->id)->exists() ||
            Realisasi::where('tahun_id', $tahun->id)->exists();

        if ($dipakai) {
            return back()->with(
                'error',
                'Tahun tidak dapat dihapus karena sudah digunakan.'
            );
        }

        $tahun->delete();

        return back()->with(
            'success',
            'Tahun berhasil dihapus.'
        );
    }
}