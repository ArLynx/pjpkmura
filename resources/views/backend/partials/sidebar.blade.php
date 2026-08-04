@php
    $menuClass = 'flex items-center gap-3 rounded-xl px-4 py-3 font-medium transition';
    $activeClass = 'bg-teal-700 text-white shadow-sm';
    $idleClass = 'text-slate-700 hover:bg-teal-100 hover:text-teal-900';
@endphp

<aside id="adminSidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col border-r border-teal-100 bg-teal-50 transition-transform duration-200 lg:translate-x-0">
    <div class="flex h-20 items-center border-b border-teal-100 px-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-700 text-white shadow-sm">
                <span class="material-symbols-outlined">monitoring</span>
            </div>
            <div>
                <div class="text-xl font-bold text-teal-900">PJPK</div>
                <div class="text-xs text-teal-700">Kabupaten Murung Raya</div>
            </div>
        </a>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-5">
        <a href="{{ route('admin.dashboard') }}" class="{{ $menuClass }} {{ request()->routeIs('admin.dashboard') ? $activeClass : $idleClass }}">
            <span class="material-symbols-outlined">dashboard</span> Dashboard
        </a>

        @if(auth()->user()->role === 'superadmin')
            <a href="{{ route('admin.users.index') }}" class="{{ $menuClass }} {{ request()->routeIs('admin.users.*') ? $activeClass : $idleClass }}">
                <span class="material-symbols-outlined">group</span> Kelola User
            </a>
        @endif

        <a href="{{ route('admin.pilars.index') }}" class="{{ $menuClass }} {{ request()->routeIs('admin.pilars.*') ? $activeClass : $idleClass }}">
            <span class="material-symbols-outlined">account_tree</span> Kelola Pilar
        </a>
        <a href="{{ route('admin.indikators.index') }}" class="{{ $menuClass }} {{ request()->routeIs('admin.indikators.*') ? $activeClass : $idleClass }}">
            <span class="material-symbols-outlined">analytics</span> Kelola Indikator
        </a>
        <a href="{{ route('admin.targets.index') }}" class="{{ $menuClass }} {{ request()->routeIs('admin.targets.*') ? $activeClass : $idleClass }}">
            <span class="material-symbols-outlined">flag</span> Target
        </a>
        <a href="{{ route('admin.realisasis.index') }}" class="{{ $menuClass }} {{ request()->routeIs('admin.realisasis.*') ? $activeClass : $idleClass }}">
            <span class="material-symbols-outlined">monitoring</span> Realisasi
        </a>
        <a href="{{ route('admin.data-pendukungs.index') }}" class="{{ $menuClass }} {{ request()->routeIs('admin.data-pendukungs.*') ? $activeClass : $idleClass }}">
            <span class="material-symbols-outlined">folder</span> Data Pendukung
        </a>
        <a href="{{ route('admin.beritas.index') }}" class="{{ $menuClass }} {{ request()->routeIs('admin.beritas.*') ? $activeClass : $idleClass }}">
            <span class="material-symbols-outlined">newspaper</span> Berita
        </a>
        <a href="{{ route('admin.publikasis.index') }}" class="{{ $menuClass }} {{ request()->routeIs('admin.publikasis.*') ? $activeClass : $idleClass }}">
            <span class="material-symbols-outlined">menu_book</span> Publikasi
        </a>
        <a href="{{ route('admin.profile.edit') }}" class="{{ $menuClass }} {{ request()->routeIs('admin.profile.*') ? $activeClass : $idleClass }}">
            <span class="material-symbols-outlined">person</span> Profil
        </a>

        <div class="my-4 border-t border-teal-200"></div>
        <a href="{{ route('home') }}" target="_blank" class="{{ $menuClass }} {{ $idleClass }}">
            <span class="material-symbols-outlined">open_in_new</span> Lihat Situs
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="{{ $menuClass }} w-full text-red-600 hover:bg-red-100">
                <span class="material-symbols-outlined">logout</span> Keluar
            </button>
        </form>
    </nav>
</aside>
