@extends('backend.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Admin')

@section('content')
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

        @php
            $role = auth()->user()->role;
        @endphp

        <h2 class="text-3xl font-bold text-slate-800">

            Selamat Datang 👋 {{ auth()->user()->name }}

        </h2>

        <p class="mt-3 text-slate-500">

            Selamat datang di Dashboard
            {{ $role == 'superadmin' ? 'Super Admin' : 'Admin' }}
            Sistem PJPK Kabupaten Murung Raya.

            @if ($role == 'superadmin')
                Melalui dashboard ini Anda dapat mengelola data admin, pilar, indikator, target, realisasi, berita,
                publikasi, serta memonitor perkembangan pengisian data oleh setiap instansi.
            @else
                Melalui dashboard ini Anda dapat mengelola target, realisasi, data pendukung, serta memonitor perkembangan
                pengisian data pada instansi Anda.
            @endif

        </p>

    </div>

    @php
        $cards = [
            ['label' => 'Total User', 'value' => $totalUser, 'icon' => 'group'],
            ['label' => 'Total Pilar', 'value' => $totalPilar, 'icon' => 'account_tree'],
            ['label' => 'Total Indikator', 'value' => $totalIndikator, 'icon' => 'analytics'],
            ['label' => 'Total Target', 'value' => $totalTarget, 'icon' => 'flag'],
            ['label' => 'Total Realisasi', 'value' => $totalRealisasi, 'icon' => 'monitoring'],
            ['label' => 'Data Pendukung', 'value' => $totalDataPendukung, 'icon' => 'folder'],
            ['label' => 'Total Berita', 'value' => $totalBerita, 'icon' => 'newspaper'],
            ['label' => 'Total Publikasi', 'value' => $totalPublikasi, 'icon' => 'menu_book'],
        ];
    @endphp

    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($cards as $card)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-slate-500">{{ $card['label'] }}</p>
                        <p class="mt-3 text-3xl font-bold text-slate-900">{{ number_format($card['value']) }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-100 text-teal-700">
                        <span class="material-symbols-outlined">{{ $card['icon'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h3 class="font-bold text-slate-900">Berita Terbaru</h3>
                <a href="{{ route('admin.beritas.index') }}"
                    class="text-sm font-semibold text-teal-700 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($beritas as $berita)
                    <div class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $berita->judul }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $berita->created_at->format('d M Y') }} ·
                            {{ $berita->penulis ?: 'Tanpa penulis' }}</p>
                    </div>
                @empty
                    <p class="px-6 py-8 text-center text-slate-500">Belum ada berita.</p>
                @endforelse
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h3 class="font-bold text-slate-900">Publikasi Terbaru</h3>
                <a href="{{ route('admin.publikasis.index') }}"
                    class="text-sm font-semibold text-teal-700 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($publikasis as $publikasi)
                    <div class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $publikasi->judul }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $publikasi->created_at->format('d M Y') }} ·
                            {{ $publikasi->penulis ?: 'Tanpa penulis' }}</p>
                    </div>
                @empty
                    <p class="px-6 py-8 text-center text-slate-500">Belum ada publikasi.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
