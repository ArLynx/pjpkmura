<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = '%'.$request->string('q')->trim().'%';
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', $keyword)
                        ->orWhere('username', 'like', $keyword)
                        ->orWhere('email', 'like', $keyword)
                        ->orWhere('instansi', 'like', $keyword);
                });
            })
            ->when($request->filled('role'), fn ($query) => $query->where('role', (string) $request->string('role')))
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', (string) $request->string('status') === 'aktif'))
            ->oldest()
            ->paginate(15)
            ->withQueryString();

        return view('backend.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('backend.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['superadmin', 'admin'])],
            'instansi' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['superadmin', 'admin'])],
            'instansi' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->user()->is($user)) {
            $validated['role'] = 'superadmin';
            $validated['is_active'] = true;
        } else {
            $validated['is_active'] = $request->boolean('is_active');
        }

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        if ($user->role === 'superadmin' && User::where('role', 'superadmin')->count() <= 1) {
            return back()->with('error', 'Superadmin terakhir tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
