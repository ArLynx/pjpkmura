@extends('frontend.layouts.app')

@section('title', 'Home | PJPK Murung Raya')

@section('content')

    {{-- ================================================= --}}
    {{-- HERO --}}
    {{-- ================================================= --}}
    <section class="relative w-full min-h-[600px] lg:min-h-[680px] overflow-hidden">

        {{-- ================================================= --}}
        {{-- HERO IMAGE 1 --}}
        {{-- ================================================= --}}
        <img src="{{ asset('image/city1.jpg') }}" alt="Pembangunan Kabupaten Murung Raya"
            class="hero-slide absolute inset-0 w-full h-full object-cover opacity-100 transition-opacity duration-1000">

        {{-- ================================================= --}}
        {{-- HERO IMAGE 2 --}}
        {{-- ================================================= --}}
        <img src="{{ asset('image/city2.jpg') }}" alt="Pembangunan Kabupaten Murung Raya"
            class="hero-slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000">

        {{-- ================================================= --}}
        {{-- HERO IMAGE 3 --}}
        {{-- ================================================= --}}
        <img src="{{ asset('image/city3.jpg') }}" alt="Pembangunan Kabupaten Murung Raya"
            class="hero-slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000">


        {{-- ================================================= --}}
        {{-- OVERLAY --}}
        {{-- ================================================= --}}
        <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/75 to-transparent"></div>


        {{-- ================================================= --}}
        {{-- CONTENT --}}
        {{-- ================================================= --}}
        <div class="relative z-10 max-w-7xl mx-auto px-6 py-20 lg:py-28 min-h-[600px] lg:min-h-[680px] flex items-center">

            <div class="max-w-2xl">

                <h1 class="text-4xl md:text-5xl lg:text-[40px] font-bold leading-[1.12] text-slate-900">

                    Peta Jalan Pembangunan Kependudukan

                    <span class="text-primary">
                        2025–2030
                    </span>

                </h1>


                <p class="mt-6 max-w-2xl text-base md:text-lg leading-7 text-slate-600">

                    Mewujudkan masyarakat Murung Raya yang sejahtera,
                    berkualitas, dan berdaya saing melalui perencanaan
                    kependudukan yang terintegrasi dan berkelanjutan.

                </p>


                <div class="mt-8">

                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-primary-hover">

                        Lihat Dashboard Indikator

                        <span class="material-symbols-outlined text-[18px]">
                            arrow_forward
                        </span>

                    </a>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- INDICATOR --}}
        {{-- ================================================= --}}
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">

            <button type="button" class="hero-dot w-2.5 h-2.5 rounded-full bg-primary transition-all duration-300"
                data-slide="0" aria-label="Slide 1"></button>

            <button type="button" class="hero-dot w-2.5 h-2.5 rounded-full bg-white/70 transition-all duration-300"
                data-slide="1" aria-label="Slide 2"></button>

            <button type="button" class="hero-dot w-2.5 h-2.5 rounded-full bg-white/70 transition-all duration-300"
                data-slide="2" aria-label="Slide 3"></button>

        </div>

    </section>

    {{-- ================================================= --}}
    {{-- BERITA TERBARU --}}
    {{-- ================================================= --}}
    <section class="py-16">

        <div class="max-w-7xl mx-auto px-6">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">

                <div>

                    <h2 class="text-2xl md:text-3xl font-semibold text-slate-900">
                        Berita Terbaru
                    </h2>

                    <p class="mt-2 text-sm md:text-base text-slate-500">
                        Kumpulan berita dan informasi terkini dari
                        Kabupaten Murung Raya.
                    </p>

                </div>

                <a href="{{ route('berita.index') }}"
                    class="inline-flex items-center gap-1 text-sm font-medium text-primary transition hover:text-primary-hover">

                    Lihat Semua

                    <span class="material-symbols-outlined text-[17px]">
                        arrow_forward
                    </span>

                </a>

            </div>


            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse ($beritas as $berita)
                    <article
                        class="group flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-shadow duration-200 hover:shadow-md">

                        {{-- FOTO --}}
                        <a href="{{ route('berita.show', $berita) }}" class="block">

                            @if ($berita->foto)
                                <div class="h-48 w-full overflow-hidden bg-slate-100">

                                    <img src="{{ asset('storage/' . $berita->foto) }}" alt="{{ $berita->judul }}"
                                        class="h-full w-full object-cover">

                                </div>
                            @else
                                <div class="flex h-48 w-full items-center justify-center bg-slate-100">

                                    <span class="material-symbols-outlined text-5xl text-slate-300">
                                        newspaper
                                    </span>

                                </div>
                            @endif

                        </a>


                        {{-- CONTENT --}}
                        <div class="flex flex-1 flex-col p-6">

                            {{-- DATE --}}
                            <span class="text-xs font-medium text-slate-400">
                                {{ $berita->created_at?->translatedFormat('d F Y') }}
                            </span>


                            {{-- TITLE --}}
                            <h3 class="mt-3 line-clamp-2 min-h-[48px] text-base font-semibold leading-6 text-slate-900">

                                {{ $berita->judul }}

                            </h3>


                            {{-- DESCRIPTION --}}
                            <p class="mt-3 line-clamp-2 text-sm leading-6 text-slate-500">

                                {{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 110) }}

                            </p>


                            {{-- ACTION --}}
                            <div class="mt-auto pt-5">

                                <a href="{{ route('berita.show', $berita) }}"
                                    class="inline-flex items-center gap-1 text-sm font-semibold text-primary transition hover:text-primary-hover">

                                    Baca Selengkapnya

                                    <span class="material-symbols-outlined text-[17px]">
                                        arrow_forward
                                    </span>

                                </a>

                            </div>

                        </div>

                    </article>

                @empty

                    <div class="md:col-span-2 lg:col-span-3">

                        <div
                            class="flex flex-col items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-14 text-center">

                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">

                                <span class="material-symbols-outlined text-3xl text-slate-400">
                                    newspaper
                                </span>

                            </div>

                            <p class="mt-4 text-sm font-medium text-slate-500">
                                Berita Belum Tersedia
                            </p>

                        </div>

                    </div>
                @endforelse

            </div>

        </div>

    </section>


    {{-- ================================================= --}}
    {{-- PUBLIKASI TERBARU --}}
    {{-- ================================================= --}}
    <section class="pb-20" id="indikator">

        <div class="max-w-7xl mx-auto px-6">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">

                <div>

                    <h2 class="text-2xl md:text-3xl font-semibold text-slate-900">
                        Publikasi Terbaru
                    </h2>

                    <p class="mt-2 text-sm md:text-base text-slate-500">
                        Akses dokumen perencanaan dan laporan capaian
                        pembangunan kependudukan.
                    </p>

                </div>

                <a href="{{ route('publikasi.index') }}"
                    class="inline-flex items-center gap-1 text-sm font-medium text-primary transition hover:text-primary-hover">

                    Lihat Semua

                    <span class="material-symbols-outlined text-[17px]">
                        arrow_forward
                    </span>

                </a>

            </div>


            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse ($publikasis as $publikasi)
                    <article
                        class="flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-shadow duration-200 hover:shadow-md">
                        {{-- FOTO PUBLIKASI --}}
                        @if ($publikasi->cover)
                            <div class="h-48 w-full overflow-hidden bg-slate-100">

                                <img src="{{ asset('storage/' . $publikasi->cover) }}" alt="{{ $publikasi->judul }}"
                                    class="h-full w-full object-cover">

                            </div>
                        @else
                            {{-- COVER TIDAK TERSEDIA --}}
                            <div class="flex h-48 w-full items-center justify-center bg-slate-100">

                                <span class="material-symbols-outlined text-5xl text-slate-300">
                                    image
                                </span>

                            </div>
                        @endif


                        {{-- CONTENT --}}
                        <div class="flex flex-1 flex-col p-6">

                            {{-- HEADER CARD --}}
                            <div class="flex items-center justify-between gap-3">

                                <span class="text-xs font-semibold uppercase tracking-wide text-primary">
                                    Publikasi
                                </span>

                                <span class="inline-flex shrink-0 items-center gap-1 text-xs font-medium text-slate-400">

                                    <span class="material-symbols-outlined text-[16px]">
                                        picture_as_pdf
                                    </span>

                                    PDF

                                </span>

                            </div>


                            {{-- DATE --}}
                            <span class="mt-4 text-xs font-medium text-slate-400">

                                {{ $publikasi->created_at?->translatedFormat('d F Y') }}

                            </span>


                            {{-- TITLE --}}
                            <h3 class="mt-3 line-clamp-2 min-h-[48px] text-base font-semibold leading-6 text-slate-900">

                                {{ $publikasi->judul }}

                            </h3>


                            {{-- DESCRIPTION --}}
                            <div class="min-h-[48px]">

                                @if ($publikasi->deskripsi)
                                    <p class="mt-3 line-clamp-2 text-sm leading-6 text-slate-500">

                                        {{ \Illuminate\Support\Str::limit(strip_tags($publikasi->deskripsi), 100) }}

                                    </p>
                                @else
                                    <p class="mt-3 text-sm leading-6 text-slate-400">
                                        Dokumen publikasi pembangunan kependudukan.
                                    </p>
                                @endif

                            </div>


                            {{-- ACTION --}}
                            <div class="mt-auto pt-6">

                                @if ($publikasi->file)
                                    <a href="{{ asset('storage/' . $publikasi->file) }}" target="_blank" download
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary/10 px-4 py-2.5 text-sm font-semibold text-primary transition-colors hover:bg-primary hover:text-white">

                                        <span class="material-symbols-outlined text-[18px]">
                                            download
                                        </span>

                                        Unduh Dokumen

                                    </a>
                                @else
                                    <div
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-100 px-4 py-2.5 text-sm font-medium text-slate-400">

                                        <span class="material-symbols-outlined text-[18px]">
                                            description
                                        </span>

                                        Dokumen Tidak Tersedia

                                    </div>
                                @endif

                            </div>

                        </div>

                    </article>

                @empty

                    <div class="md:col-span-2 lg:col-span-3">

                        <div
                            class="flex flex-col items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-14 text-center">

                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">

                                <span class="material-symbols-outlined text-3xl text-slate-400">
                                    folder_off
                                </span>

                            </div>

                            <p class="mt-4 text-sm font-medium text-slate-500">
                                Publikasi Belum Tersedia
                            </p>

                        </div>

                    </div>
                @endforelse

            </div>

        </div>

    </section>

    {{-- ================================================= --}}
    {{-- HERO CAROUSEL SCRIPT --}}
    {{-- ================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.hero-dot');

            let currentSlide = 0;
            let interval;


            function showSlide(index) {

                slides.forEach((slide, i) => {

                    slide.classList.toggle('opacity-100', i === index);
                    slide.classList.toggle('opacity-0', i !== index);

                });


                dots.forEach((dot, i) => {

                    if (i === index) {

                        dot.classList.remove('bg-white/70');
                        dot.classList.add('bg-primary');

                    } else {

                        dot.classList.remove('bg-primary');
                        dot.classList.add('bg-white/70');

                    }

                });

                currentSlide = index;

            }


            function nextSlide() {

                const next = (currentSlide + 1) % slides.length;

                showSlide(next);

            }


            function startCarousel() {

                interval = setInterval(nextSlide, 5000);

            }


            dots.forEach((dot, index) => {

                dot.addEventListener('click', function() {

                    clearInterval(interval);

                    showSlide(index);

                    startCarousel();

                });

            });


            showSlide(0);

            startCarousel();

        });
    </script>
@endsection
