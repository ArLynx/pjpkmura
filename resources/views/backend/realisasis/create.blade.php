@extends('backend.layouts.app')
@section('title', 'Tambah Realisasi')
@section('page-title', 'Tambah Realisasi')
@section('content')<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"><h2 class="mb-6 text-xl font-bold text-slate-900">Realisasi Tahunan Baru</h2><form method="POST" action="{{ route('admin.realisasis.store') }}">@csrf @include('backend.realisasis._form')</form></div>@endsection
