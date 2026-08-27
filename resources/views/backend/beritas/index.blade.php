@extends('backend.layouts.app')

@section('title', 'Berita')
@section('page-title', 'Kelola Berita')

@section('content')

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h2 class="text-xl font-bold text-slate-900">
                Daftar Berita
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Kelola konten informasi untuk halaman publik.
            </p>

        </div>


        {{-- TAMBAH BERITA --}}
        <a href="{{ route('admin.beritas.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0B91CF] px-5 py-3 font-semibold text-white hover:bg-[#0879AE]">

            <span class="material-symbols-outlined">
                add
            </span>

            Tambah Berita

        </a>

    </div>


    {{-- SEARCH --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

        <form method="GET" class="flex gap-2">

            <input
                type="search"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari judul atau penulis..."
                class="min-w-0 flex-1 rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
            >

            <button
                type="submit"
                class="rounded-xl bg-sky-600 px-5 font-semibold text-white hover:bg-sky-700"
            >
                Cari
            </button>

        </form>

    </div>


    {{-- TABLE --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                {{-- HEADER TABLE --}}
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">

                    <tr>

                        <th class="px-6 py-4">
                            Berita
                        </th>

                        <th class="px-6 py-4">
                            Penulis
                        </th>

                        <th class="px-6 py-4">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                {{-- BODY --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($beritas as $berita)

                        <tr class="align-top hover:bg-slate-50">

                            {{-- ========================================= --}}
                            {{-- BERITA --}}
                            {{-- ========================================= --}}
                            <td class="max-w-2xl px-6 py-4">

                                <div class="flex items-start gap-4">


                                    {{-- ========================================= --}}
                                    {{-- FOTO BERITA --}}
                                    {{-- ========================================= --}}

                                    @if($berita->foto)

                                        @php
                                            $foto = $berita->foto;

                                            /*
                                            |--------------------------------------------------------------------------
                                            | Jika sudah URL lengkap
                                            |--------------------------------------------------------------------------
                                            */

                                            if (
                                                str_starts_with($foto, 'http://') ||
                                                str_starts_with($foto, 'https://')
                                            ) {

                                                $fotoUrl = $foto;

                                            }

                                            /*
                                            |--------------------------------------------------------------------------
                                            | Jika database menyimpan "storage/..."
                                            |--------------------------------------------------------------------------
                                            */

                                            elseif (str_starts_with($foto, 'storage/')) {

                                                $fotoUrl = asset($foto);

                                            }

                                            /*
                                            |--------------------------------------------------------------------------
                                            | Jika database menyimpan "/storage/..."
                                            |--------------------------------------------------------------------------
                                            */

                                            elseif (str_starts_with($foto, '/storage/')) {

                                                $fotoUrl = asset(ltrim($foto, '/'));

                                            }

                                            /*
                                            |--------------------------------------------------------------------------
                                            | Jika database menyimpan path biasa
                                            | contoh:
                                            | berita/foto.jpg
                                            |--------------------------------------------------------------------------
                                            */

                                            else {

                                                $fotoUrl = asset('storage/' . ltrim($foto, '/'));

                                            }
                                        @endphp


                                        <img
                                            src="{{ $fotoUrl }}"
                                            alt="{{ $berita->judul }}"
                                            class="h-16 w-24 shrink-0 rounded-lg object-cover"
                                            onerror="this.onerror=null;this.src='{{ asset('image/logo-murung-raya.png') }}';"
                                        >

                                    @else

                                        {{-- Tidak ada foto --}}
                                        <div
                                            class="flex h-16 w-24 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-400"
                                        >

                                            <span class="material-symbols-outlined">
                                                image
                                            </span>

                                        </div>

                                    @endif


                                    {{-- ========================================= --}}
                                    {{-- INFORMASI BERITA --}}
                                    {{-- ========================================= --}}

                                    <div class="min-w-0">

                                        <div class="font-semibold text-slate-900">

                                            {{ $berita->judul }}

                                        </div>


                                        <p class="mt-1 text-sm text-slate-500">

                                            {{ Str::limit(strip_tags($berita->isi), 100) }}

                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- ========================================= --}}
                            {{-- PENULIS --}}
                            {{-- ========================================= --}}

                            <td class="px-6 py-4 text-sm text-slate-600">

                                {{ $berita->penulis ?: '-' }}

                            </td>


                            {{-- ========================================= --}}
                            {{-- TANGGAL --}}
                            {{-- ========================================= --}}

                            <td class="px-6 py-4 text-sm text-slate-600">

                                {{ $berita->created_at->format('d M Y') }}

                            </td>


                            {{-- ========================================= --}}
                            {{-- AKSI --}}
                            {{-- ========================================= --}}

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">


                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('admin.beritas.edit', $berita) }}"
                                        class="rounded-lg bg-amber-100 p-2 text-amber-700 hover:bg-amber-200"
                                        title="Edit"
                                    >

                                        <span class="material-symbols-outlined text-xl">
                                            edit
                                        </span>

                                    </a>


                                    {{-- HAPUS --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.beritas.destroy', $berita) }}"
                                        onsubmit="return confirm('Hapus berita ini?')"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="rounded-lg bg-red-100 p-2 text-red-700 hover:bg-red-200"
                                            title="Hapus"
                                        >

                                            <span class="material-symbols-outlined text-xl">
                                                delete
                                            </span>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="px-6 py-12 text-center text-slate-500"
                            >

                                Berita tidak ditemukan.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($beritas->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">

                {{ $beritas->links() }}

            </div>

        @endif

    </div>

@endsection