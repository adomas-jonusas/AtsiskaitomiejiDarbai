<x-layout>
    <section class="rounded-xl border border-slate-200 bg-white p-6">
        <h1 class="text-3xl font-bold">Žinučių srautas</h1>
    </section>
    <form method="POST" action="{{ route('chirps.store') }}" class="mt-6 rounded-xl border border-slate-200 bg-white p-5">
        @csrf
        <label for="message" class="font-semibold">Kuo nori pasidalinti?</label>
        @guest
            <p class="mt-2 text-sm text-slate-600">Norėdamas skelbti žinutes, <a href="{{ route('login') }}" class="text-blue-700 underline">prisijunk</a> arba <a href="{{ route('register') }}" class="text-blue-700 underline">registruokis</a>.</p>
        @endguest
        <textarea id="message" name="message" rows="4" maxlength="255" required class="field" aria-describedby="message-help message-error" placeholder="Parašyk trumpą žinutę...">{{ old('message') }}</textarea>
        <p id="message-error" class="mt-2 text-sm text-red-700">@error('message') {{ $message }} @enderror</p>
        <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
            <p id="message-help" class="text-xs text-slate-500">Iki 255 simbolių.</p>
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
