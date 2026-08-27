@extends('backend.layouts.app')

@section('title', 'Tambah Instansi')
@section('page-title', 'Tambah Instansi')

@section('content')

<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

    <div class="mb-6">

        <h2 class="text-xl font-bold text-slate-900">
            Tambah Instansi
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Tambahkan instansi yang dapat menjadi penanggung jawab indikator.
        </p>

    </div>

    <form method="POST" action="{{ route('admin.instansis.store') }}">

        @csrf

        @include('backend.instansis._form')

    </form>

</div>

@endsection