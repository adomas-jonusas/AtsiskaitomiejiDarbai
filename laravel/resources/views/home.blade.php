<x-layout>
    <section class="rounded-xl border border-slate-200 bg-white p-6">
        <h1 class="text-3xl font-bold">Žinučių srautas</h1>
    </section>
    @forelse ($chirps as $chirp)
        <article class="mt-4 rounded-xl border border-slate-200 bg-white p-6">
            <h2 class="font-semibold">{{ $chirp->user?->name ?? 'Anonimas' }}</h2>
            <p class="mt-2">{{ $chirp->message }}</p>
            <p class="mt-2 text-sm text-slate-500">{{ $chirp->created_at->diffForHumans() }}</p>
        </article>
    @empty
        <p class="mt-6 text-slate-600">Žinučių dar nėra. Parašyk pirmąją!</p>
    @endforelse
</x-layout>
