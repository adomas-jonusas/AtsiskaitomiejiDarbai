<x-layout>
    <x-slot:title>Prisijungimas</x-slot:title>

    <section class="mx-auto max-w-md rounded-xl border border-slate-200 bg-white p-6">
        <h1 class="text-3xl font-bold">Prisijungimas</h1>
        <p class="mt-2 text-sm text-slate-600">Sveiki sugrįžę į Chirper.</p>
        <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="text-sm font-semibold">El. paštas</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" maxlength="255" autocomplete="email" required class="field" aria-describedby="email-error">
                <p id="email-error" class="mt-1 text-sm text-red-700">@error('email') {{ $message }} @enderror</p>
            </div>
            <div>
                <label for="password" class="text-sm font-semibold">Slaptažodis</label>
                <input id="password" type="password" name="password" autocomplete="current-password" required class="field" aria-describedby="password-error">
                <p id="password-error" class="mt-1 text-sm text-red-700">@error('password') {{ $message }} @enderror</p>
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" value="1" class="size-4 accent-blue-700">
                Prisiminti mane
            </label>
            <button type="submit" class="btn w-full">Prisijungti</button>
        </form>
        <p class="mt-6 text-sm text-slate-600">Dar neturi paskyros? <a href="{{ route('register') }}" class="font-semibold text-blue-700 underline">Registruokis</a></p>
    </section>
</x-layout>
