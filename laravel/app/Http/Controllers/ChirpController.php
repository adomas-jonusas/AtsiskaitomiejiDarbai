<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChirpController extends Controller
{
    public function index(): View
    {
        $chirps = Chirp::with('user')->latest()->latest('id')->take(50)->get();

        return view('home', ['chirps' => $chirps]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(['message' => ['required', 'string', 'max:255']]);

        Chirp::create($validated);

        return to_route('home')->with('success', 'Žinutė paskelbta!');
    }

    public function edit(Chirp $chirp): View
    {
        return view('chirps.edit', ['chirp' => $chirp]);
    }

    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $validated = $request->validate(['message' => ['required', 'string', 'max:255']]);
        $chirp->update($validated);

        return to_route('home')->with('success', 'Žinutė atnaujinta!');
    }
}
