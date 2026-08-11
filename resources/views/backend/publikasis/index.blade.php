@extends('backend.layouts.app')

@section('title', 'Publikasi')
@section('page-title', 'Kelola Publikasi')

@section('content')

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-xl font-bold text-slate-900">
                Daftar Publikasi
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Kelola laporan, buku, dokumen, dan materi publikasi.
            </p>
        </div>

        <a
            href="{{ route('admin.publikasis.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0B91CF] px-5 py-3 font-semibold text-white hover:bg-[#0879AE]"
        >
            <span class="material-symbols-outlined">
                add
            </span>

            Tambah Publikasi
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
                class="rounded-xl bg-slate-800 px-5 font-semibold text-white hover:bg-slate-900"
            >
                Cari
            </button>

        </form>

    </div>


    {{-- TABLE --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">

                    <tr>

                        <th class="px-6 py-4">
                            Publikasi
                        </th>

                        <th class="px-6 py-4">
                            Penulis
                        </th>

                        <th class="px-6 py-4">
                            Tanggal
                        </th>

                        <th class="px-6 py-4">
                            File
                        </th>

                        <th class="px-6 py-4 text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($publikasis as $publikasi)

                        <tr class="align-top hover:bg-slate-50">

                            {{-- PUBLIKASI --}}
                            <td class="max-w-2xl px-6 py-4">

                                <div class="flex items-start gap-4">

                                    @if($publikasi->cover)

                                        <img
                                            src="{{ Storage::url($publikasi->cover) }}"
                                            alt="{{ $publikasi->judul }}"
                                            class="h-20 w-16 shrink-0 rounded-lg object-cover"
                                        >

                                    @else

                                        <div class="flex h-20 w-16 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-400">

                                            <span class="material-symbols-outlined">
                                                menu_book
                                            </span>

                                        </div>

                                    @endif


                                    <div class="min-w-0">

                                        <div class="font-semibold text-slate-900">
                                            {{ $publikasi->judul }}
                                        </div>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ Str::limit($publikasi->deskripsi, 110) ?: 'Tanpa deskripsi' }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- PENULIS --}}
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $publikasi->penulis ?: '-' }}
                            </td>


                            {{-- TANGGAL --}}
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $publikasi->created_at->format('d M Y') }}
                            </td>


                            {{-- FILE --}}
                            <td class="px-6 py-4">

                                <a
                                    href="{{ Storage::url($publikasi->file) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#0B91CF] hover:text-[#0879AE] hover:underline"
                                >

                                    <span class="material-symbols-outlined text-xl">
                                        download
                                    </span>

                                    Unduh

                                </a>

                            </td>


                            {{-- AKSI --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('admin.publikasis.edit', $publikasi) }}"
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
                                        action="{{ route('admin.publikasis.destroy', $publikasi) }}"
                                        onsubmit="return confirm('Hapus publikasi ini?')"
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
                                colspan="5"
                                class="px-6 py-12 text-center text-slate-500"
                            >
                                Publikasi tidak ditemukan.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($publikasis->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $publikasis->links() }}
            </div>

        @endif

    </div>

@endsection