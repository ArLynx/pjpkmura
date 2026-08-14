<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Halaman daftar berita
     */
    public function index(Request $request)
    {
        $beritas = Berita::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = '%' . $request->string('q')->trim() . '%';

                $query->where(function ($q) use ($keyword) {
                    $q->where('judul', 'like', $keyword)
                        ->orWhere('isi', 'like', $keyword)
                        ->orWhere('penulis', 'like', $keyword);
                });
            })
            ->latest()
            ->paginate(4)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Berita terbaru untuk sidebar
        |--------------------------------------------------------------------------
        */

        $beritaTerbaru = Berita::latest()
            ->take(5)
            ->get();

        return view('frontend.berita.index', compact(
            'beritas',
            'beritaTerbaru'
        ));
    }

    /**
     * Halaman detail berita
     */
    public function show(Berita $berita)
    {
        $beritaTerbaru = Berita::query()
            ->where('id', '!=', $berita->id)
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.berita.show', compact(
            'berita',
            'beritaTerbaru'
        ));
    }
}