@extends('backend.layouts.app')

@section('title', 'Edit Instansi')
@section('page-title', 'Edit Instansi')

@section('content')

<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

    <div class="mb-6">

        <h2 class="text-xl font-bold text-slate-900">
            Edit Instansi
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Perbarui nama instansi.
        </p>

    </div>

    <form method="POST"
        action="{{ route('admin.instansis.update', $instansi) }}">

        @csrf
        @method('PUT')

        @include('backend.instansis._form')

    </form>

</div>

@endsection