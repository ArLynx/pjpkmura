@php($editing = isset($berita))

<div class="grid gap-6">


    {{-- JUDUL --}}
    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Judul Berita
        </label>

        <input
            name="judul"
            value="{{ old('judul', $berita->judul ?? '') }}"
            required
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >

    </div>


    {{-- FOTO --}}
    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Foto
        </label>

        <input
            type="file"
            name="foto"
            accept="image/png,image/jpeg,image/webp"
            class="w-full rounded-xl border border-slate-300 p-3
                   file:mr-4 file:rounded-lg file:border-0
                   file:bg-sky-100 file:px-4 file:py-2
                   file:font-semibold file:text-sky-800"
        >

        <p class="mt-2 text-xs text-slate-500">
            JPG, PNG, atau WebP. Maksimal 5 MB.
        </p>


        @if($editing && $berita->foto)

            <div class="mt-3">

                <p class="mb-2 text-xs font-semibold text-slate-500">
                    Foto saat ini
                </p>

                <img
                    src="{{ Storage::url($berita->foto) }}"
                    alt="Foto berita"
                    class="h-36 rounded-xl object-cover"
                >

            </div>

        @endif

    </div>


    {{-- ISI BERITA --}}
    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Isi Berita
        </label>

        <textarea
            name="isi"
            rows="12"
            required
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >{{ old('isi', $berita->isi ?? '') }}</textarea>

    </div>


    {{-- PENULIS --}}
    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Penulis
        </label>

        <input
            name="penulis"
            value="{{ old('penulis', $berita->penulis ?? auth()->user()->name) }}"
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >

    </div>

</div>


{{-- BUTTON --}}
<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

    <a
        href="{{ route('admin.beritas.index') }}"
        class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold text-slate-700 hover:bg-slate-50"
    >
        Batal
    </a>

    <button
        type="submit"
        class="rounded-xl bg-[#0B91CF] px-6 py-3 font-semibold text-white hover:bg-[#0879AE]"
    >
        {{ $editing ? 'Simpan Perubahan' : 'Terbitkan Berita' }}
    </button>

</div>