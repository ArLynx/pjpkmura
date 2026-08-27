@extends('frontend.layouts.app')

@section('title', 'Dashboard Monitoring')

@section('content')

    <main class="min-h-screen bg-slate-50">

        {{-- ========================================================= --}}
        {{-- DASHBOARD HEADER --}}
        {{-- ========================================================= --}}

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


        <section class="max-w-7xl mx-auto px-6 py-8">

            <section class="flex flex-col lg:flex-row gap-6 mb-10">

                {{-- ===================================================== --}}
                {{-- TREN CAPAIAN PJPK --}}
                {{-- ===================================================== --}}

                <div class="w-full lg:flex-[2.5] bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">

                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">

                        <div>

                            <h4 class="text-xl font-semibold text-slate-900">
                                Tren Capaian PJPK 2025–2030
                            </h4>

                            <p class="mt-1 text-sm text-slate-500">
                                Target Kinerja vs Realisasi Tahunan
                            </p>

                        </div>

                        <div class="flex gap-4">

                            <div class="flex items-center gap-2">

                                <span class="w-3 h-3 rounded-full bg-primary"></span>

                                <span class="text-xs font-medium text-slate-600">
                                    Target
                                </span>

                            </div>

                            <div class="flex items-center gap-2">

                                <span class="w-3 h-3 rounded-full bg-primary-light border border-primary"></span>

                                <span class="text-xs font-medium text-slate-600">
                                    Realisasi
                                </span>

                            </div>

                        </div>

                    </div>

                    <div class="w-full rounded-xl border border-slate-200 overflow-hidden bg-white">

                        <img src="/image/pjpk.jpg" alt="PJPK Achievement Trends 2025-2030 Chart"
                            class="w-full h-auto object-contain block">

                    </div>

                </div>

                {{-- ===================================================== --}}
                {{-- STATUS INDIKATOR --}}
                {{-- ===================================================== --}}

                <div
                    class="w-full lg:flex-1 bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm flex flex-col">

                    <h4 class="text-xl font-semibold text-slate-900">
                        Status Indikator Tahun 2025
                    </h4>

                    <p class="mt-1 text-sm text-slate-500">
                        Proporsi pencapaian per indikator
                    </p>

                    <div class="flex-grow flex items-center justify-center relative my-8">

                        <div class="w-40 h-40 rounded-full border-8 border-slate-100 flex items-center justify-center">

                            <div class="text-center">

                                <span class="text-3xl font-bold text-slate-700">
                                    0%
                                </span>

                                <p class="mt-1 text-xs text-slate-500">
                                    Total Progres
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-3">

                        <div class="flex items-center gap-2">

                            <div class="w-2 h-2 rounded-full bg-green-600"></div>

                            <span class="text-xs text-slate-600">
                                Tercapai: {{ $jumlahTercapai }}
                            </span>

                        </div>

                        <div class="flex items-center gap-2">

                            <div class="w-2 h-2 rounded-full bg-red-600"></div>

                            <span class="text-xs text-slate-600">
                                Belum: 0
                            </span>

                        </div>

                        <div class="flex items-center gap-2">

                            <div class="w-2 h-2 rounded-full bg-amber-600"></div>

                            <span class="text-xs text-slate-600">
                                Verifikasi: 0
                            </span>

                        </div>

                        <div class="flex items-center gap-2">

                            <div class="w-2 h-2 rounded-full bg-slate-500"></div>

                            <span class="text-xs text-slate-600">
                                Belum Isi: 30
                            </span>

                        </div>

                    </div>

                </div>

            </section>

            {{-- ========================================================= --}}
            {{-- FIVE PILLARS --}}
            {{-- ========================================================= --}}

            <section class="mb-10">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                    <h4 class="text-2xl font-bold text-slate-900">
                        Ringkasan 5 Pilar PJPK
                    </h4>

                    <button type="button"
                        class="text-primary text-sm font-semibold inline-flex items-center gap-1 hover:underline">

                        Detail Pilar

                        <span class="material-symbols-outlined text-lg">
                            chevron_right
                        </span>

                    </button>

                </div>


                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-5">

                    {{-- Pilar A --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-full">

                        <div class="mb-6">

                            <h5 class="text-lg font-semibold text-slate-900 mb-2">
                                Pilar A
                            </h5>

                            <p class="text-sm leading-5 text-slate-500">
                                Pengendalian Kuantitas Penduduk
                            </p>

                        </div>

                        <div class="mt-auto">

                            <div class="flex justify-between items-end mb-2">

                                <span class="text-xs font-medium text-slate-600">
                                    6 Indikator
                                </span>

                                <span class="text-xs font-semibold text-primary">
                                    0%
                                </span>

                            </div>

                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">

                                <div class="h-full bg-primary rounded-full" style="width: 0%"></div>

                            </div>

                        </div>

                    </div>

                    {{-- Pilar B --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-full">

                        <div class="mb-6">

                            <h5 class="text-lg font-semibold text-slate-900 mb-2">
                                Pilar B
                            </h5>

                            <p class="text-sm leading-5 text-slate-500">
                                Peningkatan Kualitas Penduduk
                            </p>

                        </div>

                        <div class="mt-auto">

                            <div class="flex justify-between items-end mb-2">

                                <span class="text-xs font-medium text-slate-600">
                                    8 Indikator
                                </span>

                                <span class="text-xs font-semibold text-primary">
                                    0%
                                </span>

                            </div>

                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">

                                <div class="h-full bg-primary rounded-full" style="width: 0%"></div>

                            </div>

                        </div>

                    </div>

                    {{-- Pilar C --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-full">

                        <div class="mb-6">

                            <h5 class="text-lg font-semibold text-slate-900 mb-2">
                                Pilar C
                            </h5>

                            <p class="text-sm leading-5 text-slate-500">
                                Pengarahan Persebaran Penduduk
                            </p>

                        </div>

                        <div class="mt-auto">

                            <div class="flex justify-between items-end mb-2">

                                <span class="text-xs font-medium text-slate-600">
                                    4 Indikator
                                </span>

                                <span class="text-xs font-semibold text-primary">
                                    0%
                                </span>

                            </div>

                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">

                                <div class="h-full bg-primary rounded-full" style="width: 0%"></div>

                            </div>

                        </div>

                    </div>

                    {{-- Pilar D --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-full">

                        <div class="mb-6">

                            <h5 class="text-lg font-semibold text-slate-900 mb-2">
                                Pilar D
                            </h5>

                            <p class="text-sm leading-5 text-slate-500">
                                Pembangunan Keluarga Berencana
                            </p>

                        </div>

                        <div class="mt-auto">

                            <div class="flex justify-between items-end mb-2">

                                <span class="text-xs font-medium text-slate-600">
                                    7 Indikator
                                </span>

                                <span class="text-xs font-semibold text-primary">
                                    0%
                                </span>

                            </div>

                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">

                                <div class="h-full bg-primary rounded-full" style="width: 0%"></div>

                            </div>

                        </div>

                    </div>

                    {{-- Pilar E --}}
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-full">

                        <div class="mb-6">

                            <h5 class="text-lg font-semibold text-slate-900 mb-2">
                                Pilar E
                            </h5>

                            <p class="text-sm leading-5 text-slate-500">
                                Penataan Administrasi Kependudukan
                            </p>

                        </div>

                        <div class="mt-auto">

                            <div class="flex justify-between items-end mb-2">

                                <span class="text-xs font-medium text-slate-600">
                                    5 Indikator
                                </span>

                                <span class="text-xs font-semibold text-primary">
                                    0%
                                </span>

                            </div>

                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">

                                <div class="h-full bg-primary rounded-full" style="width: 0%"></div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

            {{-- ========================================================= --}}
            {{-- STATIC SUMMARY TABLE --}}
            {{-- ========================================================= --}}
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-10">

                <div class="p-6 md:p-8 border-b border-slate-200">

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

                        <div>

                            <h4 class="text-2xl font-bold text-slate-900">
                                Ringkasan Indikator Tahun 2025
                            </h4>

                            <p class="mt-1 text-sm text-slate-500">
                                Detail target dan realisasi indikator strategis daerah
                            </p>

                        </div>

                        <div class="flex gap-2 w-full md:w-auto">

                            <div class="relative w-full md:w-64">

                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                    search
                                </span>

                                <input type="text" placeholder="Cari indikator..."
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary">

                            </div>

                            <button type="button"
                                class="p-2.5 bg-slate-50 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">

                                <span class="material-symbols-outlined">
                                    download
                                </span>

                            </button>

                        </div>

                    </div>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-8 py-4 text-xs font-semibold text-slate-500 uppercase">
                                    Indikator
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">
                                    Pilar
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase text-right">
                                    Target 2025
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase text-right">
                                    Realisasi
                                </th>

                                <th class="px-8 py-4 text-xs font-semibold text-slate-500 uppercase text-center">
                                    Status
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            {{-- STATIC ROW 1 --}}
                            <tr class="hover:bg-slate-50 transition-colors">

                                <td class="px-8 py-5 text-sm font-semibold text-slate-800">
                                    Total Fertility Rate (TFR)
                                </td>

                                <td class="px-6 py-5">

                                    <span
                                        class="bg-primary-light text-primary px-3 py-1 rounded-full text-xs font-semibold">
                                        Pilar A
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-sm text-slate-700 text-right">
                                    2.21
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-400 text-right">
                                    -
                                </td>

                                <td class="px-8 py-5 text-center">

                                    <span
                                        class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1">

                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>

                                        Belum Diisi

                                    </span>

                                </td>

                            </tr>


                            {{-- STATIC ROW 2 --}}
                            <tr class="hover:bg-slate-50 transition-colors">

                                <td class="px-8 py-5 text-sm font-semibold text-slate-800">
                                    Prevalensi Stunting
                                </td>

                                <td class="px-6 py-5">

                                    <span
                                        class="bg-primary-light text-primary px-3 py-1 rounded-full text-xs font-semibold">
                                        Pilar B
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-sm text-slate-700 text-right">
                                    14.5%
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-400 text-right">
                                    -
                                </td>

                                <td class="px-8 py-5 text-center">

                                    <span
                                        class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1">

                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>

                                        Belum Diisi

                                    </span>

                                </td>

                            </tr>


                            {{-- STATIC ROW 3 --}}
                            <tr class="hover:bg-slate-50 transition-colors">

                                <td class="px-8 py-5 text-sm font-semibold text-slate-800">
                                    Gini Ratio
                                </td>

                                <td class="px-6 py-5">

                                    <span
                                        class="bg-primary-light text-primary px-3 py-1 rounded-full text-xs font-semibold">
                                        Pilar B
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-sm text-slate-700 text-right">
                                    0.320
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-400 text-right">
                                    -
                                </td>

                                <td class="px-8 py-5 text-center">

                                    <span
                                        class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1">

                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>

                                        Belum Diisi

                                    </span>

                                </td>

                            </tr>


                            {{-- STATIC ROW 4 --}}
                            <tr class="hover:bg-slate-50 transition-colors">

                                <td class="px-8 py-5 text-sm font-semibold text-slate-800">
                                    Persentase Migrasi Masuk
                                </td>

                                <td class="px-6 py-5">

                                    <span
                                        class="bg-primary-light text-primary px-3 py-1 rounded-full text-xs font-semibold">
                                        Pilar C
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-sm text-slate-700 text-right">
                                    2.5%
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-400 text-right">
                                    -
                                </td>

                                <td class="px-8 py-5 text-center">

                                    <span
                                        class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1">

                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>

                                        Belum Diisi

                                    </span>

                                </td>

                            </tr>


                            {{-- STATIC ROW 5 --}}
                            <tr class="hover:bg-slate-50 transition-colors">

                                <td class="px-8 py-5 text-sm font-semibold text-slate-800">
                                    Unmet Need KB
                                </td>

                                <td class="px-6 py-5">

                                    <span
                                        class="bg-primary-light text-primary px-3 py-1 rounded-full text-xs font-semibold">
                                        Pilar D
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-sm text-slate-700 text-right">
                                    7.2%
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-400 text-right">
                                    -
                                </td>

                                <td class="px-8 py-5 text-center">

                                    <span
                                        class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1">

                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>

                                        Belum Diisi

                                    </span>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                <div class="p-6 bg-slate-50 flex justify-center items-center gap-4">

                    <button type="button"
                        class="p-2 border border-slate-200 rounded-xl text-slate-400 opacity-50 cursor-not-allowed"
                        disabled>

                        <span class="material-symbols-outlined">
                            chevron_left
                        </span>

                    </button>

                    <span class="text-sm font-medium text-slate-600">
                        Halaman 1 dari 6
                    </span>

                    <button type="button" class="p-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-white">

                        <span class="material-symbols-outlined">
                            chevron_right
                        </span>

                    </button>

                </div>

            </section>

            {{-- ========================================================= --}}
            {{-- FILTER --}}
            {{-- ========================================================= --}}
            <section class="mb-8">

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:p-6">

                    {{-- FORM FILTER --}}
                    <form method="GET" action="{{ route('dashboard') }}" id="filterForm">

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-[1fr_1fr_1fr_auto] xl:items-end">

                            {{-- ================================================= --}}
                            {{-- PILAR --}}
                            {{-- ================================================= --}}
                            <div class="relative">

                                <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Pilar
                                </label>

                                <button type="button" id="pilarButton"
                                    class="flex w-full items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-left text-sm font-medium text-slate-700 transition-all duration-200 hover:border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20">

                                    <span id="pilarText" class="truncate pr-3">
                                        Semua Pilar
                                    </span>

                                    <span id="pilarIcon"
                                        class="material-symbols-outlined shrink-0 text-[20px] text-slate-500 transition-transform duration-200">
                                        expand_more
                                    </span>

                                </button>

                                {{-- PILAR DROPDOWN --}}
                                <div id="pilarDropdown"
                                    class="absolute left-0 right-0 top-full z-50 mt-2 hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">

                                    <div class="max-h-64 overflow-y-auto py-1">

                                        <button type="button" data-value="" data-text="Semua Pilar"
                                            class="pilar-option flex w-full items-center px-4 py-3 text-left text-sm font-medium text-slate-700 transition-colors hover:bg-primary-light hover:text-primary">
                                            Semua Pilar
                                        </button>

                                        @foreach ($pilars as $pilar)
                                            <button type="button" data-value="{{ $pilar->id }}"
                                                data-text="{{ $pilar->nama }}"
                                                class="pilar-option flex w-full items-center px-4 py-3 text-left text-sm font-medium text-slate-700 transition-colors hover:bg-primary-light hover:text-primary">

                                                <span class="truncate">
                                                    {{ $pilar->nama }}
                                                </span>

                                            </button>
                                        @endforeach

                                    </div>

                                </div>

                                <input type="hidden" name="pilar" id="pilarInput" value="{{ request('pilar') }}">

                            </div>


                            {{-- ================================================= --}}
                            {{-- INSTANSI --}}
                            {{-- ================================================= --}}
                            <div class="relative">

                                <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Instansi
                                </label>

                                <button type="button" id="instansiButton"
                                    class="flex w-full items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-left text-sm font-medium text-slate-700 transition-all duration-200 hover:border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20">

                                    <span id="instansiText" class="truncate pr-3">
                                        Semua Instansi
                                    </span>

                                    <span id="instansiIcon"
                                        class="material-symbols-outlined shrink-0 text-[20px] text-slate-500 transition-transform duration-200">
                                        expand_more
                                    </span>

                                </button>

                                {{-- INSTANSI DROPDOWN --}}
                                <div id="instansiDropdown"
                                    class="absolute left-0 right-0 top-full z-50 mt-2 hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">

                                    <div class="max-h-64 overflow-y-auto py-1">

                                        <button type="button" data-value="" data-text="Semua Instansi"
                                            class="instansi-option flex w-full items-center px-4 py-3 text-left text-sm font-medium text-slate-700 transition-colors hover:bg-primary-light hover:text-primary">

                                            Semua Instansi

                                        </button>

                                        @foreach ($instansis as $item)
                                            <button type="button" data-value="{{ $item->id }}"
                                                data-text="{{ $item->nama }}"
                                                class="instansi-option flex w-full items-center px-4 py-3 text-left text-sm font-medium text-slate-700 transition-colors hover:bg-primary-light hover:text-primary">

                                                <span class="truncate">
                                                    {{ $item->nama }}
                                                </span>

                                            </button>
                                        @endforeach

                                    </div>

                                </div>

                                <input type="hidden" name="instansi_id" id="instansiInput"
                                    value="{{ request('instansi_id') }}">

                            </div>


                            {{-- ================================================= --}}
                            {{-- TAHUN --}}
                            {{-- ================================================= --}}
                            <div class="relative">

                                <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Tahun
                                </label>

                                <button type="button" id="tahunButton"
                                    class="flex w-full items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-left text-sm font-medium text-slate-700 transition-all duration-200 hover:border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20">

                                    <span id="tahunText" class="truncate pr-3">
                                        {{ $tahuns->firstWhere('id', request('tahun_id', $tahun))->tahun ?? $tahun }}
                                    </span>

                                    <span id="tahunIcon"
                                        class="material-symbols-outlined shrink-0 text-[20px] text-slate-500 transition-transform duration-200">
                                        expand_more
                                    </span>

                                </button>

                                {{-- TAHUN DROPDOWN --}}
                                <div id="tahunDropdown"
                                    class="absolute left-0 right-0 top-full z-50 mt-2 hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">

                                    <div class="max-h-64 overflow-y-auto py-1">

                                        @foreach ($tahuns as $item)
                                            <button type="button" data-value="{{ $item->id }}"
                                                data-text="{{ $item->tahun }}"
                                                class="tahun-option flex w-full items-center px-4 py-3 text-left text-sm font-medium text-slate-700 transition-colors hover:bg-primary-light hover:text-primary">

                                                {{ $item->tahun }}

                                            </button>
                                        @endforeach

                                    </div>

                                </div>

                                <input type="hidden" name="tahun_id" id="tahunInput"
                                    value="{{ request('tahun_id', $tahun) }}">

                            </div>


                            {{-- ================================================= --}}
                            {{-- RESET FILTER --}}
                            {{-- ================================================= --}}
                            <div class="xl:pl-2">

                                <a href="{{ route('dashboard', ['mode' => $mode]) }}"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary-light px-5 py-3 text-sm font-semibold text-primary transition-colors hover:bg-primary hover:text-white xl:w-auto xl:min-w-[170px]">

                                    <span class="material-symbols-outlined text-[20px]">
                                        restart_alt
                                    </span>

                                    Reset Filter

                                </a>

                            </div>

                        </div>

                    </form>

                    {{-- ========================================================= --}}
                    {{-- KETERANGAN FILTER --}}
                    {{-- ========================================================= --}}
                    <div class="mt-5 border-t border-slate-200 pt-5">

                        <div class="border border-primary/20 bg-primary-light px-5 py-4">

                            <div class="flex items-start gap-3">

                                <span class="material-symbols-outlined shrink-0 text-primary">
                                    info
                                </span>

                                <div class="text-sm leading-relaxed text-slate-600">

                                    <p class="mb-1 font-semibold text-primary">
                                        Cara menggunakan filter
                                    </p>

                                    <p>
                                        Gunakan filter
                                        <strong>Tahun</strong>,
                                        <strong>Pilar</strong>, dan
                                        <strong>Instansi</strong>
                                        untuk menampilkan data indikator sesuai kebutuhan.
                                    </p>

                                    <ul class="mt-2 list-inside list-disc space-y-1">

                                        <li>
                                            Pilih <strong>Tahun</strong> untuk melihat data indikator pada tahun tertentu.
                                        </li>

                                        <li>
                                            Pilih <strong>Pilar</strong> untuk melihat indikator pada pilar tertentu sesuai
                                            dengan <strong>tahun yang dipilih</strong>.
                                        </li>

                                        <li>
                                            Pilih <strong>Instansi</strong> untuk melihat indikator yang menjadi tanggung
                                            jawab instansi sesuai dengan <strong>tahun yang dipilih</strong>.
                                        </li>

                                        <li>
                                            Pilih <strong>Instansi dan Pilar</strong> untuk melihat indikator dari instansi
                                            tertentu pada pilar dan tahun yang dipilih.
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

                    </div>

                </div>

            </section>

            <section class="grid grid-cols-1 gap-4 mb-10 sm:grid-cols-2 xl:grid-cols-4">

                {{-- ========================================================= --}}
                {{-- TOTAL PILAR --}}
                {{-- ========================================================= --}}
                <div
                    class="min-w-0 group flex flex-col bg-white p-4 rounded-2xl border border-slate-200 shadow-sm transition hover:border-primary">

                    <div class="flex justify-between items-start mb-3">

                        <div
                            class="w-10 h-10 rounded-full bg-primary-light flex items-center justify-center text-primary transition group-hover:bg-primary group-hover:text-white">

                            <span class="material-symbols-outlined text-[20px]">
                                account_tree
                            </span>

                        </div>

                    </div>

                    <p class="text-lg font-semibold text-slate-900 mb-2">
                        Total Pilar
                    </p>

                    <p class="text-sm leading-5 text-slate-500">
                        Jumlah pilar pembangunan kependudukan.
                    </p>

                    <h3 class="mt-auto pt-4 text-2xl font-bold text-slate-900">
                        {{ $jumlahPilar }}
                    </h3>

                </div>


                {{-- ========================================================= --}}
                {{-- TOTAL INDIKATOR --}}
                {{-- ========================================================= --}}
                <div
                    class="min-w-0 group flex flex-col bg-white p-4 rounded-2xl border border-slate-200 shadow-sm transition hover:border-primary">

                    <div class="flex justify-between items-start mb-3">

                        <div
                            class="w-10 h-10 rounded-full bg-primary-light flex items-center justify-center text-primary transition group-hover:bg-primary group-hover:text-white">

                            <span class="material-symbols-outlined text-[20px]">
                                data_exploration
                            </span>

                        </div>

                    </div>

                    <p class="text-lg font-semibold text-slate-900 mb-2">
                        Total Indikator
                    </p>

                    <p class="text-sm leading-5 text-slate-500">
                        Jumlah indikator sesuai filter yang dipilih.
                    </p>

                    <h3 class="mt-auto pt-4 text-2xl font-bold text-slate-900">
                        {{ $jumlahIndikator }}
                    </h3>

                </div>


                {{-- ========================================================= --}}
                {{-- TARGET --}}
                {{-- ========================================================= --}}
                <div
                    class="min-w-0 group flex flex-col bg-white p-4 rounded-2xl border border-slate-200 shadow-sm transition hover:border-primary">

                    <div class="flex justify-between items-start mb-3">

                        <div
                            class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-600 transition group-hover:bg-amber-600 group-hover:text-white">

                            <span class="material-symbols-outlined text-[20px]">
                                flag
                            </span>

                        </div>

                    </div>

                    <p class="text-lg font-semibold text-slate-900 mb-2">
                        {{ $mode == 'tahunan' ? "Target $tahun" : 'Total Target' }}
                    </p>

                    <p class="text-sm leading-5 text-slate-500">

                        @if ($mode == 'tahunan')
                            Jumlah target indikator tahun {{ $tahun }}.
                        @else
                            Jumlah target indikator periode {{ $tahunAwal }} - {{ $tahunAkhir }}.
                        @endif

                    </p>

                    <h3 class="mt-auto pt-4 text-2xl font-bold text-slate-900">
                        {{ $jumlahTarget }}
                    </h3>

                </div>


                {{-- ========================================================= --}}
                {{-- TERCAPAI --}}
                {{-- ========================================================= --}}
                <div
                    class="min-w-0 group flex flex-col bg-white p-4 rounded-2xl border border-slate-200 shadow-sm transition hover:border-primary">

                    <div class="flex justify-between items-start mb-3">

                        <div
                            class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600 transition group-hover:bg-green-600 group-hover:text-white">

                            <span class="material-symbols-outlined text-[20px]">
                                check_circle
                            </span>

                        </div>

                    </div>

                    <p class="text-lg font-semibold text-slate-900 mb-2">
                        {{ $mode == 'tahunan' ? 'Target Tercapai' : 'Total Tercapai' }}
                    </p>

                    <p class="text-sm leading-5 text-slate-500">

                        @if ($mode == 'tahunan')
                            Jumlah indikator yang mencapai target tahun {{ $tahun }}.
                        @else
                            Jumlah indikator yang mencapai target selama periode
                            {{ $tahunAwal }} - {{ $tahunAkhir }}.
                        @endif

                    </p>

                    <h3 class="mt-auto pt-4 text-2xl font-bold text-slate-900">
                        {{ $jumlahTercapai }}
                    </h3>

                </div>

            </section>


            {{-- ========================================================= --}}
            {{-- DATA MONITORING DINAMIS --}}
            {{-- ========================================================= --}}

            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- ========================================================= --}}
                {{-- HEADER CARD UTAMA --}}
                {{-- ========================================================= --}}

                <div class="border-b border-slate-200 p-6 md:p-8">

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                        <div>

                            <h2 class="text-2xl font-bold text-slate-900">
                                Data Monitoring PJPK
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                Monitoring capaian indikator berdasarkan tahun dan pilar pembangunan kependudukan.
                            </p>

                        </div>


                        {{-- MODE --}}
                        <div class="flex flex-wrap gap-2">

                            <a href="{{ route('dashboard', [
                                'mode' => 'tahunan',
                                'tahun_id' => request('tahun_id'),
                                'pilar' => request('pilar'),
                            ]) }}"
                                class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold transition
                    {{ $mode == 'tahunan'
                        ? 'bg-primary text-white shadow-sm'
                        : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">

                                <span class="material-symbols-outlined text-lg">
                                    calendar_month
                                </span>

                                Tahunan

                            </a>


                            <a href="{{ route('dashboard', [
                                'mode' => 'gabungan',
                                'tahun_id' => request('tahun_id'),
                                'pilar' => request('pilar'),
                            ]) }}"
                                class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold transition
                    {{ $mode == 'gabungan'
                        ? 'bg-primary text-white shadow-sm'
                        : 'border border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">

                                <span class="material-symbols-outlined text-lg">
                                    table_chart
                                </span>

                                {{ $labelGabungan }}

                            </a>

                        </div>

                    </div>


                    {{-- FILTER INFO --}}
                    <div class="mt-5 flex flex-wrap gap-2">

                        @if ($mode == 'tahunan')
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-primary-light px-3 py-1.5 text-xs font-semibold text-primary">

                                <span class="material-symbols-outlined text-sm">
                                    calendar_month
                                </span>

                                Tahun:
                                {{ optional($tahuns->firstWhere('id', $tahun))->tahun }}

                            </span>
                        @endif


                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-primary-light px-3 py-1.5 text-xs font-semibold text-primary">

                            <span class="material-symbols-outlined text-sm">
                                account_tree
                            </span>

                            Pilar:
                            {{ $pilarDipilih?->nama ?? 'Semua Pilar' }}

                        </span>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- AREA SEMUA TABEL --}}
                {{-- ========================================================= --}}

                <div class="py-6 md:py-8">

                    @if ($mode == 'tahunan')

                        {{-- ================================================= --}}
                        {{-- MODE TAHUNAN --}}
                        {{-- ================================================= --}}

                        @foreach ($pilarsMonitoring as $pilar)
                            <div
                                class="mx-4 mb-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm last:mb-0 md:mx-6 lg:mx-8">

                                {{-- HEADER PILAR --}}
                                <div class="bg-primary px-5 py-4 md:px-6">

                                    @php
                                        $huruf = range('A', 'Z');
                                    @endphp

                                    <h3 class="text-sm font-bold uppercase tracking-wide text-white md:text-base">

                                        {{ $huruf[$pilar->urutan - 1] }}.

                                        {{ strtoupper($pilar->nama) }}

                                    </h3>

                                </div>


                                {{-- TABLE --}}
                                <div class="overflow-x-auto">

                                    <table class="w-full min-w-[1100px] table-fixed border-collapse">

                                        <thead class="bg-primary-hover text-white">

                                            <tr>

                                                <th class="w-[5%] px-4 py-3 text-center text-xs font-semibold uppercase">
                                                    No
                                                </th>

                                                <th class="w-[22%] px-4 py-3 text-left text-xs font-semibold uppercase">
                                                    Tujuan Strategis
                                                </th>

                                                <th class="w-[20%] px-4 py-3 text-left text-xs font-semibold uppercase">
                                                    Indikator
                                                </th>

                                                <th class="w-[10%] px-4 py-3 text-center text-xs font-semibold uppercase">
                                                    Baseline
                                                </th>

                                                <th class="w-[20%] px-4 py-3 text-left text-xs font-semibold uppercase">
                                                    Sumber Data
                                                </th>

                                                <th class="w-[10%] px-4 py-3 text-center text-xs font-semibold uppercase">
                                                    Target
                                                    {{ optional($tahuns->firstWhere('id', $tahun))->tahun }}
                                                </th>

                                                <th class="w-[10%] px-4 py-3 text-center text-xs font-semibold uppercase">
                                                    Realisasi
                                                    {{ optional($tahuns->firstWhere('id', $tahun))->tahun }}
                                                </th>

                                                <th class="w-[13%] px-4 py-3 text-center text-xs font-semibold uppercase">
                                                    Status
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                            @forelse ($pilar->indikators as $indikator)
                                                @php
                                                    $target = $indikator->targets->first();
                                                    $realisasi = $indikator->realisasis->first();
                                                @endphp

                                                <tr
                                                    class="border-b border-slate-100 last:border-b-0 transition-colors hover:bg-primary-light">

                                                    {{-- NO --}}
                                                    <td class="px-4 py-4 text-center text-sm text-slate-600">
                                                        {{ $loop->iteration }}
                                                    </td>


                                                    {{-- TUJUAN --}}
                                                    <td
                                                        class="break-words px-4 py-4 align-top text-sm leading-6 text-slate-700">

                                                        {{ $indikator->tujuan_strategis }}

                                                    </td>


                                                    {{-- INDIKATOR --}}
                                                    <td
                                                        class="px-4 py-4 align-top text-sm font-medium leading-6 text-slate-800">

                                                        {{ $indikator->nama_indikator }}

                                                    </td>


                                                    {{-- BASELINE --}}
                                                    <td class="px-4 py-4 text-center text-sm text-slate-700">

                                                        {{ $indikator->nilai_baseline }}

                                                        <span class="mt-1 block text-xs text-slate-400">
                                                            {{ $indikator->tahun_baseline }}
                                                        </span>

                                                    </td>


                                                    {{-- SUMBER DATA --}}
                                                    <td class="px-4 py-4 text-sm leading-6 text-slate-600">

                                                        {{ $indikator->sumber_data ?? '-' }}

                                                    </td>


                                                    {{-- TARGET --}}
                                                    <td class="px-4 py-4 text-center text-sm font-semibold text-slate-800">

                                                        {{ $target->nilai_target ?? '-' }}

                                                    </td>


                                                    {{-- REALISASI --}}
                                                    <td class="px-4 py-4 text-center text-sm font-semibold text-slate-800">

                                                        {{ $realisasi->nilai_realisasi ?? '-' }}

                                                    </td>


                                                    {{-- STATUS --}}
                                                    <td class="px-4 py-4 text-center">

                                                        @if ($realisasi)
                                                            @if ($realisasi->status_pencapaian == 'tercapai')
                                                                <span
                                                                    class="inline-flex items-center justify-center whitespace-nowrap rounded-full bg-primary-light px-3 py-1.5 text-xs font-semibold text-primary">

                                                                    <span
                                                                        class="mr-1.5 h-1.5 w-1.5 rounded-full bg-primary"></span>

                                                                    Tercapai

                                                                </span>
                                                            @elseif ($realisasi->status_pencapaian == 'belum_tercapai')
                                                                <span
                                                                    class="inline-flex items-center justify-center whitespace-nowrap rounded-full bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600">

                                                                    <span
                                                                        class="mr-1.5 h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                                                    Belum Tercapai

                                                                </span>
                                                            @else
                                                                <span
                                                                    class="inline-flex items-center justify-center whitespace-nowrap rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">

                                                                    <span
                                                                        class="mr-1.5 h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                                                                    Belum Diisi

                                                                </span>
                                                            @endif
                                                        @else
                                                            <span class="text-slate-400">
                                                                -
                                                            </span>
                                                        @endif

                                                    </td>

                                                </tr>

                                            @empty

                                                <tr>

                                                    <td colspan="8" class="px-6 py-12 text-center">

                                                        <span class="material-symbols-outlined text-4xl text-slate-300">
                                                            table_rows
                                                        </span>

                                                        <p class="mt-3 text-sm text-slate-500">
                                                            Belum ada indikator pada pilar ini.
                                                        </p>

                                                    </td>

                                                </tr>
                                            @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>
                        @endforeach
                    @else
                        {{-- ================================================= --}}
                        {{-- MODE GABUNGAN --}}
                        {{-- ================================================= --}}

                        @foreach ($pilarsMonitoring as $pilar)
                            <div
                                class="mx-4 mb-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm last:mb-0 md:mx-6 lg:mx-8">

                                {{-- HEADER PILAR --}}
                                <div class="bg-primary px-5 py-4 md:px-6">

                                    @php
                                        $huruf = range('A', 'Z');
                                    @endphp

                                    <h3 class="text-sm font-bold uppercase tracking-wide text-white md:text-base">

                                        {{ $huruf[$pilar->urutan - 1] }}.

                                        {{ strtoupper($pilar->nama) }}

                                        ({{ $tahunAwal }}-{{ $tahunAkhir }})
                                    </h3>

                                </div>


                                {{-- TABLE --}}
                                <div class="overflow-x-auto">

                                    <table class="w-full min-w-[1000px] border-collapse">

                                        <thead class="bg-primary-hover text-white">

                                            <tr>

                                                <th rowspan="2"
                                                    class="px-4 py-3 text-center text-xs font-semibold uppercase">
                                                    No
                                                </th>

                                                <th rowspan="2"
                                                    class="px-4 py-3 text-left text-xs font-semibold uppercase">
                                                    Tujuan Strategis
                                                </th>

                                                <th rowspan="2"
                                                    class="px-4 py-3 text-left text-xs font-semibold uppercase">
                                                    Indikator
                                                </th>

                                                <th rowspan="2"
                                                    class="px-4 py-3 text-center text-xs font-semibold uppercase">
                                                    Baseline
                                                </th>

                                                <th rowspan="2"
                                                    class="px-4 py-3 text-left text-xs font-semibold uppercase">
                                                    Sumber Data
                                                </th>

                                                <th colspan="{{ $tahuns->count() }}"
                                                    class="px-4 py-3 text-center text-xs font-semibold uppercase">
                                                    Target
                                                </th>

                                            </tr>


                                            <tr>

                                                @foreach ($tahuns as $item)
                                                    <th class="px-4 py-3 text-center text-xs font-semibold">

                                                        {{ $item->tahun }}

                                                    </th>
                                                @endforeach

                                            </tr>

                                        </thead>


                                        <tbody>

                                            @forelse ($pilar->indikators as $indikator)
                                                <tr
                                                    class="border-b border-slate-100 last:border-b-0 transition-colors hover:bg-primary-light">

                                                    <td class="px-4 py-4 text-center text-sm text-slate-600">

                                                        {{ $loop->iteration }}

                                                    </td>


                                                    <td class="px-4 py-4 text-sm leading-6 text-slate-700">

                                                        {{ $indikator->tujuan_strategis }}

                                                    </td>


                                                    <td class="px-4 py-4 text-sm font-medium leading-6 text-slate-800">

                                                        {{ $indikator->nama_indikator }}

                                                    </td>


                                                    <td class="px-4 py-4 text-center text-sm text-slate-700">

                                                        {{ $indikator->nilai_baseline }}

                                                        <span class="mt-1 block text-xs text-slate-400">

                                                            {{ $indikator->tahun_baseline }}

                                                        </span>

                                                    </td>


                                                    <td class="px-4 py-4 text-sm leading-6 text-slate-600">

                                                        {{ $indikator->sumber_data ?? '-' }}

                                                    </td>


                                                    @foreach ($tahuns as $item)
                                                        @php
                                                            $target = $indikator->targets->firstWhere(
                                                                'tahun_id',
                                                                $item->id,
                                                            );
                                                        @endphp

                                                        <td
                                                            class="px-4 py-4 text-center text-sm font-semibold text-slate-800">

                                                            {{ $target->nilai_target ?? '-' }}

                                                        </td>
                                                    @endforeach

                                                </tr>

                                            @empty

                                                <tr>

                                                    <td colspan="{{ 5 + $tahuns->count() }}"
                                                        class="px-6 py-12 text-center">

                                                        <span class="material-symbols-outlined text-4xl text-slate-300">
                                                            table_rows
                                                        </span>

                                                        <p class="mt-3 text-sm text-slate-500">
                                                            Belum ada indikator pada pilar ini.
                                                        </p>

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

            </section>

        </section>

    </main>

    {{-- ========================================================= --}}
    {{-- CUSTOM FILTER SCRIPT --}}
    {{-- ========================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('filterForm');

            const dropdowns = [{
                    button: document.getElementById('pilarButton'),
                    dropdown: document.getElementById('pilarDropdown'),
                    text: document.getElementById('pilarText'),
                    input: document.getElementById('pilarInput'),
                    icon: document.getElementById('pilarIcon'),
                    options: document.querySelectorAll('.pilar-option')
                },
                {
                    button: document.getElementById('instansiButton'),
                    dropdown: document.getElementById('instansiDropdown'),
                    text: document.getElementById('instansiText'),
                    input: document.getElementById('instansiInput'),
                    icon: document.getElementById('instansiIcon'),
                    options: document.querySelectorAll('.instansi-option')
                },
                {
                    button: document.getElementById('tahunButton'),
                    dropdown: document.getElementById('tahunDropdown'),
                    text: document.getElementById('tahunText'),
                    input: document.getElementById('tahunInput'),
                    icon: document.getElementById('tahunIcon'),
                    options: document.querySelectorAll('.tahun-option')
                }
            ];


            function closeAllDropdowns(except = null) {

                dropdowns.forEach(item => {

                    if (item !== except) {

                        item.dropdown.classList.add('hidden');

                        item.icon.classList.remove('rotate-180');

                        item.button.classList.remove(
                            'border-primary',
                            'ring-2',
                            'ring-primary/20'
                        );

                    }

                });

            }


            dropdowns.forEach(item => {

                item.button.addEventListener('click', function(event) {

                    event.stopPropagation();

                    const isOpen = !item.dropdown.classList.contains('hidden');

                    closeAllDropdowns(item);

                    if (!isOpen) {

                        item.dropdown.classList.remove('hidden');

                        item.icon.classList.add('rotate-180');

                        item.button.classList.add(
                            'border-primary',
                            'ring-2',
                            'ring-primary/20'
                        );

                    }

                });


                item.options.forEach(option => {

                    option.addEventListener('click', function() {

                        const value = this.dataset.value;
                        const text = this.dataset.text;

                        item.input.value = value;
                        item.text.textContent = text;

                        closeAllDropdowns();

                        form.submit();

                    });

                });

            });


            document.addEventListener('click', function() {

                closeAllDropdowns();

            });


            dropdowns.forEach(item => {

                item.dropdown.addEventListener('click', function(event) {

                    event.stopPropagation();

                });

            });

        });
    </script>
@endsection
