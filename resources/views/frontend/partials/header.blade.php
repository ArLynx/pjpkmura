<header class="sticky top-0 z-50 bg-primary shadow-md">

    <div class="max-w-7xl mx-auto px-6">

        <div class="relative h-20 flex items-center justify-between">

            {{-- ================================================= --}}
            {{-- LOGO --}}
            {{-- ================================================= --}}

            <a href="{{ route('home') }}" class="flex items-center gap-4">

                <div class="w-18 h-18 flex items-center justify-center">

                    <img src="{{ asset('image/sipelanduk.png') }}" alt="Logo SIPELANDUK"
                        class="w-full h-full object-contain">

                </div>

                <div>

                    <h1 class="text-2xl font-bold text-white">
                        PJPK
                    </h1>

                    <p class="text-primary-light">
                        Kabupaten Murung Raya
                    </p>

                </div>

            </a>


            {{-- ================================================= --}}
            {{-- MENU --}}
            {{-- ================================================= --}}

            <nav class="hidden lg:flex absolute left-1/2 -translate-x-1/2 items-center gap-10">

                {{-- HOME --}}
                <a href="{{ route('home') }}"
                    class="transition-colors duration-300
                    {{ request()->routeIs('home') ? 'text-white font-semibold' : 'text-primary-light hover:text-white' }}">
                    Home
                </a>


                {{-- DASHBOARD --}}
                <a href="{{ route('dashboard') }}"
                    class="transition-colors duration-300
                    {{ request()->routeIs('dashboard') ? 'text-white font-semibold' : 'text-primary-light hover:text-white' }}">
                    Dashboard
                </a>


                {{-- BERITA --}}
                <a href="{{ route('berita.index') }}"
                    class="transition-colors duration-300
                    {{ request()->routeIs('berita.*') ? 'text-white font-semibold' : 'text-primary-light hover:text-white' }}">
                    Berita
                </a>


                {{-- PUBLIKASI --}}
                <a href="{{ route('publikasi.index') }}"
                    class="transition-colors duration-300
                    {{ request()->routeIs('publikasi.*') ? 'text-white font-semibold' : 'text-primary-light hover:text-white' }}">
                    Publikasi
                </a>

            </nav>


            {{-- ================================================= --}}
            {{-- LOGIN / PANEL ADMIN --}}
            {{-- ================================================= --}}

            <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}"
                class="bg-white text-primary font-semibold px-6 py-3 rounded-xl
                transition-colors duration-300 hover:bg-primary-light">

                {{ auth()->check() ? 'Panel Admin' : 'Login' }}

            </a>

        </div>

    </div>

</header>
