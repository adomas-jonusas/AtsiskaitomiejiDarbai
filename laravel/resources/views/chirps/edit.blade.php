<x-layout>
    <x-slot:title>Redaguoti žinutę</x-slot:title>

    <h1 class="text-3xl font-bold">Redaguoti žinutę</h1>
    <form method="POST" action="{{ route('chirps.update', $chirp) }}" class="mt-6 rounded-xl border border-slate-200 bg-white p-5">
        @csrf
        @method('PUT')
        <label for="message" class="font-semibold">Žinutė</label>
        <textarea id="message" name="message" rows="4" maxlength="255" required class="field" aria-describedby="message-error">{{ old('message', $chirp->message) }}</textarea>
        <p id="message-error" class="mt-2 text-sm text-red-700">@error('message') {{ $message }} @enderror</p>
        <div class="mt-4 flex flex-wrap justify-between gap-3">
            <a href="{{ route('home') }}" class="btn btn-secondary">Atšaukti</a>
            <button type="submit" class="btn">Išsaugoti</button>
        </div>
    </form>
</x-layout>
