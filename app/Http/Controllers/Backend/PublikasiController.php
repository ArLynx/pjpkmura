<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PublikasiController extends Controller
{
    public function index(Request $request): View
    {
        $publikasis = Publikasi::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = '%'.$request->string('q')->trim().'%';
                $query->where('judul', 'like', $keyword)->orWhere('penulis', 'like', $keyword);
            })
            ->oldest()
            ->paginate(15)
            ->withQueryString();

        return view('backend.publikasis.index', compact('publikasis'));
    }

    public function create(): View
    {
        return view('backend.publikasis.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['penulis'] = $validated['penulis'] ?: $request->user()->name;
        $validated['file'] = $request->file('file')->store('publikasi/files', 'public');

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('publikasi/covers', 'public');
        }

        Publikasi::create($validated);

        return redirect()->route('admin.publikasis.index')->with('success', 'Publikasi berhasil ditambahkan.');
    }

    public function edit(Publikasi $publikasi): View
    {
        return view('backend.publikasis.edit', compact('publikasi'));
    }

    public function update(Request $request, Publikasi $publikasi): RedirectResponse
    {
        $validated = $this->validated($request, true);
        $validated['penulis'] = $validated['penulis'] ?: $request->user()->name;

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($publikasi->file);
            $validated['file'] = $request->file('file')->store('publikasi/files', 'public');
        } else {
            unset($validated['file']);
        }

        if ($request->hasFile('cover')) {
            if ($publikasi->cover) {
                Storage::disk('public')->delete($publikasi->cover);
            }
            $validated['cover'] = $request->file('cover')->store('publikasi/covers', 'public');
        } else {
            unset($validated['cover']);
        }

        $publikasi->update($validated);

        return redirect()->route('admin.publikasis.index')->with('success', 'Publikasi berhasil diperbarui.');
    }

    public function destroy(Publikasi $publikasi): RedirectResponse
    {
        Storage::disk('public')->delete(array_values(array_filter([$publikasi->cover, $publikasi->file])));
        $publikasi->delete();

        return redirect()->route('admin.publikasis.index')->with('success', 'Publikasi berhasil dihapus.');
    }

    private function validated(Request $request, bool $updating = false): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'file' => [$updating ? 'nullable' : 'required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:20480'],
            'deskripsi' => ['nullable', 'string'],
            'penulis' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
