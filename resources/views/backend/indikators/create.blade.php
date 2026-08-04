@extends('backend.layouts.app')
@section('title', 'Tambah Indikator')
@section('page-title', 'Tambah Indikator')
@section('content')<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"><h2 class="mb-6 text-xl font-bold text-slate-900">Data Indikator Baru</h2><form method="POST" action="{{ route('admin.indikators.store') }}">@csrf @include('backend.indikators._form')</form></div>@endsection
