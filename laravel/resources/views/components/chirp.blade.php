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
            </div>
            <p class="mt-2 whitespace-pre-wrap break-words">{{ $chirp->message }}</p>
            <div class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('chirps.edit', $chirp) }}" class="btn btn-secondary">Redaguoti</a>
            </div>
        </div>
    </div>
</article>
