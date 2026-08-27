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
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .login-card-shadow {
            box-shadow:
                0 1px 3px rgba(15, 23, 42, .05),
                0 4px 6px -1px rgba(15, 23, 42, .10);
        }
    </style>
</head>

<body class="flex min-h-screen flex-col">

    <nav class="w-full bg-white shadow-sm">

        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-8">

            <a href="{{ route('home') }}" class="text-xl font-bold text-primary">
                PJPK Murung Raya
            </a>

            <div class="hidden items-center gap-7 md:flex">

                <a class="text-sm font-medium text-slate-600 hover:text-primary" href="{{ route('home') }}">
                    Beranda
                </a>

                <a class="text-sm font-medium text-slate-600 hover:text-primary" href="{{ route('dashboard') }}">
                    Dashboard Publik
                </a>

                <span class="rounded-lg bg-primary px-5 py-2 text-sm font-medium text-white">
                    Login
                </span>

            </div>

        </div>

    </nav>

    <main class="relative flex flex-grow items-center justify-center overflow-hidden px-4 py-12">

        <div class="absolute right-0 top-0 -mr-24 -mt-24 h-96 w-96 rounded-full bg-primary opacity-5 blur-3xl"></div>

        <div class="absolute bottom-0 left-0 -mb-24 -ml-24 h-96 w-96 rounded-full bg-primary opacity-5 blur-3xl"></div>

        <div class="z-10 w-full max-w-md">

            <div class="mb-8 flex justify-center">

                <div
                    class="login-card-shadow flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-200 bg-white">

                    <span class="material-symbols-outlined text-4xl text-primary"
                        style="font-variation-settings: 'FILL' 1;">
                        account_balance
                    </span>

                </div>

            </div>

            <div class="login-card-shadow rounded-xl border border-slate-200 bg-white p-8 md:p-10">

                <div class="mb-8 text-center">

                    <h1 class="mb-2 text-2xl font-semibold text-slate-900">
                        Masuk ke Panel Admin
                    </h1>

                    <p class="text-sm text-slate-500">
                        Gunakan akun PJPK Anda untuk mengelola data capaian indikator.
                    </p>

                </div>

                @if (session('success'))
                    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="space-y-6" method="POST" action="{{ route('login.store') }}" id="loginForm">

                    @csrf

                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-800" for="login">
                            Username atau Email
                        </label>

                        <div class="relative">

                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">

                                <span class="material-symbols-outlined text-xl text-slate-400">
                                    person
                                </span>

                            </div>

                            <input
                                class="w-full rounded-lg border border-slate-200 bg-white py-3 pl-10 pr-4 text-base outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                id="login" name="login" value="{{ old('login') }}"
                                placeholder="Masukkan username atau email" type="text" autocomplete="username"
                                required autofocus>

                        </div>

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-medium text-slate-800" for="password">
                            Kata Sandi
                        </label>

                        <div class="relative">

                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">

                                <span class="material-symbols-outlined text-xl text-slate-400">
                                    lock
                                </span>

                            </div>

                            <input
                                class="w-full rounded-lg border border-slate-200 bg-white py-3 pl-10 pr-12 text-base outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                id="password" name="password" placeholder="••••••••" type="password"
                                autocomplete="current-password" required>

                            <button
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition hover:text-primary"
                                onclick="togglePassword()" type="button" aria-label="Tampilkan kata sandi">

                                <span class="material-symbols-outlined text-xl" id="passwordIcon">
                                    visibility
                                </span>

                            </button>

                        </div>

                    </div>

                    <label class="flex cursor-pointer items-center">

                        <input name="remember" value="1"
                            class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary" type="checkbox"
                            {{ old('remember') ? 'checked' : '' }}>

                        <span class="ml-2 text-sm text-slate-600">
                            Ingat saya
                        </span>

                    </label>

                    <button id="submitButton"
                        class="w-full rounded-lg bg-primary py-3.5 text-base font-semibold text-white shadow-md transition hover:bg-primary-hover active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-70"
                        type="submit">
                        Masuk Sekarang
                    </button>

                </form>

                <div class="mt-8 border-t border-slate-200 pt-6">

                    <div class="flex items-start gap-3">

                        <span class="material-symbols-outlined shrink-0 text-xl text-amber-600">
                            info
                        </span>

                        <p class="text-sm italic text-slate-500">
                            Jika Anda mengalami kendala saat masuk, hubungi admin teknis Dinas Dalduk dan KB Kabupaten
                            Murung Raya.
                        </p>

                    </div>

                </div>

            </div>

            <div class="mt-8 text-center">

                <a class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-primary"
                    href="{{ route('home') }}">

                    <span class="material-symbols-outlined text-lg">
                        arrow_back
                    </span>

                    Kembali ke Beranda Publik

                </a>

            </div>

        </div>

    </main>

    <footer class="w-full border-t border-slate-200 bg-slate-100">

        <div
            class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-7 text-sm text-slate-600 sm:px-8 md:flex-row">

            <div>
                <strong class="text-slate-800">
                    PJPK Murung Raya
                </strong>

                · &copy; {{ now()->year }} Pemerintah Kabupaten Murung Raya
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
            passwordIcon.innerText = visible ? 'visibility' : 'visibility_off';
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
            const button = document.getElementById('submitButton');

            button.disabled = true;
            button.textContent = 'Memproses...';
        });
    </script>

</body>

</html>
