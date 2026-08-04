@extends('backend.layouts.app')
@section('title', 'Profil')
@section('page-title', 'Profil Saya')
@section('content')
<div class="mx-auto max-w-4xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-900">Informasi Akun</h2>
        <p class="mt-1 text-sm text-slate-500">Perbarui identitas dan kata sandi akun yang sedang digunakan.</p>
    </div>
    <form method="POST" action="{{ route('admin.profile.update') }}">
        @csrf @method('PUT')
        <div class="grid gap-6 md:grid-cols-2">
            <div><label class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap</label><input name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600"></div>
            <div><label class="mb-2 block text-sm font-semibold text-slate-700">Username</label><input name="username" value="{{ old('username', $user->username) }}" required class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600"></div>
            <div><label class="mb-2 block text-sm font-semibold text-slate-700">Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600"></div>
            <div><label class="mb-2 block text-sm font-semibold text-slate-700">Instansi</label><input name="instansi" value="{{ old('instansi', $user->instansi) }}" class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600"></div>
            <div><label class="mb-2 block text-sm font-semibold text-slate-700">Kata Sandi Baru</label><input type="password" name="password" class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600" autocomplete="new-password"><p class="mt-1 text-xs text-slate-500">Kosongkan bila tidak diubah.</p></div>
            <div><label class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Kata Sandi</label><input type="password" name="password_confirmation" class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600" autocomplete="new-password"></div>
        </div>
        <div class="mt-8 flex justify-end"><button class="rounded-xl bg-teal-700 px-6 py-3 font-semibold text-white hover:bg-teal-800">Simpan Profil</button></div>
    </form>
</div>
@endsection
