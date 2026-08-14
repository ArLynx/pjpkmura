@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto py-8">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

        <div class="px-6 py-5 border-b border-slate-200">
            <h1 class="text-xl font-bold text-slate-800">
                Cetak Laporan Capaian
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Pilih tahun laporan yang ingin dicetak.
            </p>
        </div>

        <form
            action="{{ route('admin.capaian.laporan.pdf') }}"
            method="GET"
            target="_blank"
            class="p-6"
        >

            <div class="max-w-sm">

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Tahun Laporan
                </label>

                <select
                    name="tahun_id"
                    required
                    class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600"
                >

                    <option value="">
                        -- Pilih Tahun --
                    </option>

                    @foreach ($tahuns as $tahun)
                        <option value="{{ $tahun->id }}">
                            {{ $tahun->tahun }}
                        </option>
                    @endforeach

                </select>

            </div>

            <div class="mt-6 flex gap-3">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-5 py-3 font-semibold text-white hover:bg-red-700"
                >
                    <span class="material-symbols-outlined">
                        picture_as_pdf
                    </span>

                    Cetak PDF
                </button>

            </div>

        </form>

    </div>

</div>

@endsection