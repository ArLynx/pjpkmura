@extends('backend.layouts.app')
@section('title', 'Tambah Publikasi')
@section('page-title', 'Tambah Publikasi')
@section('content')<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"><h2 class="mb-6 text-xl font-bold text-slate-900">Publikasi Baru</h2><form method="POST" enctype="multipart/form-data" action="{{ route('admin.publikasis.store') }}">@csrf @include('backend.publikasis._form')</form></div>@endsection
