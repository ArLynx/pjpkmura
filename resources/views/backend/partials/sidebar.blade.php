@php
    $menuClass = 'flex items-center gap-3 rounded-xl px-4 py-3 font-medium transition';

    // Warna biru langit seperti tombol Berita Terbaru
    $activeClass = 'bg-[#0B91CF] text-white shadow-sm';

    // Warna menu normal + hover
    $idleClass = 'text-slate-700 hover:bg-[#E0F4FC] hover:text-[#0879AE]';
@endphp

<aside id="adminSidebar"
    class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col border-r border-[#D5EEF8] bg-[#F0FAFD] transition-transform duration-200 lg:translate-x-0">

    {{-- Logo --}}
    <div class="flex h-20 items-center border-b border-[#D5EEF8] px-6">

        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">

            {{-- Icon --}}
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#0B91CF] text-white shadow-sm">
                <span class="material-symbols-outlined">
                    monitoring
                </span>
            </div>

            {{-- Nama --}}
            <div>
                <div class="text-xl font-bold text-[#075985]">
                    PJPK
                </div>

                <div class="text-xs text-[#0879AE]">
                    Kabupaten Murung Raya
                </div>
            </div>

        </a>

    </div>


    {{-- Menu --}}
    <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-5">

        {{-- ===================================================== --}}
        {{-- SUPER ADMIN --}}
        {{-- ===================================================== --}}

        @if (auth()->user()->role === 'superadmin')
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
                class="{{ $menuClass }} {{ request()->routeIs('admin.dashboard') ? $activeClass : $idleClass }}">

                <span class="material-symbols-outlined">
                    dashboard
                </span>

                Dashboard

            </a>

            {{-- Kelola Instansi --}}
            <a href="{{ route('admin.instansis.index') }}"
                class="{{ $menuClass }} {{ request()->routeIs('admin.instansis.*') ? $activeClass : $idleClass }}">

                <span class="material-symbols-outlined">
                    account_balance
                </span>

                Kelola Instansi

            </a>

            {{-- Kelola User --}}
            <a href="{{ route('admin.users.index') }}"
                class="{{ $menuClass }} {{ request()->routeIs('admin.users.*') ? $activeClass : $idleClass }}">

                <span class="material-symbols-outlined">
                    group
                </span>

                Kelola User

            </a>


            {{-- Kelola Pilar --}}
            <a href="{{ route('admin.pilars.index') }}"
                class="{{ $menuClass }} {{ request()->routeIs('admin.pilars.*') ? $activeClass : $idleClass }}">

                <span class="material-symbols-outlined">
                    account_tree
                </span>

                Kelola Pilar

            </a>


            {{-- Kelola Indikator --}}
            <a href="{{ route('admin.indikators.index') }}"
                class="{{ $menuClass }} {{ request()->routeIs('admin.indikators.*') ? $activeClass : $idleClass }}">

                <span class="material-symbols-outlined">
                    analytics
                </span>

                Kelola Indikator

            </a>


            {{-- Capaian --}}
            <a href="{{ route('admin.capaian.index') }}"
                class="{{ $menuClass }} {{ request()->routeIs('admin.capaian.*') ? $activeClass : $idleClass }}">

                <span class="material-symbols-outlined">
                    edit_note
                </span>

                Capaian

            </a>


            {{-- Berita --}}
            <a href="{{ route('admin.beritas.index') }}"
                class="{{ $menuClass }} {{ request()->routeIs('admin.beritas.*') ? $activeClass : $idleClass }}">

                <span class="material-symbols-outlined">
                    newspaper
                </span>

                Berita

            </a>


            {{-- Publikasi --}}
            <a href="{{ route('admin.publikasis.index') }}"
                class="{{ $menuClass }} {{ request()->routeIs('admin.publikasis.*') ? $activeClass : $idleClass }}">

                <span class="material-symbols-outlined">
                    menu_book
                </span>

                Publikasi

            </a>


            {{-- Profil --}}
            <a href="{{ route('admin.profile.edit') }}"
                class="{{ $menuClass }} {{ request()->routeIs('admin.profile.*') ? $activeClass : $idleClass }}">

                <span class="material-symbols-outlined">
                    person
                </span>

                Profil

            </a>


            {{-- ===================================================== --}}
            {{-- ADMIN BIASA --}}
            {{-- ===================================================== --}}
        @else
            {{-- Capaian --}}
            <a href="{{ route('admin.capaian.index') }}"
                class="{{ $menuClass }} {{ request()->routeIs('admin.capaian.*') ? $activeClass : $idleClass }}">

                <span class="material-symbols-outlined">
                    edit_note
                </span>

                Capaian

            </a>


            {{-- Profil --}}
            <a href="{{ route('admin.profile.edit') }}"
                class="{{ $menuClass }} {{ request()->routeIs('admin.profile.*') ? $activeClass : $idleClass }}">

                <span class="material-symbols-outlined">
                    person
                </span>

                Profil

            </a>
        @endif


        {{-- Garis pemisah --}}
        <div class="my-4 border-t border-[#BDE5F5]"></div>


        {{-- Lihat Situs --}}
        <a href="{{ route('home') }}" target="_blank" class="{{ $menuClass }} {{ $idleClass }}">

            <span class="material-symbols-outlined">
                open_in_new
            </span>

            Lihat Situs

        </a>


        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit" class="{{ $menuClass }} w-full text-red-600 hover:bg-red-100">

                <span class="material-symbols-outlined">
                    logout
                </span>

                Keluar

            </button>

        </form>

    </nav>

</aside>
