<x-layout>
    <section class="rounded-xl border border-slate-200 bg-white p-6">
        <h1 class="text-3xl font-bold">Žinučių srautas</h1>
    </section>
    <div class="mt-6 space-y-4">
        @forelse ($chirps as $chirp)
            <x-chirp :chirp="$chirp" />
        @empty
            <p class="rounded-xl border border-dashed border-blue-200 p-8 text-center text-slate-600">Žinučių dar nėra. Parašyk pirmąją!</p>
        @endforelse
    </div>
</x-layout>
