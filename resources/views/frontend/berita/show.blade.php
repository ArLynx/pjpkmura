@extends('frontend.layouts.app')

@section('title', 'Detail Berita')

@section('content')

<div class="min-h-screen bg-slate-50">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <section class="bg-white border-b border-slate-200">

        <div class="max-w-5xl mx-auto px-6 py-8">

            <a
                href="{{ route('berita.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 hover:text-teal-900"
            >

                <span class="material-symbols-outlined text-lg">
                    arrow_back
                </span>

                Kembali ke Berita

            </a>

        </div>

    </section>


    {{-- ========================================================= --}}
    {{-- CONTENT --}}
    {{-- ========================================================= --}}

    <section class="max-w-5xl mx-auto px-6 py-10">

        <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">


            {{-- ================================================= --}}
            {{-- FOTO UTAMA --}}
            {{-- ================================================= --}}

            @if ($berita->foto)

                <img
                    src="{{ asset('storage/' . $berita->foto) }}"
                    alt="{{ $berita->judul }}"
                    class="w-full max-h-[520px] object-contain bg-slate-100"
                >

            @endif


            {{-- ================================================= --}}
            {{-- ISI --}}
            {{-- ================================================= --}}

            <div class="p-6 md:p-10">

                {{-- TANGGAL DAN PENULIS --}}

                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-400 mb-5">

                    <span class="inline-flex items-center gap-2">

                        <span class="material-symbols-outlined text-lg">
                            calendar_month
                        </span>

                        {{ $berita->created_at?->translatedFormat('d F Y') }}

                    </span>


                    @if ($berita->penulis)

                        <span class="inline-flex items-center gap-2">

                            <span class="material-symbols-outlined text-lg">
                                person
                            </span>

                            {{ $berita->penulis }}

                        </span>

                    @endif

                </div>


                {{-- ================================================= --}}
                {{-- JUDUL --}}
                {{-- ================================================= --}}

                <h1 class="text-3xl md:text-4xl font-bold text-slate-800 leading-tight">

                    {{ $berita->judul }}

                </h1>


                {{-- ================================================= --}}
                {{-- GARIS --}}
                {{-- ================================================= --}}

                <div class="mt-6 mb-8 h-px bg-slate-200"></div>


                {{-- ================================================= --}}
                {{-- ISI BERITA DARI CKEDITOR --}}
                {{-- ================================================= --}}

                <div class="prose prose-slate max-w-none leading-relaxed">

                    {!! $berita->isi !!}

                </div>

            </div>

        </article>


        {{-- ========================================================= --}}
        {{-- BERITA LAINNYA --}}
        {{-- ========================================================= --}}

        @if ($beritaTerbaru->count())

            <div class="mt-10">

                <h2 class="text-2xl font-bold text-slate-800 mb-5">
                    Berita Lainnya
                </h2>


                <div class="grid md:grid-cols-3 gap-5">

                    @foreach ($beritaTerbaru as $item)

                        <article
                            class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition"
                        >

                            <a href="{{ route('berita.show', $item) }}">

                                @if ($item->foto)

                                    <img
                                        src="{{ asset('storage/' . $item->foto) }}"
                                        alt="{{ $item->judul }}"
                                        class="w-full h-40 object-cover"
                                    >

                                @else

                                    <div
                                        class="w-full h-40 bg-slate-100 flex items-center justify-center"
                                    >

                                        <span
                                            class="material-symbols-outlined text-4xl text-slate-300"
                                        >
                                            image
                                        </span>

                                    </div>

                                @endif

                            </a>


                            <div class="p-4">

                                <p class="text-xs text-slate-400 mb-2">

                                    {{ $item->created_at?->translatedFormat('d F Y') }}

                                </p>


                                <h3 class="font-bold text-slate-800 line-clamp-2">

                                    {{ $item->judul }}

                                </h3>


                                <a
                                    href="{{ route('berita.show', $item) }}"
                                    class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-teal-700"
                                >

                                    Baca berita

                                    <span class="material-symbols-outlined text-base">
                                        arrow_forward
                                    </span>

                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>

            </div>

        @endif

    </section>

</div>

@endsection