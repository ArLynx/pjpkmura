@extends('frontend.layouts.app')

@section('title', 'Publikasi & Dokumen')

@section('content')

    <div class="min-h-screen bg-slate-50">

        {{-- ========================================================= --}}
        {{-- HEADER HALAMAN --}}
        {{-- ========================================================= --}}

        <section class="bg-primary-hover">

            <div class="mx-auto max-w-7xl px-6 py-12">

                <div class="text-sm font-medium text-white">
                    Beranda
                    <span class="mx-2 text-white">/</span>
                    Publikasi
                </div>

                <h1 class="mt-4 text-3xl font-bold tracking-tight text-white md:text-4xl">
                    Publikasi & Dokumen
                </h1>

                <p class="mt-4 max-w-3xl text-lg leading-7 text-primary-light">
                    Akses koleksi dokumen strategis, laporan tahunan, dan buku
                    terkait Peta Jalan Pembangunan Kependudukan Kabupaten Murung Raya
                    untuk mendukung transparansi dan ketersediaan informasi yang akurat.
                </p>

            </div>

        </section>


        {{-- ========================================================= --}}
        {{-- CONTENT --}}
        {{-- ========================================================= --}}

        <section class="mx-auto max-w-7xl px-6 py-8">


            {{-- ===================================================== --}}
            {{-- FILTER / SEARCH --}}
            {{-- ===================================================== --}}

            <div class="mb-8 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                <form method="GET" action="{{ route('publikasi.index') }}">

                    <div class="flex flex-col gap-3 md:flex-row">


                        {{-- SEARCH --}}

                        <div class="relative flex-1">

                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-xl text-slate-400">
                                search
                            </span>

                            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari dokumen..."
                                class="w-full rounded-xl border border-slate-300 py-3 pl-12 pr-4 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary-light">

                        </div>


                        {{-- TOMBOL --}}

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white transition hover:bg-primary-hover">

                            <span class="material-symbols-outlined text-lg">
                                filter_alt
                            </span>

                            Terapkan

                        </button>


                        {{-- RESET --}}

                        @if (request()->filled('q'))
                            <a href="{{ route('publikasi.index') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-100">
                                Reset
                            </a>
                        @endif

                    </div>

                </form>

            </div>


            {{-- ===================================================== --}}
            {{-- PUBLIKASI --}}
            {{-- ===================================================== --}}

            @if ($publikasis->count())


                {{-- 3 KOLOM --}}

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($publikasis as $publikasi)
                        <article
                            class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">


                            {{-- ========================================= --}}
                            {{-- COVER --}}
                            {{-- ========================================= --}}

                            <div class="flex h-64 w-full items-center justify-center overflow-hidden bg-slate-50">

                                @if ($publikasi->cover)
                                    <img src="{{ asset('storage/' . $publikasi->cover) }}" alt="{{ $publikasi->judul }}"
                                        class="max-h-full max-w-full object-contain transition duration-300 group-hover:scale-[1.02]">
                                @else
                                    <div class="flex h-full w-full flex-col items-center justify-center text-slate-300">

                                        <span class="material-symbols-outlined text-6xl">
                                            description
                                        </span>

                                        <span class="mt-2 text-sm">
                                            Tidak ada cover
                                        </span>

                                    </div>
                                @endif

                            </div>


                            {{-- ========================================= --}}
                            {{-- DETAIL --}}
                            {{-- ========================================= --}}

                            <div class="p-5">


                                {{-- TANGGAL --}}

                                <div class="mb-3 text-xs text-slate-400">

                                    {{ $publikasi->created_at?->translatedFormat('F Y') }}

                                </div>


                                {{-- JUDUL --}}

                                <h2 class="line-clamp-2 min-h-[48px] text-base font-bold leading-snug text-slate-800">

                                    {{ $publikasi->judul }}

                                </h2>


                                {{-- DESKRIPSI --}}

                                @if ($publikasi->deskripsi)
                                    <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-slate-500">

                                        {{ \Illuminate\Support\Str::limit(strip_tags($publikasi->deskripsi), 100) }}

                                    </p>
                                @endif


                                {{-- ===================================== --}}
                                {{-- FOOTER CARD --}}
                                {{-- ===================================== --}}

                                <div class="mt-5 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">


                                    {{-- FILE --}}

                                    <div class="flex items-center gap-1 text-xs text-slate-400">

                                        <span class="material-symbols-outlined text-base">
                                            description
                                        </span>

                                        @if ($publikasi->file)
                                            Dokumen
                                        @else
                                            Tidak ada file
                                        @endif

                                    </div>


                                    {{-- DOWNLOAD --}}

                                    @if ($publikasi->file)
                                        <a href="{{ asset('storage/' . $publikasi->file) }}" target="_blank" download
                                            class="inline-flex items-center gap-1 text-sm font-semibold text-primary transition hover:text-primary-hover">

                                            Unduh

                                            <span class="material-symbols-outlined text-lg">
                                                download
                                            </span>

                                        </a>
                                    @endif

                                </div>

                            </div>

                        </article>
                    @endforeach

                </div>


                {{-- ================================================= --}}
                {{-- PAGINATION --}}
                {{-- ================================================= --}}

                @if ($publikasis->hasPages())
                    <div class="mt-10">

                        {{ $publikasis->links() }}

                    </div>
                @endif
            @else
                {{-- ================================================= --}}
                {{-- DATA KOSONG --}}
                {{-- ================================================= --}}

                <div class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm">

                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-100">

                        <span class="material-symbols-outlined text-4xl text-slate-400">
                            folder_off
                        </span>

                    </div>

                    <h2 class="mt-5 text-lg font-bold text-slate-700">
                        Publikasi tidak ditemukan
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">

                        @if (request()->filled('q'))
                            Tidak ditemukan publikasi dengan kata kunci
                            <strong>"{{ request('q') }}"</strong>.
                        @else
                            Belum ada publikasi yang tersedia.
                        @endif

                    </p>


                    @if (request()->filled('q'))
                        <a href="{{ route('publikasi.index') }}"
                            class="mt-5 inline-flex rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white hover:bg-teal-800">
                            Tampilkan Semua
                        </a>
                    @endif

                </div>

            @endif

        </section>

    </div>

@endsection
