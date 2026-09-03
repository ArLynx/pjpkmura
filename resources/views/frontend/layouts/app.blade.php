<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'PJPK Kabupaten Murung Raya')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/png" href="{{ asset('image/logo-murung-raya.png') }}">

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Material Icon --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <style>
        body {

            font-family: 'Inter', sans-serif;

        }
    </style>

</head>

<body class="bg-slate-50 flex flex-col min-h-screen">

    @include('frontend.partials.header')

    <main class="flex-1">

        @yield('content')

    </main>

    @include('frontend.partials.footer')

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    @stack('scripts')

    {{-- ========================================================= --}}
    {{-- FLOATING NAVIGATION --}}
    {{-- Dashboard = Daftar Section --}}
    {{-- Halaman lain = Kembali ke Atas --}}
    {{-- ========================================================= --}}

    @if (request()->routeIs('dashboard'))
        {{-- ===================================================== --}}
        {{-- DASHBOARD SECTION NAVIGATION --}}
        {{-- ===================================================== --}}
        <div id="dashboardSectionNav" class="fixed bottom-6 right-6 z-[60]">

            {{-- Tombol utama --}}
            <button type="button" id="dashboardNavButton" aria-label="Navigasi Dashboard" aria-expanded="false"
                class="flex h-12 w-12 items-center justify-center rounded-full bg-[#005B96] text-white shadow-lg shadow-[#005B96]/25 transition duration-200 hover:bg-[#004A7A] hover:shadow-xl hover:shadow-[#005B96]/30 focus:outline-none focus:ring-4 focus:ring-[#005B96]/20">
                <span id="dashboardNavIcon"
                    class="material-symbols-outlined text-[22px] transition-transform duration-200">
                    menu
                </span>
            </button>


            {{-- ================================================= --}}
            {{-- PANEL SECTION --}}
            {{-- ================================================= --}}
            <div id="dashboardNavPanel"
                class="pointer-events-none absolute bottom-14 right-0 mb-3 w-72 origin-bottom-right scale-95 opacity-0 transition-all duration-200">

                <div
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/10">

                    {{-- Header --}}
                    <div class="border-b border-slate-100 px-4 py-3.5">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-light text-primary">

                                <span class="material-symbols-outlined text-[19px]">
                                    dashboard
                                </span>

                            </div>

                            <div>

                                <h3 class="text-sm font-semibold text-slate-900">
                                    Navigasi Dashboard
                                </h3>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    Pilih bagian yang ingin dilihat
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Daftar Section --}}
                    <div class="max-h-[min(70vh,420px)] overflow-y-auto p-2">

                        {{-- Dashboard Utama --}}
                        <a href="#dashboard-top"
                            class="dashboard-nav-item group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-light hover:text-primary">
                            <span class="material-symbols-outlined text-[19px] text-slate-400 group-hover:text-primary">
                                dashboard
                            </span>

                            <span class="min-w-0 flex-1 truncate">
                                Dashboard Utama
                            </span>
                        </a>


                        {{-- Tren & Status --}}
                        <a href="#dashboard-tren-status"
                            class="dashboard-nav-item group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-light hover:text-primary">
                            <span class="material-symbols-outlined text-[19px] text-slate-400 group-hover:text-primary">
                                monitoring
                            </span>

                            <span class="min-w-0 flex-1 truncate">
                                Tren & Status Indikator
                            </span>
                        </a>


                        {{-- Pilar --}}
                        <a href="#dashboard-pilar"
                            class="dashboard-nav-item group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-light hover:text-primary">
                            <span class="material-symbols-outlined text-[19px] text-slate-400 group-hover:text-primary">
                                account_tree
                            </span>

                            <span class="min-w-0 flex-1 truncate">
                                Ringkasan 5 Pilar
                            </span>
                        </a>


                        {{-- Ringkasan --}}
                        <a href="#dashboard-ringkasan"
                            class="dashboard-nav-item group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-light hover:text-primary">
                            <span class="material-symbols-outlined text-[19px] text-slate-400 group-hover:text-primary">
                                summarize
                            </span>

                            <span class="min-w-0 flex-1 truncate">
                                Ringkasan Indikator
                            </span>
                        </a>


                        {{-- Filter --}}
                        <a href="#dashboard-filter"
                            class="dashboard-nav-item group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-light hover:text-primary">
                            <span class="material-symbols-outlined text-[19px] text-slate-400 group-hover:text-primary">
                                tune
                            </span>

                            <span class="min-w-0 flex-1 truncate">
                                Filter Monitoring
                            </span>
                        </a>


                        {{-- Statistik --}}
                        <a href="#dashboard-statistik"
                            class="dashboard-nav-item group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-light hover:text-primary">
                            <span class="material-symbols-outlined text-[19px] text-slate-400 group-hover:text-primary">
                                analytics
                            </span>

                            <span class="min-w-0 flex-1 truncate">
                                Statistik
                            </span>
                        </a>


                        {{-- Monitoring --}}
                        <a href="#dashboard-monitoring"
                            class="dashboard-nav-item group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-light hover:text-primary">
                            <span class="material-symbols-outlined text-[19px] text-slate-400 group-hover:text-primary">
                                table_chart
                            </span>

                            <span class="min-w-0 flex-1 truncate">
                                Data Monitoring PJPK
                            </span>
                        </a>

                    </div>

                </div>

            </div>

        </div>
    @else
        {{-- ===================================================== --}}
        {{-- KEMBALI KE ATAS --}}
        {{-- ===================================================== --}}
        <button type="button" id="backToTop" aria-label="Kembali ke atas"
            class="fixed bottom-6 right-6 z-[60] flex h-12 w-12 translate-y-4 items-center justify-center rounded-full bg-[#005B96] text-white opacity-0 shadow-lg shadow-[#005B96]/25 transition-all duration-300 hover:bg-[#004A7A] hover:shadow-xl hover:shadow-[#005B96]/30 focus:outline-none focus:ring-4 focus:ring-[#005B96]/20 pointer-events-none">

            <span class="material-symbols-outlined text-[22px]">
                keyboard_arrow_up
            </span>

        </button>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* =====================================================
               DASHBOARD NAVIGATION
            ===================================================== */

            const dashboardNavButton = document.getElementById('dashboardNavButton');
            const dashboardNavPanel = document.getElementById('dashboardNavPanel');
            const dashboardNavIcon = document.getElementById('dashboardNavIcon');

            if (dashboardNavButton && dashboardNavPanel) {

                dashboardNavButton.addEventListener('click', function(event) {

                    event.stopPropagation();

                    const isOpen =
                        dashboardNavButton.getAttribute('aria-expanded') === 'true';

                    dashboardNavButton.setAttribute(
                        'aria-expanded',
                        String(!isOpen)
                    );

                    if (!isOpen) {

                        dashboardNavPanel.classList.remove(
                            'pointer-events-none',
                            'scale-95',
                            'opacity-0'
                        );

                        dashboardNavPanel.classList.add(
                            'pointer-events-auto',
                            'scale-100',
                            'opacity-100'
                        );

                        dashboardNavIcon.textContent = 'close';

                    } else {

                        dashboardNavPanel.classList.remove(
                            'pointer-events-auto',
                            'scale-100',
                            'opacity-100'
                        );

                        dashboardNavPanel.classList.add(
                            'pointer-events-none',
                            'scale-95',
                            'opacity-0'
                        );

                        dashboardNavIcon.textContent = 'menu';

                    }

                });


                /*
                 * Navigasi section dashboard
                 * - Memberikan status aktif
                 * - Scroll smooth
                 * - Menutup panel setelah memilih
                 */
                document.querySelectorAll('.dashboard-nav-item').forEach(function(item) {

                    item.addEventListener('click', function(event) {

                        event.preventDefault();

                        const targetId = this.getAttribute('href');

                        if (!targetId || !targetId.startsWith('#')) {
                            return;
                        }

                        const target = document.querySelector(targetId);

                        if (!target) {
                            console.warn('Section tidak ditemukan:', targetId);
                            return;
                        }


                        /* =================================================
                           HAPUS STATUS AKTIF DARI SEMUA MENU
                        ================================================= */

                        document.querySelectorAll('.dashboard-nav-item').forEach(function(navItem) {

                            navItem.classList.remove(
                                'bg-primary-light',
                                'text-primary',
                                'active'
                            );

                            navItem.setAttribute('aria-current', 'false');

                            const icon = navItem.querySelector(
                            '.material-symbols-outlined');

                            if (icon) {
                                icon.classList.remove('text-primary');
                                icon.classList.add('text-slate-400');
                            }

                        });


                        /* =================================================
                           TANDAI MENU YANG DIPILIH
                        ================================================= */

                        this.classList.add(
                            'bg-primary-light',
                            'text-primary',
                            'active'
                        );

                        this.setAttribute('aria-current', 'true');

                        const activeIcon =
                            this.querySelector('.material-symbols-outlined');

                        if (activeIcon) {
                            activeIcon.classList.remove('text-slate-400');
                            activeIcon.classList.add('text-primary');
                        }


                        /* =================================================
                           TUTUP PANEL
                        ================================================= */

                        dashboardNavPanel.classList.remove(
                            'pointer-events-auto',
                            'scale-100',
                            'opacity-100'
                        );

                        dashboardNavPanel.classList.add(
                            'pointer-events-none',
                            'scale-95',
                            'opacity-0'
                        );

                        dashboardNavButton.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                        dashboardNavIcon.textContent = 'menu';


                        /* =================================================
                           SMOOTH SCROLL
                        ================================================= */

                        const headerOffset = 90;

                        const targetPosition =
                            target.getBoundingClientRect().top +
                            window.pageYOffset -
                            headerOffset;

                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });

                    });

                });


                /*
                 * Klik di luar panel = tutup.
                 */
                document.addEventListener('click', function(event) {

                    const navigation =
                        document.getElementById('dashboardSectionNav');

                    if (
                        navigation &&
                        !navigation.contains(event.target)
                    ) {

                        dashboardNavPanel.classList.remove(
                            'pointer-events-auto',
                            'scale-100',
                            'opacity-100'
                        );

                        dashboardNavPanel.classList.add(
                            'pointer-events-none',
                            'scale-95',
                            'opacity-0'
                        );

                        dashboardNavButton.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                        dashboardNavIcon.textContent = 'menu';

                    }

                });

            }


            /* =====================================================
               BACK TO TOP — HALAMAN LAIN
            ===================================================== */

            const backToTop = document.getElementById('backToTop');

            if (backToTop) {

                const toggleBackToTop = function() {

                    if (window.scrollY > 400) {

                        backToTop.classList.remove(
                            'opacity-0',
                            'translate-y-4',
                            'pointer-events-none'
                        );

                        backToTop.classList.add(
                            'opacity-100',
                            'translate-y-0',
                            'pointer-events-auto'
                        );

                    } else {

                        backToTop.classList.remove(
                            'opacity-100',
                            'translate-y-0',
                            'pointer-events-auto'
                        );

                        backToTop.classList.add(
                            'opacity-0',
                            'translate-y-4',
                            'pointer-events-none'
                        );

                    }

                };


                window.addEventListener(
                    'scroll',
                    toggleBackToTop, {
                        passive: true
                    }
                );


                toggleBackToTop();


                backToTop.addEventListener('click', function() {

                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });

                });

            }

        });
    </script>

</body>

</html>
