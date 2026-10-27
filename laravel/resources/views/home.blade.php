<x-layout>
    <section class="rounded-xl border border-slate-200 bg-white p-6">
        <h1 class="text-3xl font-bold">Žinučių srautas</h1>
    </section>
    <form method="POST" action="{{ route('chirps.store') }}" class="mt-6 rounded-xl border border-slate-200 bg-white p-5">
        @csrf
        <label for="message" class="font-semibold">Kuo nori pasidalinti?</label>
        <textarea id="message" name="message" rows="4" maxlength="255" required class="field" placeholder="Parašyk trumpą žinutę..."></textarea>
        <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
            <p class="text-xs text-slate-500">Iki 255 simbolių.</p>
            <button type="submit" class="btn">Skelbti</button>
        </div>
    </form>
    <div class="mt-6 space-y-4">
        @forelse ($chirps as $chirp)
            <x-chirp :chirp="$chirp" />
        @empty
            <p class="rounded-xl border border-dashed border-blue-200 p-8 text-center text-slate-600">Žinučių dar nėra. Parašyk pirmąją!</p>
        @endforelse
    </div>
</x-layout>
