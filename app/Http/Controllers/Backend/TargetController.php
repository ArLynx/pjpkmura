<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Target;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TargetController extends Controller
{
    public function index(Request $request): View
    {
        $targets = Target::query()
            ->with(['indikator.pilar', 'user'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = '%'.$request->string('q')->trim().'%';
                $query->whereHas('indikator', fn ($subQuery) => $subQuery->where('nama_indikator', 'like', $keyword));
            })
            ->when($request->filled('tahun'), fn ($query) => $query->where('tahun', $request->integer('tahun')))
            ->latest('tahun')
            ->paginate(15)
            ->withQueryString();

        $tahuns = Target::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('backend.targets.index', compact('targets', 'tahuns'));
    }

    public function create(): View
    {
        return view('backend.targets.create', ['indikators' => $this->indikators()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['created_by'] = $request->user()->id;
        Target::create($validated);

        return redirect()->route('admin.targets.index')->with('success', 'Target berhasil ditambahkan.');
    }

    public function edit(Target $target): View
    {
        return view('backend.targets.edit', [
            'target' => $target,
            'indikators' => $this->indikators(),
        ]);
    }

    public function update(Request $request, Target $target): RedirectResponse
    {
        $target->update($this->validated($request, $target));

        return redirect()->route('admin.targets.index')->with('success', 'Target berhasil diperbarui.');
    }

    public function destroy(Target $target): RedirectResponse
    {
        $target->delete();

        return redirect()->route('admin.targets.index')->with('success', 'Target berhasil dihapus.');
    }

    private function validated(Request $request, ?Target $target = null): array
    {
        return $request->validate([
            'indikator_id' => ['required', 'exists:indikators,id'],
            'tahun' => [
                'required',
                'integer',
                'between:2000,2100',
                Rule::unique('targets', 'tahun')
                    ->where(fn ($query) => $query->where('indikator_id', $request->integer('indikator_id')))
                    ->ignore($target?->id),
            ],
            'nilai_target' => ['nullable', 'numeric', 'between:-9999999999999.99,9999999999999.99'],
        ], [
            'tahun.unique' => 'Target untuk indikator dan tahun tersebut sudah tersedia.',
        ]);
    }

    private function indikators()
    {
        return Indikator::with('pilar')->orderBy('pilar_id')->orderBy('urutan')->get();
    }
}
