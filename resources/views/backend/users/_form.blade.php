@php($editing = isset($user))
<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
        <input id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600">
    </div>
    <div>
        <label for="username" class="mb-2 block text-sm font-semibold text-slate-700">Username</label>
        <input id="username" name="username" value="{{ old('username', $user->username ?? '') }}" required class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600">
    </div>
    <div>
        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600">
    </div>
    <div>
        <label for="instansi" class="mb-2 block text-sm font-semibold text-slate-700">Instansi</label>
        <input id="instansi" name="instansi" value="{{ old('instansi', $user->instansi ?? '') }}" class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600">
    </div>
    <div>
        <label for="role" class="mb-2 block text-sm font-semibold text-slate-700">Peran</label>
        <select id="role" name="role" required class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600" @disabled($editing && auth()->user()->is($user))>
            <option value="admin" @selected(old('role', $user->role ?? 'admin') === 'admin')>Admin</option>
            <option value="superadmin" @selected(old('role', $user->role ?? '') === 'superadmin')>Superadmin</option>
        </select>
        @if($editing && auth()->user()->is($user))<input type="hidden" name="role" value="superadmin">@endif
    </div>
    <div class="flex items-end">
        <label class="flex items-center gap-3 rounded-xl border border-slate-200 p-3">
            <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-teal-700 focus:ring-teal-600" @checked(old('is_active', $user->is_active ?? true)) @disabled($editing && auth()->user()->is($user))>
            <span class="text-sm font-semibold text-slate-700">Akun aktif</span>
        </label>
        @if($editing && auth()->user()->is($user))<input type="hidden" name="is_active" value="1">@endif
    </div>
    <div>
        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Kata Sandi {{ $editing ? '(opsional)' : '' }}</label>
        <input id="password" type="password" name="password" {{ $editing ? '' : 'required' }} class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600" autocomplete="new-password">
        @if($editing)<p class="mt-1 text-xs text-slate-500">Kosongkan bila tidak diubah.</p>@endif
    </div>
    <div>
        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Kata Sandi</label>
        <input id="password_confirmation" type="password" name="password_confirmation" {{ $editing ? '' : 'required' }} class="w-full rounded-xl border-slate-300 focus:border-teal-600 focus:ring-teal-600" autocomplete="new-password">
    </div>
</div>
<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
    <button class="rounded-xl bg-teal-700 px-6 py-3 font-semibold text-white hover:bg-teal-800">{{ $editing ? 'Simpan Perubahan' : 'Tambah Pengguna' }}</button>
</div>
