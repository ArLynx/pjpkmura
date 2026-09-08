<header class="sticky top-0 z-50 bg-primary shadow-md">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-6">

        <div class="relative flex h-16 items-center justify-between lg:h-20">

            {{-- ================================================= --}}
            {{-- LOGO --}}
            {{-- ================================================= --}}

            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-2 lg:gap-4">

                <div
                    class="flex h-11 w-11 flex-shrink-0 items-center justify-center
                            sm:h-12 sm:w-12
                            lg:h-18 lg:w-18">

                    <img src="{{ asset('image/sipelanduk.png') }}" alt="Logo SIPELANDUK"
                        class="h-full w-full object-contain">

                </div>

                <div class="min-w-0">

                    <h1
                        class="truncate text-base font-bold leading-tight text-white
                               sm:text-lg
                               lg:text-2xl">
                        SIPELANDUK
                    </h1>

                    <p
                        class="truncate text-[11px] leading-tight text-primary-light
                              sm:text-xs
                              lg:text-base">
                        Kabupaten Murung Raya
                    </p>

                </div>

            </a>


            {{-- ================================================= --}}
            {{-- MENU DESKTOP --}}
            {{-- ================================================= --}}

            <nav class="absolute left-1/2 hidden -translate-x-1/2 items-center gap-10 lg:flex">

                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'font-semibold text-white' : 'text-primary-light hover:text-white' }}">
                    Home
                </a>

                <a href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'font-semibold text-white' : 'text-primary-light hover:text-white' }}">
                    Dashboard
                </a>

                <a href="{{ route('berita.index') }}"
                    class="{{ request()->routeIs('berita.*') ? 'font-semibold text-white' : 'text-primary-light hover:text-white' }}">
                    Berita
                </a>

                <a href="{{ route('publikasi.index') }}"
                    class="{{ request()->routeIs('publikasi.*') ? 'font-semibold text-white' : 'text-primary-light hover:text-white' }}">
                    Publikasi
                </a>

            </nav>


            {{-- ================================================= --}}
            {{-- LOGIN DESKTOP --}}
            {{-- ================================================= --}}

            <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}"
                class="hidden rounded-xl bg-white px-6 py-3 font-semibold text-primary
                       transition-colors duration-300 hover:bg-primary-light lg:block">

                {{ auth()->check() ? 'Panel Admin' : 'Login' }}

            </a>


            {{-- ================================================= --}}
            {{-- HAMBURGER MOBILE --}}
            {{-- ================================================= --}}

            <button type="button" id="mobile-menu-button" aria-label="Buka menu" aria-expanded="false"
                class="flex h-10 w-10 items-center justify-center rounded-lg
                       text-white transition
                       hover:bg-white/10
                       focus:outline-none
                       focus:ring-2 focus:ring-white/40
                       lg:hidden">

                <span class="material-symbols-outlined text-[28px]">
                    menu
                </span>

            </button>

        </div>


        {{-- ================================================= --}}
        {{-- MOBILE MENU --}}
        {{-- ================================================= --}}

        <div id="mobile-menu"
            class="pointer-events-none invisible absolute left-0 right-0 top-full
           translate-y-[-8px] scale-[0.98]
           border-t border-white/10 bg-primary
           px-4 pb-4 pt-3 opacity-0 shadow-xl
           transition-all duration-300 ease-out
           lg:hidden">

            <nav class="space-y-1">

                {{-- HOME --}}
                <a href="{{ route('home') }}"
                    class="flex items-center rounded-lg px-4 py-3 text-sm font-medium
                   {{ request()->routeIs('home')
                       ? 'bg-white/15 text-white'
                       : 'text-primary-light hover:bg-white/10 hover:text-white' }}">

                    <span class="material-symbols-outlined mr-3 text-[20px]">
                        home
                    </span>

                    Home
                </a>


                {{-- DASHBOARD --}}
                <a href="{{ route('dashboard') }}"
                    class="flex items-center rounded-lg px-4 py-3 text-sm font-medium
                   {{ request()->routeIs('dashboard')
                       ? 'bg-white/15 text-white'
                       : 'text-primary-light hover:bg-white/10 hover:text-white' }}">

                    <span class="material-symbols-outlined mr-3 text-[20px]">
                        dashboard
                    </span>

                    Dashboard
                </a>


                {{-- BERITA --}}
                <a href="{{ route('berita.index') }}"
                    class="flex items-center rounded-lg px-4 py-3 text-sm font-medium
                   {{ request()->routeIs('berita.*')
                       ? 'bg-white/15 text-white'
                       : 'text-primary-light hover:bg-white/10 hover:text-white' }}">

                    <span class="material-symbols-outlined mr-3 text-[20px]">
                        newspaper
                    </span>

                    Berita
                </a>


                {{-- PUBLIKASI --}}
                <a href="{{ route('publikasi.index') }}"
                    class="flex items-center rounded-lg px-4 py-3 text-sm font-medium
                   {{ request()->routeIs('publikasi.*')
                       ? 'bg-white/15 text-white'
                       : 'text-primary-light hover:bg-white/10 hover:text-white' }}">

                    <span class="material-symbols-outlined mr-3 text-[20px]">
                        article
                    </span>

                    Publikasi
                </a>


                {{-- LOGIN --}}
                <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}"
                    class="mt-2 flex items-center justify-center rounded-lg
                   bg-white px-4 py-3 text-sm font-semibold text-primary">

                    <span class="material-symbols-outlined mr-2 text-[20px]">
                        {{ auth()->check() ? 'admin_panel_settings' : 'login' }}
                    </span>

                    {{ auth()->check() ? 'Panel Admin' : 'Login' }}

                </a>

            </nav>

        </div>

    </div>

</header>


{{-- ================================================= --}}
{{-- MOBILE MENU SCRIPT --}}
{{-- ================================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const button = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        const icon = button?.querySelector('.material-symbols-outlined');

        if (!button || !menu || !icon) return;


        function openMenu() {

            button.setAttribute('aria-expanded', 'true');

            icon.textContent = 'close';

            menu.classList.remove(
                'invisible',
                'opacity-0',
                'translate-y-[-8px]',
                'scale-[0.98]',
                'pointer-events-none'
            );

            menu.classList.add(
                'visible',
                'opacity-100',
                'translate-y-0',
                'scale-100',
                'pointer-events-auto'
            );
        }


        function closeMenu() {

            button.setAttribute('aria-expanded', 'false');

            icon.textContent = 'menu';

            menu.classList.remove(
                'visible',
                'opacity-100',
                'translate-y-0',
                'scale-100',
                'pointer-events-auto'
            );

            menu.classList.add(
                'invisible',
                'opacity-0',
                'translate-y-[-8px]',
                'scale-[0.98]',
                'pointer-events-none'
            );
        }


        button.addEventListener('click', function(event) {

            event.stopPropagation();

            const isOpen =
                button.getAttribute('aria-expanded') === 'true';

            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }

        });


        // Klik di luar menu = tutup
        document.addEventListener('click', function(event) {

            if (
                !menu.contains(event.target) &&
                !button.contains(event.target)
            ) {
                closeMenu();
            }

        });


        // Klik menu = tutup setelah memilih halaman
        menu.querySelectorAll('a').forEach(function(link) {

            link.addEventListener('click', function() {
                closeMenu();
            });

        });


        // Jika layar berubah ke desktop
        window.addEventListener('resize', function() {

            if (window.innerWidth >= 1024) {
                closeMenu();
            }

        });

    });
</script>
