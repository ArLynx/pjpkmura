@extends('backend.layouts.app')
@section('title', 'Tambah Target')
@section('page-title', 'Tambah Target')
@section('content')<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"><h2 class="mb-6 text-xl font-bold text-slate-900">Target Tahunan Baru</h2><form method="POST" action="{{ route('admin.targets.store') }}">@csrf @include('backend.targets._form')</form></div>@endsection
