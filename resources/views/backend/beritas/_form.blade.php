@php($editing = isset($berita))

<div class="grid gap-6">

    {{-- ========================================================= --}}
    {{-- JUDUL --}}
    {{-- ========================================================= --}}

    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Judul Berita
        </label>

        <input
            name="judul"
            value="{{ old('judul', $berita->judul ?? '') }}"
            required
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >

    </div>


    {{-- ========================================================= --}}
    {{-- FOTO UTAMA --}}
    {{-- ========================================================= --}}

    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Foto Utama
        </label>

        <input
            type="file"
            name="foto"
            accept="image/png,image/jpeg,image/webp"
            class="w-full rounded-xl border border-slate-300 p-3
                   file:mr-4 file:rounded-lg file:border-0
                   file:bg-sky-100 file:px-4 file:py-2
                   file:font-semibold file:text-sky-800"
        >

        <p class="mt-2 text-xs text-slate-500">
            JPG, PNG, atau WebP. Maksimal 5 MB.
        </p>


        {{-- FOTO SAAT INI --}}
        @if($editing && $berita->foto)

            <div class="mt-3">

                <p class="mb-2 text-xs font-semibold text-slate-500">
                    Foto saat ini
                </p>

                <img
                    src="{{ asset('storage/' . $berita->foto) }}"
                    alt="{{ $berita->judul }}"
                    class="h-36 w-auto max-w-md rounded-xl object-cover border border-slate-200"
                >

            </div>

        @endif

    </div>


    {{-- ========================================================= --}}
    {{-- ISI BERITA --}}
    {{-- ========================================================= --}}

    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Isi Berita
        </label>

        {{-- JANGAN PAKAI required DI TEXTAREA --}}
        <textarea
            id="isi-berita"
            name="isi"
        >{{ old('isi', $berita->isi ?? '') }}</textarea>

        <p class="mt-2 text-xs text-slate-500">
            Gunakan editor untuk menulis berita. Kamu juga bisa menambahkan
            foto di dalam isi berita.
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- PENULIS --}}
    {{-- ========================================================= --}}

    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-700">
            Penulis
        </label>

        <input
            name="penulis"
            value="{{ old('penulis', $berita->penulis ?? auth()->user()->name) }}"
            class="w-full rounded-xl border-slate-300 focus:border-sky-600 focus:ring-sky-600"
        >

    </div>

</div>


{{-- ============================================================= --}}
{{-- BUTTON --}}
{{-- ============================================================= --}}

<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

    <a
        href="{{ route('admin.beritas.index') }}"
        class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold text-slate-700 hover:bg-slate-50"
    >
        Batal
    </a>


    <button
        type="submit"
        class="rounded-xl bg-[#0B91CF] px-6 py-3 font-semibold text-white hover:bg-[#0879AE]"
    >
        {{ $editing ? 'Simpan Perubahan' : 'Terbitkan Berita' }}
    </button>

</div>


{{-- ============================================================= --}}
{{-- CKEDITOR --}}
{{-- ============================================================= --}}

<link
    rel="stylesheet"
    href="https://cdn.ckeditor.com/ckeditor5/41.4.2/ckeditor5.css"
>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>


<style>

    .ck-editor__editable {
        min-height: 400px;
    }

    .ck-editor__editable_inline {
        padding: 20px !important;
    }

    .ck-content img {
        max-width: 100%;
        height: auto;
    }

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const textarea = document.querySelector('#isi-berita');

    if (!textarea) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | CEGAH CKEDITOR DIBUAT 2 KALI
    |--------------------------------------------------------------------------
    */

    if (textarea.dataset.ckeditorInitialized === 'true') {
        return;
    }

    textarea.dataset.ckeditorInitialized = 'true';


    /*
    |--------------------------------------------------------------------------
    | CKEDITOR
    |--------------------------------------------------------------------------
    */

    ClassicEditor
        .create(textarea, {

            toolbar: [
                'heading',
                '|',
                'bold',
                'italic',
                'underline',
                '|',
                'bulletedList',
                'numberedList',
                '|',
                'link',
                'insertTable',
                '|',
                'imageUpload',
                'blockQuote',
                '|',
                'undo',
                'redo'
            ]

        })

        .then(editor => {

            /*
            |--------------------------------------------------------------------------
            | CUSTOM IMAGE UPLOAD ADAPTER
            |--------------------------------------------------------------------------
            */

            editor.plugins
                .get('FileRepository')
                .createUploadAdapter = function (loader) {

                    return new MyUploadAdapter(loader);

                };


            /*
            |--------------------------------------------------------------------------
            | SIMPAN INSTANCE EDITOR
            |--------------------------------------------------------------------------
            */

            window.beritaEditor = editor;


            /*
            |--------------------------------------------------------------------------
            | PASTIKAN DATA CKEDITOR MASUK KE TEXTAREA
            |--------------------------------------------------------------------------
            */

            const form = textarea.closest('form');

            if (form) {

                form.addEventListener('submit', function () {

                    textarea.value = editor.getData();

                });

            }

        })

        .catch(error => {

            console.error('CKEditor error:', error);

        });

});


/*
|--------------------------------------------------------------------------
| CUSTOM UPLOAD ADAPTER
|--------------------------------------------------------------------------
*/

class MyUploadAdapter {

    constructor(loader) {

        this.loader = loader;

    }


    upload() {

        return this.loader.file

            .then(file => {

                return new Promise((resolve, reject) => {

                    this.xhr = new XMLHttpRequest();


                    /*
                    |--------------------------------------------------------------------------
                    | URL UPLOAD GAMBAR
                    |--------------------------------------------------------------------------
                    */

                    this.xhr.open(
                        'POST',
                        '{{ route('admin.beritas.upload-image') }}',
                        true
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | CSRF
                    |--------------------------------------------------------------------------
                    */

                    this.xhr.setRequestHeader(
                        'X-CSRF-TOKEN',
                        '{{ csrf_token() }}'
                    );


                    this.xhr.responseType = 'json';


                    /*
                    |--------------------------------------------------------------------------
                    | SUCCESS
                    |--------------------------------------------------------------------------
                    */

                    this.xhr.addEventListener('load', () => {

                        const response = this.xhr.response;


                        if (!response || !response.url) {

                            reject(
                                response && response.message
                                    ? response.message
                                    : 'Upload gambar gagal.'
                            );

                            return;

                        }


                        resolve({
                            default: response.url
                        });

                    });


                    /*
                    |--------------------------------------------------------------------------
                    | ERROR
                    |--------------------------------------------------------------------------
                    */

                    this.xhr.addEventListener('error', () => {

                        reject('Gagal mengupload gambar.');

                    });


                    /*
                    |--------------------------------------------------------------------------
                    | ABORT
                    |--------------------------------------------------------------------------
                    */

                    this.xhr.addEventListener('abort', () => {

                        reject();

                    });


                    /*
                    |--------------------------------------------------------------------------
                    | FORM DATA
                    |--------------------------------------------------------------------------
                    */

                    const data = new FormData();

                    data.append('upload', file);


                    this.xhr.send(data);

                });

            });

    }


    abort() {

        if (this.xhr) {

            this.xhr.abort();

        }

    }

}

</script>