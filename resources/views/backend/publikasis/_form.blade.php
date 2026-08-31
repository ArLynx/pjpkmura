@php
    $editing = isset($publikasi);
@endphp


<div class="grid gap-6 md:grid-cols-2">


    {{-- ========================================================= --}}
    {{-- JUDUL --}}
    {{-- ========================================================= --}}

    <div class="md:col-span-2">

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Judul Publikasi
        </label>

        <input
            type="text"
            name="judul"
            value="{{ old('judul', $publikasi->judul ?? '') }}"
            required
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >

    </div>


    {{-- ========================================================= --}}
    {{-- COVER --}}
    {{-- ========================================================= --}}

    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Cover
        </label>


        <input
            type="file"
            name="cover"
            accept="image/png,image/jpeg,image/webp"
            class="w-full rounded-xl border border-slate-300 p-3
                   file:mr-4
                   file:rounded-lg
                   file:border-0
                   file:bg-sky-100
                   file:px-4
                   file:py-2
                   file:font-semibold
                   file:text-sky-800"
        >


        <p class="mt-2 text-xs text-slate-500">
            JPG, PNG, atau WebP. Maksimal 5 MB.
        </p>


        {{-- COVER SAAT INI --}}

        @if($editing && $publikasi->cover)

            <div class="mt-3">

                <p class="mb-2 text-xs font-semibold text-slate-500">
                    Cover saat ini
                </p>


                <img
                    src="{{ asset('storage/' . ltrim($publikasi->cover, '/')) }}"
                    alt="{{ $publikasi->judul }}"
                    class="h-40 w-32 rounded-xl bg-slate-100 object-contain"
                >

            </div>

        @endif

    </div>


    {{-- ========================================================= --}}
    {{-- FILE PUBLIKASI --}}
    {{-- ========================================================= --}}

    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">

            File Publikasi

            @if($editing)
                <span class="font-normal">(opsional)</span>
            @endif

        </label>


        <input
            type="file"
            name="file"
            {{ $editing ? '' : 'required' }}
            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
            class="w-full rounded-xl border border-slate-300 p-3
                   file:mr-4
                   file:rounded-lg
                   file:border-0
                   file:bg-sky-100
                   file:px-4
                   file:py-2
                   file:font-semibold
                   file:text-sky-800"
        >


        <p class="mt-2 text-xs text-slate-500">
            PDF atau dokumen Office. Maksimal 50 MB.
        </p>


        {{-- FILE SAAT INI --}}

        @if($editing && $publikasi->file)

            <a
                href="{{ asset('storage/' . ltrim($publikasi->file, '/')) }}"
                target="_blank"
                class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-[#0B91CF] hover:text-[#0879AE] hover:underline"
            >

                <span class="material-symbols-outlined text-lg">
                    description
                </span>

                Lihat file saat ini

            </a>

        @endif

    </div>


    {{-- ========================================================= --}}
    {{-- DESKRIPSI --}}
    {{-- ========================================================= --}}

    <div class="md:col-span-2">

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Deskripsi
        </label>

        <textarea
            name="deskripsi"
            rows="5"
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >{{ old('deskripsi', $publikasi->deskripsi ?? '') }}</textarea>

    </div>


    {{-- ========================================================= --}}
    {{-- PENULIS --}}
    {{-- ========================================================= --}}

    <div class="md:col-span-2">

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Penulis
        </label>

        <input
            type="text"
            name="penulis"
            value="{{ old('penulis', $publikasi->penulis ?? auth()->user()->name) }}"
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >

    </div>

</div>


{{-- ========================================================= --}}
{{-- BUTTON --}}
{{-- ========================================================= --}}

<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">


    <a
        href="{{ route('admin.publikasis.index') }}"
        class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold text-slate-700 hover:bg-slate-50"
    >

        Batal

    </a>


    <button
        type="submit"
        class="rounded-xl bg-[#0B91CF] px-6 py-3 font-semibold text-white hover:bg-[#0879AE]"
    >

        {{ $editing ? 'Simpan Perubahan' : 'Tambah Publikasi' }}

    </button>

</div>