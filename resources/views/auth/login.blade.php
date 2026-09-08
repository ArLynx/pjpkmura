<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - PJPK Kabupaten Murung Raya</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }

        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24;
        }

        .login-card-shadow {
            box-shadow:
                0 1px 3px rgba(15, 23, 42, .05),
                0 4px 6px -1px rgba(15, 23, 42, .10);
        }

        @media (max-width: 767px) {
            .login-main {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body class="flex min-h-screen flex-col">


    {{-- ================================================= --}}
    {{-- NAVBAR --}}
    {{-- ================================================= --}}

    <nav class="w-full border-b border-slate-100 bg-white shadow-sm">

        <div
            class="mx-auto flex max-w-7xl items-center justify-between
                    px-4 py-3.5 sm:px-8 md:py-4">

            {{-- BRAND --}}
            <a href="{{ route('home') }}" class="min-w-0 text-lg font-bold text-primary sm:text-xl">

                <span class="block truncate">
                    PJPK Murung Raya
                </span>

            </a>


            {{-- DESKTOP MENU --}}
            <div class="hidden items-center gap-7 md:flex">

                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 transition hover:text-primary">
                    Beranda
                </a>

                <a href="{{ route('dashboard') }}"
                    class="text-sm font-medium text-slate-600 transition hover:text-primary">
                    Dashboard Publik
                </a>

                <span class="rounded-lg bg-primary px-5 py-2 text-sm font-medium text-white">
                    Login
                </span>

            </div>


            {{-- MOBILE STATUS --}}
            <span
                class="rounded-lg bg-primary-light px-3 py-1.5
                         text-xs font-semibold text-primary md:hidden">
                Login
            </span>

        </div>

    </nav>


    {{-- ================================================= --}}
    {{-- MAIN --}}
    {{-- ================================================= --}}

    <main
        class="login-main relative flex flex-grow items-center justify-center
               overflow-hidden px-4 py-8
               sm:px-6 sm:py-12
               md:px-4 md:py-12">

        {{-- Background decoration --}}
        <div
            class="absolute -right-24 -top-24 h-72 w-72 rounded-full
                   bg-primary opacity-5 blur-3xl
                   sm:h-96 sm:w-96">
        </div>

        <div
            class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full
                   bg-primary opacity-5 blur-3xl
                   sm:h-96 sm:w-96">
        </div>


        {{-- LOGIN WRAPPER --}}
        <div class="z-10 w-full max-w-md">


            {{-- ICON --}}
            <div class="mb-5 flex justify-center sm:mb-8">

                <div
                    class="login-card-shadow flex h-14 w-14 items-center justify-center
                           rounded-xl border border-slate-200 bg-white
                           sm:h-16 sm:w-16 sm:rounded-2xl">

                    <span class="material-symbols-outlined text-3xl text-primary sm:text-4xl"
                        style="font-variation-settings: 'FILL' 1;">
                        account_balance
                    </span>

                </div>

            </div>


            {{-- CARD --}}
            <div
                class="login-card-shadow rounded-2xl border border-slate-200
                       bg-white px-5 py-6
                       sm:rounded-xl sm:p-8
                       md:p-10">


                {{-- TITLE --}}
                <div class="mb-6 text-center sm:mb-8">

                    <h1
                        class="mb-2 text-xl font-semibold leading-snug text-slate-900
                               sm:text-2xl">
                        Masuk ke Panel Admin
                    </h1>

                    <p
                        class="mx-auto max-w-sm text-xs leading-5 text-slate-500
                               sm:text-sm sm:leading-6">
                        Gunakan akun PJPK Anda untuk mengelola data capaian indikator.
                    </p>

                </div>


                {{-- SUCCESS --}}
                @if (session('success'))
                    <div
                        class="mb-5 rounded-lg border border-green-200 bg-green-50
                               px-3.5 py-3 text-sm leading-5 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif


                {{-- ERROR --}}
                @if ($errors->any())
                    <div
                        class="mb-5 rounded-lg border border-red-200 bg-red-50
                               px-3.5 py-3 text-sm leading-5 text-red-800">
                        {{ $errors->first() }}
                    </div>
                @endif


                {{-- FORM --}}
                <form class="space-y-5 sm:space-y-6" method="POST" action="{{ route('login.store') }}" id="loginForm">

                    @csrf


                    {{-- USERNAME / EMAIL --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-800" for="login">
                            Username atau Email
                        </label>

                        <div class="relative">

                            <div
                                class="pointer-events-none absolute inset-y-0 left-0
                                       flex items-center pl-3.5">

                                <span class="material-symbols-outlined text-xl text-slate-400">
                                    person
                                </span>

                            </div>

                            <input
                                class="w-full rounded-lg border border-slate-200
                                       bg-white py-3 pl-11 pr-4 text-sm
                                       outline-none transition
                                       placeholder:text-slate-400
                                       focus:border-primary
                                       focus:ring-2 focus:ring-primary/20
                                       sm:text-base"
                                id="login" name="login" value="{{ old('login') }}"
                                placeholder="Masukkan username atau email" type="text" autocomplete="username"
                                required autofocus>

                        </div>

                    </div>


                    {{-- PASSWORD --}}
                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-800" for="password">
                            Kata Sandi
                        </label>

                        <div class="relative">

                            <div
                                class="pointer-events-none absolute inset-y-0 left-0
                                       flex items-center pl-3.5">

                                <span class="material-symbols-outlined text-xl text-slate-400">
                                    lock
                                </span>

                            </div>

                            <input
                                class="w-full rounded-lg border border-slate-200
                                       bg-white py-3 pl-11 pr-12 text-sm
                                       outline-none transition
                                       placeholder:text-slate-400
                                       focus:border-primary
                                       focus:ring-2 focus:ring-primary/20
                                       sm:text-base"
                                id="password" name="password" placeholder="••••••••" type="password"
                                autocomplete="current-password" required>

                            <button
                                class="absolute inset-y-0 right-0 flex items-center
                                       pr-3 text-slate-400 transition
                                       hover:text-primary"
                                onclick="togglePassword()" type="button" aria-label="Tampilkan kata sandi">

                                <span class="material-symbols-outlined text-xl" id="passwordIcon">
                                    visibility
                                </span>

                            </button>

                        </div>

                    </div>


                    {{-- REMEMBER --}}
                    <label class="flex cursor-pointer items-center">

                        <input name="remember" value="1"
                            class="h-4 w-4 rounded border-slate-300
                                   text-primary focus:ring-primary"
                            type="checkbox" {{ old('remember') ? 'checked' : '' }}>

                        <span class="ml-2 text-sm text-slate-600">
                            Ingat saya
                        </span>

                    </label>


                    {{-- SUBMIT --}}
                    <button id="submitButton"
                        class="w-full rounded-lg bg-primary py-3.5
                               text-sm font-semibold text-white shadow-md
                               transition
                               hover:bg-primary-hover
                               active:scale-[0.98]
                               disabled:cursor-not-allowed
                               disabled:opacity-70
                               sm:text-base"
                        type="submit">

                        Masuk Sekarang

                    </button>

                </form>


                {{-- INFORMATION --}}
                <div class="mt-6 border-t border-slate-200 pt-5 sm:mt-8 sm:pt-6">

                    <div class="flex items-start gap-2.5 sm:gap-3">

                        <span
                            class="material-symbols-outlined mt-0.5 shrink-0
                                   text-lg text-amber-600">
                            info
                        </span>

                        <p
                            class="text-xs italic leading-5 text-slate-500
                                   sm:text-sm sm:leading-6">
                            Jika Anda mengalami kendala saat masuk, hubungi admin teknis
                            Dinas Dalduk dan KB Kabupaten Murung Raya.
                        </p>

                    </div>

                </div>

            </div>


            {{-- BACK TO HOME --}}
            <div class="mt-5 text-center sm:mt-8">

                <a class="inline-flex items-center gap-2 text-sm font-medium
                           text-slate-500 transition hover:text-primary"
                    href="{{ route('home') }}">

                    <span class="material-symbols-outlined text-lg">
                        arrow_back
                    </span>

                    Kembali ke Beranda Publik

                </a>

            </div>

        </div>

    </main>


    {{-- ================================================= --}}
    {{-- FOOTER --}}
    {{-- ================================================= --}}

    <footer class="w-full border-t border-slate-200 bg-slate-100">

        <div
            class="mx-auto flex max-w-7xl flex-col items-center
                   gap-1.5 px-4 py-5 text-center text-xs text-slate-500
                   sm:gap-3 sm:px-8 sm:py-7 sm:text-sm
                   md:flex-row md:justify-between md:text-left">

            <div>

                <strong class="text-slate-700">
                    PJPK Murung Raya
                </strong>

                <span class="hidden sm:inline">
                    ·
                </span>

                <span class="block sm:inline">
                    &copy; {{ now()->year }} Pemerintah Kabupaten Murung Raya
                </span>

            </div>

            <div>
                Panel administrasi data indikator
            </div>

        </div>

    </footer>


    <script>
        function togglePassword() {

            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            const visible = passwordInput.type === 'text';

            passwordInput.type = visible ? 'password' : 'text';

            passwordIcon.innerText = visible ?
                'visibility' :
                'visibility_off';
        }


        document.getElementById('loginForm').addEventListener('submit', function() {

            const button = document.getElementById('submitButton');

            button.disabled = true;
            button.textContent = 'Memproses...';

        });
    </script>

</body>

</html>
