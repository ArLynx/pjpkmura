@extends('backend.layouts.app')
@section('title', 'Kelola Pilar')
@section('page-title', 'Kelola Pilar')
@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div><h2 class="text-xl font-bold text-slate-900">Daftar Pilar</h2><p class="mt-1 text-sm text-slate-500">Urutan pilar menentukan susunan pada dashboard publik.</p></div>
    <a href="{{ route('admin.pilars.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-700 px-5 py-3 font-semibold text-white hover:bg-teal-800"><span class="material-symbols-outlined">add</span> Tambah Pilar</a>
</div>
<div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm"><form method="GET" class="flex gap-2"><input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama pilar..." class="min-w-0 flex-1 rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600"><button class="rounded-xl bg-slate-800 px-5 text-white hover:bg-slate-900">Cari</button></form></div>
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500"><tr><th class="px-6 py-4">Urutan</th><th class="px-6 py-4">Nama Pilar</th><th class="px-6 py-4">Jumlah Indikator</th><th class="px-6 py-4 text-right">Aksi</th></tr></thead>
        <tbody class="divide-y divide-slate-100">
        @forelse($pilars as $pilar)
            <tr class="hover:bg-slate-50"><td class="px-6 py-4 font-bold text-teal-700">{{ $pilar->urutan }}</td><td class="px-6 py-4 font-semibold text-slate-900">{{ $pilar->nama }}</td><td class="px-6 py-4 text-slate-600">{{ $pilar->indikators_count }}</td><td class="px-6 py-4"><div class="flex justify-end gap-2"><a href="{{ route('admin.pilars.edit', $pilar) }}" class="rounded-lg bg-amber-100 p-2 text-amber-700 hover:bg-amber-200"><span class="material-symbols-outlined text-xl">edit</span></a><form method="POST" action="{{ route('admin.pilars.destroy', $pilar) }}" onsubmit="return confirm('Menghapus pilar akan menghapus indikator, target, realisasi, dan data pendukung terkait. Lanjutkan?')">@csrf @method('DELETE')<button class="rounded-lg bg-red-100 p-2 text-red-700 hover:bg-red-200"><span class="material-symbols-outlined text-xl">delete</span></button></form></div></td></tr>
        @empty<tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">Belum ada data pilar.</td></tr>@endforelse
        </tbody>
    </table></div>
    @if($pilars->hasPages())<div class="border-t border-slate-200 px-6 py-4">{{ $pilars->links() }}</div>@endif
</div>
@endsection
