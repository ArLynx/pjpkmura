<header class="sticky top-0 z-50 bg-teal-800 shadow-md">

    <div class="max-w-7xl mx-auto px-6">

        <div class="h-20 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-4">

                <div
                    class="w-14 h-14 rounded-xl bg-white text-teal-700 flex items-center justify-center shadow">

                    <span class="material-symbols-outlined text-3xl">

                        monitoring

                    </span>

                </div>

                <div>

                    <h1 class="text-2xl font-bold text-white">

                        PJPK

                    </h1>

                    <p class="text-teal-100">

                        Kabupaten Murung Raya

                    </p>

                </div>

            </a>

            {{-- Menu --}}
            <nav class="hidden lg:flex items-center gap-10">

                <a href="{{ route('home') }}"
                    class="text-teal-100 hover:text-white transition">

                    Home

                </a>

                <a href="{{ route('dashboard') }}"
                    class="text-teal-100 hover:text-white transition">

                    Dashboard

                </a>

                <a href="#"
                    class="text-teal-100 hover:text-white transition">

                    Berita

                </a>

                <a href="#"
                    class="text-teal-100 hover:text-white transition">

                    Publikasi

                </a>

            </nav>

            {{-- Login --}}
            <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}"
                class="bg-white text-teal-700 font-semibold px-6 py-3 rounded-xl hover:bg-teal-50 transition">

                {{ auth()->check() ? 'Panel Admin' : 'Login' }}

            </a>

        </div>

    </div>

</header>