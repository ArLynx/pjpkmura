@extends('backend.layouts.app')
@section('title', 'Edit Data Pendukung')
@section('page-title', 'Edit Data Pendukung')
@section('content')<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"><h2 class="mb-6 text-xl font-bold text-slate-900">Perbarui Dokumen Pendukung</h2><form method="POST" enctype="multipart/form-data" action="{{ route('admin.data-pendukungs.update', $dataPendukung) }}">@csrf @method('PUT') @include('backend.data-pendukungs._form')</form></div>@endsection
