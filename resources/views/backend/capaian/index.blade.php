@extends('backend.layouts.app')

@section('title', 'Capaian')

@section('page-title', 'Capaian')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex justify-between items-end">

                <div>

                    <h2 class="text-2xl font-bold text-slate-800">

                        Penginputan Capaian Indikator

                    </h2>

                    <p class="mt-2 text-slate-500">

                        Pengisian target, realisasi dan data pendukung indikator.

                    </p>

                </div>

                <div class="flex items-center gap-2">

                    {{-- ===================================================== --}}
                    {{-- TOMBOL YANG BERHUBUNGAN DENGAN DATA CAPAIAN --}}
                    {{-- HANYA MUNCUL JIKA SUDAH ADA TAHUN AKTIF --}}
                    {{-- ===================================================== --}}

                    @if ($tahuns->isNotEmpty())

                        {{-- FILTER TAHUN --}}
                        <form method="GET" class="flex items-center">

                            <input
                                type="hidden"
                                name="pilar"
                                value="{{ $pilar }}"
                            >

                            <select
                                name="tahun_id"
                                onchange="this.form.submit()"
                                class="h-14 w-28 rounded-xl border border-slate-300 bg-white px-4 text-base font-medium text-slate-700 outline-none focus:border-[#0B91CF] focus:ring-2 focus:ring-[#0B91CF]/20"
                            >

                                @foreach ($tahuns as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        {{ $tahun == $item->id ? 'selected' : '' }}
                                    >
                                        {{ $item->tahun }}
                                    </option>

                                @endforeach

                            </select>

                        </form>


                        {{-- PDF --}}
                        <a
                            href="{{ route('admin.capaian.pdf', ['tahun_id' => $tahun]) }}"
                            target="_blank"
                            class="inline-flex h-14 items-center gap-2 rounded-xl bg-red-600 px-5 text-base font-semibold text-white transition hover:bg-red-700"
                        >

                            <span class="material-symbols-outlined text-xl">
                                picture_as_pdf
                            </span>

                            PDF

                        </a>


                        {{-- EXCEL --}}
                        <a
                            href="{{ route('admin.capaian.excel', ['tahun_id' => $tahun]) }}"
                            class="inline-flex h-14 items-center gap-2 rounded-xl bg-green-600 px-5 text-base font-semibold text-white transition hover:bg-green-700"
                        >

                            <span class="material-symbols-outlined text-xl">
                                table_view
                            </span>

                            Excel

                        </a>

                    @endif


                    {{-- ===================================================== --}}
                    {{-- SUPERADMIN --}}
                    {{-- + TAHUN DAN KELOLA TAHUN TETAP MUNCUL --}}
                    {{-- ===================================================== --}}

                    @if (auth()->user()->role == 'superadmin')

                        {{-- TAMBAH TAHUN --}}
                        <button
                            type="button"
                            onclick="openTambahTahun()"
                            class="inline-flex h-14 items-center rounded-xl border-2 border-[#0B91CF] bg-white px-5 text-base font-semibold text-[#0B91CF] transition hover:bg-[#E0F4FC]"
                        >

                            <span class="material-symbols-outlined mr-1 text-lg">
                                add
                            </span>

                            Tahun

                        </button>


                        {{-- KELOLA TAHUN --}}
                        <button
                            id="btnKelolaTahun"
                            type="button"
                            class="inline-flex h-14 items-center gap-2 rounded-xl border border-slate-300 bg-white px-5 text-base font-semibold text-slate-700 transition hover:bg-slate-100"
                        >

                            <span class="material-symbols-outlined text-lg">
                                settings
                            </span>

                            Kelola Tahun

                        </button>

                    @endif


                    {{-- ===================================================== --}}
                    {{-- SIMPAN HANYA JIKA ADA TAHUN --}}
                    {{-- ===================================================== --}}

                    @if ($tahuns->isNotEmpty())

                        <button
                            type="submit"
                            form="formCapaian"
                            class="inline-flex h-14 items-center rounded-xl bg-[#0B91CF] px-5 text-base font-semibold text-white shadow-sm transition hover:bg-[#0879AE]"
                        >

                            Simpan Semua

                        </button>

                    @endif

                </div>

            </div>

        </div>

        @if ($tahuns->isEmpty())

            {{-- ================================================= --}}
            {{-- BELUM ADA TAHUN --}}
            {{-- ================================================= --}}

            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-8 shadow-sm">

                <div class="flex flex-col items-center justify-center text-center">

                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-amber-100">

                        <span class="material-symbols-outlined text-4xl text-amber-600">
                            calendar_month
                        </span>

                    </div>

                    <h3 class="mt-5 text-xl font-bold text-slate-800">
                        Belum Ada Tahun
                    </h3>

                    <p class="mt-2 max-w-lg text-sm leading-6 text-slate-600">
                        Belum terdapat tahun aktif untuk penginputan capaian indikator.
                        Silakan tambahkan tahun terlebih dahulu sebelum melakukan
                        penginputan capaian.
                    </p>

                    @if (auth()->user()->role == 'superadmin')

                        <button
                            type="button"
                            onclick="openTambahTahun()"
                            class="mt-6 inline-flex items-center gap-2 rounded-xl bg-[#0B91CF] px-6 py-3 font-semibold text-white shadow-sm transition hover:bg-[#0879AE]"
                        >

                            <span class="material-symbols-outlined">
                                add
                            </span>

                            Tambah Tahun

                        </button>

                    @endif

                </div>

            </div>

        @else

            {{-- ================================================= --}}
            {{-- KODE PENGISIAN CAPAIAN LAMA --}}
            {{-- ================================================= --}}


        {{-- Layout --}}
        <div class="grid grid-cols-12 gap-6">

            {{-- Sidebar Pilar --}}
            <div class="col-span-3">

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-200 px-5 py-4">

                        <h3 class="font-bold text-slate-800">

                            Daftar Pilar

                        </h3>

                    </div>
                    <div class="p-4">

                        @forelse($pilars as $item)
                            <a href="{{ route('admin.capaian.index', [
                                'tahun_id' => $tahun,
                                'pilar' => $item->id,
                            ]) }}"
                                class="mb-3 flex min-h-[90px] items-center rounded-2xl border px-5 py-4 transition duration-200
            {{ $item->id == $pilar
                ? 'border-[#0B91CF] bg-[#0B91CF] text-white shadow-md'
                : 'border-slate-200 bg-white text-slate-700 hover:border-[#0B91CF] hover:bg-[#E0F4FC]' }}">

                                {{-- Huruf --}}
                                <div
                                    class="mr-4 flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full text-lg font-bold
                {{ $item->id == $pilar ? 'bg-white text-[#0B91CF]' : 'bg-slate-100 text-slate-600' }}">

                                    {{ chr(64 + $loop->iteration) }}

                                </div>

                                {{-- Nama Pilar --}}
                                <div class="flex-1">

                                    <div class="text-base font-semibold leading-6">

                                        {{ ucwords(strtolower($item->nama)) }}

                                    </div>

                                </div>

                            </a>

                        @empty

                            <div
                                class="flex flex-col items-center justify-center rounded-xl border border-dashed border-slate-300 py-12">

                                <span class="material-symbols-outlined text-5xl text-slate-300">
                                    widgets
                                </span>

                                <h3 class="mt-4 text-lg font-semibold text-slate-700">
                                    Belum Ada Data Pilar
                                </h3>

                                <p class="mt-1 text-center text-sm text-slate-500">
                                    Silakan tambahkan data pilar terlebih dahulu melalui menu
                                    <b>Kelola Pilar</b>.
                                </p>

                            </div>
                        @endforelse

                    </div>

                </div>

            </div>

            {{-- Area Tabel --}}
            <div class="col-span-9">

                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">

                        <div>

                            <h3 class="text-lg font-bold text-slate-800">

                                {{ $pilarAktif?->nama ?? 'Data Indikator' }}

                            </h3>

                            <p class="mt-1 text-sm text-slate-500">

                                Tahun {{ optional($tahuns->firstWhere('id', $tahun))->tahun }}

                            </p>

                        </div>

                        <div class="text-sm text-slate-500">

                            {{ $indikators->count() }} Indikator

                        </div>

                    </div>

                    <form id="formCapaian" action="{{ route('admin.capaian.store') }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <input type="hidden" name="tahun_id" value="{{ $tahun }}">
                        <input type="hidden" name="pilar" value="{{ $pilar }}">

                        <div class="overflow-x-auto">

                            <table class="w-full">

                                <thead class="bg-slate-100">
                                    <tr>
                                        <th class="w-16 px-4 py-4 text-center">No</th>

                                        <th class="min-w-[320px] px-4 py-4 text-left">
                                            Indikator
                                        </th>

                                        <th class="w-36 px-4 py-4 text-center">
                                            Target
                                        </th>

                                        <th class="w-36 px-4 py-4 text-center">
                                            Realisasi
                                        </th>

                                        <th class="w-44 px-4 py-4 text-center">
                                            Status
                                        </th>

                                        <th class="min-w-[320px] px-4 py-4 text-left">
                                            Rencana Aksi
                                        </th>

                                        <th class="min-w-[320px] px-4 py-4 text-left">
                                            Hambatan / Permasalahan
                                        </th>

                                        <th class="min-w-[320px] px-4 py-4 text-left">
                                            Evaluasi
                                        </th>

                                        <th class="w-60 px-4 py-4 text-center">
                                            Data Pendukung
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($indikators as $indikator)

                                        @php
                                            $target = $indikator->targets->first();
                                            $realisasi = $indikator->realisasis->first();

                                            $isSuperadmin = auth()->user()->role === 'superadmin';

                                            $isPenanggungJawab =
                                                $isSuperadmin ||
                                                (auth()->user()->instansi_id &&
                                                    $indikator->instansi_id == auth()->user()->instansi_id);
                                        @endphp

                                        <tr class="border-b border-slate-200 hover:bg-slate-50">

                                            {{-- NO --}}
                                            <td class="px-4 py-5 text-center">
                                                {{ $loop->iteration }}
                                            </td>


                                            {{-- INDIKATOR --}}
                                            <td class="px-4 py-5">

                                                <div class="font-semibold text-slate-800">
                                                    {{ $indikator->nama_indikator }}
                                                </div>

                                                <div class="mt-1 text-sm text-slate-500">
                                                    {{ $indikator->instansi?->nama ?? '-' }}
                                                </div>

                                            </td>


                                            {{-- TARGET --}}
                                            <td class="px-4 py-5 text-center">

                                                <input type="number" step="0.01" name="target[{{ $indikator->id }}]"
                                                    value="{{ old('target.' . $indikator->id, $target->nilai_target ?? '') }}"
                                                    class="target-input w-24 rounded-lg border-slate-300 text-center
                                                    {{ !$isPenanggungJawab ? 'bg-slate-100 cursor-not-allowed' : '' }}"
                                                    data-id="{{ $indikator->id }}"
                                                    {{ !$isPenanggungJawab ? 'disabled' : '' }}>

                                            </td>


                                            {{-- REALISASI --}}
                                            <td class="px-4 py-5 text-center">

                                                <input type="number" step="0.01" name="realisasi[{{ $indikator->id }}]"
                                                    value="{{ old('realisasi.' . $indikator->id, $realisasi->nilai_realisasi ?? '') }}"
                                                    class="realisasi-input w-24 rounded-lg border-slate-300 text-center
                                                    {{ !$isPenanggungJawab ? 'bg-slate-100 cursor-not-allowed' : '' }}"
                                                    data-id="{{ $indikator->id }}"
                                                    {{ !$isPenanggungJawab ? 'disabled' : '' }}>

                                            </td>


                                            {{-- STATUS --}}
                                            <td class="px-4 py-5 text-center">

                                                <select id="status-{{ $indikator->id }}"
                                                    name="status[{{ $indikator->id }}]" data-id="{{ $indikator->id }}"
                                                    class="status-select min-w-[180px] rounded-lg border px-4 py-2 transition
                                                    {{ !$isPenanggungJawab ? 'bg-slate-100 cursor-not-allowed' : '' }}"
                                                    {{ !$isPenanggungJawab ? 'disabled' : '' }}>

                                                    <option value="">
                                                        -- Pilih Status --
                                                    </option>

                                                    <option value="tercapai"
                                                        {{ optional($realisasi)->status_pencapaian == 'tercapai' ? 'selected' : '' }}>
                                                        Tercapai
                                                    </option>

                                                    <option value="belum_tercapai"
                                                        {{ optional($realisasi)->status_pencapaian == 'belum_tercapai' ? 'selected' : '' }}>
                                                        Belum Tercapai
                                                    </option>

                                                </select>

                                            </td>


                                            {{-- RENCANA AKSI --}}
                                            <td class="px-4 py-5">

                                                @if ($isSuperadmin)
                                                    {{-- Superadmin hanya melihat --}}
                                                    <div
                                                        class="min-w-[300px] whitespace-pre-line text-sm leading-6 text-slate-600">
                                                        {{ $realisasi?->rencana_aksi ?: '-' }}
                                                    </div>
                                                @else
                                                    {{-- Admin / OPD mengisi --}}
                                                    <textarea name="rencana_aksi[{{ $indikator->id }}]" rows="5"
                                                        class="w-full min-w-[300px] rounded-lg border-slate-300 text-sm
                                                        focus:border-[#0B91CF] focus:ring-[#0B91CF]
                                                        {{ !$isPenanggungJawab ? 'bg-slate-100 cursor-not-allowed' : '' }}"
                                                        placeholder="Tuliskan rencana aksi..." {{ !$isPenanggungJawab ? 'disabled' : '' }}>{{ old('rencana_aksi.' . $indikator->id, $realisasi->rencana_aksi ?? '') }}</textarea>
                                                @endif

                                            </td>


                                            {{-- HAMBATAN --}}
                                            <td class="px-4 py-5">

                                                @if ($isSuperadmin)
                                                    {{-- Superadmin hanya melihat --}}
                                                    <div
                                                        class="min-w-[300px] whitespace-pre-line text-sm leading-6 text-slate-600">
                                                        {{ $realisasi?->hambatan ?: '-' }}
                                                    </div>
                                                @else
                                                    {{-- Admin / OPD mengisi --}}
                                                    <textarea name="hambatan[{{ $indikator->id }}]" rows="5"
                                                        class="w-full min-w-[300px] rounded-lg border-slate-300 text-sm
                                                        focus:border-[#0B91CF] focus:ring-[#0B91CF]
                                                        {{ !$isPenanggungJawab ? 'bg-slate-100 cursor-not-allowed' : '' }}"
                                                        placeholder="Tuliskan hambatan atau permasalahan..." {{ !$isPenanggungJawab ? 'disabled' : '' }}>{{ old('hambatan.' . $indikator->id, $realisasi->hambatan ?? '') }}</textarea>
                                                @endif

                                            </td>


                                            {{-- EVALUASI --}}
                                            <td class="px-4 py-5">

                                                @if ($isSuperadmin)
                                                    {{-- Superadmin mengisi --}}
                                                    <textarea name="evaluasi[{{ $indikator->id }}]" rows="5"
                                                        class="w-full min-w-[300px] rounded-lg border-slate-300 text-sm
                                                        focus:border-[#0B91CF] focus:ring-[#0B91CF]"
                                                        placeholder="Tuliskan evaluasi...">{{ old('evaluasi.' . $indikator->id, $realisasi->evaluasi ?? '') }}</textarea>
                                                @else
                                                    {{-- Admin hanya melihat --}}
                                                    <div
                                                        class="min-w-[300px] whitespace-pre-line text-sm leading-6 text-slate-600">
                                                        {{ $realisasi?->evaluasi ?: '-' }}
                                                    </div>
                                                @endif

                                            </td>

                                            {{-- DATA PENDUKUNG --}}
                                            <td class="px-4 py-5 text-center">

                                                @php
                                                    $file = $realisasi?->dataPendukungs->first();
                                                @endphp

                                                <div class="space-y-3">

                                                    {{-- Preview File --}}
                                                    <div id="preview-upload-{{ $indikator->id }}"
                                                        class="rounded-lg border p-3 text-center
            {{ $file ? 'border-green-200 bg-green-50' : 'border-dashed border-slate-300' }}">

                                                        <div id="preview-text-{{ $indikator->id }}"
                                                            class="{{ $file ? 'font-medium text-green-700' : 'text-slate-400' }}">

                                                            @if ($file)
                                                                📄 {{ $file->judul }}
                                                            @else
                                                                Belum ada file
                                                            @endif

                                                        </div>

                                                    </div>


                                                    {{-- LIHAT FILE --}}
                                                    @if ($file)
                                                        <a href="{{ asset('storage/' . $file->file) }}" target="_blank"
                                                            class="block rounded-lg bg-blue-600 px-3 py-2
                text-center text-sm font-semibold text-white
                hover:bg-blue-700">

                                                            Lihat File

                                                        </a>
                                                    @endif


                                                    {{-- ================================= --}}
                                                    {{-- ADMIN PENANGGUNG JAWAB + SUPERADMIN --}}
                                                    {{-- ================================= --}}
                                                    @if ($isPenanggungJawab)
                                                        <label
                                                            class="block cursor-pointer rounded-lg bg-[#0B91CF]
                px-3 py-2 text-center text-sm font-semibold text-white
                hover:bg-[#0879AE]">

                                                            <span id="label-upload-{{ $indikator->id }}">
                                                                {{ $file ? 'Ganti File' : 'Upload File' }}
                                                            </span>

                                                            <input type="file" name="pendukung[{{ $indikator->id }}]"
                                                                class="hidden file-upload" data-id="{{ $indikator->id }}"
                                                                accept=".pdf,.jpg,.jpeg,.png,.xls,.xlsx">

                                                        </label>


                                                        {{-- BATAL PILIH FILE --}}
                                                        <button type="button" id="btn-cancel-{{ $indikator->id }}"
                                                            onclick="batalUpload({{ $indikator->id }})"
                                                            class="mt-2 hidden w-full rounded-lg
                border border-red-500 px-3 py-2
                text-sm font-semibold text-red-600
                hover:bg-red-50">

                                                            Batal Pilih File

                                                        </button>
                                                    @endif


                                                    {{-- Keterangan --}}
                                                    <p class="text-xs text-slate-500">
                                                        PDF, Excel, JPG, JPEG, PNG
                                                        <br>
                                                        Maksimal 5 MB
                                                    </p>

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="9" class="py-12 text-center text-slate-400">

                                                Belum ada indikator pada pilar ini.

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        {{-- <div class="border-t border-slate-200 px-6 py-4">
                            {{ $indikators->links() }}
                        </div> --}}

                    </form>


                </div> {{-- grid --}}

            </div> {{-- space-y-6 --}}

            @endif

            {{-- =============================== --}}
            {{-- MODAL TAMBAH TAHUN --}}
            {{-- =============================== --}}
            @if (auth()->user()->role == 'superadmin')

                <div id="modalTambahTahun" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">

                    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">

                        <h2 class="text-xl font-bold text-slate-800">

                            Tambah Tahun

                        </h2>

                        <form method="POST" action="{{ route('admin.tahuns.store') }}" class="mt-6">

                            @csrf

                            <label class="mb-2 block text-sm font-medium">

                                Tahun

                            </label>

                            <input type="number" name="tahun" min="2000" max="2100" required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-sky-600 focus:ring-sky-600">

                            <div class="mt-6 flex justify-end gap-3">

                                <button type="button" onclick="closeTambahTahun()" class="rounded-xl border px-5 py-2">

                                    Batal

                                </button>

                                <button class="rounded-xl bg-[#0B91CF] px-6 py-2 text-white hover:bg-[#0879AE]">

                                    Simpan

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

                <div id="modalEditTahun" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">

                    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">

                        <h2 class="text-xl font-bold text-slate-800">

                            Edit Tahun

                        </h2>

                        <form id="formEditTahun" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="mt-5">

                                <label class="mb-2 block text-sm font-medium">

                                    Tahun

                                </label>

                                <input id="editTahun" type="number" name="tahun" min="2000" max="2100"
                                    required class="w-full rounded-xl border border-slate-300 px-4 py-3">

                            </div>

                            <div class="mt-5">

                                <label class="mb-2 block text-sm font-medium">

                                    Status

                                </label>

                                <select id="editStatus" name="status"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-sky-600 focus:ring-sky-600">

                                    <option value="aktif">

                                        Aktif

                                    </option>

                                    <option value="nonaktif">

                                        Nonaktif

                                    </option>

                                </select>

                            </div>

                            <div class="mt-6 flex justify-end gap-3">

                                <button type="button" onclick="closeEditTahun()" class="rounded-xl border px-5 py-2">

                                    Batal

                                </button>

                                <button class="rounded-xl bg-[#0B91CF] px-6 py-2 text-white hover:bg-[#0879AE]">

                                    Simpan

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

                <div id="modalKelolaTahun" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">

                    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-xl">

                        <div class="border-b px-6 py-5">

                            <h2 class="text-xl font-bold">

                                Kelola Tahun

                            </h2>

                            <p class="text-sm text-slate-500 mt-1">

                                Tahun yang sudah memiliki data tidak dapat dihapus.

                            </p>

                        </div>

                        <div class="max-h-[500px] overflow-y-auto p-6">

                            @foreach ($tahuns as $th)
                                @php
                                    $item = $statistikTahun[$th->id] ?? [
                                        'target' => 0,
                                        'realisasi' => 0,
                                        'pendukung' => 0,
                                        'boleh_hapus' => true,
                                    ];
                                @endphp

                                <div class="mb-4 rounded-xl border p-5">

                                    <div class="flex justify-between">

                                        <div>

                                            <h3 class="text-lg font-bold">

                                                {{ $th->tahun }}

                                            </h3>

                                            <div class="mt-3 space-y-1 text-sm text-slate-600">

                                                <div>

                                                    Target :
                                                    <b>{{ $item['target'] }}</b>

                                                </div>

                                                <div>

                                                    Realisasi :
                                                    <b>{{ $item['realisasi'] }}</b>

                                                </div>

                                                <div>

                                                    Data Pendukung :
                                                    <b>{{ $item['pendukung'] }}</b>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="flex gap-2">

                                            <button type="button"
                                                onclick="editTahun(
                                                {{ $th->id }},
                                                '{{ $th->tahun }}',
                                                '{{ $th->status }}'
                                            )"
                                                class="rounded-lg bg-amber-500 px-4 py-2 text-white hover:bg-amber-600">

                                                Edit

                                            </button>

                                            @if ($item['boleh_hapus'])
                                                <form method="POST"
                                                    action="{{ route('admin.tahuns.destroy', $th->id) }}">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button onclick="return confirm('Hapus tahun {{ $th->tahun }}?')"
                                                        class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">

                                                        Hapus

                                                    </button>

                                                </form>
                                            @else
                                                <span class="rounded-lg bg-slate-100 px-4 py-2 text-slate-500">

                                                    Digunakan

                                                </span>
                                            @endif

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                        <div class="border-t p-5 text-right">

                            <button id="btnTutupKelola" class="rounded-xl border px-5 py-2">

                                Tutup

                            </button>

                        </div>

                    </div>

                </div>

            @endif

            <script>
                /*
                                                                                        |--------------------------------------------------------------------------
                                                                                        | MODAL TAHUN
                                                                                        |--------------------------------------------------------------------------
                                                                                        | Hanya digunakan Superadmin.
                                                                                        */

                function openTambahTahun() {
                    const modal = document.getElementById('modalTambahTahun');

                    if (!modal) return;

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }

                function closeTambahTahun() {
                    const modal = document.getElementById('modalTambahTahun');

                    if (!modal) return;

                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }

                function editTahun(id, tahun, status) {
                    const modalKelola = document.getElementById('modalKelolaTahun');
                    const modalEdit = document.getElementById('modalEditTahun');

                    if (!modalEdit) return;

                    if (modalKelola) {
                        modalKelola.classList.remove('flex');
                        modalKelola.classList.add('hidden');
                    }

                    const inputTahun = document.getElementById('editTahun');
                    const inputStatus = document.getElementById('editStatus');
                    const formEdit = document.getElementById('formEditTahun');

                    if (inputTahun) {
                        inputTahun.value = tahun;
                    }

                    if (inputStatus) {
                        inputStatus.value = status;
                    }

                    if (formEdit) {
                        formEdit.action = "/admin/tahuns/" + id;
                    }

                    modalEdit.classList.remove('hidden');
                    modalEdit.classList.add('flex');
                }

                function closeEditTahun() {
                    const modalEdit = document.getElementById('modalEditTahun');
                    const modalKelola = document.getElementById('modalKelolaTahun');

                    if (modalEdit) {
                        modalEdit.classList.remove('flex');
                        modalEdit.classList.add('hidden');
                    }

                    if (modalKelola) {
                        modalKelola.classList.remove('hidden');
                        modalKelola.classList.add('flex');
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | KELOLA TAHUN
                |--------------------------------------------------------------------------
                */

                const modalKelola = document.getElementById('modalKelolaTahun');
                const btnKelolaTahun = document.getElementById('btnKelolaTahun');
                const btnTutupKelola = document.getElementById('btnTutupKelola');

                if (btnKelolaTahun && modalKelola) {
                    btnKelolaTahun.onclick = function() {
                        modalKelola.classList.remove('hidden');
                        modalKelola.classList.add('flex');
                    };
                }

                if (btnTutupKelola && modalKelola) {
                    btnTutupKelola.onclick = function() {
                        modalKelola.classList.remove('flex');
                        modalKelola.classList.add('hidden');
                    };
                }


                /*
                |--------------------------------------------------------------------------
                | UPLOAD FILE
                |--------------------------------------------------------------------------
                | ADMIN + SUPERADMIN
                |--------------------------------------------------------------------------
                */

                document.querySelectorAll('.file-upload').forEach(function(input) {

                    input.addEventListener('change', function() {

                        if (this.files.length === 0) {
                            return;
                        }

                        const file = this.files[0];
                        const id = this.dataset.id;

                        let icon = "📄";

                        const ext = file.name
                            .split('.')
                            .pop()
                            .toLowerCase();

                        if (ext === "pdf") {

                            icon = "📕";

                        } else if (ext === "xls" || ext === "xlsx") {

                            icon = "📊";

                        } else if (
                            ext === "jpg" ||
                            ext === "jpeg" ||
                            ext === "png"
                        ) {

                            icon = "🖼️";
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Preview
                        |--------------------------------------------------------------------------
                        */

                        const preview = document.getElementById(
                            "preview-upload-" + id
                        );

                        const previewText = document.getElementById(
                            "preview-text-" + id
                        );

                        const labelUpload = document.getElementById(
                            "label-upload-" + id
                        );

                        const btnCancel = document.getElementById(
                            "btn-cancel-" + id
                        );


                        if (preview) {

                            preview.classList.remove(
                                "border-dashed",
                                "border-slate-300"
                            );

                            preview.classList.add(
                                "border-green-200",
                                "bg-green-50"
                            );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Nama file
                        |--------------------------------------------------------------------------
                        */

                        if (previewText) {

                            previewText.classList.remove(
                                "text-slate-400"
                            );

                            previewText.classList.add(
                                "font-medium",
                                "text-green-700"
                            );

                            previewText.innerHTML =
                                icon +
                                " <b>" +
                                file.name +
                                "</b><br>" +
                                "<span class='text-xs'>✓ File siap diupload</span>";
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Tombol
                        |--------------------------------------------------------------------------
                        */

                        if (labelUpload) {

                            labelUpload.innerHTML = "Ganti File";
                        }

                        if (btnCancel) {

                            btnCancel.classList.remove("hidden");
                        }

                    });

                });


                /*
                |--------------------------------------------------------------------------
                | BATAL PILIH FILE
                |--------------------------------------------------------------------------
                */

                function batalUpload(id) {

                    const input = document.querySelector(
                        'input[name="pendukung[' + id + ']"]'
                    );

                    if (input) {
                        input.value = "";
                    }


                    const previewText = document.getElementById(
                        "preview-text-" + id
                    );

                    if (previewText) {

                        previewText.classList.remove(
                            "font-medium",
                            "text-green-700"
                        );

                        previewText.classList.add(
                            "text-slate-400"
                        );

                        previewText.innerHTML = "Belum ada file";
                    }


                    const labelUpload = document.getElementById(
                        "label-upload-" + id
                    );

                    if (labelUpload) {

                        labelUpload.innerHTML = "Upload File";
                    }


                    const btnCancel = document.getElementById(
                        "btn-cancel-" + id
                    );

                    if (btnCancel) {

                        btnCancel.classList.add("hidden");
                    }


                    const preview = document.getElementById(
                        "preview-upload-" + id
                    );

                    if (preview) {

                        preview.classList.remove(
                            "bg-green-50",
                            "border-green-200"
                        );

                        preview.classList.add(
                            "border-dashed",
                            "border-slate-300"
                        );
                    }

                }


                /*
                |--------------------------------------------------------------------------
                | WARNA STATUS
                |--------------------------------------------------------------------------
                */

                function updateStatusColor(select) {

                    select.classList.remove(
                        'bg-green-50',
                        'border-green-500',
                        'text-green-700',

                        'bg-red-50',
                        'border-red-500',
                        'text-red-700',

                        'bg-white',
                        'border-slate-300',
                        'text-slate-700'
                    );


                    if (select.value === "tercapai") {

                        select.classList.add(
                            'bg-green-50',
                            'border-green-500',
                            'text-green-700'
                        );

                    } else if (select.value === "belum_tercapai") {

                        select.classList.add(
                            'bg-red-50',
                            'border-red-500',
                            'text-red-700'
                        );

                    } else {

                        select.classList.add(
                            'bg-white',
                            'border-slate-300',
                            'text-slate-700'
                        );

                    }

                }


                document.querySelectorAll(".status-select").forEach(function(select) {

                    updateStatusColor(select);

                    select.addEventListener("change", function() {

                        updateStatusColor(this);

                    });

                });
            </script>

        @endsection
