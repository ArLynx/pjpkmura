@php($editing = isset($pilar))

<div class="grid gap-6 md:grid-cols-[1fr_180px]">

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Nama Pilar
        </label>

        <input
            name="nama"
            value="{{ old('nama', $pilar->nama ?? '') }}"
            required
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >
    </div>


    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Urutan
        </label>

        <input
            type="number"
            min="1"
            name="urutan"
            value="{{ old('urutan', $pilar->urutan ?? 1) }}"
            required
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >
    </div>

</div>


<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

    <a
        href="{{ route('admin.pilars.index') }}"
        class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold text-slate-700 hover:bg-slate-50"
    >
        Batal
    </a>

    <button
        type="submit"
        class="rounded-xl bg-[#0B91CF] px-6 py-3 font-semibold text-white hover:bg-[#0879AE]"
    >
        {{ $editing ? 'Simpan Perubahan' : 'Tambah Pilar' }}
    </button>

</div>