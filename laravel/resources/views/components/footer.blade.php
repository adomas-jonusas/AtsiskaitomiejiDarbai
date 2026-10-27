@props(['author' => config('chirper.author'), 'className' => config('chirper.class')])

<footer class="border-t border-blue-100 bg-white px-4 py-6 text-center text-sm text-slate-600">
    <p>Sukūrė: {{ $author }} | {{ $className }}</p>
</footer>
