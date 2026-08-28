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
                {{-- TREN INDIKATOR --}}
                {{-- ===================================================== --}}

                <div class="w-full bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">

                    <div class="mb-6">

                        <h4 class="text-xl font-semibold text-slate-900 mb-2">
                            Tren Indikator
                        </h4>

                        <p class="text-sm text-slate-500">
                            Grafik perkembangan target dan realisasi indikator dari tahun ke tahun.
                        </p>

                    </div>

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

                {{-- ===================================================== --}}
                {{-- STATUS INDIKATOR --}}
                {{-- ===================================================== --}}

                <div
                    class="w-full lg:flex-1 bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm flex flex-col">

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="text-xl font-semibold text-slate-900">
                                Status Indikator
                            </h4>

                            <p class="mt-1 text-sm text-slate-500">
                                Proporsi pencapaian per indikator
                            </p>
                        </div>

                        <div class="relative">
                            <button type="button" id="statusTahunButton"
                                class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-left text-sm font-medium text-slate-700 transition-all duration-200 hover:border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20">

                                <span id="statusTahunText" class="pr-2">
                                    {{ $tahuns->firstWhere('id', $tahun)?->tahun ?? 'Pilih Tahun' }}
                                </span>

                                <span id="statusTahunIcon"
                                    class="material-symbols-outlined text-[18px] text-slate-500 transition-transform duration-200">
                                    expand_more
                                </span>

                            </button>

                            <div id="statusTahunDropdown"
                                class="absolute right-0 top-full z-50 mt-2 hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg min-w-[120px]">

                                <div class="max-h-64 overflow-y-auto py-1">
                                    @foreach ($tahuns as $item)
                                        <a href="{{ route('dashboard', array_merge(request()->query(), ['tahun_id' => $item->id])) }}"
                                            class="flex w-full items-center px-4 py-2.5 text-left text-sm font-medium transition-colors hover:bg-primary-light hover:text-primary {{ $item->id == $tahun ? 'bg-primary-light text-primary' : 'text-slate-700' }}">
                                            {{ $item->tahun }}
                                        </a>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="flex-grow flex items-center justify-center relative my-6">

                        <div class="w-36 h-36 rounded-full border-8 border-slate-100 flex items-center justify-center">

                            <div class="text-center">

                                <span class="text-3xl font-bold text-slate-700">
                                    {{ $persentaseProgres }}%
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
                                Belum: {{ $jumlahBelumTercapai }}
                            </span>

                        </div>

                        <div class="flex items-center gap-2">

                            <div class="w-2 h-2 rounded-full bg-amber-600"></div>

                            <span class="text-xs text-slate-600">
                                Verifikasi: {{ $jumlahVerifikasi }}
                            </span>

                        </div>

                        <div class="flex items-center gap-2">

                            <div class="w-2 h-2 rounded-full bg-slate-500"></div>

                            <span class="text-xs text-slate-600">
                                Belum Isi: {{ $jumlahBelumIsi }}
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

                </div>


                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-5">

                    @foreach ($ringkasanPilar as $item)
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-full">

                            <div class="mb-6">

                                <h5 class="text-lg font-semibold text-slate-900 mb-2">
                                    Pilar {{ chr(64 + $item['urutan']) }}
                                </h5>

                                <p class="text-sm leading-5 text-slate-500">
                                    {{ $item['nama'] }}
                                </p>

                            </div>

                            <div class="mt-auto">

                                <div class="flex justify-between items-end mb-2">

                                    <span class="text-xs font-medium text-slate-600">
                                        {{ $item['jumlah_indikator'] }} Indikator
                                    </span>

                                    <span class="text-xs font-semibold text-primary">
                                        {{ $item['persentase'] }}%
                                    </span>

                                </div>

                                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">

                                    <div class="h-full bg-primary rounded-full" style="width: {{ $item['persentase'] }}%"></div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </section>

            {{-- ========================================================= --}}
            {{-- RINGKASAN INDIKATOR --}}
            {{-- ========================================================= --}}
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-10">

                <div class="p-6 md:p-8 border-b border-slate-200">

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

                        <div>

                            <h4 class="text-2xl font-bold text-slate-900">
                                Ringkasan Indikator
                            </h4>

                            <p class="mt-1 text-sm text-slate-500">
                                Detail target dan realisasi indikator strategis daerah
                            </p>

                        </div>

                        <div class="flex gap-2 w-full md:w-auto">

                            <div class="relative w-full md:w-48">
                                <button type="button" id="ringkasanTahunButton"
                                    class="flex w-full items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-left text-sm font-medium text-slate-700 transition-all duration-200 hover:border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20">

                                    <span id="ringkasanTahunText" class="truncate pr-3">
                                        {{ $tahuns->firstWhere('id', $tahun)?->tahun ?? 'Semua Tahun' }}
                                    </span>

                                    <span id="ringkasanTahunIcon"
                                        class="material-symbols-outlined shrink-0 text-[20px] text-slate-500 transition-transform duration-200">
                                        expand_more
                                    </span>

                                </button>

                                <div id="ringkasanTahunDropdown"
                                    class="absolute left-0 right-0 top-full z-50 mt-2 hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">

                                    <div class="max-h-64 overflow-y-auto py-1">

                                        @foreach ($tahuns as $item)
                                            <a href="{{ route('dashboard', array_merge(request()->query(), ['tahun_id' => $item->id])) }}"
                                                class="flex w-full items-center px-4 py-3 text-left text-sm font-medium text-slate-700 transition-colors hover:bg-primary-light hover:text-primary">

                                                {{ $item->tahun }}

                                            </a>
                                        @endforeach

                                    </div>

                                </div>

                            </div>

                            <div class="relative w-full md:w-64">

                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                    search
                                </span>

                                <input type="text" id="ringkasanSearch" placeholder="Cari indikator..."
                                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary">

                            </div>

                        </div>

                    </div>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full text-left" id="ringkasanTable">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-8 py-4 text-xs font-semibold text-slate-500 uppercase">
                                    Indikator
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">
                                    Pilar
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase text-right">
                                    Target {{ $tahuns->firstWhere('id', $tahun)?->tahun ?? '' }}
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

                            @forelse ($ringkasanIndikator->items() as $item)
                                <tr class="hover:bg-slate-50 transition-colors ringkasan-row">

                                    <td class="px-8 py-5 text-sm font-semibold text-slate-800">
                                        {{ $item['nama'] }}
                                    </td>

                                    <td class="px-6 py-5">
                                        <span
                                            class="bg-primary-light text-primary px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $item['pilar'] }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 text-sm text-slate-700 text-right">
                                        {{ $item['target'] }}
                                    </td>

                                    <td class="px-6 py-5 text-sm text-slate-700 text-right">
                                        {{ $item['realisasi'] }}
                                    </td>

                                    <td class="px-8 py-5 text-center">
                                        @if ($item['status'] === 'tercapai')
                                            <span
                                                class="inline-flex items-center justify-center whitespace-nowrap rounded-full bg-primary-light px-3 py-1.5 text-xs font-semibold text-primary">
                                                <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-primary"></span>
                                                Tercapai
                                            </span>
                                        @elseif ($item['status'] === 'belum_tercapai')
                                            <span
                                                class="inline-flex items-center justify-center whitespace-nowrap rounded-full bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600">
                                                <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                                Belum Tercapai
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center justify-center whitespace-nowrap rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                                <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                                Belum Diisi
                                            </span>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <span class="material-symbols-outlined text-4xl text-slate-300">
                                            table_rows
                                        </span>
                                        <p class="mt-3 text-sm text-slate-500">
                                            Belum ada data indikator.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                @if ($ringkasanIndikator->hasPages())
                    <div class="p-6 bg-slate-50 flex justify-center items-center gap-2">
                        @if ($ringkasanIndikator->onFirstPage())
                            <button type="button" disabled
                                class="p-2 border border-slate-200 rounded-xl text-slate-400 opacity-50 cursor-not-allowed">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </button>
                        @else
                            <a href="{{ $ringkasanIndikator->previousPageUrl() }}"
                                class="p-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-white">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </a>
                        @endif

                        @foreach ($ringkasanIndikator->getUrlRange(max(1, $ringkasanIndikator->currentPage() - 2), min($ringkasanIndikator->lastPage(), $ringkasanIndikator->currentPage() + 2)) as $page => $url)
                            @if ($page == $ringkasanIndikator->currentPage())
                                <a href="{{ $url }}" class="px-3 py-1.5 rounded-xl text-sm font-semibold bg-primary text-white">{{ $page }}</a>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-white">{{ $page }}</a>
                            @endif
                        @endforeach

                        <span class="text-sm text-slate-400 mx-1">...</span>

                        <a href="{{ $ringkasanIndikator->url($ringkasanIndikator->lastPage()) }}"
                            class="px-3 py-1.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-white">
                            {{ $ringkasanIndikator->lastPage() }}
                        </a>

                        @if ($ringkasanIndikator->hasMorePages())
                            <a href="{{ $ringkasanIndikator->nextPageUrl() }}"
                                class="p-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-white">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </a>
                        @else
                            <button type="button" disabled
                                class="p-2 border border-slate-200 rounded-xl text-slate-400 opacity-50 cursor-not-allowed">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </button>
                        @endif
                    </div>
                @endif

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

@push('scripts')
    <script>
        (function () {
            const statusTahunButton = document.getElementById('statusTahunButton');
            const statusTahunDropdown = document.getElementById('statusTahunDropdown');

            if (statusTahunButton && statusTahunDropdown) {
                statusTahunButton.addEventListener('click', function (e) {
                    e.stopPropagation();
                    statusTahunDropdown.classList.toggle('hidden');
                    const icon = document.getElementById('statusTahunIcon');
                    if (icon) icon.classList.toggle('rotate-180');
                });

                document.addEventListener('click', function () {
                    statusTahunDropdown.classList.add('hidden');
                    const icon = document.getElementById('statusTahunIcon');
                    if (icon) icon.classList.remove('rotate-180');
                });

                statusTahunDropdown.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            }
        })();

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

        (function () {
            const ringkasanTahunButton = document.getElementById('ringkasanTahunButton');
            const ringkasanTahunDropdown = document.getElementById('ringkasanTahunDropdown');
            const ringkasanSearch = document.getElementById('ringkasanSearch');
            const ringkasanTable = document.getElementById('ringkasanTable');

            if (ringkasanTahunButton && ringkasanTahunDropdown) {
                ringkasanTahunButton.addEventListener('click', function (e) {
                    e.stopPropagation();
                    ringkasanTahunDropdown.classList.toggle('hidden');
                    const icon = document.getElementById('ringkasanTahunIcon');
                    if (icon) {
                        icon.classList.toggle('rotate-180');
                    }
                });

                document.addEventListener('click', function () {
                    ringkasanTahunDropdown.classList.add('hidden');
                    const icon = document.getElementById('ringkasanTahunIcon');
                    if (icon) {
                        icon.classList.remove('rotate-180');
                    }
                });

                ringkasanTahunDropdown.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            }

            if (ringkasanSearch && ringkasanTable) {
                ringkasanSearch.addEventListener('input', function () {
                    const keyword = this.value.toLowerCase();
                    const rows = ringkasanTable.querySelectorAll('.ringkasan-row');

                    rows.forEach(function (row) {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(keyword) ? '' : 'none';
                    });
                });
            }
        })();
    </script>
@endpush
