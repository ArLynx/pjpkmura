@extends('frontend.layouts.app')

@section('title', 'Dashboard Monitoring')

@section('content')

    <section class="bg-gradient-to-r from-teal-700 to-emerald-700">

        <div class="max-w-7xl mx-auto px-6 py-16">

            <h1 class="text-4xl font-bold text-white">

                Dashboard Monitoring

            </h1>

            <p class="text-teal-100 mt-3 text-lg">

                Monitoring indikator Peta Jalan Pembangunan Kependudukan Kabupaten Murung Raya.

            </p>

        </div>

    </section>

    <section class="max-w-7xl mx-auto px-6 py-10">

        {{-- Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">

            <form method="GET" action="{{ route('dashboard') }}">

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- Pilar --}}
                    <div>

                        <label class="block mb-2 font-medium text-slate-700">
                            Pilar
                        </label>

                        <select name="pilar" onchange="this.form.submit()"
                            class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600">

                            <option value="">
                                Semua Pilar
                            </option>

                            @foreach ($pilars as $pilar)
                                <option value="{{ $pilar->id }}" {{ request('pilar') == $pilar->id ? 'selected' : '' }}>

                                    {{ $pilar->nama }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Instansi --}}
                    <div>

                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Instansi
                        </label>

                        <select name="instansi_id" onchange="this.form.submit()"
                            class="w-full rounded-xl border-slate-300 px-4 py-3">

                            <option value="">
                                Semua Instansi
                            </option>

                            @foreach ($instansis as $item)
                                <option value="{{ $item->id }}"
                                    {{ request('instansi_id') == $item->id ? 'selected' : '' }}>

                                    {{ $item->nama }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Tahun --}}
                    <div>

                        <label class="block mb-2 font-medium text-slate-700">
                            Tahun
                        </label>

                        <select name="tahun_id" onchange="this.form.submit()"
                            class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600">

                            @foreach ($tahuns as $item)
                                <option value="{{ $item->id }}"
                                    {{ request('tahun_id', $tahun) == $item->id ? 'selected' : '' }}>

                                    {{ $item->tahun }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Reset --}}
                    <div class="flex items-end">

                        <a href="{{ route('dashboard', [
                            'mode' => $mode,
                        ]) }}"
                            class="w-full text-center bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-3 rounded-xl transition">

                            Reset Filter

                        </a>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- KETERANGAN FILTER --}}
                {{-- ========================================================= --}}

                <div class="mt-5 rounded-xl bg-teal-50 border border-teal-100 px-5 py-4">

                    <div class="flex items-start gap-3">

                        <span class="material-symbols-outlined text-teal-700 mt-0.5">
                            info
                        </span>

                        <div class="text-sm text-slate-600 leading-relaxed">

                            <p class="font-semibold text-teal-800 mb-1">
                                Cara menggunakan filter
                            </p>

                            <p>
                                Gunakan filter <strong>Tahun</strong>, <strong>Pilar</strong>, dan
                                <strong>Instansi</strong> untuk menampilkan data indikator sesuai
                                kebutuhan.
                            </p>

                            <ul class="mt-2 space-y-1 list-disc list-inside">

                                <li>
                                    Pilih <strong>Tahun</strong> untuk melihat data indikator
                                    pada tahun tertentu.
                                </li>

                                <li>
                                    Pilih <strong>Pilar</strong> untuk melihat indikator pada
                                    pilar tertentu sesuai dengan <strong>tahun yang dipilih</strong>.
                                </li>

                                <li>
                                    Pilih <strong>Instansi</strong> untuk melihat indikator yang
                                    menjadi tanggung jawab instansi tersebut sesuai dengan
                                    <strong>tahun yang dipilih</strong>.
                                </li>

                                <li>
                                    Pilih <strong>Instansi dan Pilar</strong> untuk melihat indikator
                                    dari instansi tertentu pada pilar dan tahun yang dipilih.
                                </li>

                                <li>
                                    Pilih <strong>Semua Pilar</strong> dan <strong>Semua Instansi</strong>
                                    untuk melihat seluruh indikator pada <strong>tahun yang dipilih</strong>.
                                </li>

                            </ul>

                            <p class="mt-2">
                                Pilar yang tidak memiliki indikator sesuai dengan filter yang dipilih
                                tidak akan ditampilkan.
                            </p>

                        </div>

                    </div>

                </div>

            </form>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

            {{-- Total Pilar --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <div class="flex justify-between items-start">

                    <div>

                        <h6 class="text-sm font-semibold text-slate-600">

                            Total Pilar

                        </h6>

                        <p class="text-xs text-slate-400 mt-1">

                            Jumlah pilar pembangunan kependudukan.

                        </p>

                        <h2 class="text-4xl font-bold text-slate-800 mt-4">

                            {{ $jumlahPilar }}

                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-xl bg-teal-100 flex items-center justify-center">

                        <span class="material-symbols-outlined text-teal-700 text-3xl">

                            account_tree

                        </span>

                    </div>

                </div>

            </div>

            {{-- Total Indikator --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <div class="flex justify-between items-start">

                    <div>

                        <h6 class="text-sm font-semibold text-slate-600">

                            Total Indikator

                        </h6>

                        <p class="text-xs text-slate-400 mt-1">

                            Jumlah indikator sesuai filter yang dipilih.

                        </p>

                        <h2 class="text-4xl font-bold text-slate-800 mt-4">

                            {{ $jumlahIndikator }}

                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">

                        <span class="material-symbols-outlined text-blue-600 text-3xl">

                            analytics

                        </span>

                    </div>

                </div>

            </div>

            {{-- Target --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <div class="flex justify-between items-start">

                    <div>

                        <h6 class="text-sm font-semibold text-slate-600">

                            {{ $mode == 'tahunan' ? "Target $tahun" : 'Total Target' }}

                        </h6>

                        <p class="text-xs text-slate-400 mt-1">

                            @if ($mode == 'tahunan')
                                Jumlah target indikator tahun {{ $tahun }}.
                            @else
                                Jumlah target indikator periode {{ $tahunAwal }} - {{ $tahunAkhir }}.
                            @endif

                        </p>

                        <h2 class="text-4xl font-bold text-slate-800 mt-4">

                            {{ $jumlahTarget }}

                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center">

                        <span class="material-symbols-outlined text-amber-600 text-3xl">

                            flag

                        </span>

                    </div>

                </div>

            </div>

            {{-- Tercapai --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                <div class="flex justify-between items-start">

                    <div>

                        <h6 class="text-sm font-semibold text-slate-600">

                            {{ $mode == 'tahunan' ? 'Target Tercapai' : 'Total Tercapai' }}

                        </h6>

                        <p class="text-xs text-slate-400 mt-1">

                            @if ($mode == 'tahunan')
                                Jumlah indikator yang mencapai target tahun {{ $tahun }}.
                            @else
                                Jumlah indikator yang mencapai target selama periode {{ $tahunAwal }} -
                                {{ $tahunAkhir }}.
                            @endif

                        </p>

                        <h2 class="text-4xl font-bold text-slate-800 mt-4">

                            {{ $jumlahTercapai }}

                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center">

                        <span class="material-symbols-outlined text-green-600 text-3xl">

                            check_circle

                        </span>

                    </div>

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- BLOK TREN INDIKATOR --}}
        {{-- ========================================================= --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-10 overflow-hidden">

            <div class="px-6 py-6 border-b border-slate-200">

                <h2 class="text-2xl font-bold text-slate-800">

                    Tren Indikator

                </h2>

                <p class="text-slate-500 mt-2">

                    Grafik perkembangan target dan realisasi indikator dari tahun ke tahun.

                </p>

            </div>

            <div class="px-6 py-6">

                <form id="form-tren" method="GET" action="{{ route('dashboard.trenData') }}" onsubmit="return false;">

                    <div class="grid md:grid-cols-2 gap-6">

                        <div>

                            <label class="block mb-2 font-medium text-slate-700">
                                Pilar
                            </label>

                            <select name="pilar_tren" id="pilar-tren"
                                class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600">

                                <option value="">
                                    Pilih Pilar
                                </option>

                                @foreach ($pilars as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $pilarTren == $item->id ? 'selected' : '' }}>

                                        {{ $item->nama }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div>

                            <label class="block mb-2 font-medium text-slate-700">
                                Indikator
                            </label>

                            <select name="indikator_tren" id="indikator-tren"
                                class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600"
                                {{ $indikatorsTren->isEmpty() ? 'disabled' : '' }}>

                                <option value="">
                                    Pilih Indikator
                                </option>

                                @foreach ($indikatorsTren as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $indikatorTren == $item->id ? 'selected' : '' }}>

                                        {{ $item->nama_indikator }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>

                </form>

                <div id="tren-hasil">

                    @if ($indikatorDipilih)

                        <div class="mt-6">

                            <h3 class="text-lg font-bold text-slate-800" id="tren-nama">

                                {{ $indikatorDipilih->nama_indikator }}

                            </h3>

                            <p class="text-slate-500 mt-1 text-sm" id="tren-tujuan">

                                {{ $indikatorDipilih->tujuan_strategis }}

                            </p>

                        </div>

                        <div class="relative mt-6" style="height: 360px;">

                            <canvas id="trenChart"></canvas>

                        </div>

                        @if ($dataTren->baseline)
                            <p class="mt-4 text-sm text-slate-500" id="tren-baseline">

                                Baseline:
                                <span class="font-semibold text-slate-700">{{ $dataTren->baseline['nilai'] }}</span>
                                @if ($dataTren->baseline['tahun'])
                                    (tahun {{ $dataTren->baseline['tahun'] }})
                                @endif

                            </p>
                        @endif

                    @else

                        <div class="mt-6 rounded-xl bg-slate-50 border border-slate-200 px-5 py-8 text-center text-slate-500">

                            Pilih pilar dan indikator untuk melihat grafik tren.

                        </div>

                    @endif

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-6 border-b border-slate-200">

                {{-- Judul --}}
                <div>

                    <h2 class="text-2xl font-bold text-slate-800">

                        Data Monitoring PJPK

                    </h2>

                    <p class="text-slate-500 mt-2">

                        Monitoring capaian indikator berdasarkan tahun dan pilar pembangunan kependudukan.

                    </p>

                </div>

                {{-- Tab --}}
                <div class="mt-6 flex gap-3">

                    <a href="{{ route('dashboard', [
                        'mode' => 'tahunan',
                        'tahun_id' => request('tahun_id'),
                        'pilar' => request('pilar'),
                    ]) }}"
                        class="px-6 py-3 rounded-xl font-semibold transition

                    {{ $mode == 'tahunan' ? 'bg-teal-700 text-white shadow' : 'bg-white border border-slate-300 hover:bg-slate-50' }}">

                        <span class="material-symbols-outlined align-middle mr-1">

                            calendar_month

                        </span>

                        Tahunan

                    </a>

                    <a href="{{ route('dashboard', [
                        'mode' => 'gabungan',
                        'tahun_id' => request('tahun_id'),
                        'pilar' => request('pilar'),
                    ]) }}"
                        class="px-6 py-3 rounded-xl font-semibold transition

                    {{ $mode == 'gabungan' ? 'bg-teal-700 text-white shadow' : 'bg-white border border-slate-300 hover:bg-slate-50' }}">

                        <span class="material-symbols-outlined align-middle mr-1">

                            table_chart

                        </span>

                        {{ $labelGabungan }}

                    </a>

                </div>

                {{-- Informasi --}}
                <div class="flex flex-wrap gap-3 mt-6">

                    @if ($mode == 'tahunan')
                        <span class="px-4 py-2 rounded-full bg-teal-100 text-teal-700 text-sm font-semibold">

                            Tahun :

                            {{ optional($tahuns->firstWhere('id', $tahun))->tahun }}

                        </span>
                    @endif

                    <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">

                        Pilar :

                        {{ $pilarDipilih?->nama ?? 'Semua Pilar' }}

                    </span>

                </div>

            </div>

            <div class="overflow-x-auto">

                @if ($mode == 'tahunan')

                    @foreach ($pilarsMonitoring as $pilar)
                        <div class="mt-8">

                            {{-- Header Pilar --}}
                            <div class="bg-gradient-to-r from-teal-700 to-emerald-700 text-white rounded-t-xl px-6 py-4">

                                @php
                                    $huruf = range('A', 'Z');
                                @endphp

                                <h3 class="text-lg font-bold uppercase">

                                    {{ $huruf[$pilar->urutan - 1] }}.

                                    {{ strtoupper($pilar->nama) }}

                                </h3>

                            </div>

                            <div class="overflow-x-auto">

                                <table class="w-full table-fixed border-collapse">

                                    <thead class="bg-teal-600 text-white">

                                        <tr>

                                            {{-- NO --}}
                                            <th class="border border-white px-4 py-3 text-center w-[5%]">
                                                No
                                            </th>

                                            {{-- TUJUAN STRATEGIS --}}
                                            <th class="border border-white px-4 py-3 text-left w-[22%]">
                                                Tujuan Strategis
                                            </th>

                                            {{-- INDIKATOR --}}
                                            <th class="border border-white px-4 py-3 text-left w-[20%]">
                                                Indikator
                                            </th>

                                            {{-- BASELINE --}}
                                            <th class="border border-white px-4 py-3 text-center w-[10%]">
                                                Baseline
                                            </th>

                                            {{-- SUMBER DATA --}}
                                            <th class="border border-white px-4 py-3 text-left w-[20%]">
                                                Sumber Data
                                            </th>

                                            {{-- TARGET --}}
                                            <th class="border border-white px-4 py-3 text-center w-[10%]">
                                                Target {{ optional($tahuns->firstWhere('id', $tahun))->tahun }}
                                            </th>

                                            {{-- REALISASI --}}
                                            <th class="border border-white px-4 py-3 text-center w-[10%]">
                                                Realisasi {{ optional($tahuns->firstWhere('id', $tahun))->tahun }}
                                            </th>

                                            {{-- STATUS --}}
                                            <th class="border border-white px-4 py-3 text-center w-[13%]">
                                                Status
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse($pilar->indikators as $indikator)
                                            @php

                                                $target = $indikator->targets->first();

                                                $realisasi = $indikator->realisasis->first();

                                            @endphp

                                            <tr class="hover:bg-slate-50">

                                                <td class="border border-slate-200 px-4 py-3 text-center">

                                                    {{ $loop->iteration }}

                                                </td>

                                                <td class="border border-slate-200 px-4 py-3 text-left align-top break-words">
                                                    {{ $indikator->tujuan_strategis }}
                                                </td>

                                                <td class="border border-slate-200 px-4 py-3 text-center">

                                                    {{ $indikator->nama_indikator }}

                                                </td>

                                                <td class="border border-slate-200 px-4 py-3 text-center">

                                                    {{ $indikator->nilai_baseline }}

                                                    <br>

                                                    <span class="text-xs text-slate-400">

                                                        {{ $indikator->tahun_baseline }}

                                                    </span>

                                                </td>

                                                <td class="border border-slate-200 px-4 py-3 text-center">

                                                    {{ $indikator->sumber_data ?? '-' }}

                                                </td>

                                                <td class="border border-slate-200 px-4 py-3 text-center">

                                                    {{ $target->nilai_target ?? '-' }}

                                                </td>

                                                <td class="border border-slate-200 px-4 py-3 text-center">

                                                    {{ $realisasi->nilai_realisasi ?? '-' }}

                                                </td>

                                                <td class="border border-slate-200 px-4 py-3 text-center">
                                                    @if ($realisasi)
                                                        @if ($realisasi->status_pencapaian == 'tercapai')
                                                            <span
                                                                class="inline-flex items-center justify-center whitespace-nowrap rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                                                                Tercapai
                                                            </span>
                                                        @elseif($realisasi->status_pencapaian == 'belum_tercapai')
                                                            <span
                                                                class="inline-flex items-center justify-center whitespace-nowrap rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                                                                Belum Tercapai
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center justify-center whitespace-nowrap rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600">
                                                                Belum Diisi
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="text-slate-400">-</span>
                                                    @endif
                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td colspan="9" class="text-center py-8 text-slate-500">

                                                    Belum ada indikator pada pilar ini.

                                                </td>

                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>
                    @endforeach
                @else
                    {{-- ========================= --}}
                    {{-- MODE GABUNGAN --}}
                    {{-- ========================= --}}

                    @foreach ($pilarsMonitoring as $pilar)
                        <div class="mb-10 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

                            <div class="bg-gradient-to-r from-teal-700 to-emerald-700 text-white px-6 py-4">

                                @php
                                    $huruf = range('A', 'Z');
                                @endphp

                                <h3 class="text-lg font-bold uppercase">

                                    {{ $huruf[$pilar->urutan - 1] }}.

                                    {{ strtoupper($pilar->nama) }}

                                    ({{ $tahunAwal }}-{{ $tahunAkhir }})
                                </h3>

                            </div>

                            <div class="overflow-x-auto">

                                <table class="w-full border-collapse">

                                    <thead class="bg-teal-600 text-white">

                                        <tr>

                                            <th rowspan="2" class="border border-white px-4 py-3 text-center">
                                                No
                                            </th>

                                            <th rowspan="2" class="border border-white px-4 py-3 text-left">
                                                Tujuan Strategis
                                            </th>

                                            <th rowspan="2" class="border border-white px-4 py-3 text-left">
                                                Indikator
                                            </th>

                                            <th rowspan="2" class="border border-white px-4 py-3 text-center">
                                                Baseline
                                            </th>

                                            <th rowspan="2" class="border border-white px-4 py-3 text-left">
                                                Sumber Data
                                            </th>

                                            <th colspan="{{ $tahuns->count() }}" class="px-4 py-3 border text-center">

                                                TARGET

                                            </th>

                                        </tr>

                                        <tr>

                                            @foreach ($tahuns as $item)
                                                <th class="px-4 py-3 border text-center">

                                                    {{ $item->tahun }}

                                                </th>
                                            @endforeach

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse($pilar->indikators as $indikator)
                                            <tr class="hover:bg-slate-50">

                                                <td class="border border-slate-200 px-4 py-3 text-center">

                                                    {{ $loop->iteration }}

                                                </td>

                                                <td class="border border-slate-200 px-4 py-3">

                                                    {{ $indikator->tujuan_strategis }}

                                                </td>

                                                <td class="border border-slate-200 px-4 py-3 font-medium">

                                                    {{ $indikator->nama_indikator }}

                                                </td>

                                                <td class="border border-slate-200 px-4 py-3 text-center">

                                                    {{ $indikator->nilai_baseline }}

                                                    <br>

                                                    <small class="text-slate-400">

                                                        {{ $indikator->tahun_baseline }}

                                                    </small>

                                                </td>

                                                <td class="border border-slate-200 px-4 py-3">

                                                    {{ $indikator->sumber_data ?? '-' }}

                                                </td>

                                                @foreach ($tahuns as $item)
                                                    @php

                                                        $target = $indikator->targets->firstWhere(
                                                            'tahun_id',
                                                            $item->id,
                                                        );

                                                    @endphp

                                                    <td class="border border-slate-200 px-4 py-3 text-center">

                                                        {{ $target->nilai_target ?? '-' }}

                                                    </td>
                                                @endforeach

                                            </tr>

                                        @empty

                                            <tr>

                                                <td colspan="{{ 5 + $tahuns->count() }}"
                                                    class="text-center py-8 text-slate-500">

                                                    Belum ada indikator pada pilar ini.

                                                </td>

                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>
                    @endforeach

                @endif
            </div>

        </div>

    </section>

@endsection

@push('scripts')
    <script>
        (function () {
            const pilarSelect = document.getElementById('pilar-tren');
            const indikatorSelect = document.getElementById('indikator-tren');
            const hasil = document.getElementById('tren-hasil');
            const endpoint = @json(route('dashboard.trenData'));

            if (!pilarSelect || !indikatorSelect) {
                return;
            }

            let chart = null;

            const buildDatasets = (trenData) => {
                const baselineData = { tahun: [], nilai: [] };

                if (trenData && trenData.baseline && trenData.baseline.tahun) {
                    baselineData.tahun.push(trenData.baseline.tahun);
                    baselineData.nilai.push(trenData.baseline.nilai);
                }

                return [
                    {
                        label: 'Target',
                        data: trenData ? trenData.target : [],
                        borderColor: '#0d9488',
                        backgroundColor: 'rgba(13, 148, 136, 0.1)',
                        spanGaps: false,
                        tension: 0.3,
                    },
                    {
                        label: 'Realisasi',
                        data: trenData ? trenData.realisasi : [],
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        spanGaps: false,
                        tension: 0.3,
                    },
                    {
                        label: 'Baseline',
                        data: baselineData.nilai,
                        borderColor: '#d97706',
                        backgroundColor: 'rgba(217, 119, 6, 0.2)',
                        pointStyle: 'rectRounded',
                        pointRadius: 6,
                        showLine: false,
                    },
                ];
            };

            const renderChart = (trenData) => {
                const labels = trenData ? trenData.tahun : [];

                if (chart) {
                    chart.data.labels = labels;
                    chart.data.datasets = buildDatasets(trenData);
                    chart.update();
                    return;
                }

                const ctx = document.getElementById('trenChart');

                if (!ctx) {
                    return;
                }

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: buildDatasets(trenData),
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        spanGaps: false,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tahun',
                                },
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Nilai',
                                },
                            },
                        },
                    },
                });
            };

            const muatTren = async (pilarId, indikatorId) => {
                const params = new URLSearchParams();

                if (pilarId) {
                    params.set('pilar_tren', pilarId);
                }

                if (indikatorId) {
                    params.set('indikator_tren', indikatorId);
                }

                const response = await fetch(`${endpoint}?${params.toString()}`);
                const data = await response.json();

                const pilihanAktif = indikatorSelect.value;

                indikatorSelect.innerHTML = '';
                indikatorSelect.disabled = data.indikators.length === 0;

                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = 'Pilih Indikator';
                indikatorSelect.appendChild(placeholder);

                data.indikators.forEach((ind) => {
                    const option = document.createElement('option');
                    option.value = ind.id;
                    option.textContent = ind.nama_indikator;
                    indikatorSelect.appendChild(option);
                });

                indikatorSelect.value = data.indikators.some((ind) => String(ind.id) === String(pilihanAktif))
                    ? pilihanAktif
                    : (data.indikator ? data.indikator.id : '');

                if (data.indikator && data.data_tren) {
                    hasil.innerHTML = `
                        <div class="mt-6">
                            <h3 class="text-lg font-bold text-slate-800">${data.indikator.nama_indikator}</h3>
                            <p class="text-slate-500 mt-1 text-sm">${data.indikator.tujuan_strategis}</p>
                        </div>
                        <div class="relative mt-6" style="height: 360px;">
                            <canvas id="trenChart"></canvas>
                        </div>
                        ${data.data_tren.baseline ? `
                            <p class="mt-4 text-sm text-slate-500">
                                Baseline:
                                <span class="font-semibold text-slate-700">${data.data_tren.baseline.nilai}</span>
                                ${data.data_tren.baseline.tahun ? `(tahun ${data.data_tren.baseline.tahun})` : ''}
                            </p>
                        ` : ''}
                    `;
                    chart = null;
                    renderChart(data.data_tren);
                } else if (data.indikator && !data.data_tren) {
                    hasil.innerHTML = `
                        <div class="mt-6">
                            <h3 class="text-lg font-bold text-slate-800">${data.indikator.nama_indikator}</h3>
                            <p class="text-slate-500 mt-1 text-sm">${data.indikator.tujuan_strategis}</p>
                        </div>
                        <div class="mt-6 rounded-xl bg-slate-50 border border-slate-200 px-5 py-8 text-center text-slate-500">
                            Belum ada data tren untuk indikator ini.
                        </div>
                    `;
                    chart = null;
                } else {
                    hasil.innerHTML = `
                        <div class="mt-6 rounded-xl bg-slate-50 border border-slate-200 px-5 py-8 text-center text-slate-500">
                            Pilih pilar dan indikator untuk melihat grafik tren.
                        </div>
                    `;
                    chart = null;
                }
            };

            pilarSelect.addEventListener('change', function () {
                muatTren(this.value, '');
            });

            indikatorSelect.addEventListener('change', function () {
                muatTren(pilarSelect.value, this.value);
            });

            @if ($indikatorDipilih && $dataTren && ! $dataTren->kosong())
                renderChart(@json($dataTren->toArray()));
            @endif
        })();
    </script>
@endpush
