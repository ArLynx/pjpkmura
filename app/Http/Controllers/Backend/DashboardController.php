<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\DataPendukung;
use App\Models\Indikator;
use App\Models\Pilar;
use App\Models\Publikasi;
use App\Models\Realisasi;
use App\Models\Target;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('backend.dashboard', [

            'totalUser' => User::count(),

            'totalPilar' => Pilar::count(),

            'totalIndikator' => Indikator::count(),

            'totalTarget' => Target::count(),

            'totalRealisasi' => Realisasi::count(),

            'totalDataPendukung' => DataPendukung::count(),

            'totalBerita' => Berita::count(),

            'totalPublikasi' => Publikasi::count(),

            'beritas' => Berita::latest()
                ->limit(3)
                ->get(),

            'publikasis' => Publikasi::latest()
                ->limit(3)
                ->get(),

        ]);
    }
}