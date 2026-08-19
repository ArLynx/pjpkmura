@extends('backend.layouts.app')

@section('title', 'Analisis')
@section('page-title', 'Analisis')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Analisis Tren Indikator</h1>
            <p class="mt-1 text-slate-500">Bandingkan target, realisasi, dan baseline di seluruh tahun.</p>
        </div>

        <form method="GET" action="{{ route('admin.analisis.index') }}"
            class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:grid-cols-2">
            <label class="block">
                <span class="mb-2 block text-sm font-semibold text-slate-700">Pilar</span>
                <select name="pilar" onchange="this.form.submit()"
                    class="w-full rounded-xl border-slate-300 focus:border-[#0B91CF] focus:ring-[#0B91CF]">
                    @foreach ($pilars as $item)
                        <option value="{{ $item->id }}" @selected($pilarId == $item->id)>{{ $item->nama }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="mb-2 block text-sm font-semibold text-slate-700">Indikator</span>
                <select name="indikator" onchange="this.form.submit()"
                    class="w-full rounded-xl border-slate-300 focus:border-[#0B91CF] focus:ring-[#0B91CF]"
                    @disabled(!$pilar || $pilar->indikators->isEmpty())>
                    @forelse ($pilar?->indikators ?? [] as $item)
                        <option value="{{ $item->id }}" @selected($indikator?->id == $item->id)>{{ $item->nama_indikator }}</option>
                    @empty
                        <option>Belum ada indikator</option>
                    @endforelse
                </select>
            </label>
        </form>

        @if ($indikator)
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-5">
                    <h2 class="text-xl font-bold text-slate-800">{{ $indikator->nama_indikator }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $indikator->satuan ?: 'Tanpa satuan' }} · {{ $pilar?->nama }}</p>
                </div>
                @if ($tren && count($tren['tahun']))
                    <div class="h-[360px]"><canvas id="trendChart"></canvas></div>
                @else
                    <div class="rounded-xl border border-dashed border-slate-300 p-10 text-center text-slate-500">Belum ada data target atau realisasi untuk indikator ini.</div>
                @endif
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="font-bold text-slate-800">Detail Capaian Per Tahun</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-100 text-slate-600"><tr><th class="px-6 py-4">Tahun</th><th class="px-6 py-4">Target</th><th class="px-6 py-4">Realisasi</th><th class="px-6 py-4">Status Pencapaian</th></tr></thead>
                        <tbody>
                            @forelse ($detail as $row)
                                <tr class="border-t border-slate-200"><td class="px-6 py-4 font-semibold">{{ $row['tahun'] }}</td><td class="px-6 py-4">{{ $row['target'] ?? '-' }}</td><td class="px-6 py-4">{{ $row['realisasi'] ?? '-' }}</td><td class="px-6 py-4">{{ $row['status'] === 'tercapai' ? 'Tercapai' : ($row['status'] === 'belum_tercapai' ? 'Belum tercapai' : '-') }}</td></tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada detail data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-500">Belum ada indikator yang dapat dianalisis.</div>
        @endif
    </div>
@endsection

@push('scripts')
    @if ($tren && count($tren['tahun']))
        <script>
            new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: @json($tren['tahun']),
                    datasets: [
                        { label: 'Target', data: @json($tren['target']), borderColor: '#0B91CF', backgroundColor: '#0B91CF', spanGaps: false, tension: 0.25 },
                        { label: 'Realisasi', data: @json($tren['realisasi']), borderColor: '#059669', backgroundColor: '#059669', spanGaps: false, tension: 0.25 },
                        { label: 'Baseline', data: @json(array_map(fn ($tahun) => $tren['baseline'] && $tren['baseline']['tahun'] == $tahun ? (float) $tren['baseline']['nilai'] : null, $tren['tahun'])), borderColor: '#F59E0B', backgroundColor: '#F59E0B', borderDash: [6, 4], pointRadius: 6, spanGaps: false }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: false } } }
            });
        </script>
    @endif
@endpush
