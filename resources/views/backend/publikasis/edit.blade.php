@extends('backend.layouts.app')
@section('title', 'Edit Publikasi')
@section('page-title', 'Edit Publikasi')
@section('content')<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"><h2 class="mb-6 text-xl font-bold text-slate-900">Perbarui Publikasi</h2><form method="POST" enctype="multipart/form-data" action="{{ route('admin.publikasis.update', $publikasi) }}">@csrf @method('PUT') @include('backend.publikasis._form')</form></div>@endsection
