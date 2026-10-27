<x-layout>
    <section class="rounded-xl border border-slate-200 bg-white p-6">
        <h1 class="text-3xl font-bold">Žinučių srautas</h1>
    </section>
    @foreach ($chirps as $chirp)
        <article class="mt-4 rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="font-semibold">{{ $chirp['author'] }}</h2>
            <p class="mt-2">{{ $chirp['message'] }}</p>
            <p class="mt-2 text-sm text-slate-500">{{ $chirp['time'] }}</p>
        </article>
    @endforeach
</x-layout>
