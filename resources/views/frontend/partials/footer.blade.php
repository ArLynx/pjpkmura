<footer class="bg-teal-800 text-white mt-20">

    <div class="max-w-7xl mx-auto px-6 py-14">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Logo --}}
            <div>

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-xl bg-white text-teal-700 flex items-center justify-center shadow">

                        <span class="material-symbols-outlined">
                            monitoring
                        </span>

                    </div>

                    <div>

                        <h2 class="text-2xl font-bold">

                            PJPK

                        </h2>

                        <p class="text-teal-100 text-sm">

                            Kabupaten Murung Raya

                        </p>

                    </div>

                </div>

                <p class="mt-6 text-teal-100 leading-7">

                    Website resmi Peta Jalan Pembangunan Kependudukan (PJPK)
                    Kabupaten Murung Raya sebagai media publikasi informasi,
                    monitoring capaian indikator pembangunan kependudukan,
                    berita, serta publikasi dokumen perencanaan daerah.

                </p>

            </div>

            {{-- Menu --}}
            <div>

                <h3 class="font-semibold text-lg mb-5">

                    Menu

                </h3>

                <div class="space-y-3">

                    <a href="{{ route('home') }}" class="block text-teal-100 hover:text-white transition">

                        Home

                    </a>

                    <a href="{{ route('dashboard') }}" class="block text-teal-100 hover:text-white transition">

                        Dashboard

                    </a>

                    <a href="#" class="block text-teal-100 hover:text-white transition">

                        Berita

                    </a>

                    <a href="#" class="block text-teal-100 hover:text-white transition">

                        Publikasi

                    </a>

                </div>

            </div>

            {{-- Kontak --}}
            <div>

                <h3 class="font-semibold text-lg mb-5">

                    Kontak

                </h3>

                <div class="space-y-4 text-teal-100">

                    <div class="flex items-start gap-3">

                        <span class="material-symbols-outlined">

                            location_on

                        </span>

                        <span>

                            Diskominfo Kabupaten Murung Raya

                        </span>

                    </div>

                    <div class="flex items-start gap-3">

                        <span class="material-symbols-outlined">

                            mail

                        </span>

                        <span>

                            diskominfo@murungrayakab.go.id

                        </span>

                    </div>

                    <div class="flex items-start gap-3">

                        <span class="material-symbols-outlined">

                            call

                        </span>

                        <span>

                            (0532) XXXXXXX

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Copyright --}}
    <div class="border-t border-teal-700">

        <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col md:flex-row justify-between items-center gap-3">

            <p class="text-sm text-teal-200">

                © 2026 Tim Pengembang Dinas Kominfo SP Kabupaten Murung Raya.
                Seluruh Hak Cipta Dilindungi.

            </p>

            <span class="px-3 py-1 rounded-full bg-teal-700 text-xs font-medium">

                Version 1.0.0

            </span>

        </div>

    </div>

</footer>
