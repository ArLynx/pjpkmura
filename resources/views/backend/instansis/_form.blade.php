<div>

    <label for="nama" class="mb-2 block text-sm font-semibold text-slate-700">

        Nama Instansi

    </label>

    <input id="nama" name="nama" type="text" value="{{ old('nama', $instansi->nama ?? '') }}" required autofocus
        placeholder="Contoh: DP3A DALDUKKB"
        class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600">

</div>


<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

    <a href="{{ route('admin.instansis.index') }}"
        class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold text-slate-700 hover:bg-slate-50">

        Batal

    </a>


    <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 font-semibold text-white hover:bg-sky-700">

        {{ isset($instansi) ? 'Simpan Perubahan' : 'Tambah Instansi' }}

    </button>

</div>
