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
            <div class="flex flex-wrap items-center gap-3">
                @auth
                    <span class="break-all text-sm text-slate-600">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Atsijungti</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">Prisijungti</a>
                    <a href="{{ route('register') }}" class="btn">Registruotis</a>
                @endauth
            </div>
        </nav>
    </header>
    <main class="mx-auto w-full max-w-2xl flex-1 px-4 py-8">
        @if (session('success'))
            <p role="status" class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-4 text-blue-800">{{ session('success') }}</p>
        @endif
        {{ $slot }}
    </main>
    <x-footer />
</body>
</html>
