@extends('frontend.layouts.app')

@section('title', 'Berita & Kegiatan PJPK')

@section('content')

    <div class="min-h-screen bg-slate-50">

        {{-- ========================================================= --}}
        {{-- CONTENT --}}
        {{-- ========================================================= --}}

        <section class="max-w-7xl mx-auto px-6 py-10">

            <div class="grid lg:grid-cols-[1fr_330px] gap-8">


                {{-- ================================================= --}}
                {{-- KOLOM UTAMA --}}
                {{-- ================================================= --}}

                <div>


                    {{-- ================================================= --}}
                    {{-- SEARCH --}}
                    {{-- ================================================= --}}

                    <form method="GET" action="{{ route('berita.index') }}" class="mb-6">

                        <div class="flex gap-3">

                            <div class="relative flex-1">

                                <span
                                    class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-2xl text-slate-400">
                                    search
                                </span>

                                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari berita..."
                                    class="w-full rounded-2xl border border-slate-300 bg-white py-4 pl-14 pr-5 text-base text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary-light">

                            </div>

                            <button type="submit"
                                class="rounded-2xl bg-primary px-7 font-semibold text-white transition hover:bg-primary-hover">
                                Cari
                            </button>

                        </div>

                    </form>


                    {{-- ================================================= --}}
                    {{-- DAFTAR BERITA --}}
                    {{-- ================================================= --}}

                    <div class="grid gap-6 md:grid-cols-2">

                        @forelse ($beritas as $berita)
                            <article
                                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">


                                {{-- FOTO COVER --}}
                                <a href="{{ route('berita.show', $berita) }}" class="block">
                                    @if ($berita->foto)
                                        <div class="flex h-64 w-full items-center justify-center overflow-hidden bg-white">

                                            <img src="{{ asset('storage/' . $berita->foto) }}" alt="{{ $berita->judul }}"
                                                class="h-full w-full object-contain p-2">

                                        </div>
                                    @else
                                        <div class="flex h-64 w-full items-center justify-center bg-slate-100">

                                            <span class="material-symbols-outlined text-5xl text-slate-300">
                                                image
                                            </span>

                                        </div>
                                    @endif
                                </a>


                                {{-- ===================================== --}}
                                {{-- DETAIL BERITA --}}
                                {{-- ===================================== --}}

                                <div class="p-5">


                                    {{-- TANGGAL --}}

                                    <div class="mb-3 flex items-center gap-2 text-sm text-slate-400">

                                        <span class="material-symbols-outlined text-lg">
                                            calendar_month
                                        </span>

                                        {{ $berita->created_at?->translatedFormat('d F Y') }}

                                    </div>


                                    {{-- JUDUL --}}

                                    <h2 class="line-clamp-2 text-xl font-bold leading-snug text-slate-800">

                                        {{ $berita->judul }}

                                    </h2>


                                    {{-- RINGKASAN --}}

                                    <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-500">

                                        {{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 140) }}

                                    </p>


                                    {{-- FOOTER CARD --}}

                                    <div class="mt-5 flex items-center justify-between gap-3">


                                        {{-- PENULIS --}}

                                        <span class="min-w-0 truncate text-sm text-slate-400">

                                            {{ $berita->penulis ?: 'PJPK Murung Raya' }}

                                        </span>


                                        {{-- DETAIL --}}

                                        <a href="{{ route('berita.show', $berita) }}"
                                            class="inline-flex shrink-0 items-center gap-1 font-semibold text-primary transition hover:text-primary-hover">

                                            Selengkapnya

                                            <span class="material-symbols-outlined">
                                                arrow_forward
                                            </span>

                                        </a>

                                    </div>

                                </div>

                            </article>

                        @empty


                            {{-- ========================================= --}}
                            {{-- KOSONG --}}
                            {{-- ========================================= --}}

                            <div class="col-span-full rounded-2xl border border-slate-200 bg-white p-12 text-center">

                                <span class="material-symbols-outlined text-6xl text-slate-300">
                                    newspaper
                                </span>

                                <h3 class="mt-4 text-lg font-bold text-slate-700">
                                    Berita belum tersedia
                                </h3>

                                <p class="mt-2 text-sm text-slate-500">
                                    Belum ada berita yang dapat ditampilkan.
                                </p>

                            </div>
                        @endforelse

                    </div>


                    {{-- ================================================= --}}
                    {{-- PAGINATION --}}
                    {{-- ================================================= --}}

                    @if ($beritas->hasPages())
                        <div class="mt-8 flex justify-center">

                            {{ $beritas->links() }}

                        </div>
                    @endif


                </div>


                {{-- ================================================= --}}
                {{-- SIDEBAR --}}
                {{-- ================================================= --}}

                <aside class="space-y-6">


                    {{-- ================================================= --}}
                    {{-- CARI INFORMASI --}}
                    {{-- ================================================= --}}

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h2 class="text-lg font-bold text-slate-800">
                            Cari Informasi
                        </h2>

                        <p class="mt-3 text-sm leading-relaxed text-slate-500">
                            Gunakan pencarian untuk menemukan berita dan kegiatan
                            PJPK Kabupaten Murung Raya.
                        </p>

                    </div>


                    {{-- ================================================= --}}
                    {{-- BERITA TERBARU --}}
                    {{-- ================================================= --}}

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h2 class="text-lg font-bold text-slate-800">
                            Berita Terbaru
                        </h2>


                        <div class="mt-5 space-y-4">

                            @foreach ($beritaTerbaru as $item)
                                <a href="{{ route('berita.show', $item) }}" class="group flex gap-3">


                                    {{-- FOTO KECIL --}}

                                    <div class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-slate-100">

                                        @if ($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}"
                                                class="h-full w-full object-cover transition group-hover:scale-105">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center">

                                                <span class="material-symbols-outlined text-3xl text-slate-300">
                                                    image
                                                </span>

                                            </div>
                                        @endif

                                    </div>


                                    {{-- DETAIL --}}

                                    <div class="min-w-0">

                                        <h3
                                            class="line-clamp-2 text-sm font-semibold leading-snug text-slate-700 group-hover:text-primary">

                                            {{ $item->judul }}

                                        </h3>

                                        <p class="mt-1 text-xs text-slate-400">

                                            {{ $item->created_at?->translatedFormat('d F Y') }}

                                        </p>

                                    </div>

                                </a>
                            @endforeach

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- INFORMASI TERKINI --}}
                    {{-- ================================================= --}}

                    <div class="rounded-2xl bg-primary p-6 text-white shadow-sm">

                        <span class="material-symbols-outlined text-3xl">
                            notifications_active
                        </span>


                        <h2 class="mt-5 text-xl font-bold">
                            Dapatkan Informasi Terkini
                        </h2>


                        <p class="mt-3 text-sm leading-relaxed text-teal-50">
                            Pantau berita dan kegiatan terbaru
                            Peta Jalan Pembangunan Kependudukan
                            Kabupaten Murung Raya.
                        </p>


                        <a href="{{ route('berita.index') }}"
                            class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-white px-4 py-3 font-semibold text-primary transition hover:bg-primary-light">

                            Lihat Berita Sekarang

                        </a>

                    </div>

                </aside>

            </div>

        </section>

    </div>

@endsection
