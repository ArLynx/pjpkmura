@extends('backend.layouts.app')

@section('title', 'Profil')
@section('page-title', 'Profil Saya')

@section('content')

    <div class="mx-auto max-w-4xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

        <div class="mb-6">

            <h2 class="text-xl font-bold text-slate-900">
                Informasi Akun
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Perbarui identitas dan kata sandi akun yang sedang digunakan.
            </p>

        </div>


        <form method="POST" action="{{ route('admin.profile.update') }}">

            @csrf
            @method('PUT')


            <div class="grid gap-6 md:grid-cols-2">

                {{-- NAMA --}}
                <div>

                    <label
                        for="name"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Nama Lengkap
                    </label>

                    <input
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
                    >

                </div>


                {{-- USERNAME --}}
                <div>

                    <label
                        for="username"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Username
                    </label>

                    <input
                        id="username"
                        name="username"
                        value="{{ old('username', $user->username) }}"
                        required
                        class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
                    >

                </div>


                {{-- EMAIL --}}
                <div>

                    <label
                        for="email"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
                    >

                </div>


                {{-- INSTANSI --}}
                <div>

                    <label
                        for="instansi"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Instansi
                    </label>

                    <input
                        id="instansi"
                        name="instansi"
                        value="{{ old('instansi', $user->instansi) }}"
                        class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
                    >

                </div>


                {{-- PASSWORD --}}
                <div>

                    <label
                        for="password"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Kata Sandi Baru
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
                        autocomplete="new-password"
                    >

                    <p class="mt-1 text-xs text-slate-500">
                        Kosongkan bila tidak diubah.
                    </p>

                </div>


                {{-- KONFIRMASI PASSWORD --}}
                <div>

                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Konfirmasi Kata Sandi
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
                        autocomplete="new-password"
                    >

                </div>

            </div>


            {{-- BUTTON --}}
            <div class="mt-8 flex justify-end">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#0B91CF] px-6 py-3 font-semibold text-white shadow-sm transition hover:bg-[#0879AE]"
                >

                    <span class="material-symbols-outlined">
                        save
                    </span>

                    Simpan Profil

                </button>

            </div>

        </form>

    </div>

@endsection