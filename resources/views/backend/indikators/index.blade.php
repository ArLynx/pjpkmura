@extends('backend.layouts.app')
@section('title', 'Kelola Indikator')
@section('page-title', 'Kelola Indikator')
@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div><h2 class="text-xl font-bold text-slate-900">Daftar Indikator</h2><p class="mt-1 text-sm text-slate-500">Kelola indikator berdasarkan pilar, instansi, baseline, dan sumber data.</p></div>
    <a href="{{ route('admin.indikators.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-700 px-5 py-3 font-semibold text-white hover:bg-teal-800"><span class="material-symbols-outlined">add</span> Tambah Indikator</a>
</div>
<div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <form method="GET" class="grid gap-3 md:grid-cols-[1fr_280px_auto]">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari indikator, tujuan, atau instansi..." class="rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600">
        <select name="pilar_id" class="rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600"><option value="">Semua pilar</option>@foreach($pilars as $pilar)<option value="{{ $pilar->id }}" @selected((string)request('pilar_id') === (string)$pilar->id)>{{ $pilar->nama }}</option>@endforeach</select>
        <button class="rounded-xl bg-slate-800 px-5 py-3 font-semibold text-white hover:bg-slate-900">Terapkan</button>
    </form>
</div>
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
<div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-200">
<thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"><tr><th class="px-6 py-4">Indikator</th><th class="px-6 py-4">Pilar</th><th class="px-6 py-4">Instansi</th><th class="px-6 py-4">Baseline</th><th class="px-6 py-4">Data Tahunan</th><th class="px-6 py-4 text-right">Aksi</th></tr></thead>
<tbody class="divide-y divide-slate-100">
@forelse($indikators as $indikator)
<tr class="align-top hover:bg-slate-50">
<td class="max-w-md px-6 py-4"><div class="font-semibold text-slate-900">{{ $indikator->nama_indikator }}</div><div class="mt-1 text-sm text-slate-500">{{ $indikator->tujuan_strategis }}</div><div class="mt-2 text-xs text-slate-400">Urutan {{ $indikator->urutan }}{{ $indikator->satuan ? ' · Satuan: '.$indikator->satuan : '' }}</div></td>
<td class="px-6 py-4 text-sm text-slate-700">{{ $indikator->pilar->nama }}</td>
<td class="px-6 py-4 text-sm text-slate-600">{{ $indikator->instansi }}</td>
<td class="px-6 py-4 text-sm text-slate-600">{{ $indikator->nilai_baseline ?: '-' }}{{ $indikator->tahun_baseline ? ' ('.$indikator->tahun_baseline.')' : '' }}</td>
<td class="px-6 py-4 text-sm text-slate-600">{{ $indikator->targets_count }} target<br>{{ $indikator->realisasis_count }} realisasi</td>
<td class="px-6 py-4"><div class="flex justify-end gap-2"><a href="{{ route('admin.indikators.edit', $indikator) }}" class="rounded-lg bg-amber-100 p-2 text-amber-700 hover:bg-amber-200"><span class="material-symbols-outlined text-xl">edit</span></a><form method="POST" action="{{ route('admin.indikators.destroy', $indikator) }}" onsubmit="return confirm('Menghapus indikator juga menghapus target, realisasi, dan data pendukung terkait. Lanjutkan?')">@csrf @method('DELETE')<button class="rounded-lg bg-red-100 p-2 text-red-700 hover:bg-red-200"><span class="material-symbols-outlined text-xl">delete</span></button></form></div></td>
</tr>
@empty<tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">Data indikator tidak ditemukan.</td></tr>@endforelse
</tbody></table></div>
@if($indikators->hasPages())<div class="border-t border-slate-200 px-6 py-4">{{ $indikators->links() }}</div>@endif
</div>
@endsection
