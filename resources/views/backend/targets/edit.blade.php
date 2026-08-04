@extends('backend.layouts.app')
@section('title', 'Edit Target')
@section('page-title', 'Edit Target')
@section('content')<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"><h2 class="mb-6 text-xl font-bold text-slate-900">Perbarui Target</h2><form method="POST" action="{{ route('admin.targets.update', $target) }}">@csrf @method('PUT') @include('backend.targets._form')</form></div>@endsection
