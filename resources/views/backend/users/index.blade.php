@extends('backend.layouts.app')
@section('title', 'Kelola User')
@section('page-title', 'Kelola User')
@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-xl font-bold text-slate-900">Daftar Pengguna</h2>
        <p class="mt-1 text-sm text-slate-500">Kelola akun, peran, instansi, dan status akses.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-700 px-5 py-3 font-semibold text-white hover:bg-teal-800">
        <span class="material-symbols-outlined">add</span> Tambah User
    </a>
</div>

<div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <form method="GET" class="grid gap-3 md:grid-cols-4">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama, username, email..." class="rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600 md:col-span-2">
        <select name="role" class="rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600">
            <option value="">Semua peran</option>
            <option value="superadmin" @selected(request('role') === 'superadmin')>Superadmin</option>
            <option value="admin" @selected(request('role') === 'admin')>Admin</option>
        </select>
        <div class="flex gap-2">
            <select name="status" class="min-w-0 flex-1 rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600">
                <option value="">Semua status</option>
                <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
            </select>
            <button class="rounded-xl bg-slate-800 px-4 text-white hover:bg-slate-900" aria-label="Terapkan filter"><span class="material-symbols-outlined">search</span></button>
        </div>
    </form>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr><th class="px-6 py-4">Pengguna</th><th class="px-6 py-4">Peran</th><th class="px-6 py-4">Instansi</th><th class="px-6 py-4">Status</th><th class="px-6 py-4 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-900">{{ $user->name }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ '@'.$user->username }} · {{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4"><span class="rounded-full bg-teal-100 px-3 py-1 text-xs font-semibold capitalize text-teal-800">{{ $user->role }}</span></td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $user->instansi ?: '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="rounded-lg bg-amber-100 p-2 text-amber-700 hover:bg-amber-200" title="Edit"><span class="material-symbols-outlined text-xl">edit</span></a>
                                @if(!auth()->user()->is($user))
                                    {{-- <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                        @csrf @method('DELETE')
                                        <button class="rounded-lg bg-red-100 p-2 text-red-700 hover:bg-red-200" title="Hapus"><span class="material-symbols-outlined text-xl">delete</span></button>
                                    </form> --}}
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">Data pengguna tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())<div class="border-t border-slate-200 px-6 py-4">{{ $users->links() }}</div>@endif
</div>
@endsection
