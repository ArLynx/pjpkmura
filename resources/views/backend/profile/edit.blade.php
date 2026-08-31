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
                {{-- <div>

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

                </div> --}}


                {{-- PASSWORD --}}
                <div>

                    <label
                        for="password"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Kata Sandi Baru
                    </label>

                    <div class="relative">

                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="w-full rounded-xl border-slate-300 pr-12 focus:border-sky-600 focus:ring-sky-600"
                            autocomplete="new-password"
                        >

                        {{-- Tombol lihat password --}}
                        <button
                            type="button"
                            onclick="togglePassword('password', 'passwordIcon')"
                            class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-slate-400 transition hover:text-sky-600"
                            tabindex="-1"
                            title="Lihat kata sandi"
                        >

                            <span
                                id="passwordIcon"
                                class="material-symbols-outlined"
                            >
                                visibility
                            </span>

                        </button>

                    </div>

                    <p class="mt-1 text-xs text-slate-500">
                        Kosongkan bila tidak diubah. Kata Sandi Minimal 8 kombinasi angka dan huruf
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

                    <div class="relative">

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="w-full rounded-xl border-slate-300 pr-12 focus:border-sky-600 focus:ring-sky-600"
                            autocomplete="new-password"
                        >

                        {{-- Tombol lihat konfirmasi password --}}
                        <button
                            type="button"
                            onclick="togglePassword('password_confirmation', 'passwordConfirmationIcon')"
                            class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-slate-400 transition hover:text-sky-600"
                            tabindex="-1"
                            title="Lihat konfirmasi kata sandi"
                        >

                            <span
                                id="passwordConfirmationIcon"
                                class="material-symbols-outlined"
                            >
                                visibility
                            </span>

                        </button>

                    </div>

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


    {{-- ===================================================== --}}
    {{-- JAVASCRIPT LIHAT PASSWORD --}}
    {{-- ===================================================== --}}

    <script>
        function togglePassword(inputId, iconId) {

            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (!input || !icon) {
                return;
            }

            if (input.type === 'password') {

                input.type = 'text';

                icon.textContent = 'visibility_off';

            } else {

                input.type = 'password';

                icon.textContent = 'visibility';

            }
        }
    </script>

@endsection