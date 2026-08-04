@if(session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
        <span class="material-symbols-outlined">check_circle</span>
        <p>{{ session('success') }}</p>
    </div>
@endif
@if(session('error'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
        <span class="material-symbols-outlined">error</span>
        <p>{{ session('error') }}</p>
    </div>
@endif
@if($errors->any())
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
        <div class="mb-2 flex items-center gap-2 font-semibold">
            <span class="material-symbols-outlined">error</span> Periksa kembali data berikut:
        </div>
        <ul class="list-disc space-y-1 pl-6 text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
