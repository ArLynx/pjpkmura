@php($editing = isset($user))

<div class="grid gap-6 md:grid-cols-2">

    {{-- Nama --}}
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Nama Lengkap
        </label>

        <input
            id="name"
            name="name"
            value="{{ old('name', $user->name ?? '') }}"
            required
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >
    </div>

    {{-- Username --}}
    <div>
        <label for="username" class="mb-2 block text-sm font-semibold text-slate-700">
            Username
        </label>

        <input
            id="username"
            name="username"
            value="{{ old('username', $user->username ?? '') }}"
            required
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >
    </div>

    {{-- Email --}}
    <div>
        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
            Email Aktif
        </label>

        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email', $user->email ?? '') }}"
            required
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >
    </div>

    {{-- Instansi --}}
    <div>
        <label for="instansi_id"
            class="mb-2 block text-sm font-semibold text-slate-700">

            Instansi

        </label>

        <select
            id="instansi_id"
            name="instansi_id"
            required
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >

            <option value="">
                -- Pilih Instansi --
            </option>

            @foreach($instansis as $instansi)

                <option
                    value="{{ $instansi->id }}"
                    @selected(
                        old(
                            'instansi_id',
                            $user->instansi_id ?? ''
                        ) == $instansi->id
                    )
                >
                    {{ $instansi->nama }}
                </option>

            @endforeach

        </select>

    </div>

    {{-- Peran --}}
    <div>
        <label for="role" class="mb-2 block text-sm font-semibold text-slate-700">
            Peran
        </label>

        @if($editing && ($user->role ?? '') === 'superadmin')
            <input
                type="text"
                value="Superadmin"
                disabled
                class="w-full rounded-xl border-slate-300 bg-slate-100 text-slate-600 cursor-not-allowed"
            >
            <input type="hidden" name="role" value="superadmin">
            <p class="mt-1 text-xs text-slate-500">
                Peran Superadmin dibuat melalui seeder sistem dan tidak dapat diubah dari CRUD.
            </p>
        @else
            <input
                type="text"
                value="Admin"
                disabled
                class="w-full rounded-xl border-slate-300 bg-slate-100 text-slate-600 cursor-not-allowed"
            >
            <input type="hidden" name="role" value="admin">
            <p class="mt-1 text-xs text-slate-500">
                Pengguna yang ditambahkan melalui form ini otomatis memiliki peran Admin.
            </p>
        @endif
    </div>

    {{-- Status Aktif --}}
    <div class="flex items-end">
        <label class="flex items-center gap-3 rounded-xl border border-slate-200 p-3">

            <input
                type="checkbox"
                name="is_active"
                value="1"
                class="rounded border-slate-300 text-sky-600 focus:ring-sky-600"
                @checked(old('is_active', $user->is_active ?? true))
                @disabled($editing && auth()->user()->is($user))
            >

            <span class="text-sm font-semibold text-slate-700">
                Akun aktif
            </span>

        </label>

        @if($editing && auth()->user()->is($user))
            <input type="hidden" name="is_active" value="1">
        @endif
    </div>

    {{-- Password --}}
    <div>
        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">
            Kata Sandi (Minimal 8 kombinasi angka dan huruf) {{ $editing ? '(opsional)' : '' }}
        </label>

        <div class="relative">

            <input
                id="password"
                type="password"
                name="password"
                {{ $editing ? '' : 'required' }}
                class="w-full rounded-xl border-slate-300 pr-12 focus:border-sky-600 focus:ring-sky-600"
                autocomplete="new-password"
            >

            {{-- Tombol lihat password --}}
            <button
                type="button"
                onclick="togglePassword('password', 'passwordIcon')"
                class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-slate-400 hover:text-sky-600"
                tabindex="-1"
                title="Lihat kata sandi"
            >
                <span
                    id="passwordIcon"
                    class="material-symbols-outlined"
                >
                    visibility
                </span>
            </button>

        </div>

        @if($editing)
            <p class="mt-1 text-xs text-slate-500">
                Kosongkan bila tidak diubah. Kata Sandi Minimal 8 kombinasi angka dan huruf
            </p>
        @endif
    </div>


    {{-- Konfirmasi Password --}}
    <div>
        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">
            Konfirmasi Kata Sandi
        </label>

        <div class="relative">

            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                {{ $editing ? '' : 'required' }}
                class="w-full rounded-xl border-slate-300 pr-12 focus:border-sky-600 focus:ring-sky-600"
                autocomplete="new-password"
            >

            {{-- Tombol lihat konfirmasi password --}}
            <button
                type="button"
                onclick="togglePassword('password_confirmation', 'passwordConfirmationIcon')"
                class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-slate-400 hover:text-sky-600"
                tabindex="-1"
                title="Lihat konfirmasi kata sandi"
            >
                <span
                    id="passwordConfirmationIcon"
                    class="material-symbols-outlined"
                >
                    visibility
                </span>
            </button>

        </div>
    </div>
</div>

{{-- Tombol --}}
<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

    <a
        href="{{ route('admin.users.index') }}"
        class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold text-slate-700 hover:bg-slate-50"
    >
        Batal
    </a>

    <button
        type="submit"
        class="rounded-xl bg-sky-600 px-6 py-3 font-semibold text-white hover:bg-sky-700"
    >
        {{ $editing ? 'Simpan Perubahan' : 'Tambah Pengguna' }}
    </button>

</div>

<script>
    function togglePassword(inputId, iconId) {

        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {

            input.type = 'text';

            icon.textContent = 'visibility_off';

        } else {

            input.type = 'password';

            icon.textContent = 'visibility';

        }
    }
</script>