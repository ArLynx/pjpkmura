@extends('backend.layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('content')
<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="mb-6 text-xl font-bold text-slate-900">Perbarui Data Pengguna</h2>
    <form method="POST" action="{{ route('admin.users.update', $user) }}">@csrf @method('PUT') @include('backend.users._form')</form>
</div>
@endsection
