@extends('backend.layouts.app')
@section('title', 'Edit Realisasi')
@section('page-title', 'Edit Realisasi')
@section('content')<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"><h2 class="mb-6 text-xl font-bold text-slate-900">Perbarui Realisasi</h2><form method="POST" action="{{ route('admin.realisasis.update', $realisasi) }}">@csrf @method('PUT') @include('backend.realisasis._form')</form></div>@endsection
