<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'PJPK Kabupaten Murung Raya')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/png" href="{{ asset('image/logo-murung-raya.png') }}">

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Material Icon --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <style>
        body {

            font-family: 'Inter', sans-serif;

        }
    </style>

</head>

<body class="bg-slate-50 flex flex-col min-h-screen">

    @include('frontend.partials.header')

    <main class="flex-1">

        @yield('content')

    </main>

    @include('frontend.partials.footer')

</body>

</html>
