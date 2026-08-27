<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Publikasi;

class HomeController extends Controller
{
    public function index()
    {
        // Berita terbaru
        $beritas = Berita::latest()
            ->take(3)
            ->get();

        // Publikasi terbaru
        $publikasis = Publikasi::latest()
            ->take(3)
            ->get();

        return view('frontend.home', compact(
            'beritas',
            'publikasis'
        ));
    }
}