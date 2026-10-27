<x-layout>
    <x-slot:title>Registracija</x-slot:title>

    <section class="mx-auto max-w-md rounded-xl border border-slate-200 bg-white p-6">
        <h1 class="text-3xl font-bold">Registracija</h1>
        <p class="mt-2 text-sm text-slate-600">Susikurk paskyrą ir dalinkis savo žinutėmis.</p>
        <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="name" class="text-sm font-semibold">Vardas</label>
                <input id="name" name="name" value="{{ old('name') }}" maxlength="255" autocomplete="name" required class="field" aria-describedby="name-error">
                <p id="name-error" class="mt-1 text-sm text-red-700">@error('name') {{ $message }} @enderror</p>
            </div>
            <div>
                <label for="email" class="text-sm font-semibold">El. paštas</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" maxlength="255" autocomplete="email" required class="field" aria-describedby="email-error">
                <p id="email-error" class="mt-1 text-sm text-red-700">@error('email') {{ $message }} @enderror</p>
            </div>
            <div>
                <label for="password" class="text-sm font-semibold">Slaptažodis (bent 8 simboliai)</label>
                <input id="password" type="password" name="password" minlength="8" autocomplete="new-password" required class="field" aria-describedby="password-error">
                <p id="password-error" class="mt-1 text-sm text-red-700">@error('password') {{ $message }} @enderror</p>
            </div>
            <div>
                <label for="password_confirmation" class="text-sm font-semibold">Pakartok slaptažodį</label>
                <input id="password_confirmation" type="password" name="password_confirmation" minlength="8" autocomplete="new-password" required class="field">
            </div>
            <button type="submit" class="btn w-full">Registruotis</button>
        </form>
        <p class="mt-6 text-sm text-slate-600">Jau turi paskyrą? <a href="{{ route('login') }}" class="font-semibold text-blue-700 underline">Prisijunk</a></p>
    </section>
</x-layout>
