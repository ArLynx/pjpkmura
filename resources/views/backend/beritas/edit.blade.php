@extends('backend.layouts.app')
@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')
@section('content')<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"><h2 class="mb-6 text-xl font-bold text-slate-900">Perbarui Berita</h2><form method="POST" enctype="multipart/form-data" action="{{ route('admin.beritas.update', $berita) }}">@csrf @method('PUT') @include('backend.beritas._form')</form></div>@endsection
