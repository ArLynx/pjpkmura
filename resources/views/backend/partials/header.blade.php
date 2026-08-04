<header class="sticky top-0 z-20 border-b border-teal-100 bg-teal-50/95 shadow-sm backdrop-blur">
    <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button id="sidebarToggle" type="button" class="rounded-lg p-2 text-teal-800 hover:bg-teal-100 lg:hidden" aria-label="Buka menu">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div>
                <h1 class="text-xl font-bold text-teal-950 sm:text-2xl">@yield('page-title', 'Dashboard')</h1>
                <p class="mt-1 hidden text-sm text-teal-700 sm:block">Sistem pemantauan PJPK Kabupaten Murung Raya</p>
            </div>
        </div>

        <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 rounded-xl px-2 py-2 hover:bg-teal-100">
            <div class="hidden text-right sm:block">
                <div class="font-semibold text-teal-950">{{ auth()->user()->name }}</div>
                <div class="text-xs capitalize text-teal-700">{{ auth()->user()->role }}{{ auth()->user()->instansi ? ' · '.auth()->user()->instansi : '' }}</div>
            </div>
            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-teal-700 text-white shadow-sm">
                <span class="material-symbols-outlined">person</span>
            </div>
        </a>
    </div>
</header>
