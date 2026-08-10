<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\BeritaController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DataPendukungController;
use App\Http\Controllers\Backend\IndikatorController;
use App\Http\Controllers\Backend\PilarController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\PublikasiController;
use App\Http\Controllers\Backend\RealisasiController;
use App\Http\Controllers\Backend\TargetController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\TahunController;
use App\Http\Controllers\Backend\CapaianController;

use App\Http\Controllers\Frontend\DashboardController as FrontendDashboardController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [FrontendDashboardController::class, 'index'])->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'active'])
    ->group(function () {
        Route::get('/', fn() => redirect()->route('admin.dashboard'))->name('index');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class)->except('show')->middleware('superadmin');

        Route::resource('pilars', PilarController::class)->except('show');
        Route::resource('indikators', IndikatorController::class)->except('show');
        Route::resource('targets', TargetController::class)->except('show');
        Route::resource('realisasis', RealisasiController::class)->except('show');
        Route::resource('data-pendukungs', DataPendukungController::class)
            ->parameters(['data-pendukungs' => 'dataPendukung'])
            ->except('show');
        Route::resource('beritas', BeritaController::class)->except('show');
        Route::resource('publikasis', PublikasiController::class)->except('show');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/capaian', [CapaianController::class, 'index'])->name('capaian.index');
        Route::post('/capaian', [CapaianController::class, 'store'])->name('capaian.store');

        Route::resource('tahuns', TahunController::class)->except(['show', 'create', 'edit']);
    });
