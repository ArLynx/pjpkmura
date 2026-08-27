<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use Illuminate\Http\Request;

class PublikasiController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Daftar Publikasi
        |--------------------------------------------------------------------------
        */

        $publikasis = Publikasi::query()

            ->when($request->filled('q'), function ($query) use ($request) {

                $keyword = '%' . $request->q . '%';

                $query->where(function ($q) use ($keyword) {

                    $q->where('judul', 'like', $keyword)
                        ->orWhere('deskripsi', 'like', $keyword)
                        ->orWhere('penulis', 'like', $keyword);

                });

            })

            ->latest()

            // 6 publikasi per halaman
            ->paginate(6)

            ->withQueryString();


        return view(
            'frontend.publikasi.index',
            compact('publikasis')
        );
    }
}