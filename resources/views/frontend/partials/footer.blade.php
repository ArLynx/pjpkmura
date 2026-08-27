@php
    use App\Helpers\VisitorCounter;
    $statistik = VisitorCounter::count();
@endphp
<footer class="bg-primary text-white mt-16">

    {{-- ================================================= --}}
    {{-- MAIN FOOTER --}}
    {{-- ================================================= --}}
    <div class="max-w-7xl mx-auto px-6 py-7">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-7 lg:gap-12 items-start">

            {{-- ================================================= --}}
            {{-- KOLOM KIRI : IDENTITAS --}}
            {{-- ================================================= --}}
            <div class="min-w-0">

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 flex items-center justify-center shrink-0">

                        <img src="{{ asset('image/sipelanduk.png') }}" alt="Logo SIPELANDUK"
                            class="w-full h-full object-contain">

                    </div>

                    <div class="min-w-0">

                        <h2 class="text-xl font-bold leading-tight">
                            PJPK
                        </h2>

                        <p class="text-primary-light text-sm leading-tight">
                            Kabupaten Murung Raya
                        </p>

                    </div>

                </div>

                <p class="mt-3 max-w-md text-sm leading-6 text-primary-light">

                    Website resmi Peta Jalan Pembangunan Kependudukan (PJPK)
                    Kabupaten Murung Raya sebagai media publikasi informasi,
                    monitoring capaian indikator pembangunan kependudukan,
                    berita, serta publikasi dokumen perencanaan daerah.

                </p>

            </div>


            {{-- ================================================= --}}
            {{-- KOLOM TENGAH : DATA STATISTIK --}}
            {{-- ================================================= --}}
            <div class="flex justify-center">

                <div class="w-full max-w-xs">

                    <h3 class="flex items-center gap-2 text-base font-semibold leading-5 mb-3">

                        <span class="material-symbols-outlined text-lg shrink-0">
                            bar_chart
                        </span>

                        <span>
                            Statistik Pengunjung
                        </span>

                    </h3>

                    <div class="space-y-2 text-sm">

                        <div class="grid grid-cols-[185px_20px_32px] items-center">

                            <span class="text-primary-light">
                                Total Pengunjung
                            </span>

                            <span class="text-primary-light text-center">
                                :
                            </span>

                            <span class="text-white font-semibold text-left">
                                {{ $statistik['total'] }}
                            </span>

                        </div>

                        <div class="grid grid-cols-[185px_20px_32px] items-center">

                            <span class="text-primary-light">
                                Pengunjung Hari Ini
                            </span>

                            <span class="text-primary-light text-center">
                                :
                            </span>

                            <span class="text-white font-semibold text-left">
                                {{ $statistik['today'] }}
                            </span>

                        </div>

                        <div class="grid grid-cols-[185px_20px_32px] items-center">

                            <span class="text-primary-light">
                                Pengunjung Online
                            </span>

                            <span class="text-primary-light text-center">
                                :
                            </span>

                            <span class="text-white font-semibold text-left">
                                {{ $statistik['online'] }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- KOLOM KANAN : KONTAK --}}
            {{-- ================================================= --}}
            <div class="md:justify-self-end w-full md:max-w-sm">

                <h3 class="flex items-center gap-2 text-base font-semibold leading-5 mb-3">

                    <span class="material-symbols-outlined text-lg shrink-0">
                        support_agent
                    </span>

                    <span>
                        Kontak
                    </span>

                </h3>

                <div class="space-y-2 text-sm text-primary-light">

                    {{-- Alamat --}}
                    <div class="flex items-start gap-3">

                        <span class="material-symbols-outlined text-lg shrink-0">
                            location_on
                        </span>

                        <span class="leading-5">
                            Diskominfo Kabupaten Murung Raya
                        </span>

                    </div>

                    {{-- Email --}}
                    <div class="flex items-start gap-3">

                        <span class="material-symbols-outlined text-lg shrink-0">
                            mail
                        </span>

                        <span class="leading-5 break-words">
                            diskominfo@murungrayakab.go.id
                        </span>

                    </div>

                    {{-- Telepon --}}
                    <div class="flex items-start gap-3">

                        <span class="material-symbols-outlined text-lg shrink-0">
                            call
                        </span>

                        <span class="leading-5">
                            (0532) XXXXXXX
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- COPYRIGHT --}}
    {{-- ================================================= --}}
    <div class="border-t border-white/20">

        <div class="max-w-7xl mx-auto px-6 py-3">

            <div class="text-center">

                <a href="https://diskominfo.murungrayakab.go.id/developers" target="_blank" rel="noopener noreferrer"
                    class="inline-block text-xs leading-5 text-white transition-colors duration-300 hover:text-sky-200">

                    © {{ date('Y') }} Dinas Komunikasi, Informatika, Statistik dan Persandian Kabupaten Murung Raya

                </a>

            </div>

        </div>

    </div>

</footer>
