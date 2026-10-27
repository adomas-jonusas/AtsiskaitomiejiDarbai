@props(['chirp'])

<article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <div class="flex gap-3">
        <div aria-hidden="true" class="flex size-10 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700">
            {{ mb_strtoupper(mb_substr($chirp->user?->name ?? 'Anonimas', 0, 1)) }}
        </div>
        <div class="min-w-0 flex-1">
            <div class="flex flex-wrap items-baseline gap-x-2 gap-y-1">
                <h2 class="break-words font-semibold">{{ $chirp->user?->name ?? 'Anonimas' }}</h2>
                <time datetime="{{ $chirp->created_at->toIso8601String() }}" title="{{ $chirp->created_at->format('Y-m-d H:i') }}" class="text-xs text-slate-500">
                    {{ $chirp->created_at->diffForHumans() }}
                </time>
                @if ($chirp->updated_at->gt($chirp->created_at->copy()->addSeconds(5)))
                    <span class="text-xs italic text-slate-500">redaguota</span>
                @endif
            </div>
            <p class="mt-2 whitespace-pre-wrap break-words">{{ $chirp->message }}</p>
            @can('update', $chirp)
                <div class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('chirps.edit', $chirp) }}" class="btn btn-secondary">Redaguoti</a>
                <form method="POST" action="{{ route('chirps.destroy', $chirp) }}" onsubmit="return confirm('Ar tikrai ištrinti šią žinutę?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-secondary text-red-700">Ištrinti</button>
                </form>
                </div>
            @endcan
        </div>
    </div>
</article>
