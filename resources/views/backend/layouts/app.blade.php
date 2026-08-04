<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') | PJPK Murung Raya</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">
    <div class="min-h-screen lg:flex">
        <div id="sidebarOverlay" class="fixed inset-0 z-30 hidden bg-slate-950/40 lg:hidden"></div>
        @include('backend.partials.sidebar')

        <div class="min-w-0 flex-1 lg:ml-64">
            @include('backend.partials.header')

            <main class="p-4 sm:p-6 lg:p-8">
                <div class="mx-auto max-w-[1600px]">
                    @include('backend.partials.flash')
                    @yield('content')
                </div>
            </main>

            @include('backend.partials.footer')
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');

        function setSidebar(open) {
            sidebar?.classList.toggle('-translate-x-full', !open);
            overlay?.classList.toggle('hidden', !open);
        }

        toggle?.addEventListener('click', () => setSidebar(true));
        overlay?.addEventListener('click', () => setSidebar(false));
    </script>
    @stack('scripts')
</body>
</html>
