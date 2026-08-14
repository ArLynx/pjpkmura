@extends('frontend.layouts.app')

@section('title', 'Dashboard Monitoring')

@section('content')

    <section class="bg-primary-hover">

        <div class="max-w-7xl mx-auto px-6 py-16">

            <h1 class="text-4xl font-bold text-white">

                Dashboard Monitoring

            </h1>

            <p class="text-primary-light mt-3 text-lg">

                Monitoring indikator Peta Jalan Pembangunan Kependudukan Kabupaten Murung Raya.

            </p>

        </div>

    </section>

    <section class="max-w-7xl mx-auto px-6 py-10">

        {{-- Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">

            <form method="GET" action="{{ route('dashboard') }}">

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- Tahun --}}
                    <div>

                        <label class="block mb-2 font-medium text-slate-700">

                            Tahun

                        </label>

                        <select name="tahun" onchange="this.form.submit()"
                            class="w-full rounded-xl border-slate-300 focus:border-primary focus:ring-primary">

                            @foreach ($tahuns as $item)
                                <option value="{{ $item }}"
                                    {{ request('tahun', $tahun) == $item ? 'selected' : '' }}>

                                    {{ $item }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                    {{-- Pilar --}}
                    <div>

                        <label class="block mb-2 font-medium text-slate-700">

                            Pilar

                        </label>

                        <select name="pilar" onchange="this.form.submit()"
                            class="w-full rounded-xl border-slate-300 focus:border-primary focus:ring-primary">

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

                    <div class="w-14 h-14 rounded-xl bg-primary-light flex items-center justify-center">

                        <span class="material-symbols-outlined text-primary text-3xl">

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

                    <div class="w-14 h-14 rounded-xl bg-primary-light flex items-center justify-center">

                        <span class="material-symbols-outlined text-primary text-3xl">

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

                    <div class="w-14 h-14 rounded-xl bg-primary-light flex items-center justify-center">

                        <span class="material-symbols-outlined text-primary text-3xl">

                            check_circle

                        </span>

                    </div>

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
                        'tahun' => request('tahun'),
                        'pilar' => request('pilar'),
                    ]) }}"
                        class="px-6 py-3 rounded-xl font-semibold transition
                        {{ $mode == 'tahunan' ? 'bg-primary text-white shadow' : 'bg-white border border-slate-300 hover:bg-slate-50' }}">

                        <span class="material-symbols-outlined align-middle mr-1">

                            calendar_month

                        </span>

                        Tahunan

                    </a>

                    <a href="{{ route('dashboard', [
                        'mode' => 'gabungan',
                        'tahun' => request('tahun'),
                        'pilar' => request('pilar'),
                    ]) }}"
                        class="px-6 py-3 rounded-xl font-semibold transition
                        {{ $mode == 'gabungan' ? 'bg-primary text-white shadow' : 'bg-white border border-slate-300 hover:bg-slate-50' }}">

                        <span class="material-symbols-outlined align-middle mr-1">

                            table_chart

                        </span>

                        {{ $labelGabungan }}

                    </a>

                </div>

                {{-- Informasi --}}
                <div class="flex flex-wrap gap-3 mt-6">

                    @if ($mode == 'tahunan')
                        <span class="px-4 py-2 rounded-full bg-primary-light text-primary text-sm font-semibold">

                            Tahun :

                            {{ $tahun }}

                        </span>
                    @endif

                    <span class="px-4 py-2 rounded-full bg-primary-light text-primary text-sm font-semibold">

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
                            <div class="bg-gradient-to-r from-primary to-primary-hover text-white rounded-t-xl px-6 py-4">

                                @php
                                    $huruf = range('A', 'Z');
                                @endphp

                                <h3 class="text-lg font-bold uppercase">

                                    {{ $huruf[$loop->index] }}.

                                    {{ strtoupper($pilar->nama) }}

                                </h3>

                            </div>

                            <div class="overflow-x-auto">

                                <table class="w-full border-collapse">

                                    <thead class="bg-primary text-white">

                                        <tr>

                                            <th class="border border-white px-4 py-3 w-16 text-center">

                                                No

                                            </th>

                                            <th class="border border-white px-4 py-3 text-left">

                                                Tujuan Strategis

                                            </th>

                                            <th class="border border-white px-4 py-3 text-left">

                                                Indikator

                                            </th>

                                            <th class="border border-white px-4 py-3 text-center">

                                                Baseline

                                            </th>

                                            <th class="border border-white px-4 py-3 text-left">

                                                Sumber Data

                                            </th>

                                            <th class="border border-white px-4 py-3 text-center">

                                                Target {{ $tahun }}

                                            </th>

                                            <th class="border border-white px-4 py-3 text-center">

                                                Realisasi

                                            </th>

                                            <th class="border border-white px-4 py-3 text-center">

                                                Status

                                            </th>

                                            <th class="border border-white px-4 py-3 text-center">

                                                Pendukung

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

                                                <td class="border border-slate-200 px-4 py-3 text-center">

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
                                                                class="px-3 py-1 rounded-full bg-primary-light text-primary text-xs">

                                                                Tercapai

                                                            </span>
                                                        @elseif($realisasi->status_pencapaian == 'belum_tercapai')
                                                            <span
                                                                class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs">

                                                                Belum Tercapai

                                                            </span>
                                                        @else
                                                            <span
                                                                class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs">

                                                                Belum Diisi

                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="text-slate-400">

                                                            -

                                                        </span>
                                                    @endif

                                                </td>

                                                <td class="border border-slate-200 px-4 py-3 text-center">

                                                    @if ($realisasi && $realisasi->dataPendukungs->count())
                                                        <span class="text-primary font-semibold">

                                                            {{ $realisasi->dataPendukungs->count() }} File

                                                        </span>
                                                    @else
                                                        <span class="text-slate-400">

                                                            -

                                                        </span>
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

                            <div class="bg-gradient-to-r from-primary to-primary-hover text-white px-6 py-4">

                                @php
                                    $huruf = range('A', 'Z');
                                @endphp

                                <h3 class="text-lg font-bold uppercase">

                                    {{ $huruf[$loop->index] }}.

                                    {{ strtoupper($pilar->nama) }}

                                    ({{ $tahunAwal }}-{{ $tahunAkhir }})
                                </h3>

                            </div>

                            <div class="overflow-x-auto">

                                <table class="w-full border-collapse">

                                    <thead class="bg-primary text-white">

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

                                                    {{ $item }}

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

                                                        $target = $indikator->targets->firstWhere('tahun', $item);

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
