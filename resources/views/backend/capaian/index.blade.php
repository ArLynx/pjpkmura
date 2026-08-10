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

                <div class="flex gap-3">

                    <form method="GET">

                        <input type="hidden" name="pilar" value="{{ $pilar }}">

                        <select name="tahun_id" onchange="this.form.submit()" class="rounded-xl border-slate-300">

                            @foreach ($tahuns as $item)
                                <option value="{{ $item->id }}" {{ $tahun == $item->id ? 'selected' : '' }}>
                                    {{ $item->tahun }}
                                </option>
                            @endforeach

                        </select>

                        @if (auth()->user()->role == 'superadmin')
                            <button type="button" onclick="openTambahTahun()"
                                class="rounded-xl border border-teal-600 px-5 py-3 font-semibold text-teal-700">
                                + Tahun
                            </button>

                            <button id="btnKelolaTahun" type="button"
                                class="rounded-xl border border-slate-300 px-4 py-2 font-semibold hover:bg-slate-100">
                                ⚙ Kelola Tahun
                            </button>
                        @endif

                    </form>

                    <button type="submit" form="formCapaian"
                        class="rounded-xl bg-teal-700 px-6 py-3 font-semibold text-white hover:bg-teal-800">
                        Simpan Semua
                    </button>

                </div>

            </div>

        </div>

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
                ? 'border-teal-700 bg-teal-700 text-white shadow-md'
                : 'border-slate-200 bg-white text-slate-700 hover:border-teal-500 hover:bg-teal-50' }}">

                                {{-- Huruf --}}
                                <div
                                    class="mr-4 flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full text-lg font-bold
                {{ $item->id == $pilar ? 'bg-white text-teal-700' : 'bg-slate-100 text-slate-600' }}">

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

                                        <th class="w-16 px-4 py-4 text-center">

                                            No

                                        </th>

                                        <th class="w-[420px] px-4 py-4 text-left">

                                            Indikator

                                        </th>

                                        <th class="w-40 px-4 py-4 text-center">

                                            Target

                                        </th>

                                        <th class="w-40 px-4 py-4 text-center">

                                            Realisasi

                                        </th>

                                        <th class="w-40 px-4 py-4 text-center">

                                            Status

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

                                        @endphp

                                        <tr class="border-b hover:bg-slate-50">

                                            <td class="px-4 py-5 text-center">

                                                {{ $loop->iteration }}

                                            </td>

                                            <td class="px-4 py-5">

                                                <div class="font-semibold text-slate-800">

                                                    {{ $indikator->nama_indikator }}

                                                </div>

                                                <div class="mt-1 text-sm text-slate-500">

                                                    {{ $indikator->instansi }}

                                                </div>

                                            </td>

                                            <td class="px-4 py-5 text-center">

                                                <input type="number" step="0.01" name="target[{{ $indikator->id }}]"
                                                    value="{{ old('target.' . $indikator->id, $target->nilai_target ?? '') }}"
                                                    class="target-input w-24 rounded-lg border-slate-300 text-center"
                                                    data-id="{{ $indikator->id }}">

                                            </td>

                                            <td class="px-4 py-5 text-center">

                                                <input type="number" step="0.01" name="realisasi[{{ $indikator->id }}]"
                                                    value="{{ old('realisasi.' . $indikator->id, $realisasi->nilai_realisasi ?? '') }}"
                                                    class="realisasi-input w-24 rounded-lg border-slate-300 text-center"
                                                    data-id="{{ $indikator->id }}">

                                            </td>

                                            <td class="px-4 py-5 text-center">

                                                <select id="status-{{ $indikator->id }}"
                                                    name="status[{{ $indikator->id }}]" data-id="{{ $indikator->id }}"
                                                    class="status-select min-w-[180px] rounded-lg border px-4 py-2 transition">

                                                    <option value="">-- Pilih Status --</option>

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

                                            {{-- Upload --}}
                                            <td class="px-4 py-5 text-center">

                                                @php
                                                    $file = $realisasi?->dataPendukungs->first();
                                                @endphp

                                                <div class="space-y-3">

                                                    <div id="preview-upload-{{ $indikator->id }}"
                                                        class="rounded-lg border p-3 text-center
        {{ $file ? 'border-green-200 bg-green-50' : 'border-dashed border-slate-300' }}">

                                                        <div id="preview-text-{{ $indikator->id }}"
                                                            class="{{ $file ? 'text-green-700 font-medium' : 'text-slate-400' }}">

                                                            @if ($file)
                                                                📄 {{ $file->judul }}
                                                            @else
                                                                Belum ada file
                                                            @endif

                                                        </div>

                                                    </div>

                                                    @if ($file)
                                                        <a href="{{ asset('storage/' . $file->file) }}" target="_blank"
                                                            class="block rounded-lg bg-blue-600 px-3 py-2 text-center text-sm text-white">

                                                            Lihat File

                                                        </a>
                                                    @endif

                                                    <label
                                                        class="block cursor-pointer rounded-lg bg-teal-700 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-teal-800">

                                                        <span id="label-upload-{{ $indikator->id }}">

                                                            {{ $file ? 'Ganti File' : 'Upload File' }}

                                                        </span>

                                                        <input type="file" name="pendukung[{{ $indikator->id }}]"
                                                            class="hidden file-upload" data-id="{{ $indikator->id }}"
                                                            accept=".pdf,.jpg,.jpeg,.png,.xls,.xlsx">

                                                    </label>

                                                    <button type="button" id="btn-cancel-{{ $indikator->id }}"
                                                        onclick="batalUpload({{ $indikator->id }})"
                                                        class="hidden mt-2 w-full rounded-lg border border-red-500 px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50">

                                                        Batal Pilih File

                                                    </button>

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

                                            <td colspan="6" class="py-12 text-center text-slate-400">

                                                Belum ada indikator pada pilar ini.

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </form>


                </div> {{-- grid --}}

            </div> {{-- space-y-6 --}}

            {{-- =============================== --}}
            {{-- MODAL TAMBAH TAHUN --}}
            {{-- =============================== --}}
            @if(auth()->user()->role == 'superadmin')

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
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-teal-600 focus:ring-teal-600">

                        <div class="mt-6 flex justify-end gap-3">

                            <button type="button" onclick="closeTambahTahun()" class="rounded-xl border px-5 py-2">

                                Batal

                            </button>

                            <button class="rounded-xl bg-teal-700 px-6 py-2 text-white">

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

                            <input id="editTahun" type="number" name="tahun" min="2000" max="2100" required
                                class="w-full rounded-xl border border-slate-300 px-4 py-3">

                        </div>

                        <div class="mt-5">

                            <label class="mb-2 block text-sm font-medium">

                                Status

                            </label>

                            <select id="editStatus" name="status"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3">

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

                            <button class="rounded-xl bg-teal-700 px-6 py-2 text-white">

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
                                            <form method="POST" action="{{ route('admin.tahuns.destroy', $th->id) }}">

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

            @if(auth()->user()->role == 'superadmin')
            <script>
                function openTambahTahun() {

                    document
                        .getElementById('modalTambahTahun')
                        .classList.remove('hidden');

                    document
                        .getElementById('modalTambahTahun')
                        .classList.add('flex');

                }

                function closeTambahTahun() {

                    document
                        .getElementById('modalTambahTahun')
                        .classList.remove('flex');

                    document
                        .getElementById('modalTambahTahun')
                        .classList.add('hidden');

                }

                function editTahun(id, tahun, status) {

                    // Tutup modal kelola
                    document
                        .getElementById('modalKelolaTahun')
                        .classList.remove('flex');

                    document
                        .getElementById('modalKelolaTahun')
                        .classList.add('hidden');

                    // Isi form edit
                    document
                        .getElementById('editTahun')
                        .value = tahun;

                    document
                        .getElementById('editStatus')
                        .value = status;

                    document
                        .getElementById('formEditTahun')
                        .action = "/admin/tahuns/" + id;

                    // Buka modal edit
                    document
                        .getElementById('modalEditTahun')
                        .classList.remove('hidden');

                    document
                        .getElementById('modalEditTahun')
                        .classList.add('flex');

                }

                function closeEditTahun() {

                    // Tutup modal edit
                    document
                        .getElementById('modalEditTahun')
                        .classList.remove('flex');

                    document
                        .getElementById('modalEditTahun')
                        .classList.add('hidden');

                    // Tampilkan kembali modal kelola
                    document
                        .getElementById('modalKelolaTahun')
                        .classList.remove('hidden');

                    document
                        .getElementById('modalKelolaTahun')
                        .classList.add('flex');

                }

                const modalKelola =
                    document.getElementById('modalKelolaTahun');

                document
                    .getElementById('btnKelolaTahun')
                    .onclick = function() {

                        modalKelola.classList.remove('hidden');

                        modalKelola.classList.add('flex');

                    };

                document
                    .getElementById('btnTutupKelola')
                    .onclick = function() {

                        modalKelola.classList.remove('flex');

                        modalKelola.classList.add('hidden');

                    };

                document.querySelectorAll('.file-upload').forEach(function(input) {

                    input.addEventListener('change', function() {

                        if (this.files.length === 0) {
                            return;
                        }

                        let file = this.files[0];

                        let id = this.dataset.id;

                        let icon = "📄";

                        let ext = file.name.split('.').pop().toLowerCase();

                        if (ext == "pdf") {

                            icon = "📕";

                        } else if (ext == "xls" || ext == "xlsx") {

                            icon = "📊";

                        } else if (ext == "jpg" || ext == "jpeg" || ext == "png") {

                            icon = "🖼️";

                        }

                        document
                            .getElementById("preview-upload-" + id)
                            .classList.remove("border-dashed");

                        document
                            .getElementById("preview-upload-" + id)
                            .classList.remove("border-slate-300");

                        document
                            .getElementById("preview-upload-" + id)
                            .classList.add("border-green-200");

                        document
                            .getElementById("preview-upload-" + id)
                            .classList.add("bg-green-50");

                        document
                            .getElementById("preview-text-" + id)
                            .innerHTML =
                            icon +
                            " <b>" + file.name + "</b><br><span class='text-xs'>✓ File siap diupload</span>";

                        document
                            .getElementById("label-upload-" + id)
                            .innerHTML = "Ganti File";

                        document
                            .getElementById("btn-cancel-" + id)
                            .classList.remove("hidden");

                    });

                });

                function batalUpload(id) {

                    let input = document.querySelector(
                        'input[name="pendukung[' + id + ']"]'
                    );

                    input.value = "";

                    document
                        .getElementById("preview-text-" + id)
                        .innerHTML = "Belum ada file";

                    document
                        .getElementById("label-upload-" + id)
                        .innerHTML = "Upload File";

                    document
                        .getElementById("btn-cancel-" + id)
                        .classList.add("hidden");

                    let preview =
                        document.getElementById("preview-upload-" + id);

                    preview.classList.remove("bg-green-50");
                    preview.classList.remove("border-green-200");

                    preview.classList.add("border-dashed");
                    preview.classList.add("border-slate-300");

                }

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

                    if (select.value == "tercapai") {

                        select.classList.add(
                            'bg-green-50',
                            'border-green-500',
                            'text-green-700'
                        );

                    } else if (select.value == "belum_tercapai") {

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
            @endif

        @endsection
