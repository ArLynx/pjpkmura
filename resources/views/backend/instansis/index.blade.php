@extends('backend.layouts.app')

@section('title', 'Kelola Instansi')
@section('page-title', 'Kelola Instansi')

@section('content')

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <h2 class="text-xl font-bold text-slate-900">
            Daftar Instansi
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Kelola daftar instansi yang menjadi penanggung jawab indikator.
        </p>
    </div>

    <a href="{{ route('admin.instansis.create') }}"
        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0B91CF] px-5 py-3 font-semibold text-white hover:bg-[#0879AE]">

        <span class="material-symbols-outlined">
            add
        </span>

        Tambah Instansi
    </a>

</div>


<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="overflow-x-auto">

        <table class="min-w-full divide-y divide-slate-200">

            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">

                <tr>

                    <th class="px-6 py-4 w-20">
                        No
                    </th>

                    <th class="px-6 py-4">
                        Nama Instansi
                    </th>

                    <th class="px-6 py-4 text-center">
                        Jumlah User
                    </th>

                    <th class="px-6 py-4 text-center">
                        Jumlah Indikator
                    </th>

                    <th class="px-6 py-4 text-right">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

                @forelse($instansis as $instansi)

                    <tr class="hover:bg-sky-50">

                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $instansis->firstItem() + $loop->index }}
                        </td>

                        <td class="px-6 py-4">

                            <div class="font-semibold text-slate-900">
                                {{ $instansi->nama }}
                            </div>

                        </td>

                        <td class="px-6 py-4 text-center text-sm text-slate-600">
                            {{ $instansi->users_count }}
                        </td>

                        <td class="px-6 py-4 text-center text-sm text-slate-600">
                            {{ $instansi->indikators_count }}
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-end gap-2">

                                <a href="{{ route('admin.instansis.edit', $instansi) }}"
                                    class="rounded-lg bg-amber-100 p-2 text-amber-700 hover:bg-amber-200"
                                    title="Edit">

                                    <span class="material-symbols-outlined text-xl">
                                        edit
                                    </span>

                                </a>


                                <form method="POST"
                                    action="{{ route('admin.instansis.destroy', $instansi) }}"
                                    onsubmit="return confirm('Hapus instansi ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="rounded-lg bg-red-100 p-2 text-red-700 hover:bg-red-200"
                                        title="Hapus">

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

                        <td colspan="5"
                            class="px-6 py-12 text-center text-slate-500">

                            Belum ada data instansi.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    @if($instansis->hasPages())

        <div class="border-t border-slate-200 px-6 py-4">

            {{ $instansis->links() }}

        </div>

    @endif

</div>

@endsection