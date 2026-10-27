<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title.' | '.config('app.name') : config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-900">
    <header class="border-b border-blue-100 bg-white">
        <nav aria-label="Pagrindinė navigacija" class="mx-auto flex max-w-4xl flex-wrap items-center justify-between gap-4 px-4 py-5">
            <a href="{{ route('home') }}" class="text-xl font-bold text-blue-700">{{ config('app.name') }}</a>
        </nav>
    </header>
    <main class="mx-auto w-full max-w-2xl flex-1 px-4 py-8">
        {{ $slot }}
    </main>
    <x-footer />
</body>
</html>
