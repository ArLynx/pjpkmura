<header class="sticky top-0 z-30 border-b border-[#D5EEF8] bg-[#F0FAFD]">

    <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

        {{-- ==================== KIRI ==================== --}}
        <div class="flex items-center gap-4">

            {{-- Tombol sidebar mobile --}}
            <button
                id="sidebarToggle"
                type="button"
                class="rounded-xl p-2 text-slate-600 transition hover:bg-[#E0F4FC] hover:text-[#0879AE] lg:hidden"
            >
                <span class="material-symbols-outlined">
                    menu
                </span>
            </button>

            {{-- Judul halaman --}}
            <div>
                <h1 class="text-2xl font-bold text-[#075985]">
                    @yield('page-title', 'Dashboard Admin')
                </h1>

                <p class="mt-1 text-sm text-[#0879AE]">
                    Sistem pemantauan PJPK Kabupaten Murung Raya
                </p>
            </div>

        </div>


        {{-- ==================== KANAN ==================== --}}
        <div class="flex items-center">

            <a
                href="{{ route('admin.profile.edit') }}"
                class="flex items-center gap-3 rounded-xl px-2 py-2 transition hover:bg-[#E0F4FC]"
            >

                {{-- Informasi user --}}
                <div class="hidden text-right sm:block">

                    {{-- Nama --}}
                    <div class="font-semibold text-[#075985]">
                        {{ auth()->user()->name }}
                    </div>

                    {{-- Role --}}
                    <div class="text-xs capitalize text-[#0879AE]">

                        @if(auth()->user()->role === 'superadmin')
                            Superadmin
                        @else
                            Admin
                        @endif

                        {{-- Instansi --}}
                        @if(auth()->user()->instansi)
                            · {{ auth()->user()->instansi->nama }}
                        @endif

                    </div>

                </div>


                {{-- Icon profile --}}
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-full bg-[#0B91CF] text-white shadow-sm"
                >
                    <span class="material-symbols-outlined">
                        person
                    </span>
                </div>

            </a>

        </div>

    </div>

</header>